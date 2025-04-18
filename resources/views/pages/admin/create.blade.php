@extends('layouts.layout')
@section('title', 'Admin | Sitani')
@section('content')
    <x-ui.card>
        <div class="mb-5 border-b border-[#E5E8EC]">
            <x-ui.title :title="'Tambah Data Admin'" />
        </div>
        <form id="form-tambah-admin" action="{{ route('admin.store') }}" method="post">
            @csrf
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-form.input-text :keyId="'nama'" :label="'Nama Admin'" :name="'nama'" :placeholder="'Masukan nama admin'" />
                <x-form.input-phone :name="'no_hp'" :label="'No Hp'" :placeholder="'Masukan no hp admin'" :keyId="'no_hp'" :helperText="'Gunakan format 08xxxxxxxxxx'" />
                <x-form.input-text :keyId="'alamat'" :label="'Alamat'" :name="'alamat'" :placeholder="'Masukan alamat lengkap admin'" />
                <x-form.input-email :keyId="'email'" :label="'Email'" :name="'email'" :placeholder="'Masukan email admin'" :isFloatingLabel="false" :helperText="'Pastikan email admin aktif'" />
            </div>
            <div class="flex gap-2.5">
                <x-ui.button.back-button :style="'btn-soft'" :title="'Kembali'" />
                <x-ui.button.save-button :style="'btn-soft'" formId="form-tambah-admin" />
            </div>
        </form>
    </x-ui.card>
@endsection
