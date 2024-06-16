<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DepartmentController;
use App\Models\User;





/**----------------------------------------------------------------------------------------------------- */
Route::get('/', function () {
    return view('welcome');
});



//Autentication1
/**----------------------------------------------------------------------------------------------------- */
Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {

    Route::get('/dashboard', function () {
        // $users = User::all(); //1.เรียกฐานข้อมูลทั้งหมดผ่าน Model : Eloquen-ORM
           $users = DB::table('users')->get();  //2.เรียกฐานข้อมูลทั้งหมดไม่ผ่าน Model : Query Builder
        return view('dashboard' , compact('users'));})->name('dashboard');//dashboad.php

});
/**----------------------------------------------------------------------------------------------------- */

//Autentication2 จัด Group
Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
        Route::get('department/all',[DepartmentController::class,'index'])->name('department');
        Route::post('/department/add' , [DepartmentController::class,'store'])->name('addDepartment');
        Route::get('/department/edit/{id}', [DepartmentController::class, 'edit']);
        Route::post('/department/update/{id}', [DepartmentController::class, 'update']);
        Route::get('/delete/{id}', [DepartmentController::class, 'delete'])->name('delete');


});






