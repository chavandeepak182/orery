<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all()->toArray();
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
    public function show($id)
    {
        $categories=Category::find($id);
 
        if (!$categories) {
            return response()->json([
                'success' => false,
                'message' => 'Category with id ' . $id . ' not found'
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $categories->toArray()
        ], 400);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_name' => 'required',
            
        ]);
 
        $categories = new Category();
        $categories->category_name = $request->category_name;
        $categories->save();
 
            if($categories)
            return response()->json([
                'success' => true,
                'data' => $categories->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Category could not be added'
            ], 500);
    }
    public function update(Request $request, $id) {
            $categories=Category::find($id);
            $categories->category_name = $request->input('category_name');
          $categories->save();
        if($categories)
          return response()->json([
            "message" => "records updated successfully"
          ], 200);
        
        else {
          return response()->json([
            "message" => "Category not found"
          ], 404);
        }
      }
      public function destroy(Request $request,$id)
    {
      $categories=Category::find($id);
      if (!$categories) {
        return response()->json([
            'success' => false,
            'message' => 'Category with id ' . $id . ' not found'
        ], 400);
    }

    if ($categories->delete()) {
        return response()->json([
            'success' => true,
            'message' => 'Category deleted'
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Category could not be deleted'
        ], 500);
    }
}
    
}
