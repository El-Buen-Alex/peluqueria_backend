<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentDoneController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Models\Appointment_done;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
    
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('/prueba', function (){
            echo "yes";
    });
    Route::post('/getAuthenticatedUser', [AuthController::class, 'getAuthenticatedUser']);
    Route::get('/getCustomers', [CustomerController::class, 'index']);
    Route::post('/addCustomer', [CustomerController::class, 'store']);
    Route::post('/getAppointments',[AppointmentController::class, 'index']);
    Route::post('/addAppointment',[AppointmentController::class, 'store']);
    Route::post('/getAppointmentByDate', [AppointmentController::class, 'getAppointment']);
    Route::post('/completeAppointment', [AppointmentController::class, 'completeAppointment']);
    Route::post('/registerAppointment', [AppointmentDoneController::class, 'store']);
    Route::get('/getAppointmentsFinished',[AppointmentDoneController::class, 'index']);
});

