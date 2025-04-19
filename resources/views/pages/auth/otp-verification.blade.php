@extends('layouts.auth-layout')

@section('title', 'Verifikasi OTP | Sitani')
@section('content')
    <x-ui.card :extraClassOptions="'max-sm:w-full max-sm:h-full max-sm:flex max-sm:justify-center max-sm:items-center max-sm:rounded-none!'">
        <form id="verif-otp" action="{{ route('verifikasi-otp.post') }}" method="post">
            <div class="card-header">
                <span class="block w-full text-center text-3xl" style="font-family: Marck Script">Verifikasi OTP</span>
            </div>
            <div class="card-body">
                <x-form.pin-input />
                <button type="submit" id="verif-button" class="btn w-full btn-soft btn-accent mt-6">
                    <span class="icon-[solar--verified-check-broken] size-4.5 shrink-0"></span>Verifikasi
                </button>
            </div>
            <div class="card-footer">
                <span class="label-text block text-center"><a href="{{ route('verifikasi-email') }}"
                        class="link link-accent link-animated">Kembali</a></span>
            </div>
        </form>
    </x-ui.card>
@endsection
