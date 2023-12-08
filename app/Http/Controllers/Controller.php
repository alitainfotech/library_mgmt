<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Author;
use App\Models\Book;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->author = new Author;
        $this->book = new Book;
    }

    public function success($message, $data, $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ],$code);
    }

    public function error($message, $code)
    {
        return response()->json([
            'status' => 'error',
            'code' => $code,
            'message' => $message,
        ], $code);
    }

}
