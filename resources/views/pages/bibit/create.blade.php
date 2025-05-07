@extends('layouts.layout')
@section('title', 'Bibit | Sitani')
@section('content')
    <x-ui.card >
        <div class="mb-5 border-b border-[#E5E8EC]">
            <x-ui.title :title="'Tambah Data Bibit'" />
        </div>
        <form id="form-tambah-bibit" action="{{ route('bibit.store') }}" method="post">
            @csrf
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-form.input-text :keyId="'nama'" :label="'Nama Bibit'" :name="'nama'" :placeholder="'Masukan nama bibit'" />
                <x-form.select :label="'Komoditas'" :name="'komoditas_id'" :optionLabel="'nama'" :optionValue="'id'" :options="$datas" :selected="null" :placeholder="'Pilih Komoditas...'" />
                <x-form.text-area :keyId="'deskripsi'" :label="'Deskripsi'" :name="'deskripsi'" :placeholder="'Masukan deskripsi bibit, contoh: Cap gajah merupakan bibit padi paling berkualitas'" :extraClassOption="'col-span-2'" />
            </div>
            <div class="flex gap-2.5">
                <x-ui.button.back-button :style="'btn-soft'" :title="'Kembali'" :routes="'bibit.index'" />
                <x-ui.button.save-button :style="'btn-soft'" formId="form-tambah-bibit" />
            </div>
        </form>
    </x-ui.card>
@endsection
