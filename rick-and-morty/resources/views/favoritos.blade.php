@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

<h1 style="text-align: center; color:white">Tus favoritos</h1>
        <!-- Lista de personajes favoritos -->
        @if($characters)
        <div id="characters-list" class="row">
            @forelse ($characters as $character)
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <img src="{{ $character['image'] }}" class="card-img-top" alt="{{ $character['name'] }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $character['name'] }}</h5>
                            <p class="card-text">Status: {{ $character['status'] }}</p>
                            <p class="card-text">Species: {{ $character['species'] }}</p>
                            <p class="card-text">Gender: {{ $character['gender'] }}</p>
                            <button class="btn btn-danger" onclick="deleteCharacter({{ $character['id'] }})">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </div>
                    </div>
                </div>
        @empty
                <div class="col-md-12">
                    <p>No tienes personajes favoritos.</p>
                </div>
            @endforelse
            @endif
        </div>
    </div>
</div>

<!-- Incluye toastr.js si aún no está incluido -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"/>

@endsection
