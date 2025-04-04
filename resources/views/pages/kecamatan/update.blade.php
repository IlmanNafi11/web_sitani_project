@extends('layouts.layout')
@section('content')
    <div class="desa-page-content flex flex-col w-full h-screen relative overflow-hidden">
        <x-partials.header />
        <div class="content-container flex w-full h-[calc(100vh-70px)] absolute top-[70px]">
            <x-partials.side-bar />
            <div class="content flex-1 w-full p-8 flex">
                <div class="main-content w-full overflow-y-auto p-6 rounded-xl bg-white border border-[#E5E8EC] h-fit">
                    <div class="flex flex-col gap-4">
                        <div class="border-b border-[#E5E8EC]">
                            <span class="title-label-page font-medium mb-4 block">Perbarui Data Kecamatan</span>
                        </div>
                        <div class="form-container">
                            <form id="form-update-kecamatan" action="{{ route('kecamatan.update', $kecamatan->id) }}"
                                method="post">
                                @method('PUT')
                                @csrf
                                <div class="flex flex-col gap-3 mb-5">
                                    <label for="nama" class="@error('nama')
                                        text-red-600
                                    @enderror">Nama Kecamatan</label>
                                    <input
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('nama') bg-red-50 text-red-600 border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                        placeholder="Masukan nama kecamatan" type="text" id="nama" name="nama"
                                        value="{{ old('nama', $kecamatan->nama) }}">
                                    @if ($errors->any())
                                        <div>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <p class="text-red-600">{{ $error }}</p>
                                                @endforeach
                                            </ul>
                                        </div>

                                    @endif
                                </div>

                                <x-ui.button-save formId="form-update-kecamatan" title="Perbarui"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
@endsection
