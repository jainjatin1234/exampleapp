<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Note;


class NoteController extends Controller
{
    //

    function getnotes(){
        return Note::all();
    }

    function getonenote($id){
        return Note::find($id);
    }
    
    function addNote(Request $request){
        $rules = array(
            'title'=>'required | min:5 ',
            'body'=>'required | min:50'
        );
        $validation=Validator::make($request->all(),$rules);
    
        if($validation->fails()){
            return $validation->errors(); 
        } else {
            $note = new Note();
            $note->title=$request->title;
            $note->body=$request->body;
    
            if($note->save()){
                return response()->json(['message' => 'Note added successfully','code'=>201] ); 
            } else {
                return response()->json(['message' => 'Operation failed', 'code'=>500]); 
            }
        }
    }
    function updatenote(Request $request, $id) {
        // Validation rules
        $rules = [
            'title' => 'required|min:5',   // Title must be at least 5 characters
            'body'  => 'required|min:50'   // Body must be at least 50 characters
        ];
    
        // Validate the incoming request data
        $validation = Validator::make($request->all(), $rules);
    
        // Check if validation fails
        if ($validation->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validation->errors(),
                'code'    => 422
            ], 422);  // Return 422 status code for validation errors
        }
    
        // Find the note by its ID
        $note = Note::find($id);
    
        // Check if the note exists
        if (!$note) {
            return response()->json([
                'message' => 'Note not found',
                'code'    => 404
            ], 404);  // Return 404 if the note is not found
        }
    
        // Update the note with the validated data
        $note->title = $request->title;
        $note->body  = $request->body;
    
        // Save the updated note
        if ($note->save()) {
            return response()->json([
                'message' => 'Note updated successfully',
                'code'    => 200
            ], 200);  // Return success response
        } else {
            return response()->json([
                'message' => 'Failed to update note',
                'code'    => 500
            ], 500);  // Return error response if the update fails
        }
        
    function deletenote($id){
        $note = Note::destroy($id);
        if($note){
            return response()->json(['message' => 'note deleted ', 'code' => 201]);

        }else{
            return response()->json(['message' => ' error while deleting note', 'code' => 500]);

        }
    }

   


     }
    }