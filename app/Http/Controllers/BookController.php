<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function getBooks(Request $request)
    {
        $builder = Book::query();
        $term = $request->query();

        if (!empty($term['languages'])) {
            $builder->whereIn('language_id', $term['languages']);
        }

        if (!empty($term['categories'])) {
            $builder->whereIn('category_id', $term['categories']);
        }

        if (!empty($term['authors'])) {
            $builder->whereHas('authors', function ($q) use ($term) {
                $q->whereIn('authors.id', $term['authors']);
            });
        }

        $books = $builder->with(['language', 'category', 'authors'])->paginate(6);
        return response()->json(['books' => $books], 200);
    }

    public function getBooksByIds(Request $request)
    {
        $ids = $request->query('ids');
        $books = Book::whereIn('id', $ids)->get();

        return response()->json(['books' => $books], 200);
    }

    public function getBook($id)
    {
        $book = Book::where('id', $id)->with(['language', 'category', 'authors'])->whereHas("orders", function ($query) {
            $query->where("orders.created_at", ">=", Carbon::now()->subDays(7));
        })->first();
        return view('pages.user.book-user', ['book' => $book]);
    }

    public function updateBook($id, Request $request)
    {
        Book::find($id)->update($request->all());
    }
    public function createBook(Request $request)
    {

        $book = Book::create($request->all());

        $path = null;
        if ($request->hasFile('book_picture')) {
            $book_picture = $request->file('book_picture');
            $naziv = time() . '.' . $book_picture->getClientOriginalExtension();

            $path = $book_picture->storeAs('', $naziv, 'public');
        };

        $book->book_image_path = $path;
        $book->save();
        if ($request->input('authors')) {

            $book->authors()->attach(explode(',', $request->input('authors')));
        }

        return response()->json(['message' => 'Knjiga uspesno napravljena'], 200);
    }
    public function deleteBook($id)
    {
        Book::find($id)->delete();

        return response()->json(['message' => 'Knjiga uspesno obrisana'], 200);
    }
}
