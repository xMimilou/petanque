<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;
use Illuminate\Support\Facades\Log;
use App\Http\Services\AlertServiceInterface;

class ContactsController extends Controller
{
    public function __construct(private readonly AlertServiceInterface $alertService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::all();
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Display all messages by users
     */

    public function messages()
    {
        // if user is connected, display all from the user where email is the same as the connected user if user is not connected, display nothing
        if (auth()->user()) {
            $contacts = Contact::where('contact_sender_email', auth()->user()->email)->get();
        } else {
            $contacts = [];
        }
        
        return view('users.contacts.messages', compact('contacts'));
    }

    public function archived()
    {
        $archivedContacts = Contact::where('is_archived', true)->get();
        return view('admin.contacts.archived', compact('archivedContacts'));
    }

    /**
     * Archive the specified resource.
     */
    public function archive(Request $request, string $id)
    {
        try {
            // Utilisation de la méthode update pour modifier directement le contact
            Log::info("Archiving contact with ID: $id");
            Contact::where('id', $id)->update(['is_archived' => true]);
        } catch (\Exception $e) {
            Log::info("test");
            //Log::error($e->getMessage());
            $this->alertService->error('Une erreur est survenue lors de l’archivage du contact.');
            return redirect()->back();
        }
        $this->alertService->success('Le contact a bien été archivé.');
        return redirect()->route('admin.contacts.index');
    }

    // unarchive
    public function unarchive(Request $request, string $id)
    {
        try {
            // Utilisation de la méthode update pour modifier directement le contact
            Log::info("Unarchiving contact with ID: $id");
            Contact::where('id', $id)->update(['is_archived' => false]);
        } catch (\Exception $e) {
            $this->alertService->error('Une erreur est survenue lors de la désarchivage du contact.');
            //Log::error($e->getMessage());
            return redirect()->back();
        }
        $this->alertService->success('Le contact a bien été désarchivé.');
        return redirect()->route('admin.contacts.index');
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'contact_sender_email' => 'required|email',
                'contact_sender_object' => 'required|string', // 'nullable|string
                'contact_sender_message' => 'required|string',
            ]);
            Contact::create($validatedData);
        } catch (\Exception $e) {
            $this->alertService->error('Une erreur est survenue lors de la création du contact.');
            return redirect()->back();
        }
        $this->alertService->success('Le contact a bien été créé.');
        return redirect()->route('user.contacts.messages');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = Contact::findOrFail($id);
        return view('users.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contacts = Contact::findOrFail($id);
        return view('admin.contacts.edit', compact('contacts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $validatedData = $request->validate([
                'contact_sender_email' => 'required|email',
                'contact_sender_object' => 'required|string', // 'nullable|string
                'contact_sender_message' => 'required|string',
            ]);
            $contact->update($validatedData);
        } catch (\Exception $e) {
            $this->alertService->error('Une erreur est survenue lors de la modification du contact.');
            return redirect()->back();
        }
        $this->alertService->success('Le contact a bien été modifié.');
        return redirect()->route('admin.contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
        } catch (\Exception $e) {
            $this->alertService->error('Une erreur est survenue lors de la suppression du contact.');
            return redirect()->back();
        }
        $this->alertService->success('Le contact a bien été supprimé.');
        return redirect()->route('admin.contacts.index');
    }
}
