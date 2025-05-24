<?php

namespace Tests\Unit\Repositories;

use App\Exceptions\DataAccessException;
use App\Exceptions\ResourceNotFoundException;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\KelompokTani;
use App\Models\PenyuluhTerdaftar;
use App\Repositories\KelompokTaniRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Mockery;

class KelompokTaniRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private KelompokTaniRepository $kelompokTaniRepository;
    private KelompokTani $kelompokTani;
    private Kecamatan $kecamatan;
    private Desa $desa;

    protected function setUp(): void
    {
        parent::setUp();
        $this->kelompokTaniRepository = new KelompokTaniRepository();

        $this->kecamatan = Kecamatan::create([
            'nama' => 'Kecamatan Test'
        ]);

        $this->desa = Desa::create([
            'nama' => 'Desa Test',
            'kecamatan_id' => $this->kecamatan->id
        ]);

        $this->kelompokTani = KelompokTani::create([
            'nama' => 'Kelompok Tani Test',
            'desa_id' => $this->desa->id,
            'kecamatan_id' => $this->kecamatan->id
        ]);
    }

    public function test_get_all_kelompok_tani()
    {
        $result = $this->kelompokTaniRepository->getAll();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        $this->assertEquals('Kelompok Tani Test', $result->first()->nama);
    }

    public function test_get_all_kelompok_tani_with_relations()
    {
        $result = $this->kelompokTaniRepository->getAll(true);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        $firstKelompokTani = $result->first();

        $this->assertEquals('Kelompok Tani Test', $firstKelompokTani->nama);
        $this->assertEquals('Kecamatan Test', $firstKelompokTani->kecamatan->nama);
        $this->assertEquals('Desa Test', $firstKelompokTani->desa->nama);
    }

    public function test_get_kelompok_tani_by_id()
    {
        $result = $this->kelompokTaniRepository->getById($this->kelompokTani->id);

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($this->kelompokTani->id, $result->id);
        $this->assertEquals('Kelompok Tani Test', $result->nama);
        $this->assertNotNull($result->kecamatan);
        $this->assertNotNull($result->desa);
    }

    public function test_create_kelompok_tani()
    {
        $data = [
            'nama' => 'Kelompok Tani Baru',
            'desa_id' => $this->desa->id,
            'kecamatan_id' => $this->kecamatan->id
        ];

        $result = $this->kelompokTaniRepository->create($data);

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($data['nama'], $result->nama);
        $this->assertEquals($data['desa_id'], $result->desa_id);
        $this->assertEquals($data['kecamatan_id'], $result->kecamatan_id);
    }

    public function test_update_kelompok_tani()
    {
        $updateData = [
            'nama' => 'Kelompok Tani Updated'
        ];

        $result = $this->kelompokTaniRepository->update($this->kelompokTani->id, $updateData);

        $this->assertTrue($result);

        $updatedKelompokTani = KelompokTani::find($this->kelompokTani->id);
        $this->assertEquals($updateData['nama'], $updatedKelompokTani->nama);
    }

    public function test_delete_kelompok_tani()
    {
        $result = $this->kelompokTaniRepository->delete($this->kelompokTani->id);

        $this->assertTrue($result);
        $this->assertNull(KelompokTani::find($this->kelompokTani->id));
    }

    public function test_get_by_penyuluh_id()
    {
        $penyuluh = PenyuluhTerdaftar::create([
            'nama' => 'Penyuluh Test',
            'no_hp' => '08123456789',
            'alamat' => 'Alamat Test',
            'kecamatan_id' => $this->kecamatan->id
        ]);

        $this->kelompokTani->penyuluhTerdaftars()->attach($penyuluh->id);

        $result = $this->kelompokTaniRepository->getByPenyuluhId([$penyuluh->id]);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        $this->assertEquals($this->kelompokTani->id, $result->first()->id);
    }

    public function test_calculate_total()
    {
        $total = $this->kelompokTaniRepository->calculateTotal();
        $this->assertEquals(1, $total);
    }

    public function test_count_by_kecamatan_id()
    {
        $count = $this->kelompokTaniRepository->countByKecamatanId($this->kecamatan->id);
        $this->assertEquals(1, $count);
    }

    public function test_attach_penyuluh()
    {
        $penyuluh = PenyuluhTerdaftar::create([
            'nama' => 'Penyuluh Test',
            'no_hp' => '08123456789',
            'alamat' => 'Alamat Test',
            'kecamatan_id' => $this->kecamatan->id
        ]);

        $result = $this->kelompokTaniRepository->attach($this->kelompokTani, $penyuluh->id);
        $this->assertTrue($result);

        $this->assertTrue($this->kelompokTani->penyuluhTerdaftars()->where('penyuluh_terdaftar_id', $penyuluh->id)->exists());
    }

    public function test_detach_penyuluh()
    {
        $penyuluh = PenyuluhTerdaftar::create([
            'nama' => 'Penyuluh Test',
            'no_hp' => '08123456789',
            'alamat' => 'Alamat Test',
            'kecamatan_id' => $this->kecamatan->id
        ]);

        $this->kelompokTani->penyuluhTerdaftars()->attach($penyuluh->id);

        $result = $this->kelompokTaniRepository->detach($this->kelompokTani, $penyuluh->id);
        $this->assertEquals(1, $result);

        $this->assertFalse($this->kelompokTani->penyuluhTerdaftars()->where('penyuluh_terdaftar_id', $penyuluh->id)->exists());
    }

    public function test_sync_penyuluh()
    {
        $penyuluh = PenyuluhTerdaftar::create([
            'nama' => 'Penyuluh Test',
            'no_hp' => '08123456789',
            'alamat' => 'Alamat Test',
            'kecamatan_id' => $this->kecamatan->id
        ]);

        $result = $this->kelompokTaniRepository->sync($this->kelompokTani, [$penyuluh->id]);

        $this->assertIsArray($result);
        $this->assertTrue($this->kelompokTani->penyuluhTerdaftars()->where('penyuluh_terdaftar_id', $penyuluh->id)->exists());
    }

    public function test_get_all_by_kecamatan_id()
    {
        $result = $this->kelompokTaniRepository->getAllByKecamatanId($this->kecamatan->id);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        $this->assertEquals($this->kelompokTani->id, $result->first()->id);
    }

    public function test_get_all_by_kecamatan_id_with_search_criteria()
    {
        $result = $this->kelompokTaniRepository->getAllByKecamatanId(
            $this->kecamatan->id,
            ['search_nama_kelompok_tani' => 'Test']
        );

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        $this->assertEquals($this->kelompokTani->id, $result->first()->id);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
