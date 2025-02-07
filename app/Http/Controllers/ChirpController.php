<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        // return view('chirps.index'); 
        /**  
        * Passer les instances du model Chirp associés à un user à la view chirps.index  
        * en utilisant le "eager loading" (with), et trié par ordre chronologique décroissant. 
        **/ 
        return view('chirps.index', [ 
            'chirps' => Chirp::with('user')->latest()->get(), 
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate : controle du format du message ( obligatoire / chaine de caractères / max 255 caractères )
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
        // create : création d'un objet Chirp avec le message et l'id de l'utilisateur connecté
        $request->user()->chirps()->create($validated);
        // redirect : redirection vers la page d'accueil
        return redirect()->route('chirps.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp) : View
    {
        // retourner la view
        $this->authorize('update', $chirp); 
        return view('chirps.edit', [ 
            'chirp' => $chirp, 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp) : RedirectResponse
    {
        // Contrôler les données
        $this->authorize('update', $chirp);
        $validated = $request->validate([ 
            'message' => 'required|string|max:255', 
        ]); 
        // Update 
        $chirp->update($validated); 
        //Rediriger 
        return redirect(route('chirps.index')); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        // contrôle autorisation pour delete
        $this->authorize('delete',$chirp);
        // delete
        $chirp->delete();
        // Rediriger
        return redirect(route('chirps.index'));
    }
}
