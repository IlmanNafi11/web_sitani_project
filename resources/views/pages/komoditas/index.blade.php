@extends('layouts.layout')
@section('content')
    <x-ui.result-alert />
    <div class="desa-page-content flex flex-col w-full h-screen relative overflow-hidden">
        <x-partials.header />
        <div class="content-container flex w-full h-[calc(100vh-70px)] absolute top-[70px]">
            <x-partials.side-bar />
            <div class="content flex-1 w-full p-8 flex">
                <div class="main-content w-full overflow-y-auto p-6 rounded-xl bg-white border border-[#E5E8EC]">
                    <div class="flex mb-8 flex-col gap-4">
                        <div>
                            <span class="title-label-page">Data Komoditas</span>
                        </div>
                        <div>
                            <x-ui.bread-crumb :breadcrumbs="[['name' => 'Komoditas', 'url' => route('komoditas.index')], ['name' => 'Data Komoditas']]" />
                        </div>
                    </div>
                    <table id="komoditas-table" class="table">
                        <thead>
                            <tr>
                                <th class="bg-[#F6F8FB] border-b border-[#E5E8EC]">
                                    <span class="flex items-center">
                                        Nama Komoditas
                                    </span>
                                </th>
                                <th class="bg-[#F6F8FB] border-b border-[#E5E8EC]">
                                    <span class="flex items-center">
                                        Jumlah Musim/Tahun
                                    </span>
                                </th>
                                <th class="bg-[#F6F8FB] border-b border-[#E5E8EC]">
                                    <span class="flex items-center">
                                        Deskripsi
                                    </span>
                                </th>
                                <th class="bg-[#F6F8FB] border-b border-[#E5E8EC] w-[100px]!">
                                    <span class="flex items-center">
                                        Action
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($datas as $komoditas)
                                <tr class="text-black">
                                    <td>{{ $komoditas->nama }}</td>
                                    <td>{{ $komoditas->musim }}</td>
                                    <td>{{ $komoditas->deskripsi ?? 'Tidak ada deskripsi' }}</td>
                                    <td class="flex gap-3">
                                        <x-ui.button-edit id="{{ $komoditas->id }}" route="komoditas.edit" />
                                        <x-ui.button-delete route="komoditas.destroy" id="{{ $komoditas->id }}" />
                                    </td>
                                </tr>
                            @empty

                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    <script>

        if (document.getElementById("komoditas-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#komoditas-table", {
                paging: true,
                perPage: 5,
                perPageSelect: [5, 10, 15, 20, 25],
                sortable: true,
                searcable: true,
                labels: {
                    placeholder: "Cari data",
                    searchTitle: "Search within table",
                    pageTitle: "Page {page}",
                    perPage: "Data per halaman",
                    noRows: "Data Kosong",
                    info: "Menampilkan {start} sampai {end} dari {rows} data",
                    noResults: "Data tidak ditemukan",
                },
            });

            $(document).ready(function () {
                const dataTable = $(".datatable-top");
                dataTable.prepend(`
                                                            <div class="action-header-container flex flex-wrap gap-4">
                                                                <a href="{{ route('komoditas.create') }}"
                                                                    class="add-data-button cursor-pointer text-white bg-blue-700 hover:bg-blue-800 w-fit p-2 flex justify-center items-center space-x-1 rounded-lg h-[48px]">
                                                                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M10 3v4a1 1 0 0 1-1 1H5m4 8h6m-6-4h6m4-8v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
                                                                    </svg>
                                                                    <span>Tambah Data</span>
                                                                </a>
                                                                <div
                                                                    class="import-csv-button cursor-pointer text-white bg-green-500 hover:bg-green-800 w-fit p-2 flex justify-center items-center space-x-1 rounded-lg h-[48px]">
                                                                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m2.665 9H6.647A1.647 1.647 0 0 1 5 15.353v-1.706A1.647 1.647 0 0 1 6.647 12h1.018M16 12l1.443 4.773L19 12m-6.057-.152-.943-.02a1.34 1.34 0 0 0-1.359 1.22 1.32 1.32 0 0 0 1.172 1.421l.536.059a1.273 1.273 0 0 1 1.226 1.718c-.2.571-.636.754-1.337.754h-1.13" />
                                                                    </svg>
                                                                    <a href="">Import Csv</a>
                                                                </div>
                                                                <div
                                                                    class="import-csv-button cursor-pointer text-white bg-yellow-500 hover:bg-yellow-800 w-fit p-2 flex justify-center items-center space-x-1 rounded-lg h-[48px]">
                                                                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01" />
                                                                    </svg>
                                                                    <a href="">Unduh template</a>
                                                                </div>
                                                            </div>
                                                    `);
                $(".datatable-top").children().not(".action-header-container").wrapAll('<div class="features-action-container flex flex-row-reverse gap-4 flex-wrap"></div>');
            });
        }
    </script>
@endsection
