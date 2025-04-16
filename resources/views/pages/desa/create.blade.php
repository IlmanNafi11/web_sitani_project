@extends('layouts.layout')
@section('content')
    <x-ui.card>
        <div class="mb-5 border-b border-[#E5E8EC]">
            <x-ui.title :title="'Tambah Data Desa'" />
        </div>
        <form id="form-tambah-desa" action="{{ route('desa.store') }}" method="post">
            @csrf
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-form.input-text :keyId="'nama'" :label="'Nama Desa'" :name="'nama'" :placeholder="'Masukan nama desa'" />
                <x-form.select :label="'Kecamatan'" :name="'kecamatan_id'" :optionLabel="'nama'" :optionValue="'id'"
                    :options="$kecamatans" :selected="null" :placeholder="'Pilih Kecamatan...'" />
            </div>
            <div class="flex gap-2.5">
                <x-ui.button.back-button :style="'btn-soft'" :title="'Kembali'" />
                <x-ui.button-save formId="form-tambah-desa" />
            </div>
        </form>
    </x-ui.card>
@endsection
