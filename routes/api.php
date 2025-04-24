<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\NotificationController;


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

Route::get('/appversion',[AuthController::class,'Getversion']);
Route::get('v2/appversion',[AuthController::class,'GetversionV2']);
Route::get('/testnotification',[NotificationController::class,'Testnotifcation']);
Route::get('/topicsuncser',[AuthController::class,'subscribe']);
Route::get('/sendnotifications',[AuthController::class,'sendnotifications']);
Route::get('/team',[ApiController::class,'teamlist']);
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/gksmsofthunterslogin', [AuthController::class, 'loginUser']);
Route::post('check-email', [AuthController::class, 'checkEmail']);


// Route::get('account/reverify', [AuthController::class, 'ReverifyAccount']);
// Route::get('account/verifyotp', [AuthController::class, 'verifyAccountotp']);
// Route::get('account/reverifyrotp', [AuthController::class, 'ReverifyAccountotp']);'throttle:60,1'


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('account/reverify', [AuthController::class, 'ReverifyAccount']);
Route::middleware('auth:sanctum')->get('account/verifyotp', [AuthController::class, 'verifyAccountotp']);
Route::middleware(['auth:sanctum','throttle:3,3'])->get('account/reverifyrotp', [AuthController::class, 'ReverifyAccountotp']);
Route::group(['middleware'=>['auth:sanctum','validate.user','throttle:60,1']],function(){
    Route::any('v1/dashboard',[ApiController::class,'index']);
    Route::any('/schemes',[ApiController::class,'show_scheme']);
    Route::get('/scheme/view-scheme/{id}', [ApiController::class, 'viewScheme']);
    Route::get('/scheme/list-view-scheme/{id}', [ApiController::class, 'listViewScheme']);
    Route::get('/scheme/scheme/{id}', [ApiController::class, 'showScheme']);
    Route::post('/property/booking', [ApiController::class, 'bookProperty']);
    Route::get('/property/book-hold', [ApiController::class, 'propertyBook']);
    Route::get('/property-reports', [ApiController::class, 'propertyReports']);
    Route::post('/property-reports', [ApiController::class, 'propertyReports']);
    Route::get('/associate-property-reports', [ApiController::class, 'associatePropertyReports']);
    Route::get('/property-detail-report/{id}', [ApiController::class, 'propertyDetailReports']);
    Route::post('change-password', [AuthController::class, 'chnagePassword']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/search/{id}/{name}',[ApiController::class,'search']);
    Route::get('/multiple-book-hold/{id}',[ApiController::class,'multipalbooking']);
    Route::post('/multiplebookhold',[ApiController::class,'multipalbook']);
    Route::get('/proof_upload/{id}',[ApiController::class,'ProofUplod'])->middleware('is_timing_right');
    Route::post('/proof_upload',[ApiController::class,'ProofUplodStore'])->middleware('is_timing_right');
    Route::get('/waiting_list/{id}/{plot}',[ApiController::class,'waitingList']);
    Route::post('/auth/deleteaccount', [AuthController::class, 'Accountdelete']);
    Route::get('/delete-booking/{id}', [ApiController::class,'deleAccount'])->name('delete.booking');
    Route::post('/delete-booking',[ApiController::class,'deleteBooking'])->name('booking.delete');
    Route::get('/property/waiting-book-hold', [ApiController::class, 'waitingpropertyBook']);

    Route::get('/property/edit-customer', [ApiController::class, 'editCustomer'])->name('property.edit_customer');
    Route::post('/property/update-customer',[ApiController::class,'updateCustomer'])->name('property.update_customer');
    Route::get('/notifications',[ApiController::class,'GetNotification'])->name('user.notifications');



    Route::get('/customerlist',[ApiController::class,'CustomerList']);
    Route::get('/customerlistcreate',[ApiController::class,'CustomerListCreate']);
    Route::post('/customerliststore',[ApiController::class,'CustomerListStore']);
    Route::get('/customerlist_destroy',[ApiController::class,'CustomerlistDistroy']);
    Route::get('/getschemecustomer/{id}',[ApiController::class,'GetSchemeCustomerlist']);
    Route::post('/property/multi-booking-scheme',[ApiController::class,'multipalschemebokhold']);
    
});

