@extends('layouts.auth-layout')

@section('title', 'Verifikasi Email | Sitani')
@section('content')
    <x-ui.card>
        <form id="verif-email" action="{{ route('verifikasi-otp') }}" method="post">
            <div class="card-header">
                <span class="block w-full text-center text-3xl" style="font-family: Marck Script">Verifikasi email</span>
            </div>
            <div class="card-body">
                <x-form.input-email :label="'Email'" :name="'email'" :keyId="'email'" :placeholder="'Masukan email'"
                    :helperText="'Pastikan anda memiliki akses ke email anda'" />
                <x-ui.button.save-button :icon="'icon-[fa--send]'" :formId="'verif-email'" :style="'btn-soft'" />
            </div>
            <div class="card-footer">
                <span class="label-text block text-center"><a href="{{ route('login') }}"
                        class="link link-accent link-animated">Kembali</a></span>
            </div>
        </form>
    </x-ui.card>
@endsection
