@extends('layouts.layout')
@section('content')
    <x-ui.card>
        <div class="mb-5 border-b border-[#E5E8EC]">
            <x-ui.title :title="'Perbarui Data Penyuluh'" />
        </div>
        <form id="form-perbarui-penyuluh" action="{{ route('penyuluh-terdaftar.update', $penyuluh->id) }}" method="post">
            @method('PUT')
            @csrf
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-form.input-text :keyId="'nama'" :label="'Nama Penyuluh'" :name="'nama'" :placeholder="'Masukan nama penyuluh'" :defaultValue="$penyuluh->nama" />
                <x-form.input-phone :keyId="'no_hp'" :label="'Nomor Hp'" :name="'no_hp'" :placeholder="'08xxx'" :helperText="'Masukan nomor telepon dengan format 08xxx'" :defaultValue="$penyuluh->no_hp" />
                <x-form.input-text :keyId="'alamat'" :label="'Alamat'" :name="'alamat'" :placeholder="'Masukan alamat penyuluh'" :defaultValue="$penyuluh->alamat"/>
                <x-form.select :name="'kecamatan_id'" :label="'Kecamatan'" :options="$kecamatans" :optionLabel="'nama'" :optionValue="'id'" :placeholder="'Pilih Kecamatan'" :selected="$penyuluh->kecamatan_id" />
            </div>
            <div class="flex gap-2.5">
                <x-ui.button.back-button :style="'btn-soft'" :title="'Kembali'" />
                <x-ui.button.save-button :style="'btn-soft'" formId="form-perbarui-penyuluh" />
            </div>
        </form>
    </x-ui.card>
@endsection

