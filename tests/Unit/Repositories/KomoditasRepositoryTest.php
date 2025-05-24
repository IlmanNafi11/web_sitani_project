<?php

namespace Tests\Unit\Repositories;

use App\Models\BibitBerkualitas;
use App\Models\Komoditas;
use App\Repositories\KomoditasRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class KomoditasRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private KomoditasRepository $komoditasRepository;
    private Komoditas $komoditas;

    private const MUSIM = 2;

    protected function setUp(): void
    {
        parent::setUp();
        $this->komoditasRepository = new KomoditasRepository();

        $this->komoditas = Komoditas::create([
            'nama' => 'Padi',
            'deskripsi' => 'Tanaman Padi',
            'musim' => self::MUSIM
        ]);
    }

    public function test_get_all_komoditas()
    {
        $result = $this->komoditasRepository->getAll();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        $firstKomoditas = $result->first();

        $this->assertEquals('Padi', $firstKomoditas->nama);
        $this->assertEquals('Tanaman Padi', $firstKomoditas->deskripsi);
        $this->assertEquals(self::MUSIM, $firstKomoditas->musim);
    }

    public function test_get_all_komoditas_with_relations()
    {
        $bibit = BibitBerkualitas::create([
            'nama' => 'Bibit Unggul',
            'komoditas_id' => $this->komoditas->id,
            'deskripsi' => 'Bibit padi unggul'
        ]);

        $result = $this->komoditasRepository->getAll(true);

        $this->assertInstanceOf(Collection::class, $result);
        $firstKomoditas = $result->first();

        $this->assertEquals('Padi', $firstKomoditas->nama);
        $this->assertNotNull($firstKomoditas->bibitBerkualitas);
        $this->assertEquals('Bibit Unggul', $firstKomoditas->bibitBerkualitas->first()->nama);
    }

    public function test_create_komoditas()
    {
        $data = [
            'nama' => 'Jagung',
            'deskripsi' => 'Tanaman Jagung',
            'musim' => self::MUSIM
        ];

        $result = $this->komoditasRepository->create($data);

        $this->assertInstanceOf(Model::class, $result);
        $this->assertEquals($data['nama'], $result->nama);
        $this->assertEquals($data['deskripsi'], $result->deskripsi);
        $this->assertEquals($data['musim'], $result->musim);
    }

    public function test_update_komoditas()
    {
        $updateData = [
            'nama' => 'Padi Updated',
            'deskripsi' => 'Deskripsi Updated',
            'musim' => self::MUSIM
        ];

        $result = $this->komoditasRepository->update($this->komoditas->id, $updateData);

        $this->assertEquals(1, $result);

        $updatedKomoditas = Komoditas::find($this->komoditas->id);
        $this->assertEquals($updateData['nama'], $updatedKomoditas->nama);
        $this->assertEquals($updateData['deskripsi'], $updatedKomoditas->deskripsi);
        $this->assertEquals($updateData['musim'], $updatedKomoditas->musim);
    }

    public function test_get_musim()
    {
        $result = $this->komoditasRepository->GetMusim();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
        $firstKomoditas = $result->first();

        $this->assertEquals('Padi', $firstKomoditas->nama);
        $this->assertEquals(self::MUSIM, $firstKomoditas->musim);
        $this->assertArrayNotHasKey('deskripsi', $firstKomoditas->toArray());
    }
}
