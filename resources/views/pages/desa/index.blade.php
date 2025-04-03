@extends('layouts.layout')
@section('content')
    <div class="desa-page-content flex flex-col w-full h-screen relative overflow-hidden">
        <x-partials.header />
        <div class="content-container flex w-full h-[calc(100vh-70px)] absolute top-[70px]">
            <x-partials.side-bar />
            <div class="content flex-1 w-full p-8 flex">
                <div class="main-content w-full overflow-y-auto p-6 rounded-xl bg-white border border-[#F6F8FB] shadow">
                    <div class="flex mb-8 flex-col gap-4">
                        <div>
                            <span class="title-label-page">Data Desa</span>
                        </div>
                        <div>
                            <x-ui.bread-crumb :breadcrumbs="[['name' => 'Desa', 'url' => route('desa.index')], ['name' => 'Data Desa']]" />
                        </div>
                    </div>
                    <table id="desa-table" class="table">
                        <thead>
                            <tr>
                                <th class="bg-[#F6F8FB] border-b border-[#E5E8EC]">
                                    <span class="flex items-center">
                                        Desa
                                    </span>
                                </th>
                                <th class="bg-[#F6F8FB] border-b border-[#E5E8EC]">
                                    <span class="flex items-center">
                                        Kecamatan
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
                            <tr class="text-black">
                                <td>GPT-4</td>
                                <td>OpenAI</td>
                                <td class="flex gap-3">
                                    <div
                                        class="edit-button flex space-x-1 justify-center items-center font-medium w-fit h-auto p-2 bg-blue-700 rounded-md text-white">
                                        <svg class="w-6 h-6 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                        </svg>
                                        <a href="">Ubah</a>
                                    </div>
                                    <div
                                        class="delete-button flex gap-1 justify-center items-center font-medium w-fit h-auto bg-red-600 rounded-md p-3 text-white">
                                        <svg class="w-6 h-6 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                        <a href="">Hapus</a>
                                    </div>
                                </td>
                            </tr>
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

        if (document.getElementById("desa-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#desa-table", {
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
                                <div
                                    class="add-data-button text-white bg-blue-700 hover:bg-blue-800 w-fit p-2 flex justify-center items-center space-x-1 rounded-lg h-[48px]">
                                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M10 3v4a1 1 0 0 1-1 1H5m4 8h6m-6-4h6m4-8v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
                                    </svg>
                                    <a href="{{ route('desa.create') }}">Tambah Data</a>
                                </div>
                                <div
                                    class="import-csv-button text-white bg-green-500 hover:bg-green-800 w-fit p-2 flex justify-center items-center space-x-1 rounded-lg h-[48px]">
                                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m2.665 9H6.647A1.647 1.647 0 0 1 5 15.353v-1.706A1.647 1.647 0 0 1 6.647 12h1.018M16 12l1.443 4.773L19 12m-6.057-.152-.943-.02a1.34 1.34 0 0 0-1.359 1.22 1.32 1.32 0 0 0 1.172 1.421l.536.059a1.273 1.273 0 0 1 1.226 1.718c-.2.571-.636.754-1.337.754h-1.13" />
                                    </svg>
                                    <a href="">Import Csv</a>
                                </div>
                                <div
                                    class="import-csv-button text-white bg-yellow-500 hover:bg-yellow-800 w-fit p-2 flex justify-center items-center space-x-1 rounded-lg h-[48px]">
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
