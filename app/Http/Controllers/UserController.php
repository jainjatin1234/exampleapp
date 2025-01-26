<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function getUser(){
        return view('user');
    }

     function getstudent(){
        $studentdata = new Student();
        echo "<pre/>";
       print_r( $studentdata->getstudentdata());

    }

}
