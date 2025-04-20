@extends('layouts.layout')
@section('title', 'Edit Admin | Sitani')
@section('content')
    <x-ui.result-alert/>
    <x-ui.card>
        <div class="mb-5 border-b border-[#E5E8EC]">
            <x-ui.title :title="'Perbarui Data Admin'"/>
        </div>
        <form id="form-edit-admin" action="{{ route('admin.update', $admin->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-form.input-text :keyId="'nama'" :label="'Nama Admin'" :name="'nama'"
                                   :placeholder="'Masukan nama admin'" :defaultValue="$admin->nama"/>
                <x-form.input-phone :name="'no_hp'" :label="'No Hp'" :placeholder="'Masukan no hp admin'"
                                    :keyId="'no_hp'" :helperText="'Gunakan format 08xxxxxxxxxx'"
                                    :defaultValue="$admin->no_hp"/>
                <x-form.input-text :keyId="'alamat'" :label="'Alamat'" :name="'alamat'"
                                   :placeholder="'Masukan alamat lengkap admin'" :defaultValue="$admin->alamat"/>
                <x-form.input-email :keyId="'email'" :label="'Email'" :name="'email'"
                                    :placeholder="'Masukan email admin'" :defaultValue="$admin->user->email"
                                    :isFloatingLabel="false" :helperText="'Pastikan email admin aktif'"/>
                <x-form.select :label="'Role'" :name="'role'" :keyId="'role'" :options="$roles"
                               :selected="$admin->user->roles->first()?->name ?? null"
                               :optionValue="'name'" :optionLabel="'name'"/>
            </div>
            <div class="flex gap-2.5">
                <x-ui.button.back-button :style="'btn-soft'" :title="'Kembali'"/>
                <x-ui.button.save-button :style="'btn-soft'" formId="form-edit-admin"/>
            </div>
        </form>
    </x-ui.card>
@endsection
