@extends('layouts.layout')
@section('title', 'Kecamatan | Sitani')
@section('content')
    <x-ui.card>
        <div class="mb-5 border-b border-[#E5E8EC]">
            <x-ui.title :title="'Perbarui Data Kecamatan'" />
        </div>
        <form id="form-perbarui-kecamatan" action="{{ route('kecamatan.update', $kecamatan->id) }}" method="post">
            @method('PUT')
            @csrf
            <div class="w-full grid grid-cols-1 gap-4 mb-4">
                <x-form.input-text :keyId="'nama'" :label="'Nama Kecamatan'" :name="'nama'" :placeholder="'Masukan nama kecamatan'" :defaultValue="$kecamatan->nama"/>
            </div>
            <div class="flex gap-2.5">
                <x-ui.button.back-button :style="'btn-soft'" :title="'Kembali'" :routes="'kecamatan.index'" />
                <x-ui.button.save-button :style="'btn-soft'" formId="form-perbarui-kecamatan" />
            </div>
        </form>
    </x-ui.card>
@endsection
