<?php

namespace Tests\Unit\Repositories;

use App\Exceptions\DataAccessException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\Admin;
use App\Models\User;
use App\Repositories\AdminRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Mockery;
use Spatie\Permission\Models\Role;

class AdminRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private AdminRepository $adminRepository;
    private Admin $admin;
    private User $user;
    private Role $role;

    protected function setUp(): void
    {
        parent::setUp();

        $this->role = Role::create(['name' => 'admin']);

        $this->adminRepository = new AdminRepository();

        $this->user = User::create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'is_password_set' => true
        ]);

        $this->admin = Admin::create([
            'nama' => 'Test Admin',
            'no_hp' => '081234567890',
            'alamat' => 'Test Address',
            'user_id' => $this->user->id
        ]);

        $this->user->assignRole('admin');
    }

    public function test_get_all_admins()
    {
        $result = $this->adminRepository->getAll();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        $this->assertEquals('Test Admin', $result->first()->nama);
    }

    public function test_get_admin_by_id()
    {
        $result = $this->adminRepository->getById($this->admin->id);

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($this->admin->id, $result->id);
        $this->assertEquals('Test Admin', $result->nama);
    }

    public function test_create_admin()
    {
        $data = [
            'email' => 'newadmin@example.com',
            'password' => 'password123',
            'is_password_set' => true,
            'nama' => 'New Admin',
            'no_hp' => '087654321098',
            'alamat' => 'New Address',
            'role' => 'admin'
        ];

        $result = $this->adminRepository->create($data);

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($data['nama'], $result->nama);
        $this->assertEquals($data['no_hp'], $result->no_hp);
        $this->assertEquals($data['alamat'], $result->alamat);
        $this->assertEquals($data['email'], $result->user->email);
    }

    public function test_update_admin()
    {
        $updateData = [
            'nama' => 'Updated Admin',
            'no_hp' => '089876543210',
            'alamat' => 'Updated Address',
            'email' => 'updated@example.com',
            'role' => 'admin'
        ];

        $result = $this->adminRepository->update($this->admin->id, $updateData);

        $this->assertTrue($result);

        $updatedAdmin = Admin::find($this->admin->id);
        $this->assertEquals($updateData['nama'], $updatedAdmin->nama);
        $this->assertEquals($updateData['no_hp'], $updatedAdmin->no_hp);
        $this->assertEquals($updateData['alamat'], $updatedAdmin->alamat);
        $this->assertEquals($updateData['email'], $updatedAdmin->user->email);
    }

    public function test_delete_admin()
    {
        $adminId = $this->admin->id;
        $userId = $this->user->id;

        $result = $this->adminRepository->delete($adminId);

        $this->assertTrue($result);
        $this->assertNull(Admin::find($adminId));
        $this->assertNull(User::find($userId));
    }

    public function test_get_by_id_throws_exception_when_admin_not_found()
    {
        $this->expectException(ResourceNotFoundException::class);
        $this->adminRepository->getById(99999);
    }

    public function test_update_throws_exception_when_admin_not_found()
    {
        $this->expectException(ResourceNotFoundException::class);
        $this->adminRepository->update(99999, ['nama' => 'Test']);
    }

    public function test_delete_throws_exception_when_admin_not_found()
    {
        $this->expectException(ResourceNotFoundException::class);
        $this->adminRepository->delete(99999);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
