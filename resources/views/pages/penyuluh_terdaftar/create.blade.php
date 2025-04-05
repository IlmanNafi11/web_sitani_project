@extends('layouts.layout')
@section('content')
    <div class="penyuluh-page-content flex flex-col w-full h-screen relative overflow-hidden">
        <x-partials.header />
        <div class="content-container flex w-full h-[calc(100vh-70px)] absolute top-[70px]">
            <x-partials.side-bar />
            <div class="content flex-1 w-full p-8 flex">
                <div class="main-content w-full overflow-y-auto p-6 rounded-xl bg-white border border-[#E5E8EC] h-fit">
                    <div class="flex flex-col gap-4">
                        <div class="border-b border-[#E5E8EC]">
                            <span class="title-label-page font-medium mb-4 block">Tambah Data Penyuluh</span>
                        </div>
                        <div class="form-container">
                            <form id="form-tambah-penyuluh" action="{{ route('penyuluh-terdaftar.store') }}" method="post">
                                @csrf
                                <div class="w-full grid grid-cols-1 md:grid-cols-2 grid-rows-3 md:grid-rows-2 gap-4 mb-4 md:mb-0">
                                    <div class="flex flex-col gap-3 col-span-1 row-span-1">
                                        <label for="nama" class="@error('nama')
                                            text-red-600
                                        @enderror">Nama Penyuluh</label>
                                        <input
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('nama') bg-red-50 text-red-600 border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                            placeholder="Masukan nama penyuluh" type="text" id="nama" name="nama"
                                            value="{{ old('nama') }}">
                                        @error('nama')
                                            <p class="text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col gap-3 col-span-1 row-span-1">
                                        <label for="no_hp">Nomor Telepon</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 19 18">
                                                    <path
                                                        d="M18 13.446a3.02 3.02 0 0 0-.946-1.985l-1.4-1.4a3.054 3.054 0 0 0-4.218 0l-.7.7a.983.983 0 0 1-1.39 0l-2.1-2.1a.983.983 0 0 1 0-1.389l.7-.7a2.98 2.98 0 0 0 0-4.217l-1.4-1.4a2.824 2.824 0 0 0-4.218 0c-3.619 3.619-3 8.229 1.752 12.979C6.785 16.639 9.45 18 11.912 18a7.175 7.175 0 0 0 5.139-2.325A2.9 2.9 0 0 0 18 13.446Z" />
                                                </svg>
                                            </div>
                                            <input type="text" id="no_hp" name="no_hp"
                                                aria-describedby="helper-text-explanation"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('nama') bg-red-50 text-red-600 border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="08xxx" value="{{ old('no_hp') }}" />
                                        </div>

                                        @error('no_hp')
                                            <p class="text-red-600">{{ $message }}</p>

                                            @else

                                            <p id="helper-text-explanation" class="text-gray-500 dark:text-gray-400">Masukan nomor telepon dengan format 08xxx</p>

                                        @enderror
                                    </div>

                                    <div class="flex flex-col gap-3 col-span-1 row-span-1">
                                        <label for="alamat" class="@error('alamat')
                                            text-red-600
                                        @enderror">Alamat</label>
                                        <input
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('alamat') bg-red-50 text-red-600 border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                            placeholder="Masukan alamat penyuluh" type="text" id="alamat" name="alamat"
                                            value="{{ old('alamat') }}">
                                        @error('alamat')
                                            <p class="text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col gap-3">
                                        <label for="kecamatan_id" class="@error('kecamatan_id')
                                            text-red-600
                                        @enderror">Kecamatan</label>
                                        <select name="kecamatan_id" id="kecamatan_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('nama') bg-red-50 text-red-600 border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                                            <option value="" selected disabled>Pilih kecamatan</option>
                                            @foreach ($kecamatans as $kecamatan)
                                                <option value="{{ $kecamatan->id }}">
                                                    {{ $kecamatan->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kecamatan_id')
                                            <p class="text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <x-ui.button-save formId="form-tambah-penyuluh" />
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
