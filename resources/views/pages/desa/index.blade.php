@extends('layouts.layout')
@section('content')
    <div class="desa-page-content flex flex-col w-full h-screen relative overflow-hidden">
        <x-partials.header />
        <div class="content-container flex w-full h-[calc(100vh-70px)] absolute top-[70px]">
            <x-partials.side-bar />
            <div class="main-content flex-1 overflow-y-auto p-4 w-full">
                
            </div>
        </div>
    </div>
@endsection
