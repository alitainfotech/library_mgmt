<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class BookController extends Controller
{
    /**
     * Display the main page for listing books.
     */
    public function list()
    {
        return view('index');
    }

    public function getBooks(Request $request)
    {
        $perPage = 10; // Number of records per page
        $totalRecords = $this->book::count();
        $totalPages = ceil($totalRecords / $perPage);

        $currentPage = $request->query('page', 1);

        $draw = $request->get('draw');
        $start = $request->get("start") ?? 0;
        $rowperpage = $request->get("length") ?? 10; // Set a default value if needed

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');

        $columnIndex = !empty($columnIndex_arr) ? $columnIndex_arr[0]['column'] : 0;
        $columnName = (!empty($columnName_arr) && isset($columnName_arr[$columnIndex])) ? $columnName_arr[$columnIndex]['data'] : 'id';
        $columnSortOrder = !empty($order_arr) ? $order_arr[0]['dir'] : 'asc';

        // Count total records and records with filter
        $totalRecords = $this->book::with('libraryName')->select('count(*) as allcount')->count();

        $records = $this->book::with('libraryName')
        ->orderBy($columnName, $columnSortOrder)
        ->where('library', 1)
        ->skip(($currentPage - 1) * $perPage)
        ->take($perPage)
        ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $id = $record->id;
            $name = $record->name;
            $authorNames = $record->authors->pluck('name')->implode(', '); // Concatenate author names
            $libraryName = $record->libraryName->name; // Get library name

            // Additional fields
            $imageUrl = asset('storage/books/' . $record->image); // Adjust the path accordingly

            $data_arr[] = [
                'id' => $id,
                'name' => $name,
                'author_names' => $authorNames,
                'library_name' => $libraryName,
                'image_url' => $imageUrl,
            ];
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "data" => $data_arr,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        );

        return response()->json($response);
    }

    /**
     * Display all books.
     */
    public function index()
    {
        try{
            // Retrieve all books with associated library information
            $books = $this->book::with('library')->get();
            $message = 'Book Details';
            return $this->success($message, $books, 200);
        }catch (Exception $e) {
            // Handle exceptions and return an error response
            return $this->error($e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(Request $request)
    {
        try{
            // Validate incoming request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'author_id' => [
                    'required',
                    'array', // Ensure 'author_id' is an array
                    'exists:authors,id', // Check if each author ID in the array exists
                ],
                'library' => [
                    'required',
                    'exists:libraries,id',
                ],
                'image' => 'required',
            ]);

            // Process and store book information
            $authorIds = implode(',', $validatedData['author_id']);
            $filename = time() . rand(1000, 9999) . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('books', $filename, 'public');
            $imagePath = str_replace('books/', '', $imagePath);
            $book = $this->book;
            $book->name = $request->name;
            $book->author_id = $authorIds;
            $book->image = $imagePath;
            $book->library = auth()->user()->id;
            $book->save();

            $message = 'Book created successfully';
            return $this->success($message, $book, 200);

        } catch (Exception $e) {
            // Handle exceptions and return an error response
            return $this->error($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified book.
     */
    public function show(string $id)
    {
        try{
            // Find and display the specified book
            $book = $this->book::with('libraryName')->find($id);
            if (!$book) {
                return $this->error('Book not found', 404);
            }
            $message = 'Book Detail';
            return $this->success($message, $book, 200);
        }catch (Exception $e) {
            // Handle exceptions and return an error response
            return $this->error($e->getMessage(), 400);
        }
    }

    /**
     * Update the specified book in storage.
     */
    public function update(Request $request)
    {
        try {
            // Validate incoming request data for book update
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'author_id' => [
                    'required',
                    'exists:authors,id',
                ],
                'id' => [
                    'required',
                    'exists:books,id',
                ],
                'library ' => [
                    'required',
                    'exists:libraries,id',
                ],
                'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif', // 'sometimes' means the field is optional
            ]);

            // Find and update the specified book
            $book = $this->book::find($request->id);
            if (!$book) {
                return $this->error('Book not found', 404);
            }

            $book->name = $request->name;
            $book->author_id = $request->author_id;

            // Handle book image update
            if ($request->hasFile('image')) {
                $filename = time() . rand(1000, 9999) . '.' . $request->file('image')->getClientOriginalExtension();

                $imagePath = $request->file('image')->storeAs('books', $filename, 'public');

                $imagePath = str_replace('books/', '', $imagePath);

                // Delete old image if exists
                if ($book->image) {
                    Storage::disk('public')->delete('books/' . $book->image);
                }

                $book->image = $imagePath;
            }

            $book->save();

            $message = 'Book updated successfully';
            return $this->success($message, $book, 200);

        } catch (Exception $e) {
            // Handle exceptions and return an error response
            return $this->error($e->getMessage(), 400);
        }
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(string $id)
    {
        try{
            // Find and delete the specified book
            $book = $this->book::find($id);
            if (!$book) {
                return $this->error('Book not found', 404);
            }
            $book->delete();
            $message = 'Book deleted successfully';
            return $this->success($message, $book, 200);

        } catch (Exception $e) {
            // Handle exceptions and return an error response
            return $this->error($e->getMessage(), 400);
        }
    }
}
