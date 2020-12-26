<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publication;

class PublicationController extends Controller
{
    public function index()
    {
        $publications = Publication::all()->toArray();
        return response()->json([
            'success' => true,
            'data' => $publications
        ]);
    }
    public function show($id)
    {
        $publications=Publication::find($id);
 
        if (!$publications) {
            return response()->json([
                'success' => false,
                'message' => 'Publication with id ' . $id . ' not found'
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $publications->toArray()
        ], 400);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'publication_name' => 'required',
            
        ]);
 
        $publications = new Publication();
        $publications->publication_name = $request->publication_name;
        $publications->save();
 
            if($publications)
            return response()->json([
                'success' => true,
                'data' => $publications->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Publication could not be added'
            ], 500);
    }
    public function update(Request $request, $id) {
            $publications=Publication::find($id);
            $publications->publication_name = $request->input('publication_name');
          $publications->save();
        if($publications)
          return response()->json([
            "message" => "records updated successfully"
          ], 200);
        
        else {
          return response()->json([
            "message" => "Publication not found"
          ], 404);
        }
      }
      public function destroy(Request $request,$id)
    {
      $publications=Publication::find($id);
      if (!$publications) {
        return response()->json([
            'success' => false,
            'message' => 'Publication with id ' . $id . ' not found'
        ], 400);
    }

    if ($publications->delete()) {
        return response()->json([
            'success' => true,
            'message' => 'Publication deleted'
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Publication could not be deleted'
        ], 500);
    }
}
}
