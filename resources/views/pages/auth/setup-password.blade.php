@extends('layouts.auth-layout')

@section('title', 'Atur Kata Sandi | Sitani')
@section('content')
    <x-ui.card :extraClassOptions="'max-sm:w-full max-sm:h-full max-sm:flex max-sm:justify-center max-sm:items-center max-sm:rounded-none!'">
        <form id="setup-password" action="{{ route('setup-password.auth') }}" method="post">
            @csrf
            <div class="card-header">
                <span class="block w-full text-center text-3xl" style="font-family: Marck Script">Atur Kata Sandi</span>
            </div>
            <div class="card-body">
                <x-form.password-input :name="'password'" :keyId="'password'" :placeholder="'Masukan kata sandi baru'" :label="'Kata Sandi'"
                                       :helperText="'Pastikan anda pengikut jokowi'" />
                <x-form.password-input :name="'password_confirmation'" :keyId="'password_confirmation'" :placeholder="'Masukan kembali kata sandi baru'" :label="'Ulangi Kata Sandi'"
                                       :helperText="'Pastikan anda pengikut gibran'" />
                <x-ui.button.save-button :formId="'setup-password'" :title="'Simpan'" :style="'btn-soft'" :icon="'icon-[radix-icons--update]'" :titleAlert="'Simpan Kata Sandi?'" :messageAlert="'Pastikan anda mengingat kata sandi baru anda!'" />
            </div>
            <div class="card-footer">
                <span class="label-text block text-center"><a href="{{ route('login') }}"
                                                              class="link link-accent link-animated">Kembali</a></span>
            </div>
        </form>
    </x-ui.card>
@endsection
