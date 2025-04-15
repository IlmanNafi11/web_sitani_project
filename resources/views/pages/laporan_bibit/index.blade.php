@extends('layouts.layout')
@section('content')
    <x-ui.result-alert />
    <div class="laporan-bibit-page-content flex flex-col w-full h-screen relative overflow-hidden">
        <x-partials.header />
        <div class="content-container flex w-full h-[calc(100vh-70px)] absolute top-[70px]">
            <x-partials.side-bar />
            <div class="content flex-1 w-full overflow-scroll p-8 flex">
                <div class="main-content w-full overflow-y-auto p-6 rounded-xl bg-white border border-[#E5E8EC]">
                    <div class="flex mb-8 flex-col gap-4">
                        <div>
                            <span class="title-label-page">Data Laporan Bibit</span>
                        </div>
                        <div>
                            <x-ui.bread-crumb :breadcrumbs="[['name' => 'Laporan Bibit', 'url' => route('laporan-bibit.index')], ['name' => 'Data Laporan']]" />
                        </div>
                    </div>
                    <table id="laporan-bibit-table" class="table">
                        <x-ui.table.header-table :items="[
                            ['title' => 'Kelompok Tani'],
                            ['title' => 'Komoditas'],
                            ['title' => 'Estimasi Panen'],
                            ['title' => 'Pelapor'],
                            ['title' => 'Waktu Laporan'],
                            ['title' => 'Status'],
                            ['title' => 'Aksi'],
                        ]" />
                        <tbody>
                            @forelse ($laporans as $laporan)
                                <tr class="text-black">
                                    <td>{{ $laporan->kelompokTani->nama }}</td>
                                    <td>{{ $laporan->komoditas->nama }}</td>
                                    <td>{{ $laporan->laporanKondisiDetail->estimasi_panen }}</td>
                                    <td>{{ $laporan->penyuluh->penyuluhTerdaftar->nama }}</td>
                                    <td>{{ $laporan->created_at }}</td>
                                    @php
                                        $statusMap = [
                                            "1" => ['title' => 'Berkualitas', 'color' => 'badge-success'],
                                            "0" => ['title' => 'Tidak Berkualitas', 'color' => 'badge-error'],
                                            "2" => ['title' => 'Menunggu Verifikasi', 'color' => 'badge-warning'],
                                        ];

                                        $statusData = $statusMap[$laporan->status] ?? ['title' => 'Status tidak diketahui', 'color' => 'badge-secondary'];
                                    @endphp
                                    <td>
                                        <x-ui.badge :color="$statusData['color']" :title="$statusData['title']" :style="'badge-soft'">
                                            {{ $statusData['title'] }}
                                        </x-ui.badge>
                                    </td>
                                    <td>
                                    <x-ui.dropdown-action :title="'Lihat Aksi'">
                                        <x-ui.button-edit id="{{$laporan->id}}" route="laporan-bibit.edit" title="Verifikasi"/>
                                        <x-ui.button-delete id="{{$laporan->id}}" route="laporan-bibit.destroy"/>
                                    </x-ui.dropdown-action>
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
        if (document.getElementById("laporan-bibit-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#laporan-bibit-table", {
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
        }
    </script>
@endsection
