@extends('layouts.layout')
@section('title', 'Tambah Role | Sitani')
@section('content')
    <x-ui.card>
        <x-ui.result-alert/>
        <div class="mb-5 border-b border-[#E5E8EC]">
            <x-ui.title :title="'Tambah Role'"/>
        </div>
        <form id="form-tambah-role" action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-form.input-text :keyId="'name'" :label="'Nama Role'" :name="'name'"
                                   :placeholder="'Masukkan nama role'"/>

                {{-- Permission Checkbox Group --}}
                <div class="col-span-1 md:col-span-2">
                    <label class="block mb-1 font-medium">Akses Permission:</label>
                    @php
                        $groupedPermissions = $permissions->groupBy(function($perm) {
                            return explode('.', $perm->name)[0];
                        });
                        $menuLabels = [
                            'dashboard' => 'Dashboard',
                            'bibit' => 'Kelola Bibit',
                            'komoditas' => 'Kelola Komoditas',
                            'penyuluh' => 'Kelola Penyuluh',
                            'kelompok-tani' => 'Kelola Kelompok Tani',
                            'desa' => 'Kelola Desa',
                            'kecamatan' => 'Kelola Kecamatan',
                            'laporan-bibit' => 'Kelola Laporan Bibit',
                            'laporan-hibah' => 'Kelola Laporan Hibah',
                            'admin' => 'Kelola Admin',
                            'role-permission' => 'Kelola Role Permission',
                            'akses-panel' => 'Akses Panel Admin',
                        ];
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 mt-2">
                        @foreach($groupedPermissions as $menu => $perms)
                            <div class="card rounded-lg card-border shadow-none p-4">
                                <div class="font-semibold text-accent-700 mb-2 flex items-center gap-2">
                                    <span
                                        class="inline-block px-2 py-1 rounded bg-accent-100 text-accent-700 text-xs font-bold tracking-wide">
                                        {{ $menuLabels[$menu] ?? \Illuminate\Support\Str::headline($menu) }}
                                    </span>
                                </div>
                                <div class="flex flex-col gap-2">
                                    @foreach($perms as $permission)
                                        <label
                                            class="flex items-center gap-2 px-2 py-1 rounded hover:bg-accent-50 transition cursor-pointer">
                                            <input
                                                type="checkbox"
                                                name="permissions[]"
                                                value="{{ $permission->id }}"
                                                class="accent-accent-500 rounded focus:ring-2 focus:ring-accent-400"
                                                {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                            >
                                            <span
                                                class="text-sm text-gray-700">{{ \Illuminate\Support\Str::after($permission->name, '.') }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('permissions')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="flex gap-2.5">
                <x-ui.button.back-button :style="'btn-soft'" :title="'Kembali'"/>
                <x-ui.button.save-button :style="'btn-soft'" formId="form-tambah-role"/>
            </div>
        </form>
    </x-ui.card>
@endsection
