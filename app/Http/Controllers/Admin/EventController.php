<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Services\AlertServiceInterface;

class EventController extends Controller
{
    public function __construct(private readonly AlertServiceInterface $alertService)
    {
    }
    // Afficher tous les événements validés
    public function index()
    {
        //$events = Event::where('is_validated', true)->get();
        // display all events validated, or created by the user, but if the user is an admin, display all events
        if(auth()->user()->role == 'admin'){
            $events = Event::all();
        }else{
            $events = Event::where('is_validated', true)->orWhere('user_id', auth()->user()->id)->get();
        }
        
        return view('users.events.index', compact('events'));
    }

    // Afficher le formulaire de création d'un nouvel événement
    public function create()
    {
        return view('users.events.create');
    }

    // Enregistrer un nouvel événement
    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'type' => 'required|string',
                'event_date' => 'required|date',
                'max_participants' => 'required|integer',
                'registration_deadline' => 'required|date',
                'pre_registration_fee' => 'required|integer',
                'registration_fee' => 'required|integer',
                'location' => 'required|string'
            ]);
            // set is_validated to false
            $request->merge(['is_validated' => false]);
            // add user_id to the request
            $request->merge(['user_id' => auth()->user()->id]);

            Event::create($request->all());

            $this->alertService->success('Événement créé avec succès.');

            return redirect()->route('user.events.index');
        }catch(\Exception $e){
            $this->alertService->error('Une erreur est survenue lors de la création de l\'événement : ' . $e->getMessage());
            return redirect()->route('user.events.index');
        }
    }

    // Valider un événement (pour les administrateurs)
    public function validateEvent(Event $event)
    {
        // if user is not an admin redirect back
        if(!auth()->user()->role == 'admin'){
            $this->alertService->error('Vous n\'êtes pas autorisé à valider un événement.');
            return redirect()->route('user.events.index');
        }
        // if the event is already validated redirect back
        $event->update(['is_validated' => true]);
        $this->alertService->success('Événement validé.');
        return redirect()->route('user.events.index');
    }

    public function unvalidateEvent(Event $event){
        // if user is not an admin redirect back
        if(!auth()->user()->role == 'admin'){
            $this->alertService->error('Vous n\'êtes pas autorisé à invalider un événement.');
            return redirect()->route('user.events.index');
        }
        // if the event is already validated redirect back
        $event->update(['is_validated' => false]);
        $this->alertService->success('Événement invalidé.');
        return redirect()->route('user.events.index');
    }

    // Afficher un événement spécifique with id
    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        $eventregistrations = EventRegistration::where('event_id', $id)->get();

        return view('users.events.show', compact('event', 'eventregistrations'));
    }

    public function edit(Event $event)
    {
        return view('users.events.edit', compact('event'));
    }

    // Mettre à jour un événement dans la base de données
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string',
            'event_date' => 'required|date',
            'max_participants' => 'required|integer',
            'registration_deadline' => 'required|date',
            'pre_registration_fee' => 'required|integer',
            'registration_fee' => 'required|integer',
            'location' => 'required|string'

        ]);

        // set is_validated to false
        $request->merge(['is_validated' => false]);

        $event->update($request->all());
        $this->alertService->success('Événement mis à jour avec succès.');

        return redirect()->route('user.events.index');
    }

    // Supprimer un événement
    public function destroy(Event $event)
    {
        $event->delete();
        $this->alertService->success('Événement supprimé avec succès.');
        return redirect()->route('user.events.index');
    }

    // display all events
    public function all()
    {
        $events = Event::all();
        return view('admin.events.all', compact('events'));
    }    
}