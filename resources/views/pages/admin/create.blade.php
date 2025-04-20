@extends('layouts.layout')
@section('title', 'Admin | Sitani')
@section('content')
    <x-ui.card>
        <div class="mb-5 border-b border-[#E5E8EC]">
            <x-ui.title :title="'Tambah Data Admin'"/>
        </div>
        <form id="form-tambah-admin" action="{{ route('admin.store') }}" method="post">
            @csrf
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-form.input-text :keyId="'nama'" :label="'Nama Admin'" :name="'nama'"
                                   :placeholder="'Masukan nama admin'"/>
                <x-form.input-phone :name="'no_hp'" :label="'No Hp'" :placeholder="'Masukan no hp admin'"
                                    :keyId="'no_hp'" :helperText="'Gunakan format 08xxxxxxxxxx'"/>
                <x-form.input-text :keyId="'alamat'" :label="'Alamat'" :name="'alamat'"
                                   :placeholder="'Masukan alamat lengkap admin'"/>
                <x-form.input-email :keyId="'email'" :label="'Email'" :name="'email'"
                                    :placeholder="'Masukan email admin'" :isFloatingLabel="false"
                                    :helperText="'Pastikan email admin aktif'"/>
                <div class="flex flex-col gap-1.5 mb-2">
                    <div class="join gap-2.5">
                        <x-form.radio :extraClassOption="'join-item'" :extraClassElement="'radio-inset'"
                                      :keyId="'role-bibit'" :label="'Admin Bibit'" :name="'role'" :value="'admin_bibit'"
                                      :checked="old('role') === 'admin_bibit'"
                                      :helperText="'Admin bibit dapat menambahkan bibit dan mengelola bibit'"
                                      :defaultValue="null" />
                        <x-form.radio :extraClassOption="'join-item'" :extraClassElement="'radio-inset'"
                                      :keyId="'role-hibah'" :label="'Admin Hibah Alat'" :name="'role'"
                                      :value="'admin_hibah'" :checked="old('role') === 'admin_hibah'"
                                      :helperText="'Admin hibah alat dapat menambahkan hibah alat dan mengelola hibah alat'"
                                      :defaultValue="null" />
                    </div>

                    @error('role')
                    <span class="helper-text text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="flex gap-2.5">
                <x-ui.button.back-button :style="'btn-soft'" :title="'Kembali'"/>
                <x-ui.button.save-button :style="'btn-soft'" formId="form-tambah-admin"/>
            </div>
        </form>
    </x-ui.card>
@endsection
