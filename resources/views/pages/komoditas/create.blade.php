@extends('layouts.layout')
@section('title', 'Komoditas | Sitani')
@section('content')
    <x-ui.card>
        <div class="mb-5 border-b border-[#E5E8EC]">
            <x-ui.title :title="'Tambah Data Komoditas'" />
        </div>
        <form id="form-tambah-komoditas" action="{{ route('komoditas.store') }}" method="post">
            @csrf
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-form.input-text :keyId="'nama'" :label="'Nama Komoditas'" :name="'nama'" :placeholder="'Masukan nama komoditas'" />
                <x-form.text-area :keyId="'deskripsi'" :label="'Deskripsi'" :name="'deskripsi'" :placeholder="'Masukan deskripsi komoditas, contoh: Komoditas padi merupakan komoditas utama dinganjuk'"
                    :extraClassOption="'col-span-1 row-span-3'" :extraClassElement="'h-[calc(100%-30px)]'" />
                <x-form.number-counter :name="'musim'" :min="1" :max="10" :defaultValue="1" :extraClassElement="'col-span-1 row-span-2'" :keyId="'musim'" :helperText="'Mohon pilih jumlah musim antara 1 - 10'" :label="'Jumlah Musim'" />
            </div>
            <div class="flex gap-2.5">
                <x-ui.button.back-button :style="'btn-soft'" :title="'Kembali'" />
                <x-ui.button.save-button :style="'btn-soft'" formId="form-tambah-komoditas" />
            </div>
        </form>
    </x-ui.card>
@endsection

