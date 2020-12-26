<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all()->toArray();
        return response()->json([
            'success' => true,
            'data' => $authors
        ]);
    }
    public function show($id)
    {
        $authors=Author::find($id);
 
        if (!$authors) {
            return response()->json([
                'success' => false,
                'message' => 'Author with id ' . $id . ' not found'
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $authors->toArray()
        ], 400);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'author_name' => 'required',
            
        ]);
 
        $authors = new Author();
        $authors->author_name = $request->author_name;
        $authors->save();
 
            if($authors)
            return response()->json([
                'success' => true,
                'data' => $authors->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Author could not be added'
            ], 500);
    }
    public function update(Request $request, $id) {
            $authors=Author::find($id);
            $authors->author_name = $request->input('author_name');
          $authors->save();
        if($authors)
          return response()->json([
            "message" => "records updated successfully"
          ], 200);
        
        else {
          return response()->json([
            "message" => "Author not found"
          ], 404);
        }
      }
      public function destroy(Request $request,$id)
    {
      $authors=Author::find($id);
      if (!$authors) {
        return response()->json([
            'success' => false,
            'message' => 'Author with id ' . $id . ' not found'
        ], 400);
    }

    if ($authors->delete()) {
        return response()->json([
            'success' => true,
            'message' => 'Author deleted'
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Author could not be deleted'
        ], 500);
    }
}
}
