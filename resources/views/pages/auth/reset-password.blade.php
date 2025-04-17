@extends('layouts.auth-layout')

@section('title', 'Perbarui Sandi | Sitani')
@section('content')
    <x-ui.card>
        <form id="reset-password" action="{{ route('login') }}" method="GET">
            <div class="card-header">
                <span class="block w-full text-center text-3xl" style="font-family: Marck Script">Perbarui Sandi</span>
            </div>
            <div class="card-body">
                <x-form.password-input :name="'password'" :keyId="'password'" :placeholder="'Masukan kata sandi baru'" :label="'Kata Sandi'"
                    :helperText="'Pastikan anda pengikut jokowi'" />
                <button type="submit" id="verif-button" class="btn w-full btn-soft btn-accent">
                    <span class="icon-[radix-icons--update] size-4.5 shrink-0"></span>Perbarui
                </button>
            </div>
            <div class="card-footer">
                <span class="label-text block text-center"><a href="{{ route('login') }}"
                        class="link link-accent link-animated">Kembali</a></span>
            </div>
        </form>
    </x-ui.card>
@endsection
