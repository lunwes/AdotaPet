<?php

namespace App\Http\Controllers;

use App\Models\Especie;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $animais = Animal::with('fotos')->get();
        return view('animal.index', compact('animais'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $especies = Especie::all();
        return view("animal.create", compact('animals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Animal::create($request->all());
        } catch (Exception $e) {
            Log::error('Erro ao inserir animal: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString()
            ]);
        }
        return redirect()->route('animals.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $animal = Animal::findOrFail($id);
        return view("animal.show", compact('animal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $animal = Animal::findOrFail($id);
        $especies = Especie::all();
        return view('animal.edit', compact('especies', 'animal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $animal = Animal::findOrFail($id);
            $animal->update($request->all());
        } catch (Exception $e) {
            Log::error('Erro ao alterar animal: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString()
            ]);
        }
        return redirect()->route('animals.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $animal = Animal::findOrFail($id);
            $animal->delete();
        } catch (Exception $e) {
            Log::error('Erro ao excluir animal: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString()
            ]);
        }
        return redirect()->route('animals.index');
    }
}
