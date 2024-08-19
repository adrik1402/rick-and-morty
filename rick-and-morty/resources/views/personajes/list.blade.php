
@if (isset($error))
    <div class="alert alert-danger" role="alert">
        {{ $error }}
    </div>
@else
    <div class="mt-4">
        <h3>Characters</h3>
        <div class="row">
            @foreach ($characters as $character)
            <div class="col-md-3 mb-3">
                <div class="card">
                    <img src="{{ $character['image'] }}" class="card-img-top" alt="{{ $character['name'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $character['name'] }}</h5>
                        <p class="card-text">Status: {{ $character['status'] }}</p>
                        <p class="card-text">Species: {{ $character['species'] }}</p>
                        <p class="card-text">Gender: {{ $character['gender'] }}</p>
                        <div class="d-flex justify-content-between mt-3">
                            <a href="#" onclick="addCharacter('{{ $character['id'] }}')" class="btn btn-success"><i class="fas fa-plus"></i> Add</a>
                            <a href="#" onclick="deleteCharacter('{{ $character['id'] }}')"class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-4 pagination">
            @if ($info['prev'])
                <a style="margin-right: 5px" href="{{ route('characters.index', ['page' => $info['prev']]) }}" class="btn btn-secondary">Anterior</a>
            @endif
            @if ($info['next'])
                <a href="{{ route('characters.index', ['page' => $info['next']]) }}" class="btn btn-secondary">Siguiente</a>
            @endif
        </div>
    </div>
@endif
