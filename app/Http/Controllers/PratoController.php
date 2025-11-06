<?php

namespace App\Http\Controllers;

use App\Models\Prato;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PratoController extends Controller
{
    // Lista todos os pratos COM BUSCA
    public function index(Request $request)
    {
        $search = $request->get('search');
        $pratosQuery = Prato::with('categoria')->orderBy('descricao');
        
        if ($search) {
            $pratosQuery->where(function($query) use ($search) {
                $query->where('descricao', 'like', "%{$search}%")
                    ->orWhereHas('categoria', function($q) use ($search) {
                        $q->where('descricao', 'like', "%{$search}%");
                    });
            });
        }
        
        $pratos = $pratosQuery->paginate(10)->appends(['search' => $search]);
        
        return view('admin.pratos', compact('pratos', 'search'));
    }

    // Formulário para criar novo prato
    public function create()
    {
        $categorias = Categoria::orderBy('descricao')->get();
        return view('admin.create-prato', compact('categorias'));
    }

    // Salvar novo prato
    public function store(Request $request)
    {
        $validated = $request->validate([
            'descricao' => 'required|string|max:255',
            'cod_cat' => 'required|exists:categorias,cod_cat',
            'valor_unitario' => 'required|numeric|min:0',
            'foto_prato' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Upload da imagem para public/images/pratos/
        if ($request->hasFile('foto_prato')) {
            $validated['foto_prato'] = $this->uploadImagem($request->file('foto_prato'));
        }

        Prato::create($validated);

        return redirect()->route('admin.pratos.index')
            ->with('success', 'Prato criado com sucesso!');
    }

    // Mostrar um prato específico
    public function show(Prato $prato)
    {
        return view('admin.pratos.show', compact('prato'));
    }

    // Formulário para editar prato
    public function edit($id)
    {
        $prato = Prato::findOrFail($id);
        $categorias = Categoria::orderBy('descricao')->get();
        return view('admin.edit-prato', compact('prato', 'categorias'));
    }

    // Atualizar prato
    public function update(Request $request, $id)
    {
        $prato = Prato::findOrFail($id);

        $validated = $request->validate([
            'descricao' => 'required|string|max:255',
            'cod_cat' => 'required|exists:categorias,cod_cat',
            'valor_unitario' => 'required|numeric|min:0',
            'foto_prato' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Se enviou nova imagem
        if ($request->hasFile('foto_prato')) {
            // Deleta imagem antiga
            if ($prato->foto_prato) {
                $this->deletarImagem($prato->foto_prato);
            }
            // Upload nova imagem
            $validated['foto_prato'] = $this->uploadImagem($request->file('foto_prato'));
        }

        $prato->update($validated);

        return redirect()->route('admin.pratos.index')
            ->with('success', 'Prato atualizado com sucesso!');
    }

    // Deletar prato
    public function destroy($id)
    {
        $prato = Prato::findOrFail($id);

        // Deleta a imagem do servidor
        if ($prato->foto_prato) {
            $this->deletarImagem($prato->foto_prato);
        }

        $prato->delete();

        return redirect()->route('admin.pratos.index')
            ->with('success', 'Prato deletado com sucesso!');
    }

    // ==================== MÉTODOS AUXILIARES ====================

    // Upload da imagem para public/images/pratos/
    private function uploadImagem($file)
    {
        // Gera nome único para o arquivo
        $nomeOriginal = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $nomeSlug = Str::slug($nomeOriginal);
        $extensao = $file->getClientOriginalExtension();
        $nomeArquivo = $nomeSlug . '-' . time() . '.' . $extensao;
        
        // Move para public/images/pratos/
        $file->move(public_path('images/pratos'), $nomeArquivo);
        
        return $nomeArquivo; // Salva apenas o nome no banco
    }

    // Deletar imagem do servidor
    private function deletarImagem($nomeArquivo)
    {
        $caminho = public_path('images/pratos/' . $nomeArquivo);
        if (file_exists($caminho)) {
            unlink($caminho);
        }
    }
}