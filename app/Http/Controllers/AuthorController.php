<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function getAuthors()
    {

        return response()->json(['authors' => Author::all()], 200);
    }

    public function createAuthor(Request $request) {

        Author::create($request->all());

        return response()->json(['message' => 'Autor uspesno dodat'], 200);
    }

    public function deleteAuthor(Author $author) {

        $author->delete();
        return response()->json(['message' => 'Autor uspesno izbrisan'], 200);
    }
}
