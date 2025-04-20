@extends('layouts.layout')
@section('title', 'Admin | Sitani')
@section('content')
    <x-ui.result-alert/>
    <x-ui.card>
        <div class="mb-5">
            <x-ui.title :title="'Data Admin'"/>
            <x-ui.sub-title :title="'Manajemen Data Admin di Dinas Pertanian Nganjuk'"/>
        </div>
        <table id="admin-table" class="table">
            <x-ui.table.header-table :items="[
        ['title' => 'Nama Admin'],
        ['title' => 'Nomor Hp'],
        ['title' => 'Alamat'],
        ['title' => 'Email'],
        ['title' => 'Role'],
        ['title' => 'Aksi'],
    ]"/>
            <tbody>
            @forelse ($admins as $admin)
                <tr class="text-black">
                    <td>{{ $admin->nama }}</td>
                    <td>{{ $admin->no_hp }}</td>
                    <td>{{ $admin->alamat }}</td>
                    <td>{{ $admin->user->email }}</td>
                    <td>
                        @php
                            $roleName = $admin->user->roles->first()?->name ?? '';
                            $isSuperAdmin = strcasecmp($roleName, 'super admin') === 0;
                            $icon = $isSuperAdmin ? 'icon-[solar--shield-star-broken]' : 'icon-[solar--shield-user-broken]';
                            $color = $isSuperAdmin ? 'badge-success' : 'badge-accent';
                        @endphp
                        <x-ui.badge :style="'badge-soft'" :icon="$icon" :color="$color" :title="ucwords($roleName ?: 'Tidak Ada Role')"/>
                    </td>
                    <td class="flex gap-3">
                        <x-ui.button.edit-button :color="'btn-warning'" :style="'btn-soft'"
                                                 :route="route('admin.edit', $admin->id)"
                                                 :title="'Perbarui'"/>
                        <x-ui.button.delete-button :color="'btn-error'" :style="'btn-soft'" :title="'Hapus'"
                                                   :keyId="$admin->id" :route="route('admin.destroy', $admin->id)"/>
                    </td>
                </tr>
            @empty

            @endforelse

            </tbody>
        </table>
    </x-ui.card>
    <script>

        if (document.getElementById("admin-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#admin-table", {
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
                dataTable.prepend(`<div class="action-header-container flex"><x-ui.button.add-button :color="'btn-accent'" :style="'btn-soft'" :route="route('admin.create')" :title="'Tambah Data'" /></div>`);
                dataTable.children().not(".action-header-container").wrapAll('<div class="features-action-container flex flex-row-reverse gap-4 flex-wrap"></div>');
            });
        }
    </script>
@endsection
