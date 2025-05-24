<?php

namespace Tests\Unit\Repositories;

use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\KelompokTani;
use App\Repositories\DesaRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Mockery;

class DesaRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private DesaRepository $desaRepository;
    private Desa $desa;
    private Kecamatan $kecamatan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->desaRepository = new DesaRepository();

        $this->kecamatan = Kecamatan::create([
            'nama' => 'Kecamatan Test'
        ]);

        // Buat desa untuk testing
        $this->desa = Desa::create([
            'nama' => 'Desa Test',
            'kecamatan_id' => $this->kecamatan->id
        ]);
    }

    public function test_get_all_desa()
    {
        $result = $this->desaRepository->getAll();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        $this->assertEquals('Desa Test', $result->first()->nama);
    }

    public function test_get_all_desa_with_relations()
    {
        $result = $this->desaRepository->getAll(true);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        $firstDesa = $result->first();

        $this->assertEquals('Desa Test', $firstDesa->nama);
        $this->assertNotNull($firstDesa->kecamatan);
        $this->assertEquals('Kecamatan Test', $firstDesa->kecamatan->nama);
    }

    public function test_get_desa_by_id()
    {
        $result = $this->desaRepository->getById($this->desa->id);

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($this->desa->id, $result->id);
        $this->assertEquals('Desa Test', $result->nama);
        $this->assertEquals('Kecamatan Test', $result->kecamatan->nama);
    }

    public function test_create_desa()
    {
        $data = [
            'nama' => 'Desa Baru',
            'kecamatan_id' => $this->kecamatan->id
        ];

        $result = $this->desaRepository->create($data);

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($data['nama'], $result->nama);
        $this->assertEquals($data['kecamatan_id'], $result->kecamatan_id);
    }

    public function test_update_desa()
    {
        $updateData = [
            'nama' => 'Desa Updated'
        ];

        $result = $this->desaRepository->update($this->desa->id, $updateData);

        $this->assertEquals(1, $result);

        $updatedDesa = Desa::find($this->desa->id);
        $this->assertEquals($updateData['nama'], $updatedDesa->nama);
        $this->assertEquals($this->kecamatan->id, $updatedDesa->kecamatan_id);
    }

    public function test_delete_desa()
    {
        $desaId = $this->desa->id;
        $kecamatanId = $this->kecamatan->id;

        $result = $this->desaRepository->delete($desaId);

        $this->assertEquals(1, $result);
        $this->assertNull(Desa::find($desaId));
        $this->assertNotNull(Kecamatan::find($kecamatanId));
    }

    public function test_get_by_kecamatan_id()
    {
        Desa::create([
            'nama' => 'Desa Test 2',
            'kecamatan_id' => $this->kecamatan->id
        ]);

        $result = $this->desaRepository->getByKecamatanId($this->kecamatan->id);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals(2, $result->count());
        $this->assertTrue($result->contains('nama', 'Desa Test'));
        $this->assertTrue($result->contains('nama', 'Desa Test 2'));
    }

    public function test_calculate_total()
    {
        $initialCount = Desa::count();

        Desa::create([
            'nama' => 'Desa Test 2',
            'kecamatan_id' => $this->kecamatan->id
        ]);

        Desa::create([
            'nama' => 'Desa Test 3',
            'kecamatan_id' => $this->kecamatan->id
        ]);

        $total = $this->desaRepository->calculateTotal();
        $this->assertEquals($initialCount + 2, $total);
    }

    public function test_desa_kelompok_tani_relation()
    {
        $kelompokTani = KelompokTani::create([
            'nama' => 'Kelompok Tani Test',
            'desa_id' => $this->desa->id,
            'kecamatan_id' => $this->kecamatan->id
        ]);

        $desa = Desa::with('kelompokTani')->find($this->desa->id);
        $this->assertNotNull($desa->kelompokTani);
        $this->assertEquals($kelompokTani->id, $desa->kelompokTani->id);
        $this->assertEquals('Kelompok Tani Test', $desa->kelompokTani->nama);
    }

    public function test_get_by_id_returns_null_when_desa_not_found()
    {
        $result = $this->desaRepository->getById(99999);
        $this->assertNull($result);
    }

    public function test_update_returns_zero_when_desa_not_found()
    {
        $result = $this->desaRepository->update(99999, ['nama' => 'Test']);
        $this->assertEquals(0, $result);
    }

    public function test_delete_returns_zero_when_desa_not_found()
    {
        $result = $this->desaRepository->delete(99999);
        $this->assertEquals(0, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
