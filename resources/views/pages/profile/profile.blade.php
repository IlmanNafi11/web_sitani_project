@extends('layouts.layout')
@section('title', 'Profil | Sitani')
@section('content')
    <x-ui.result-alert />
    <x-ui.card>
        <div class="mb-5">
            <x-ui.title :title="'Data Pengguna'" />
            <x-ui.sub-title :title="'Data Pribadi Pengguna'" />
        </div>
        <div>
            <form id="profil" action="{{ route('profile.update', $user->id) }}" method="post">
                @method('PUT')
                @csrf
                <div class="pt-0 grid grid-cols-2 gap-2.5 max-sm:grid-cols-1 mb-4">
                    <x-form.input-text :name="'nama'" :label="'Nama Lengkap'" :placeholder="'Nama Lengkap'" :keyId="'nama'" :defaultValue="$user->admin->nama" />
                    <x-form.input-text :name="'no_hp'" :label="'No Telepon'" :placeholder="'Nomor Hp'" :keyId="'no_hp'" :defaultValue="$user->admin->no_hp" />
                    <x-form.input-text :name="'alamat'" :label="'Alamat Lengkap'" :placeholder="'Alamat Lengkap'" :keyId="'alamat'" :defaultValue="$user->admin->alamat" />
                    <x-form.input-email :name="'email'" :label="'Email'" :placeholder="'Masukan email'" :keyId="'email'" :isFloatingLabel="false" :isDisabled="true" :defaultValue="$user->email" />
                </div>
                <div class="action-container flex gap-2.5">
                    <button type="button" class="btn btn-soft btn-secondary" onclick="window.history.back()">Kembali</button>
                    <x-ui.button.save-button :formId="'profil'" :title="'Perbarui'" :style="'btn-soft'" :color="'btn-accent'" />
                </div>
            </form>
        </div>
    </x-ui.card>
@endsection
