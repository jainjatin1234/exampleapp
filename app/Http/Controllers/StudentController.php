<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class StudentController extends Controller
{
    //
    function list(){
        return Student::all();
    }
    function list1(){
        return Student::all();
    }
    function teacher(){
        return Teacher::all();
    }

    public function uploadFile(Request $request)
    {
        $uploadedFile = $request->file('image');
        $result = Cloudinary::upload($uploadedFile->getRealPath(), [
            'folder' => 'example_folder'
        ]);
    
        return response()->json([
            'url' => $result->getSecurePath()]);
    }
 

    function addStudent(Request $request){
        $rules = array(
            'name'=>'required | min:2 | max:10',
            'email'=>'email | required',
            'password'=>'required'
        );
        $validation=Validator::make($request->all(),$rules);
    
        if($validation->fails()){
            return $validation->errors(); 
        } else {
            $stu = new Student();
            $stu->name=$request->name;
            $stu->email=$request->email;
            $stu->password=$request->password;
    
            if($stu->save()){
                return response()->json(['message' => 'Student added successfully','code'=>201] ); 
            } else {
                return response()->json(['message' => 'Operation failed', 'code'=>500]); 
            }
        }
    }

    function updatestudent(Request $request){
        $student=Student::find($request->id);
        $student->name=$request->name;
        $student->email=$request->email;
        $student->password=$request->password;
        if($student->save()){
            return ["result"=>"student update"];
        }else{
            return "student not update";
        }
    }

    function deletestudent($id){
        $student = Student::destroy($id);
        if($student){
            return "student deleted";
        }else{
            return "not deleted";
        }
    }

    function searchstudent($name){
        $student = Student::where('name','like',"%$name%")->get();
        if($student){
            return $student;
        }else{
            return "not found";
        }
    }
}



