@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Personajes') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Formulario de Filtros -->
                    <form id="filters-form" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="name">Nombre:</label>
                                <input type="text" name="filters[name]" class="form-control" placeholder="Name" value="{{ $filters['name'] ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <label for="status">Estado:</label>
                                <select name="filters[status]" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="alive" {{ (isset($filters['status']) && $filters['status'] == 'alive') ? 'selected' : '' }}>Alive</option>
                                    <option value="dead" {{ (isset($filters['status']) && $filters['status'] == 'dead') ? 'selected' : '' }}>Dead</option>
                                    <option value="unknown" {{ (isset($filters['status']) && $filters['status'] == 'unknown') ? 'selected' : '' }}>Unknown</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="species">Especie:</label>
                                <select name="filters[species]" class="form-control">
                                    <option value="">Todas</option>
                                    @foreach ($species as $key => $value)
                                        <option value="{{ $key }}" {{ (isset($filters['species']) && $filters['species'] == $key) ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="gender">Género:</label>
                                <select name="filters[gender]" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="female" {{ (isset($filters['gender']) && $filters['gender'] == 'female') ? 'selected' : '' }}>Female</option>
                                    <option value="male" {{ (isset($filters['gender']) && $filters['gender'] == 'male') ? 'selected' : '' }}>Male</option>
                                    <option value="unknown" {{ (isset($filters['gender']) && $filters['gender'] == 'unknown') ? 'selected' : '' }}>Unknown</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>

                    <!-- Lista de personajes -->
                    <div id="characters-list">
                        @include('personajes.list', ['characters' => $characters, 'info' => $info])
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
        $('#filters-form').on('submit', function(event) {
            event.preventDefault(); 

            $.ajax({
                url: '{{ route('characters.index', ['page' => 1]) }}',
                method: 'GET',
                data: $(this).serialize(),
                success: function(response) {
                    $('#characters-list').html(response);
                }
            });
        });

    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        var url = $(this).attr('href');

        if (url && url.startsWith('http')) {
            url = url.replace('https://rickandmortyapi.com/api/character', '');
        }

        $.ajax({
            url: url,
            success: function(response) {
                $('#characters-list').html(response);
            },
            error: function(xhr) {
                console.log('Error:', xhr.responseText);
            }
        });
    });
    });
</script>
@endsection
