@extends('layouts.layout')
@section('title', 'Laporan Bantuan Alat | Sitani')
@section('content')
    <x-ui.result-alert />
    <x-ui.card>
        <div class="mb-5">
            <x-ui.title :title="'Data Laporan Bantuan Alat'" />
            <x-ui.sub-title :title="'Manajemen Data Laporan Bantuan Alat tiap Kelompok Tani oleh Penyuluh'" />
        </div>
        <table id="laporan-bantuan-alat-table" class="table">
            <x-ui.table.header-table :items="[
        ['title' => 'Kelompok Tani'],
        ['title' => 'Penyuluh'],
        ['title' => 'Alat Diminta'],
        ['title' => 'Waktu Laporan'],
        ['title' => 'Status'],
        ['title' => 'Aksi'],
    ]" />
            <tbody>
                @forelse ($laporans as $laporan)
                            <tr class="text-black">
                                <td>{{ $laporan->kelompokTani->nama }}</td>
                                <td>{{ $laporan->penyuluh->nama }}</td>
                                <td>
                                    <x-ui.badge :color="'badge-info'" :style="'badge-soft'"
                                        :icon="'icon-[heroicons--calendar-date-range]'"
                                        :title="$laporan->laporanBantuanAlatDetail->waktu_laporan" />
                                </td>
                                <td>{{ $laporan->penyuluh->penyuluhTerdaftar->nama }}</td>
                                <td>
                                    <x-ui.badge :color="'badge-accent'" :style="'badge-soft'"
                                        :icon="'icon-[fluent--document-bullet-list-clock-20-regular]'" :title="$laporan->created_at" />
                                </td>
                                @php
    $statusMap = [
        "1" => ['title' => 'Disetujui', 'color' => 'badge-success', 'icon' => 'icon-[solar--verified-check-bold]'],
        "0" => ['title' => 'Tidak Disetujui', 'color' => 'badge-error', 'icon' => 'icon-[lucide--badge-alert]'],
        "2" => ['title' => 'Menunggu Verifikasi', 'color' => 'badge-warning', 'icon' => 'icon-[ph--clock-user-light]'],
    ];

    $statusData = $statusMap[$laporan->status] ?? ['title' => 'Status tidak diketahui', 'color' => 'badge-secondary'];
                                @endphp
                                <td>
                                    <x-ui.badge :color="$statusData['color']" :title="$statusData['title']" :style="'badge-soft'"
                                        :icon="$statusData['icon']">
                                        {{ $statusData['title'] }}
                                    </x-ui.badge>
                                </td>
                                <td>
                                    <x-ui.dropdown-action :title="'Lihat Aksi'">
                                        <x-ui.button.edit-button :route="route('laporan-alat.edit', $laporan->id)"
                                            :title="'Verifikasi'" :style="'btn-soft'" :color="'btn-success'"
                                            :icon="'icon-[line-md--check-list-3-filled]'" :extraClassOption="'w-full'" :permission="'laporan-alat.ubah'" />
                                        <x-ui.button.delete-button :route="route('laporan-alat.destroy', $laporan->id)"
                                            :keyId="$laporan->id" :color="'btn-error'" :style="'btn-soft'" :title="'Hapus'"
                                            :icon="'icon-[line-md--document-delete]'" :extraClassOption="'w-full'" :permission="'laporan-alat.hapus'" />
                                    </x-ui.dropdown-action>
                                </td>
                            </tr>
                @empty

                @endforelse

            </tbody>
        </table>
    </x-ui.card>
    <script>
        if (document.getElementById("laporan-bantuan-alat-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#laporan-bantuan-alat-table", {
                paging: true,
                perPage: 5,
                perPageSelect: [5, 10, 15, 20, 25],
                sortable: true,
                searcable: true,
                labels: {
                    placeholder: "Cari data",
                    searchTitle: "Search within table",
                    pageTitle: "Page {page}",
                    perPage: "Data per halaman",
                    noRows: "Data Kosong",
                    info: "Menampilkan {start} sampai {end} dari {rows} data",
                    noResults: "Data tidak ditemukan",
                },
            });

        }
    </script>
@endsection
