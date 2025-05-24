<?php

namespace Tests\Unit\Repositories;

use App\Models\BibitBerkualitas;
use App\Models\Komoditas;
use App\Repositories\BibitRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Mockery;

class BibitRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private BibitRepository $bibitRepository;
    private BibitBerkualitas $bibit;
    private Komoditas $komoditas;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bibitRepository = new BibitRepository();

        $this->komoditas = Komoditas::create([
            'nama' => 'Padi',
            'deskripsi' => 'Tanaman Pangan',
            'musim' => 1
        ]);

        $this->bibit = BibitBerkualitas::create([
            'nama' => 'Bibit Padi Unggul',
            'deskripsi' => 'Bibit padi dengan kualitas terbaik',
            'komoditas_id' => $this->komoditas->id
        ]);
    }

    public function test_get_all_bibits()
    {
        $result = $this->bibitRepository->getAll();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        $this->assertEquals('Bibit Padi Unggul', $result->first()->nama);
    }

    public function test_get_all_bibits_with_relations()
    {
        $result = $this->bibitRepository->getAll(true);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        $firstBibit = $result->first();

        $this->assertEquals('Bibit Padi Unggul', $firstBibit->nama);
        $this->assertNotNull($firstBibit->komoditas);
        $this->assertEquals('Padi', $firstBibit->komoditas->nama);
    }

    public function test_get_bibit_by_id()
    {
        $result = $this->bibitRepository->getById($this->bibit->id);

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($this->bibit->id, $result->id);
        $this->assertEquals('Bibit Padi Unggul', $result->nama);
    }

    public function test_create_bibit()
    {
        $newKomoditas = Komoditas::create([
            'nama' => 'Jagung',
            'deskripsi' => 'Tanaman Pangan Jagung',
            'musim' => 2
        ]);

        $data = [
            'nama' => 'Bibit Jagung Super',
            'deskripsi' => 'Bibit jagung berkualitas tinggi',
            'komoditas_id' => $newKomoditas->id
        ];

        $result = $this->bibitRepository->create($data);

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($data['nama'], $result->nama);
        $this->assertEquals($data['deskripsi'], $result->deskripsi);
        $this->assertEquals($data['komoditas_id'], $result->komoditas_id);
    }

    public function test_update_bibit()
    {
        $updateData = [
            'nama' => 'Bibit Padi Super Updated',
            'deskripsi' => 'Deskripsi updated'
        ];

        $result = $this->bibitRepository->update($this->bibit->id, $updateData);

        $this->assertEquals(1, $result);

        $updatedBibit = BibitBerkualitas::find($this->bibit->id);
        $this->assertEquals($updateData['nama'], $updatedBibit->nama);
        $this->assertEquals($updateData['deskripsi'], $updatedBibit->deskripsi);
    }

    public function test_delete_bibit()
    {
        $bibitId = $this->bibit->id;
        $komoditasId = $this->komoditas->id;

        $result = $this->bibitRepository->delete($bibitId);

        $this->assertEquals(1, $result);
        $this->assertNull(BibitBerkualitas::find($bibitId));
        $this->assertNotNull(Komoditas::find($komoditasId));
    }

    public function test_calculate_total()
    {
        $initialCount = BibitBerkualitas::count();

        BibitBerkualitas::create([
            'nama' => 'Bibit Test 1',
            'deskripsi' => 'Deskripsi test 1',
            'komoditas_id' => $this->komoditas->id
        ]);

        BibitBerkualitas::create([
            'nama' => 'Bibit Test 2',
            'deskripsi' => 'Deskripsi test 2',
            'komoditas_id' => $this->komoditas->id
        ]);

        $total = $this->bibitRepository->calculateTotal();
        $this->assertEquals($initialCount + 2, $total);
    }

    public function test_get_by_id_returns_null_when_bibit_not_found()
    {
        $result = $this->bibitRepository->getById(99999);
        $this->assertNull($result);
    }

    public function test_update_returns_zero_when_bibit_not_found()
    {
        $result = $this->bibitRepository->update(99999, ['nama' => 'Test']);
        $this->assertEquals(0, $result);
    }

    public function test_delete_returns_zero_when_bibit_not_found()
    {
        $result = $this->bibitRepository->delete(99999);
        $this->assertEquals(0, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
