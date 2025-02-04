<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\ApiController;

use App\Http\Controllers\NoteController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test',function(){
    return  ["name"=>"anil sidhu", 'channel'=>"Code step by step"];
});


Route::post('signup',[UserAuthController::class,'signup']);
Route::post('login',[UserAuthController::class,'login']);

// Route::group(['middleware'=>"auth:sanctum"],function(){

// });


Route::get('students',[StudentController::class,'list']);
Route::get('students1',[StudentController::class,'list1']);
Route::get('teachers',[StudentController::class,'teacher']);
Route::get('teachers',[StudentController::class,'teacher']);
Route::put('update-student',[StudentController::class,'updatestudent']);
Route::delete('delete-student/{id}',[StudentController::class,'deletestudent']);
Route::post('add-student',[StudentController::class,'addStudent']);
Route::post('add-product',[ProductController::class,'addproduct']);
Route::get('getproducts',[ProductController::class,'getproducts']);

Route::get('search-student/{name}',[StudentController::class,'searchstudent']);

// Route::get('login',[UserAuthController::class,'login'])->name('login');


Route::post('add-note',[NoteController::class,'addNote']);
Route::get('getnotes',[NoteController::class,'getnotes']);
Route::get('getoneNote/{id}',[NoteController::class,'getonenote']);
Route::delete('delete-note/{id}',[NoteController::class,'deletenote']);
Route::put('update-note/{id}',[NoteController::class,'updatenote']);

 

Route::post('/upload', [StudentController::class, 'uploadFile']); 

Route::post('login', [ApiController::class, 'login']);
Route::post('register', [ApiController::class, 'register']);
Route::get('getusers',[ApiController::class,'getuser']);

Route::group(['middleware' => ['jwt.verify']],function(){
    Route::get('logout',[ApiController::class,'logout']);
});