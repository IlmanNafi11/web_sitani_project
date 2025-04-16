@extends('layouts.layout')
@section('title', 'Bibit | Sitani')
@section('content')
    <x-ui.result-alert />
    <x-ui.card>
        <div class="mb-5">
            <x-ui.title :title="'Data Bibit'" />
            <x-ui.sub-title :title="'Manajemen Data bibit berkualitas'" />
        </div>
        <table id="bibit-table" class="table">
            <x-ui.table.header-table :items="[
        ['title' => 'Nama Bibit'],
        ['title' => 'Komoditas'],
        ['title' => 'Deskripsi'],
        ['title' => 'Aksi'],
    ]" />
            <tbody>
                @forelse ($datas as $bibit)
                    <tr class="text-black">
                        <td>{{ $bibit->nama }}</td>
                        <td>{{ $bibit->komoditas->nama }}</td>
                        <td>{{ $bibit->deskripsi ?? 'Tidak ada deskripsi' }}</td>
                        <td class="flex gap-3">
                            <x-ui.button.edit-button :color="'btn-warning'" :style="'btn-soft'" :route="route('bibit.edit', $bibit->id)" :title="'Perbarui'" />
                            <x-ui.button.delete-button :color="'btn-error'" :style="'btn-soft'" :title="'Hapus'"
                                :keyId="$bibit->id" :route="route('bibit.destroy', $bibit->id)" />
                        </td>
                    </tr>
                @empty

                @endforelse

            </tbody>
        </table>
    </x-ui.card>
    <script>

        if (document.getElementById("bibit-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#bibit-table", {
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
                dataTable.prepend(`<div class="action-header-container flex"><x-ui.button.add-button :color="'btn-accent'" :style="'btn-soft'" :route="route('bibit.create')" :title="'Tambah Data'" /></div>`);
                $(".datatable-top").children().not(".action-header-container").wrapAll('<div class="features-action-container flex flex-row-reverse gap-4 flex-wrap"></div>');
            });
        }
    </script>
@endsection
