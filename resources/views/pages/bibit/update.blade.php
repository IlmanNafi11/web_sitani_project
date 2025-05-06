@extends('layouts.layout')
@section('title', 'Bibit | Sitani')
@section('content')
    <x-ui.card>
        <div class="mb-5 border-b border-[#E5E8EC]">
            <x-ui.title :title="'Perbarui Data Bibit'" />
        </div>
        <form id="form-update-bibit" action="{{ route('bibit.update', $bibit->id) }}" method="post">
            @method('PUT')
            @csrf
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-form.input-text :keyId="'nama'" :label="'Nama Bibit'" :name="'nama'" :placeholder="'Masukan nama bibit'" :defaultValue="$bibit->nama" />
                <x-form.select :label="'Komoditas'" :name="'komoditas_id'" :optionLabel="'nama'" :optionValue="'id'"
                    :options="$komoditas" :selected="$bibit->komoditas_id" :placeholder="'Pilih Komoditas...'" />
                <x-form.text-area :keyId="'deskripsi'" :label="'Deskripsi'" :name="'deskripsi'" :placeholder="'Masukan deskripsi bibit, contoh: Cap gajah merupakan bibit padi paling berkualitas'"
                    :extraClassOption="'col-span-2'" :defaultValue="$bibit->deskripsi" />
            </div>
            <div class="flex gap-2.5">
                <x-ui.button.back-button :style="'btn-soft'" :title="'Kembali'" :routes="'bibit.index'" />
                <x-ui.button.save-button :formId="'form-update-bibit'" :style="'btn-soft'" />
            </div>
        </form>
    </x-ui.card>
@endsection

