<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournois;
use App\Models\ParticipationTournois;
use Illuminate\Support\Facades\Log;
use App\Http\Services\AlertServiceInterface;
class TournoisController extends Controller
{
    public function __construct(private readonly AlertServiceInterface $alertService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupération de tous les tournois
        $tournois = Tournois::all();

        // affichage par date de début de tournoi
        $tournois = Tournois::orderBy('tournoi_start_date', 'desc')->get();

        // Affichage de la vue avec les tournois
        return view('admin.tournois.index', compact('tournois'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Affichage de la vue avec le formulaire de création
        return view('admin.tournois.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validation des données du formulaire
            $validatedData = $request->validate([
                'tournoi_name' => 'required|string|max:255',
                'tournoi_start_date' => 'required|date',
                'tournoi_description' => 'required|string',
                'tournoi_location' => 'required|string',
                'tournoi_registration_deadline' => 'required|date',
                'tournoi_pre_inscription_fee' => 'required|numeric',
                'tournoi_inscription_fee' => 'required|numeric',
                'tournoi_max_participants' => 'required|numeric',
                'tournoi_team_local' => 'required|string|max:255',
                'tournoi_team_visitor' => 'required|string|max:255',

                // Inclure des règles de validation pour les autres champs si nécessaire
            ]);


            // Création du tournoi
            Tournois::create($validatedData);
        } catch (\Exception $e) {
            $this->alertService->error('Une erreur est survenue : ' . $e->getMessage());
            return redirect()->back();
        }
        $this->alertService->success('Le tournoi a bien été créé.');
        return redirect()->route('admin.tournois.index');

    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Récupération du tournoi
        $tournoi = Tournois::findOrFail($id);

        // Récupération des participations
        $participants = ParticipationTournois::where('tournoi_id', $id)->get();


        // Affichage de la vue avec le tournoi et les participations
        return view('admin.tournois.show', compact('tournoi', 'participants'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Récupération du tournoi
        $tournoi = Tournois::findOrFail($id);

        // Affichage de la vue avec le formulaire d'édition
        return view('admin.tournois.edit', compact('tournoi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Récupération du tournoi
            $tournoi = Tournois::findOrFail($id);

            // Validation des données du formulaire
            $validatedData = $request->validate([
                'tournoi_name' => 'required|string|max:255',
                'tournoi_start_date' => 'required|date',
                'tournoi_description' => 'required|string',
                'tournoi_location' => 'required|string',
                'tournoi_registration_deadline' => 'required|date',
                'tournoi_pre_inscription_fee' => 'required|numeric',
                'tournoi_inscription_fee' => 'required|numeric',
                'tournoi_max_participants' => 'required|numeric',
                'tournoi_team_local' => 'required|string|max:255',
                'tournoi_team_visitor' => 'required|string|max:255',
            ]);

            // Mise à jour du tournoi
            $tournoi->update($validatedData);
        } catch (\Exception $e) {
            $this->alertService->error('Une erreur est survenue lors de la mise à jour du tournoi.');
            return redirect()->back();
        }
        $this->alertService->success('Le tournoi a bien été modifié.');
        return redirect()->route('admin.tournois.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Récupération du tournoi
            $tournoi = Tournois::findOrFail($id);

            // Suppression du tournoi
            $tournoi->delete();
        } catch (\Exception $e) {
            $this->alertService->error('Une erreur est survenue lors de la suppression du tournoi.');
            return redirect()->back();
        }
        $this->alertService->success('Le tournoi a bien été supprimé.');

        return redirect()->route('admin.tournois.index');
    }
}
