@extends('layouts.app')

@section('content')
<div class="container container-inicio">
    <div class="row align-items-center">
        <div class="col-md-6 text-center">
            <img src="{{ asset('build/assets/img/img-principal.png') }}" alt="img-principal" class="img-fluid">
        </div>
        <div class="col-md-6 text-center">
            <div class="d-flex flex-column align-items-center">
                <a href="{{ route('characters.index') }}" class="btn btn-primary my-2">
                    Ver Personajes
                </a>
                <a href="{{ route('favoritos') }}" class="btn btn-secondary my-2">
                    Ver Favoritos
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
