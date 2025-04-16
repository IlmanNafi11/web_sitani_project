@extends('layouts.layout')
@section('title', 'Dashboard | Sitani')
@section('content')
    <div class="w-full h-full flex justify-center items-center flex-col">
        <picture>
            <source srcset="{{ asset('storage/profile/profile.jpg') }}" type="image/jpeg" />
            <img src="{{ asset('storage/profile/profile.webp') }}" alt="avatar profil" />
        </picture>
        <span>Proses....</span>
    </div>
@endsection
