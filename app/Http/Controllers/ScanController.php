<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('mesa')) {
            $tableCode = $request->get('mesa');
            
            $mesa = \App\Models\Mesa::where('descricao', $tableCode)->first();
            
            if ($mesa) {
                session([
                    'mesa_logada' => true,
                    'mesa_id' => $mesa->cod_mesa,
                    'table_code' => $mesa->descricao,
                ]);
                
                \Illuminate\Support\Facades\Log::info('Mesa logada via QR Code: ' . $mesa->descricao);
                
                return redirect()->route('menu')
                    ->with('success', 'Bem-vindo! Mesa ' . $mesa->descricao . ' registrada.');
            } else {
                return view('scan')->with('error', 'Mesa não encontrada! Verifique o QR Code.');
            }
        }
        
        return view('scan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_code' => 'required|string|max:50'
        ]);

        session(['table_code' => $request->table_code]);

        return redirect()->route('menu')
            ->with('success', 'Mesa registrada com sucesso!');
    }
}