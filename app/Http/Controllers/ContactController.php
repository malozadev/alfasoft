<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Data Validation
        $validatedData = $request->validate([
            'name' => 'required|string|min:5|max:255',
            'contact' => 'required|integer|unique:contacts,contact|digits:9',
            'email' => 'required|email|unique:contacts,email|max:255',
            'address' => 'nullable|string|max:500',
        ], [
            // Name field messages
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.min' => 'Name must be at least 5 characters.',
            'name.max' => 'Name may not be greater than 255 characters.',

            // Contact field messages
            'contact.required' => 'Contact number is required.',
            'contact.integer' => 'Contact must be an integer.',
            'contact.unique' => 'This contact number is already registered.',
            'contact.digits' => 'Contact must be exactly 9 digits.',

            // Email field messages
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'email.max' => 'Email may not be greater than 255 characters.',

            // Address field messages
            'address.string' => 'Address must be a string.',
            'address.max' => 'Address may not be greater than 500 characters.',
        ]);

        try {
            Contact::create($validatedData);

            return redirect()->route('contacts.index')
                ->with('success', 'Contact created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating contact: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $contact = Contact::findOrFail($id);

        // Data validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contacts,email,' . $id . '|max:255',
            'contact' => 'required|integer|unique:contacts,contact,' . $id . '|digits:9',
            'address' => 'nullable|string|max:500',
        ], [
            // Name field messages
            'name.required' => 'Name is required.',

            // Email field messages
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',

            // Contact field messages
            'contact.required' => 'Contact number is required.',
            'contact.integer' => 'Contact must be an integer.',
            'contact.unique' => 'This contact number is already registered.',
            'contact.digits' => 'Contact must be exactly 9 digits.',

            // Address field messages
            'address.string' => 'Address must be a string.',
            'address.max' => 'Address may not be greater than 500 characters.',
        ]);

        try {
            $contact->update($validatedData);

            return redirect()->route('contacts.index')
                ->with('success', 'Contact updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating contact: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $contact = Contact::findOrFail($id);

            // Como não há tabelas relacionadas, podemos excluir diretamente
            $contact->delete();

            return redirect()->route('contacts.index')
                ->with('success', 'Contact deleted successfully!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('contacts.index')
                ->with('error', 'Contact not found.');
        } catch (\Exception $e) {
            return redirect()->route('contacts.index')
                ->with('error', 'Error deleting contact: ' . $e->getMessage());
        }
    }
}
