<?php

namespace Tests\Unit\Repositories;

use App\Models\Kecamatan;
use App\Models\KelompokTani;
use App\Models\PenyuluhTerdaftar;
use App\Repositories\PenyuluhTerdaftarRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Mockery;

class PenyuluhTerdaftarRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private PenyuluhTerdaftarRepository $penyuluhTerdaftarRepository;
    private PenyuluhTerdaftar $penyuluhTerdaftar;
    private Kecamatan $kecamatan;

    protected function setUp(): void
    {
        parent::setUp();
        $this->penyuluhTerdaftarRepository = new PenyuluhTerdaftarRepository();

        $this->kecamatan = Kecamatan::create([
            'nama' => 'Kecamatan Test'
        ]);

        $this->penyuluhTerdaftar = PenyuluhTerdaftar::create([
            'nama' => 'Penyuluh Test',
            'no_hp' => '08123456789',
            'alamat' => 'Alamat Test',
            'kecamatan_id' => $this->kecamatan->id
        ]);
    }

    public function test_get_all_penyuluh_terdaftar()
    {
        $result = $this->penyuluhTerdaftarRepository->getAll();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        $firstPenyuluhTerdaftar = $result->first();

        $this->assertEquals('Penyuluh Test', $firstPenyuluhTerdaftar->nama);
        $this->assertEquals('08123456789', $firstPenyuluhTerdaftar->no_hp);
        $this->assertEquals('Alamat Test', $firstPenyuluhTerdaftar->alamat);
        $this->assertEquals($this->kecamatan->id, $firstPenyuluhTerdaftar->kecamatan_id);
    }

    public function test_get_all_penyuluh_terdaftar_with_relations()
    {
        $result = $this->penyuluhTerdaftarRepository->getAll(true);

        $this->assertInstanceOf(Collection::class, $result);
        $firstPenyuluhTerdaftar = $result->first();

        $this->assertNotNull($firstPenyuluhTerdaftar->kecamatan);
        $this->assertEquals('Kecamatan Test', $firstPenyuluhTerdaftar->kecamatan->nama);
    }

    public function test_get_penyuluh_terdaftar_by_id()
    {
        $result = $this->penyuluhTerdaftarRepository->getById($this->penyuluhTerdaftar->id);

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($this->penyuluhTerdaftar->id, $result->id);
        $this->assertEquals('Penyuluh Test', $result->nama);
        $this->assertEquals('08123456789', $result->no_hp);
        $this->assertEquals('Alamat Test', $result->alamat);
        $this->assertNotNull($result->kecamatan);
        $this->assertEquals('Kecamatan Test', $result->kecamatan->nama);
    }

    public function test_get_penyuluh_terdaftar_by_phone()
    {
        $result = $this->penyuluhTerdaftarRepository->getByPhone('08123456789');

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($this->penyuluhTerdaftar->id, $result->id);
        $this->assertEquals('Penyuluh Test', $result->nama);
        $this->assertEquals('08123456789', $result->no_hp);
    }

    public function test_create_penyuluh_terdaftar()
    {
        $data = [
            'nama' => 'Penyuluh Baru',
            'no_hp' => '08987654321',
            'alamat' => 'Alamat Baru',
            'kecamatan_id' => $this->kecamatan->id
        ];

        $result = $this->penyuluhTerdaftarRepository->create($data);

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($data['nama'], $result->nama);
        $this->assertEquals($data['no_hp'], $result->no_hp);
        $this->assertEquals($data['alamat'], $result->alamat);
        $this->assertEquals($data['kecamatan_id'], $result->kecamatan_id);
    }

    public function test_update_penyuluh_terdaftar()
    {
        $updateData = [
            'nama' => 'Penyuluh Updated',
            'alamat' => 'Alamat Updated',
            'no_hp' => '08111222333'
        ];

        $result = $this->penyuluhTerdaftarRepository->update($this->penyuluhTerdaftar->id, $updateData);

        $this->assertEquals(1, $result);

        $updatedPenyuluhTerdaftar = PenyuluhTerdaftar::find($this->penyuluhTerdaftar->id);
        $this->assertEquals($updateData['nama'], $updatedPenyuluhTerdaftar->nama);
        $this->assertEquals($updateData['alamat'], $updatedPenyuluhTerdaftar->alamat);
        $this->assertEquals($updateData['no_hp'], $updatedPenyuluhTerdaftar->no_hp);
    }

    public function test_delete_penyuluh_terdaftar()
    {
        $result = $this->penyuluhTerdaftarRepository->delete($this->penyuluhTerdaftar->id);

        $this->assertEquals(1, $result);
        $this->assertNull(PenyuluhTerdaftar::find($this->penyuluhTerdaftar->id));
    }

    public function test_get_by_kecamatan_id()
    {
        $result = $this->penyuluhTerdaftarRepository->getByKecamatanId($this->kecamatan->id);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        $firstPenyuluhTerdaftar = $result->first();

        $this->assertEquals($this->penyuluhTerdaftar->nama, $firstPenyuluhTerdaftar->nama);
        $this->assertEquals($this->penyuluhTerdaftar->id, $firstPenyuluhTerdaftar->id);
    }

    public function test_calculate_total()
    {
        $total = $this->penyuluhTerdaftarRepository->calculateTotal();
        $this->assertEquals(1, $total);
    }

    public function test_get_by_phone_returns_null_when_not_found()
    {
        $result = $this->penyuluhTerdaftarRepository->getByPhone('08999999999');
        $this->assertNull($result);
    }

    public function test_get_by_id_returns_null_when_not_found()
    {
        $result = $this->penyuluhTerdaftarRepository->getById(99999);
        $this->assertNull($result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
