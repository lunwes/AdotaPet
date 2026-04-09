<?php

namespace App\Http\Controllers;

use App\Models\Especie;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Vacina;
use Exception;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $animais = Animal::with('fotos')->get();
        $especies = Especie::all();
        $vacinas = Vacina::all();

        return view('animal.index', compact('animais', 'especies', 'vacinas'));
    }

    public function create()
    {
        $especies = Especie::all();
        $vacinas = Vacina::all();

        return view("animal.create", compact('especies', 'vacinas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:100',
            'sexo' => 'required',
            'sobre' => 'required',
            'especie_id' => 'required|exists:especie,id',
            'fotos' => 'required|array|min:1',
            'fotos.*' => 'image|mimes:jpg,jpeg,png|max:5120'
        ]);

        try {
            DB::beginTransaction();

            $animal = Animal::create([
                'nome' => $request->nome,
                'sexo' => $request->sexo,
                'sobre' => $request->sobre,
                'data_nascimento' => $request->data_nascimento,
                'castracao' => $request->castracao ?? 0,
                'especie_id' => $request->especie_id,
                'adotado' => 0
            ]);

            $vacinas = json_decode($request->vacinas, true);
            if (!empty($vacinas) && is_array($vacinas)) {
                foreach ($vacinas as $nomeVacina) {
                    $vacina = Vacina::firstOrCreate(['nome' => $nomeVacina]);
                    $animal->vacinas()->syncWithoutDetaching([$vacina->id]);
                }
            }

            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $foto) {
                    $caminho = $foto->store('animais', 'public');
                    $animal->fotos()->create(['caminho' => $caminho]);
                }
            }

            DB::commit();

            return redirect()->route('animais.index')
                ->with('success', 'Animal cadastrado com sucesso!');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro ao cadastrar animal: ' . $e->getMessage());

            return back()->with('error', 'Erro ao cadastrar animal. Tente novamente.')
                ->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $animal = Animal::with(['especie', 'fotos', 'vacinas'])->findOrFail($id);
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
        $request->validate([
            'nome' => 'required|max:100',
            'sexo' => 'required',
            'sobre' => 'required',
            'especie_id' => 'required|exists:especie,id',
        ]);

        try {
            DB::beginTransaction();

            $animal = Animal::findOrFail($id);

            // Atualizar dados do animal
            $animal->update([
                'nome' => $request->nome,
                'sexo' => $request->sexo,
                'sobre' => $request->sobre,
                'data_nascimento' => $request->data_nascimento,
                'castracao' => $request->castracao ?? 0,
                'especie_id' => $request->especie_id,
            ]);

            // Remover fotos marcadas para exclusão
            if ($request->has('fotos_remover')) {
                foreach ($request->fotos_remover as $fotoId) {
                    $foto = $animal->fotos()->find($fotoId);
                    if ($foto) {
                        // Remover arquivo do storage
                        \Storage::disk('public')->delete($foto->caminho);
                        $foto->delete();
                    }
                }
            }

            // Adicionar novas fotos
            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $foto) {
                    $caminho = $foto->store('animais', 'public');
                    $animal->fotos()->create(['caminho' => $caminho]);
                }
            }

            // Atualizar vacinas
            $vacinas = json_decode($request->vacinas, true);
            if (!empty($vacinas) && is_array($vacinas)) {
                $vacinasIds = [];
                foreach ($vacinas as $nomeVacina) {
                    $vacina = Vacina::firstOrCreate(['nome' => $nomeVacina]);
                    $vacinasIds[] = $vacina->id;
                }
                $animal->vacinas()->sync($vacinasIds);
            } else {
                $animal->vacinas()->detach();
            }

            DB::commit();

            return redirect()->route('animais.index')
                ->with('success', 'Animal atualizado com sucesso!');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar animal: ' . $e->getMessage());

            return back()->with('error', 'Erro ao atualizar animal. Tente novamente.')
                ->withInput();
        }
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
