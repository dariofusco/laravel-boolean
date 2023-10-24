<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Mail\NewCocktailMember;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required|max:500',
        ]);

        $newContact = new Contact();
        $newContact->name = $data["name"];
        $newContact->email = $data["email"];
        $newContact->message = $data["message"];
        $newContact->save();

        Mail::to($data['email'])->send(new NewCocktailMember($data));

        return response()->json([
            'message' => "Grazie {$data['name']} per il tuo messaggio. Ti contatteremo presto!"
        ], 201);
    }
}
