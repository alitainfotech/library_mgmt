<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Retrieve all authors
            $author = $this->author::get();
            $message = 'Author Details';
            return $this->success($message, $author, 200);
        } catch (Exception $e) {
            // Handle exceptions and return an error response
            return $this->error($e->getMessage(), 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:authors',
            ]);

            // Create a new author
            $author = $this->author;
            $author->name = $request->name;
            $author->email = $request->email;
            $author->save();

            $message = 'Author created successfully';
            return $this->success($message, $author, 200);

        } catch (Exception $e) {
            // Handle exceptions and return an error response
            return $this->error($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Find the author by ID
            $author = $this->author::find($id);
            if (!$author) {
                return $this->error('Author not found', 404);
            }
            $message = 'Author Detail';
            return $this->success($message, $author, 200);
        } catch (Exception $e) {
            // Handle exceptions and return an error response
            return $this->error($e->getMessage(), 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Find the author by ID
            $author = $this->author::find($id);
            if (!$author) {
                return $this->error('Author not found', 404);
            }

            // Validate the incoming request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:authors,email,' . $id,
            ]);

            // Update author details
            $author->name = $request->name;
            $author->email = $request->email;
            $author->save();

            $message = 'Author updated successfully';
            return $this->success($message, $author, 200);

        } catch (Exception $e) {
            // Handle exceptions and return an error response
            return $this->error($e->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the author by ID
            $author = $this->author::find($id);
            if (!$author) {
                return $this->error('Author not found', 404);
            }

            // Delete the author
            $author->delete();
            $message = 'Author deleted successfully';
            return $this->success($message, $author, 200);

        } catch (Exception $e) {
            // Handle exceptions and return an error response
            return $this->error($e->getMessage(), 400);
        }
    }
}
