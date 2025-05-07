@extends('layouts.layout')
@section('title', 'Komoditas | Sitani')
@section('content')
    <x-ui.card>
        <div class="mb-5 border-b border-[#E5E8EC]">
            <x-ui.title :title="'Perbarui Data Komoditas'" />
        </div>
        <form id="form-perbarui-komoditas" action="{{ route('komoditas.update', $komoditas->id) }}" method="post">
            @method('PUT')
            @csrf
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-form.input-text :keyId="'nama'" :label="'Nama Komoditas'" :name="'nama'" :placeholder="'Masukan nama komoditas'" :defaultValue="$komoditas->nama" />
                <x-form.text-area :keyId="'deskripsi'" :label="'Deskripsi'" :name="'deskripsi'" :placeholder="'Masukan deskripsi komoditas, contoh: Komoditas padi merupakan komoditas utama dinganjuk'"
                    :extraClassOption="'col-span-1 row-span-3'" :extraClassElement="'h-[calc(100%-30px)]'" :defaultValue="$komoditas->deskripsi" />
                <x-form.number-counter :name="'musim'" :min="1" :max="10" :defaultValue="$komoditas->musim" :extraClassElement="'col-span-1 row-span-2'" :keyId="'musim'" :helperText="'Mohon pilih jumlah musim antara 1 - 10'" :label="'Jumlah Musim'" />
            </div>
            <div class="flex gap-2.5">
                <x-ui.button.back-button :style="'btn-soft'" :title="'Kembali'" :routes="'komoditas.index'" />
                <x-ui.button.save-button :style="'btn-soft'" formId="form-perbarui-komoditas" />
            </div>
        </form>
    </x-ui.card>
@endsection
