<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Writer;

class WriterController extends Controller
{
    public function index()
    {
        $writers = Writer::all()->toArray();
        return response()->json([
            'success' => true,
            'data' => $writers
        ]);
    }
    public function show($id)
    {
        $writers=Writer::find($id);
 
        if (!$writers) {
            return response()->json([
                'success' => false,
                'message' => 'Writer with id ' . $id . ' not found'
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $writers->toArray()
        ], 400);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'writer_name' => 'required',
            
        ]);
 
        $writers = new Writer();
        $writers->writer_name = $request->writer_name;
        $writers->save();
 
            if($writers)
            return response()->json([
                'success' => true,
                'data' => $writers->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Writer could not be added'
            ], 500);
    }
    public function update(Request $request, $id) {
            $writers=Writer::find($id);
            $writers->writer_name = $request->input('writer_name');
          $writers->save();
        if($writers)
          return response()->json([
            "message" => "records updated successfully"
          ], 200);
        
        else {
          return response()->json([
            "message" => "Writer not found"
          ], 404);
        }
      }
      public function destroy(Request $request,$id)
    {
      $writers=Writer::find($id);
      if (!$writers) {
        return response()->json([
            'success' => false,
            'message' => 'Writer with id ' . $id . ' not found'
        ], 400);
    }

    if ($writers->delete()) {
        return response()->json([
            'success' => true,
            'message' => 'Writer deleted'
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Writer could not be deleted'
        ], 500);
    }
}
}
