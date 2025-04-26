@extends('layouts.layout')
@section('title', 'Role & Akses | Sitani')
@section('content')
    <x-ui.result-alert />
    <x-ui.card>
        <div class="mb-5">
            <x-ui.title :title="'Data Role & Akses'" />
            <x-ui.sub-title :title="'Manajemen Role dan Permission Untuk Hak Akses User'" />
        </div>
        <table id="role-table" class="table">
            <x-ui.table.header-table :items="[
                ['title' => 'Nama Role'],
                ['title' => 'Guard'],
                ['title' => 'Aksi'],
            ]"/>
            <tbody>
                @forelse ($roles as $role)
                    <tr class="text-black align-top">
                        <td class="py-2">{{ $role->name }}</td>
                        <td class="py-2">
                            {{ $role->guard_name }}
                        </td>
                        <td class="flex gap-3 py-2">
                            <x-ui.button.edit-button :color="'btn-warning'" :style="'btn-soft'"
                                :route="route('admin.roles.edit', $role->id)" :title="'Perbarui'" :permission="'role-permission.ubah'" />
                            <x-ui.button.delete-button :color="'btn-error'" :style="'btn-soft'" :title="'Hapus'"
                                :keyId="$role->id" :route="route('admin.roles.destroy', $role->id)" :permission="'role-permission.hapus'" />
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </x-ui.card>
    <script>
        if (document.getElementById("role-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#role-table", {
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
                dataTable.prepend(`<div class="action-header-container flex">
                    <x-ui.button.add-button :color="'btn-accent'" :style="'btn-soft'" :route="route('admin.roles.create')" :title="'Tambah Data'" :permission="'role-permission.tambah'" />
                </div>`);
                dataTable.children().not(".action-header-container").wrapAll('<div class="features-action-container flex flex-row-reverse gap-4 flex-wrap"></div>');
            });
        }
    </script>
@endsection
