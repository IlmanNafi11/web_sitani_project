<?php

namespace Tests\Unit\Repositories;

use App\Models\Kecamatan;
use App\Models\Penyuluh;
use App\Models\PenyuluhTerdaftar;
use App\Models\User;
use App\Repositories\PenyuluhRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Mockery;
use Spatie\Permission\Models\Role;

class PenyuluhRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private PenyuluhRepository $penyuluhRepository;
    private User $user;
    private PenyuluhTerdaftar $penyuluhTerdaftar;
    private Penyuluh $penyuluh;
    private Kecamatan $kecamatan;

    protected function setUp(): void
    {
        parent::setUp();
        $this->penyuluhRepository = new PenyuluhRepository();

        Role::create(['name' => 'penyuluh']);

        $this->kecamatan = Kecamatan::create([
            'nama' => 'Kecamatan Test'
        ]);

        $this->user = User::create([
            'email' => 'penyuluh@test.com',
            'password' => bcrypt('password'),
            'is_password_set' => true
        ]);

        $this->user->assignRole('penyuluh');

        $this->penyuluhTerdaftar = PenyuluhTerdaftar::create([
            'nama' => 'Penyuluh Test',
            'no_hp' => '08123456789',
            'alamat' => 'Alamat Test',
            'kecamatan_id' => $this->kecamatan->id
        ]);

        $this->penyuluh = Penyuluh::create([
            'user_id' => $this->user->id,
            'penyuluh_terdaftar_id' => $this->penyuluhTerdaftar->id
        ]);
    }

    public function test_get_all_penyuluh()
    {
        $result = $this->penyuluhRepository->getAll();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        $this->assertEquals($this->penyuluh->id, $result->first()->id);
    }

    public function test_get_all_penyuluh_with_relations()
    {
        $result = $this->penyuluhRepository->getAll(true);

        $this->assertInstanceOf(Collection::class, $result);
        $firstPenyuluh = $result->first();

        $this->assertEquals($this->penyuluh->id, $firstPenyuluh->id);
        $this->assertNotNull($firstPenyuluh->user);
        $this->assertNotNull($firstPenyuluh->penyuluhTerdaftar);
        $this->assertEquals('penyuluh@test.com', $firstPenyuluh->user->email);
        $this->assertEquals('Penyuluh Test', $firstPenyuluh->penyuluhTerdaftar->nama);
    }

    public function test_get_penyuluh_by_id()
    {
        $result = $this->penyuluhRepository->getById($this->penyuluh->id);

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($this->penyuluh->id, $result->id);
        $this->assertEquals($this->user->id, $result->user->id);
        $this->assertEquals($this->penyuluhTerdaftar->id, $result->penyuluhTerdaftar->id);
    }

    public function test_create_penyuluh()
    {
        $data = [
            'email' => 'newpenyuluh@test.com',
            'password' => 'password123',
            'penyuluh_terdaftar_id' => $this->penyuluhTerdaftar->id
        ];

        $result = $this->penyuluhRepository->create($data);

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($data['email'], $result->user->email);
        $this->assertEquals($data['penyuluh_terdaftar_id'], $result->penyuluh_terdaftar_id);
        $this->assertTrue($result->user->hasRole('penyuluh'));
    }

    public function test_update_penyuluh()
    {
        $newPenyuluhTerdaftar = PenyuluhTerdaftar::create([
            'nama' => 'Penyuluh Test 2',
            'no_hp' => '08987654321',
            'alamat' => 'Alamat Test 2',
            'kecamatan_id' => $this->kecamatan->id
        ]);

        $updateData = [
            'penyuluh_terdaftar_id' => $newPenyuluhTerdaftar->id
        ];

        $result = $this->penyuluhRepository->update($this->penyuluh->id, $updateData);

        $this->assertTrue($result);

        $updatedPenyuluh = Penyuluh::find($this->penyuluh->id);
        $this->assertEquals($newPenyuluhTerdaftar->id, $updatedPenyuluh->penyuluh_terdaftar_id);
    }

    public function test_delete_penyuluh()
    {
        $result = $this->penyuluhRepository->delete($this->penyuluh->id);

        $this->assertTrue($result);
        $this->assertNull(Penyuluh::find($this->penyuluh->id));
    }

    public function test_calculate_total()
    {
        $total = $this->penyuluhRepository->calculateTotal();
        $this->assertEquals(1, $total);
    }

    public function test_exists_by_penyuluh_terdaftar_id()
    {
        $exists = $this->penyuluhRepository->existsByPenyuluhTerdaftarId($this->penyuluhTerdaftar->id);
        $this->assertTrue($exists);

        $notExists = $this->penyuluhRepository->existsByPenyuluhTerdaftarId(99999);
        $this->assertFalse($notExists);
    }

    public function test_delete_throws_exception_when_penyuluh_not_found()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->penyuluhRepository->delete(99999);
    }

    public function test_update_throws_exception_when_penyuluh_not_found()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->penyuluhRepository->update(99999, ['penyuluh_terdaftar_id' => 1]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
