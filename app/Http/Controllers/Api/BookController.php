<?php

namespace App\Http\Controllers\Api;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return response(['users' => Book::all()]);
        $books = Book::all();
        return new BookCollection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {

        try {
            $validated = $request->validated();
            $book = Book::create($validated);
            return response([
                'status' => 'success',
                'message' => 'create book successfully',
                'book' => new BookResource($book)
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return response([
            'status' => 'success',
            'data' => new BookResource($book)
        ]);

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        try {
            $data = $request->validated();
            $book->update($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Update book successfully',
                'data' => new BookResource($book)
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        try {
            $data = $book->name;
            $book->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Delete successfully',
                'Deleted book' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
