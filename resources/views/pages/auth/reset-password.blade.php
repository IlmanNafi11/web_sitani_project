@extends('layouts.auth-layout')

@section('title', 'Perbarui Sandi | Sitani')
@section('content')
    <x-ui.result-alert />
    <x-ui.card :extraClassOptions="'max-sm:w-full max-sm:h-full max-sm:flex max-sm:justify-center max-sm:items-center max-sm:rounded-none!'">
        <form id="reset-password" action="{{ route('reset-password.post') }}" method="post">
            @csrf
            <div class="card-header">
                <span class="block w-full text-center text-3xl" style="font-family: Marck Script">Perbarui Sandi</span>
            </div>
            <div class="card-body">
                <x-form.password-input :name="'password'" :keyId="'password'" :placeholder="'Masukan kata sandi baru'" :label="'Kata Sandi'"
                    :helperText="'Pastikan kata sandi mudah diingat'" />
                <x-form.password-input :name="'password_confirmation'" :keyId="'password_confirmation'" :placeholder="'Ulangi kata sandi'" :label="'Konfirmasi Kata Sandi'"
                                       :helperText="'Pastikan masukan sama dengan kata sandi baru'" />
                <button type="submit" id="verif-button" class="btn w-full btn-soft btn-accent">
                    <span class="icon-[radix-icons--update] size-4.5 shrink-0"></span>Perbarui
                </button>
            </div>
            <div class="card-footer">
                <span class="label-text block text-center"><a href="{{ route('verifikasi-otp') }}"
                        class="link link-accent link-animated">Kembali</a></span>
            </div>
        </form>
    </x-ui.card>
@endsection
