<?php

namespace Tests\Unit\Repositories;

use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\KelompokTani;
use App\Models\PenyuluhTerdaftar;
use App\Repositories\KecamatanRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Mockery;

class KecamatanRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private KecamatanRepository $kecamatanRepository;
    private Kecamatan $kecamatan;

    protected function setUp(): void
    {
        parent::setUp();
        $this->kecamatanRepository = new KecamatanRepository();

        $this->kecamatan = Kecamatan::create([
            'nama' => 'Kecamatan Test'
        ]);
    }

    public function test_get_all_kecamatan()
    {
        $result = $this->kecamatanRepository->getAll();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        $this->assertEquals('Kecamatan Test', $result->first()->nama);
    }

    public function test_get_all_kecamatan_with_relations()
    {
        $desa = Desa::create([
            'nama' => 'Desa Test',
            'kecamatan_id' => $this->kecamatan->id
        ]);

        $result = $this->kecamatanRepository->getAll(true);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        $firstKecamatan = $result->first();

        $this->assertEquals('Kecamatan Test', $firstKecamatan->nama);
        $this->assertNotNull($firstKecamatan->desa, 'Desa relation should not be null');
        $this->assertInstanceOf(Desa::class, $firstKecamatan->desa);
        $this->assertEquals('Desa Test', $firstKecamatan->desa->nama);
    }

    public function test_get_kecamatan_by_id()
    {
        $result = $this->kecamatanRepository->getById($this->kecamatan->id);

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($this->kecamatan->id, $result->id);
        $this->assertEquals('Kecamatan Test', $result->nama);
    }

    public function test_create_kecamatan()
    {
        $data = [
            'nama' => 'Kecamatan Baru'
        ];

        $result = $this->kecamatanRepository->create($data);

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($data['nama'], $result->nama);
    }

    public function test_update_kecamatan()
    {
        $updateData = [
            'nama' => 'Kecamatan Updated'
        ];

        $result = $this->kecamatanRepository->update($this->kecamatan->id, $updateData);

        $this->assertEquals(1, $result);

        $updatedKecamatan = Kecamatan::find($this->kecamatan->id);
        $this->assertEquals($updateData['nama'], $updatedKecamatan->nama);
    }

    public function test_delete_kecamatan()
    {
        $kecamatanId = $this->kecamatan->id;

        $result = $this->kecamatanRepository->delete($kecamatanId);

        $this->assertEquals(1, $result);
        $this->assertNull(Kecamatan::find($kecamatanId));
    }

    public function test_kecamatan_desa_relation()
    {
        $desa = Desa::create([
            'nama' => 'Desa Test',
            'kecamatan_id' => $this->kecamatan->id
        ]);

        $kecamatan = Kecamatan::with('desa')->find($this->kecamatan->id);

        $this->assertNotNull($kecamatan->desa);
        $this->assertEquals($desa->id, $kecamatan->desa->id);
        $this->assertEquals('Desa Test', $kecamatan->desa->nama);
    }

    public function test_kecamatan_penyuluh_terdaftar_relation()
    {
        $penyuluhTerdaftar = PenyuluhTerdaftar::create([
            'nama' => 'Penyuluh Test',
            'no_hp' => '08123456789',
            'alamat' => 'Alamat Test',
            'kecamatan_id' => $this->kecamatan->id
        ]);

        $kecamatan = Kecamatan::with('penyuluhTerdaftar')->find($this->kecamatan->id);

        $this->assertNotNull($kecamatan->penyuluhTerdaftar);
        $this->assertEquals($penyuluhTerdaftar->id, $kecamatan->penyuluhTerdaftar->id);
        $this->assertEquals('Penyuluh Test', $kecamatan->penyuluhTerdaftar->nama);
    }

    public function test_kecamatan_kelompok_tani_relation()
    {
        $desa = Desa::create([
            'nama' => 'Desa Test',
            'kecamatan_id' => $this->kecamatan->id
        ]);

        $kelompokTani = KelompokTani::create([
            'nama' => 'Kelompok Tani Test',
            'kecamatan_id' => $this->kecamatan->id,
            'desa_id' => $desa->id
        ]);

        $kecamatan = Kecamatan::with('kelompokTani')->find($this->kecamatan->id);

        $this->assertNotNull($kecamatan->kelompokTani);
        $this->assertEquals($kelompokTani->id, $kecamatan->kelompokTani->id);
        $this->assertEquals('Kelompok Tani Test', $kecamatan->kelompokTani->nama);
    }

    public function test_get_by_id_returns_null_when_kecamatan_not_found()
    {
        $result = $this->kecamatanRepository->getById(99999);
        $this->assertNull($result);
    }

    public function test_update_returns_zero_when_kecamatan_not_found()
    {
        $result = $this->kecamatanRepository->update(99999, ['nama' => 'Test']);
        $this->assertEquals(0, $result);
    }

    public function test_delete_returns_zero_when_kecamatan_not_found()
    {
        $result = $this->kecamatanRepository->delete(99999);
        $this->assertEquals(0, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
