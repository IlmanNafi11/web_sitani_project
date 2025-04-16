@extends('layouts.layout')
@section('title', 'Komoditas | Sitani')
@section('content')
    <x-ui.result-alert />
    <x-ui.card>
        <div class="mb-5">
            <x-ui.title :title="'Data Komoditas'" />
            <x-ui.sub-title :title="'Manajemen Data Komoditas pertanian di Nganjuk'" />
        </div>
        <table id="komoditas-table" class="table">
            <x-ui.table.header-table :items="[
        ['title' => 'Nama Komoditas'],
        ['title' => 'Jumlah Musim/Tahun'],
        ['title' => 'Deskripsi'],
        ['title' => 'Aksi'],
    ]" />
            <tbody>
                @forelse ($datas as $komoditas)
                    <tr class="text-black">
                        <td>{{ $komoditas->nama }}</td>
                        <td>{{ $komoditas->musim }}</td>
                        <td>{{ $komoditas->deskripsi ?? 'Tidak ada deskripsi' }}</td>
                        <td class="flex gap-3">
                            <x-ui.button.edit-button :color="'btn-warning'" :style="'btn-soft'" :route="route('komoditas.edit', $komoditas->id)" :title="'Perbarui'" />
                            <x-ui.button.delete-button :color="'btn-error'" :style="'btn-soft'" :title="'Hapus'"
                                :keyId="$komoditas->id" :route="route('komoditas.destroy', $komoditas->id)" />
                        </td>
                    </tr>
                @empty

                @endforelse

            </tbody>
        </table>
    </x-ui.card>
    <script>

        if (document.getElementById("komoditas-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#komoditas-table", {
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
                dataTable.prepend(`<div class="action-header-container flex"><x-ui.button.add-button :color="'btn-accent'" :style="'btn-soft'" :route="route('komoditas.create')" :title="'Tambah Data'" /></div>`);
                $(".datatable-top").children().not(".action-header-container").wrapAll('<div class="features-action-container flex flex-row-reverse gap-4 flex-wrap"></div>');
            });
        }
    </script>
@endsection
