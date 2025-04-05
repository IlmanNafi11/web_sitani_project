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
                            <span class="title-label-page font-medium mb-4 block">Perbarui Data Bibit</span>
                        </div>
                        <div class="form-container">
                            <form id="form-update-bibit" action="{{ route('bibit.update', $bibit->id) }}" method="post">
                                @method('PUT')
                                @csrf
                                <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div class="flex flex-col gap-3">
                                        <label for="nama" class="@error('nama')
                                            text-red-600
                                        @enderror">Nama Bibit</label>
                                        <input
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('nama') bg-red-50 text-red-600 border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                            placeholder="Masukan nama bibit" type="text" id="nama" name="nama"
                                            value="{{ old('nama', $bibit->nama) }}">
                                        @error('nama')
                                            <p class="text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col gap-3">
                                        <label for="komoditas_id" class="@error('komoditas_id')
                                            text-red-600
                                        @enderror">Komoditas</label>
                                        <select name="komoditas_id" id="komoditas_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('nama') bg-red-50 text-red-600 border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                                            <option value="" disabled>Pilih komoditas</option>
                                            @foreach ($komoditas as $kmds)
                                                <option value="{{ $kmds->id }}" {{ $bibit->komoditas_id == $kmds->id ? 'selected' : '' }}>
                                                    {{ $kmds->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('komoditas_id')
                                            <p class="text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col gap-3 col-span-2 h-full">
                                        <label for="deskripsi" class="">Deskripsi</label>
                                        <textarea id="deskripsi" name="deskripsi" rows="5"
                                            class="block p-2.5 w-full h-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('deskripsi') bg-red-50 text-red-600 border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                            placeholder="Masukan deskriksi bibit disini...">{{ old('deskripsi', $bibit->deskripsi) }}</textarea>
                                        @error('deskripsi')
                                            <p class="text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <x-ui.button-save formId="form-update-bibit" />
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
