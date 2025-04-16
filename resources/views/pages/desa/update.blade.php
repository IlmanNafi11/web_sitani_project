@extends('layouts.layout')
@section('content')
    <x-ui.card>
        <div class="mb-5 border-b border-[#E5E8EC]">
            <x-ui.title :title="'Perbarui Data Desa'" />
        </div>
        <form id="form-perbarui-desa" action="{{ route('desa.update', $desa->id) }}" method="post">
            @method('PUT')
            @csrf
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-form.input-text :keyId="'nama'" :label="'Nama Desa'" :name="'nama'" :placeholder="'Masukan nama desa'" :defaultValue="$desa->nama" />
                <x-form.select :label="'Kecamatan'" :name="'kecamatan_id'" :optionLabel="'nama'" :optionValue="'id'"
                    :options="$kecamatans" :selected="$desa->kecamatan_id" :placeholder="'Pilih Kecamatan...'" />
            </div>
            <div class="flex gap-2.5">
                <x-ui.button.back-button :style="'btn-soft'" :title="'Kembali'" />
                <x-ui.button-save formId="form-perbarui-desa" />
            </div>
        </form>
    </x-ui.card>
@endsection

