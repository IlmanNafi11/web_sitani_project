@extends('layouts.layout')
@section('title', 'Admin | Sitani')
@section('content')
    <x-ui.result-alert/>
    <x-ui.table.import-failed-table/>
    <x-ui.card>
        <div class="mb-5">
            <x-ui.title :title="'Data Admin'"/>
            <x-ui.sub-title :title="'Manajemen Data Admin di Dinas Pertanian Nganjuk'"/>
        </div>
        <div id="file-action-container">
            <x-ui.dropdown-action :title="'File'" :color="'btn-secondary'">
                <x-ui.button.export-button :title="'Unduh Template'" :style="'btn-soft'" :color="'btn-secondary'"
                                           :routes="route('admin.download')" :permission="'admin.lihat'"
                                           :extra-class-element="'w-full'" :icon="'icon-[line-md--file-download]'" />
                <x-ui.button.export-button :title="'Export Excel'" :style="'btn-soft'" :color="'btn-success'"
                                           :routes="route('admin.export')" :permission="'admin.export'"
                                           :extra-class-element="'w-full'" :icon="'icon-[line-md--file-export]'" />
                <x-ui.button.import-button :title="'Import Excel'" :style="'btn-soft'" :color="'btn-info'"
                                           :permission="'admin.import'" :extra-class-element="'w-full'"
                                           :keyId="'import-modal'" :icon="'icon-[line-md--file-import]'" />
            </x-ui.dropdown-action>
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
                                                 :title="'Perbarui'" :permission="'admin.ubah'" />
                        <x-ui.button.delete-button :color="'btn-error'" :style="'btn-soft'" :title="'Hapus'"
                                                   :keyId="$admin->id" :route="route('admin.destroy', $admin->id)" :permission="'admin.hapus'"/>
                    </td>
                </tr>
            @empty

            @endforelse

            </tbody>
        </table>
        <x-ui.modal :title="'Import Data Admin'" :keyId="'import-modal'">
            <form id="import-form" action="{{ route('admin.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body pt-0">
                    <x-form.file-input :keyId="'import-file'" :name="'file'"
                                       :helper-text="'Pastikan Format cslx, xls'" :accept="'.xlsx, .xls'" />
                </div>
                <div class="modal-footer">
                    <x-ui.button.cancel-import-button :dataOverlay="'import-modal'" :inputId="'import-file'" :labelId="'helper-text-input-file'" />
                    <x-ui.button.submit-import-button :title="'Import'" :color="'btn-success'" :formId="'import-form'"
                                             :style="'btn-soft'"
                                             :message-alert="'Pastikan data telah sesuai dengan aturan yang tertera'"
                                             :title-alert="'Impor Data?'" :title-confirm-button="'Ya'"
                                             :title-cancel-button="'Batal'" :inputId="'import-file'"/>
                </div>
            </form>
        </x-ui.modal>
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
                dataTable.prepend(`<div id="action-header-container" class="action-header-container flex gap-2.5"><x-ui.button.add-button :color="'btn-accent'" :style="'btn-soft'" :route="route('admin.create')" :title="'Tambah Data'" :permission="'admin.tambah'" /></div>`);
                dataTable.children().not(".action-header-container").wrapAll('<div class="features-action-container flex flex-row-reverse gap-4 flex-wrap"></div>');

                const fileActionContainer = document.getElementById('file-action-container');
                const actionHeaderContainer = document.getElementById('action-header-container');

                if (fileActionContainer && actionHeaderContainer) {
                    actionHeaderContainer.appendChild(fileActionContainer);
                }
            });
        }
    </script>
@endsection
