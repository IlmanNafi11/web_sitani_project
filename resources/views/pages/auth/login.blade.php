@extends('layouts.auth-layout')

@section('title', 'Login | Sitani')
@section('content')
    <x-ui.card :extraClassOptions="'max-sm:w-full max-sm:h-full max-sm:flex max-sm:justify-center max-sm:items-center max-sm:rounded-none!'">
        <form id="login-form" action="" method="post" class="max-sm:w-full ">
            <div class="card-header h-auto w-full">
                <span class="logo text-4xl block text-center" style="font-family: Marck Script">Sitani</span>
            </div>
            <div div class="card-body h-auto w-full grid grid-cols-1 gap-2.5">
                <x-form.input-email :name="'email'" :keyId="'email'" :placeholder="'Masukan email'" :label="'Email'"
                    :helperText="'Masukan email terdaftar'" />
                <x-form.password-input :name="'password'" :keyId="'password'" :placeholder="'Masukan Password'"
                    :label="'Kata Sandi'" :helperText="'Masukan password akun'" />
                <x-ui.button.save-button :icon="'icon-[line-md--login]'" :style="'btn-soft'" :formId="'login-form'"
                    :title="'Login'" />
            </div>
            <div class="card-footer">
                <span class="label-text block text-center">Lupa Kata sandi?<a href="#"
                        class="ml-1 link link-accent link-animated">Perbarui</a></span>
            </div>
        </form>
    </x-ui.card>
@endsection
