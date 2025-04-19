@extends('layouts.auth-layout')

@section('title', 'Verifikasi Email | Sitani')
@section('content')
    <x-ui.card :extraClassOptions="'max-sm:w-full max-sm:h-full max-sm:flex max-sm:justify-center max-sm:items-center max-sm:rounded-none!'">
        <form id="verif-email" action="{{ route('verifikasi-email.post') }}" method="post">
            @csrf
            <div class="card-header">
                <span class="block w-full text-center text-3xl" style="font-family: Marck Script">Verifikasi email</span>
            </div>
            <div class="card-body">
                <x-form.input-email :label="'Email'" :name="'email'" :keyId="'email'" :placeholder="'Masukan email'"
                    :helperText="'Pastikan anda memiliki akses ke email anda'" />
                <button type="submit" id="verif-button" class="btn w-full btn-soft btn-accent">
                    <span class="icon-[fa--send] size-4.5 shrink-0"></span>Kirim
                </button>
            </div>
            <div class="card-footer">
                <span class="label-text block text-center"><a href="{{ route('login') }}"
                        class="link link-accent link-animated">Kembali</a></span>
            </div>
        </form>
    </x-ui.card>
@endsection
