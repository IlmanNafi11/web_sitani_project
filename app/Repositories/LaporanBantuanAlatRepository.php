<?php
namespace App\Repositories;

use App\Exceptions\DataAccessException;
use App\Models\LaporanBantuanAlat;
use App\Models\LaporanBantuanAlatDetail;
use App\Repositories\Interfaces\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class LaporanBantuanAlatRepository implements BaseRepositoryInterface
{
    public function getAll($withRelations = false): Collection|array
    {
        if ($withRelations) {
            return LaporanBantuanAlat::with([
                'kelompokTani:id,nama',
                'penyuluh:id,penyuluh_terdaftar_id',
                'penyuluh.penyuluhTerdaftar:id,nama,no_hp',
                'LaporanBantuanAlatDetail'
            ])->select(['id', 'kelompok_tani_id', 'penyuluh_id', 'status', 'alat_diminta', 'created_at'])->get();
        }

        return LaporanBantuanAlat::all();
    }

    public function getById($id): ?Model
    {
        return LaporanBantuanAlat::with([
            'kelompokTani:id,nama',
            'penyuluh:id,penyuluh_terdaftar_id',
            'penyuluh.penyuluhTerdaftar:id,nama,no_hp',
            'LaporanBantuanAlatDetail'
        ])->select(['id', 'kelompok_tani_id', 'penyuluh_id', 'status', 'created_at', 'path_proposal'])
          ->where('id', $id)
          ->first();
    }

    /**
     * @throws DataAccessException
     */
    public function create(array $data): ?Model
    {
        try {
            $pathProposal = null;
            $detailPath = [];
            $now = date('Y-m-d');
            $kelompokTaniId = $data['kelompok_tani_id'];
            $fileFields = [
                'path_ktp_ketua',
                'path_ktp_sekretaris',
                'path_ktp_ketua_upkk',
                'path_ktp_anggota1',
                'path_ktp_anggota2',
                'path_badan_hukum',
                'path_piagam',
                'path_surat_domisili',
                'path_foto_lokasi',
                'path_proposal'
            ];

            foreach ($fileFields as $field) {
                if (request()->hasFile($field) && request()->file($field)->isValid()) {
                    $file = request()->file($field);
                    $filename = time() . '_' . $file->getClientOriginalName();
                    if ($field === 'path_proposal') {
                        $pathProposal = $file->storeAs("laporan_bantuan_alat/" . $kelompokTaniId . "/" . $now  . "/" . $field, $filename, 'public');
                    }
                    $detailPath[$field] = $file->storeAs("laporan_bantuan_alat/" . $kelompokTaniId . "/" . $now  . "/" . $field, $filename, 'public');
                }
            }
            $laporan = LaporanBantuanAlat::create([
                'kelompok_tani_id' => $kelompokTaniId,
                'penyuluh_id' => $data['penyuluh_id'],
                'alat_diminta' => $data['alat_diminta'],
                'path_proposal' => $pathProposal,
            ]);
            Log::info("LAPORAN: " . $laporan);
            LaporanBantuanAlatDetail::create([
                'permintaan_bantuan_alat_id' => $laporan->id,
                'nama_ketua' => $data['nama_ketua'],
                'no_hp_ketua' => $data['no_hp_ketua'],
                'npwp' => $data['npwp'],
                'email_kelompok_tani' => $data['email_kelompok_tani'],
                'password_email' => $data['password_email'],
                'path_ktp_ketua' => $detailPath['path_ktp_ketua'],
                'path_badan_hukum' => $detailPath['path_badan_hukum'],
                'path_piagam' => $detailPath['path_piagam'],
                'path_surat_domisili' => $detailPath['path_surat_domisili'],
                'path_foto_lokasi' => $detailPath['path_foto_lokasi'],
                'path_ktp_sekretaris' => $detailPath['path_ktp_sekretaris'],
                'path_ktp_ketua_upkk' => $detailPath['path_ktp_ketua_upkk'],
                'path_ktp_anggota1' => $detailPath['path_ktp_anggota1'],
                'path_ktp_anggota2' => $detailPath['path_ktp_anggota2'],
            ]);
            // kirim notif
            return $laporan;
        } catch (\Throwable $e) {
            Log::info($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile() . ' ' . $e->getTraceAsString());
            throw new DataAccessException('Terjadi kesalahan tak terduga di ' . __METHOD__ . $e->getMessage(), 0, $e);
        }
    }

    public function update(string|int $id, array $data): bool|int
    {
        return LaporanBantuanAlat::where('id', $id)->update($data);
    }

    public function delete(string|int $id): bool|int
    {
        return LaporanBantuanAlat::destroy($id);
    }
}
