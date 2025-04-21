@extends('layouts.layout')
@section('title', 'Kelompok Tani | Sitani')
@section('content')
    <x-ui.result-alert />
    <x-ui.card>
        <div class="mb-5">
            <x-ui.title :title="'Data Kelompok Tani'" />
            <x-ui.sub-title :title="'Manajemen Data Kelompok Tani yang Terdaftar di Dinas'" />
        </div>
        <table id="kelompok-tani-table" class="table">
            <x-ui.table.header-table :items="[
        ['title' => 'Nama Kelompok Tani'],
        ['title' => 'Desa'],
        ['title' => 'Kecamatan'],
        ['title' => 'Penyuluh'],
        ['title' => 'Aksi'],
    ]" />
            <tbody>
                @forelse ($kelompokTanis as $kelompokTani)
                    <tr class="text-black">
                        <td>{{ $kelompokTani->nama }}</td>
                        <td>{{ $kelompokTani->desa->nama }}</td>
                        <td>{{ $kelompokTani->kecamatan->nama }}</td>
                        <td>{{ $kelompokTani->penyuluhTerdaftars->pluck('nama')->implode(', ') }}</td>
                        <td class="flex gap-3">
                            <x-ui.button.edit-button :color="'btn-warning'" :style="'btn-soft'"
                                :route="route('kelompok-tani.edit', $kelompokTani->id)" :title="'Perbarui'" :permission="'kelompok-tani.ubah'" />
                            <x-ui.button.delete-button :color="'btn-error'" :style="'btn-soft'" :title="'Hapus'"
                                :keyId="$kelompokTani->id" :route="route('kelompok-tani.destroy', $kelompokTani->id)" :permission="'kelompok-tani.hapus'" />
                        </td>
                    </tr>
                @empty

                @endforelse

            </tbody>
        </table>
    </x-ui.card>
    <script>

        if (document.getElementById("kelompok-tani-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#kelompok-tani-table", {
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

            $(document).ready(function () {
                const dataTable = $(".datatable-top");
                dataTable.prepend(`<div class="action-header-container flex"><x-ui.button.add-button :color="'btn-accent'" :style="'btn-soft'" :route="route('kelompok-tani.create')" :title="'Tambah Data'" :permission="'kelompok-tani.tambah'" /></div>`);
                $(".datatable-top").children().not(".action-header-container").wrapAll('<div class="features-action-container flex flex-row-reverse gap-4 flex-wrap"></div>');
            });
        }
    </script>
@endsection
