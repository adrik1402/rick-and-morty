<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorito;

class CharacterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $page = 1)
    {
        $filters = $this->manageFilters($request, $page);

        $response = Http::get('https://rickandmortyapi.com/api/character', $this->buildQueryParams($filters, $page));

        if ($response->successful()) {
            $data = $response->json();
            return $this->renderView($request, $data['results'] ?? [], $data['info'] ?? [], $filters);
        }

        return $this->renderView($request, [], [], $filters, 'No se pudo obtener los personajes.');
    }

    public function addCharacter(Request $request)
    {
        $user_id = Auth::id();
        $personaje_id = $request->input('id');

        if ($this->isCharacterFavorited($user_id, $personaje_id)) {
            return response()->json(['success' => false, 'message' => 'Este personaje ya está en tus favoritos.']);
        }

        return $this->saveFavorite($user_id, $personaje_id);
    }

    public function deleteCharacter(Request $request)
    {
        $user_id = Auth::id();
        $personaje_id = $request->input('id');

        return $this->removeFavorite($user_id, $personaje_id);
    }

    public function getFavoritos()
    {
        $user_id = Auth::id();
        $favoritos = Favorito::where('user_id', $user_id)->pluck('personaje_id');

        if ($favoritos->isEmpty()) {
            return view('favoritos', ['characters' => []]);
        }

        $response = Http::get("https://rickandmortyapi.com/api/character/{$favoritos->implode(',')}");

        return $response->successful()
            ? view('favoritos', ['characters' => $this->formatCharacters($response->json())])
            : response()->json(['error' => 'No se pudieron obtener los personajes de la API.'], 500);
    }
    private function manageFilters(Request $request, &$page)
    {
        $filters = $request->session()->get('filters', []);
        if ($request->has('filters')) {
            $filters = $request->input('filters');
            $request->session()->put('filters', $filters);
            $page = 1;
        } else {
            $page = $request->page;
        }

        return $filters;
    }

    private function buildQueryParams(array $filters, $page)
    {
        return array_merge(array_filter($filters), ['page' => $page]);
    }

    private function renderView(Request $request, array $characters, array $info, array $filters, $error = null)
    {
        $view = $request->ajax() ? 'personajes.list' : 'home';
        return view($view, [
            'characters' => $characters,
            'info' => $info,
            'filters' => $filters,
            'error' => $error,
            'species' => $this->getEspecies(),
        ]);
    }

    private function isCharacterFavorited($user_id, $personaje_id)
    {
        return Favorito::where('user_id', $user_id)->where('personaje_id', $personaje_id)->exists();
    }

    private function saveFavorite($user_id, $personaje_id)
    {
        try {
            Favorito::create(['user_id' => $user_id, 'personaje_id' => $personaje_id]);
            return response()->json(['success' => true, 'message' => 'Personaje añadido a favoritos.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'No se pudo añadir el personaje a favoritos.']);
        }
    }

    private function removeFavorite($user_id, $personaje_id)
    {
        try {
            $favorito = Favorito::where('user_id', $user_id)->where('personaje_id', $personaje_id)->firstOrFail();
            $favorito->delete();
            return response()->json(['success' => true, 'message' => 'Eliminado correctamente!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Fallo al eliminar']);
        }
    }

    protected function getEspecies()
    {
        return [
            'human' => 'Human',
            'alien' => 'Alien',
        ];
    }

    private function formatCharacters($characters)
    {
        return isset($characters['id']) ? [$characters] : $characters;
    }
}
