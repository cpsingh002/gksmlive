<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\SchemeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssociateController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\TeamController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('admin-login', [AuthController::class, 'adminLogin'])->name('login.admin');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('associate-register', [AuthController::class, 'associateRegister']);
Route::post('associate-register', [AuthController::class, 'storeAssociate'])->name('register.admin');

Route::get("send-email", [PHPMailerController::class, "composeEmail"])->name("send-email");

Route::get('associate-login', [AssociateController::class, 'index']);
Route::post('associate-login', [AssociateController::class, 'AssociateLogin'])->name('login.associate');

Route::get('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('check-email', [AuthController::class, 'checkEmail'])->name('forgot-password.check-email');
Route::post('change-password', [AuthController::class, 'chnagePassword']);
//Route::get('/', [DashboardController::class, 'index']);

Route::group(['middleware'=>'auth'], function(){

    Route::post('associates/change-password', [AuthController::class, 'adminchnagePassword']);
    // Route::get('/productions', [ProductionController::class, 'index']);

// Route::get('/add-production', [ProductionController::class, 'addProduction']);
// Route::post('/add-production', [ProductionController::class, 'storeProduction'])->name('production.store');
// Route::get('/destroy-production/{id}', [ProductionController::class, 'destroyProduction'])->name('production.destroy');
// Route::get('/edit-production/{id}', [ProductionController::class, 'getProduction'])->name('production.edit');
// Route::post('/update-production', [ProductionController::class, 'updateProduction'])->name('production.update');
Route::get('/edit-profile', [ProductionController::class, 'productionProfilePage']);
Route::post('/update-profile', [ProductionController::class, 'profileUpdate'])->name('production.profileUpdate');

Route::get('production-login', [ProductionController::class, 'LoginPage']);
Route::post('production-login', [ProductionController::class, 'ProductionLogin'])->name('login.production');

// Route::get('/attributes', [AttributeController::class, 'index']);
// Route::get('/add-attribute', [AttributeController::class, 'addAttribute']);
// Route::post('/add-attribute', [AttributeController::class, 'storeAttribute'])->name('attribute.store');
// Route::get('/destroy-attribute/{id}', [AttributeController::class, 'destroyAttribute'])->name('attribute.destroy');
// Route::get('/edit-attribute/{id}', [AttributeController::class, 'getAttribute'])->name('attribute.edit');
// Route::post('/update-attribute', [AttributeController::class, 'updateAttribute'])->name('attribute.update');
// Route::get('/attribute/status/{status}/{id}',[AttributeController::class,'changestatus'])->name('attribute.status');


// Route::get('/schemes', [SchemeController::class, 'index']);
// Route::get('/add-scheme', [SchemeController::class, 'addScheme']);
// Route::post('/add-scheme', [SchemeController::class, 'storeScheme'])->name('scheme.store');
Route::get('/destroy-scheme/{id}', [SchemeController::class, 'destroyScheme'])->name('scheme.destroy');
Route::get('/scheme/edit-scheme/{id}', [SchemeController::class, 'editScheme'])->name('scheme.edit');
Route::post('/scheme/edit-scheme', [SchemeController::class, 'updateScheme'])->name('scheme.update');

Route::get('/scheme/view-scheme/{id}', [SchemeController::class, 'opertorviewshceme'])->name('view.scheme');
Route::get('/scheme/list-view-scheme/{id}', [SchemeController::class, 'listViewScheme'])->name('list_view.scheme');
Route::get('/scheme/scheme/{id}', [SchemeController::class, 'showScheme'])->name('show.scheme');

Route::post('/property/view-property/update', [SchemeController::class, 'updateplot'])->name('property_plot.update');
Route::get('/property/view-property/{id}', [SchemeController::class, 'viewProperty'])->name('view.property');
Route::post('/property/update', [SchemeController::class, 'updateProperty'])->name('property.update');
Route::post('/property/status', [SchemeController::class, 'propertyStatus'])->name('property.status');
Route::post('/property/status/update', [SchemeController::class,  'statusOfPropery'])->name('property.status_update');
//Route::post('/property/status', [SchemeController::class, 'propertyStatus'])->name('property.status');
Route::get('/property/book-hold', [SchemeController::class, 'propertyBook'])->name('property.book-hold');
Route::get('/property/book', [SchemeController::class, 'propertyBook'])->name('property.book');
Route::get('/property/hold', [SchemeController::class, 'propertyHold'])->name('property.hold');

Route::post('/property/booking', [SchemeController::class, 'bookProperty'])->name('property.book_property');
Route::get('/property/edit-customer', [SchemeController::class, 'editCustomer'])->name('property.edit_customer');
Route::post('/property/update-customer',[SchemeController::class,'updateCustomer'])->name('property.update_customer');
Route::post('/property/holding', [SchemeController::class, 'holdProperty'])->name('property.hold_property');

Route::post('/property-reports', [SchemeController::class, 'propertyReports'])->name('scheme.get-reports');
Route::get('/property-detail-report/{id}', [SchemeController::class, 'propertyDetailReports'])->name('show.report-detail');
Route::get('/property-cancel/{id}', [SchemeController::class, 'propertyStatuscancel'])->name('cancel.property-cancel');
Route::get('/complete/property-cancel/{id}', [SchemeController::class, 'propertyrelease'])->name('complete.property-cancel');
Route::post('/property-cancel',[SchemeController::class,'propertyCancel'])->name('cancel.property');
Route::get('/property-complete/{id}', [SchemeController::class, 'propertyComplete'])->name('complete.property-complete');
Route::get('/property-status/{id}', [SchemeController::class, 'propertyStatusForManagment'])->name('for-managment.property-status');
Route::get('/property-delete/{id}', [SchemeController::class, 'propertyStatusdelete'])->name('for-managment.property-delete');
Route::post('/property-delete',[SchemeController::class,'propertyplotdelete'])->name('delete.property');

Route::get('/property-complete/{id}', [SchemeController::class, 'propertyComplete'])->name('complete.property-complete');
Route::get('/property-status/{id}', [SchemeController::class, 'propertyStatusForManagment'])->name('for-managment.property-status');

Route::post('/managment-hold', [SchemeController::class, 'propertyManagmentHold'])->name('property.managment_hold');


Route::get('/property-reports', [SchemeController::class, 'propertyReports']);
Route::get('/associate-property-reports', [SchemeController::class, 'associatePropertyReports']);
// Route::post('/associate-property-reports', [SchemeController::class, 'associatePropertyReports'])->name('scheme.get-associate-reports');





Route::get('/properties', [PropertyController::class, 'index']);
Route::get('/add-property', [PropertyController::class, 'addProperty']);
Route::post('/add-property', [PropertyController::class, 'storeProperty'])->name('property.store');
Route::get('/destroy-property/{id}', [PropertyController::class, 'destroyProperty'])->name('property.destroy');

// Route::get('/operators', [UserController::class, 'index']);
// Route::get('/add-operator', [UserController::class, 'addUser']);
// Route::post('/add-operator', [UserController::class, 'storeUser'])->name('user.store');

// Route::get('/destroy-user/{id}', [UserController::class, 'destroyUser'])->name('user.destroy');
// Route::get('/deactivate-user/{id}/{status}', [UserController::class, 'deactivateUser'])->name('user.deactivate');
// Route::get('/activate-user/{id}/{status}', [UserController::class, 'activateUser'])->name('user.activate');
// Route::get('/user/view-user/{id}', [UserController::class, 'viewUser'])->name('view.user');

// Route::get('/edit-user/{id}', [UserController::class, 'editUser'])->name('edit-user.user');
// Route::post('/update-user', [UserController::class, 'updateUser'])->name('user.update');


// Route::get('/associates', [AssociateController::class, 'index']);
// Route::get('/add-associate', [AssociateController::class, 'addAssociate']);
// Route::post('/add-associate', [AssociateController::class, 'storeAssociate'])->name('associate.store');
// Route::get('associate-pending-request', [AssociateController::class, 'AssociatePendingRequest']);
// Route::post('/associate-approved', [AssociateController::class, 'approvedStatus'])->name('associate.approved');
// Route::post('/associate-cancelled', [AssociateController::class, 'cancelledStatus'])->name('associate.cancelled');
// Route::get('/export-associate', [AssociateController::class, 'exportAssociate']);

Route::get('import-csv', [CsvController::class, 'index']);
Route::post('/import-csv', [CsvController::class, 'storeCsv'])->name('importCsv.store');

// Route::get('/', function () {
//     return view('dashboard/index');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard/index');
// });
// Route::get('/opertor', [AssociateController::class, 'indexopertor']);
Route::get('/removecustomer/{id}', [CustomerController::class, 'destroy']);
// Route::get('/teams', [TeamController::class, 'index']);
// Route::get('/add-team', [TeamController::class, 'addTeam']);
// Route::post('/add-team', [TeamController::class, 'storeTeam'])->name('team.store');
// Route::get('/team-view',[TeamController::class,'viewTeam'])->name('team.view');
// Route::get('/destroy-attribute/{id}', [AttributeController::class, 'destroyAttribute'])->name('attribute.destroy');
// Route::get('/edit-attribute/{id}', [AttributeController::class, 'getAttribute'])->name('attribute.edit');
// Route::get('/destroy-team/{id}', [TeamController::class, 'destroyTeam'])->name('team.destroy');
// Route::get('/edit-team/{id}', [TeamController::class, 'getTeam'])->name('team.edit');
// Route::post('/update-team', [TeamController::class, 'updateTeam'])->name('team.update');
// Route::get('/team/status/{status}/{id}',[TeamController::class,'changestatus'])->name('team.status');
// Route::get('/supert-team/status/{status}/{id}',[TeamController::class,'changesuperteam'])->name('superteam.status');
});

Route::get('/allseen', function () {
    Artisan:: call('statusAllseen:days');
});


// Routes for super Admin
Route::group(['middleware'=>'admin_auth'], function(){

    Route::prefix('/admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('/schemes', [SchemeController::class, 'index'])->name('schemes');
        Route::get('/add-scheme', [SchemeController::class, 'addScheme']);
        Route::post('/add-scheme', [SchemeController::class, 'storeScheme'])->name('scheme.store');
        // Route::get('/destroy-scheme/{id}', [SchemeController::class, 'destroyScheme'])->name('scheme.destroy');
        // Route::get('/scheme/edit-scheme/{id}', [SchemeController::class, 'editScheme'])->name('scheme.edit');
        // Route::post('/scheme/edit-scheme', [SchemeController::class, 'updateScheme'])->name('scheme.update');

        // Route::get('/scheme/view-scheme/{id}', [SchemeController::class, 'viewScheme'])->name('view.scheme');
        // Route::get('/scheme/list-view-scheme/{id}', [SchemeController::class, 'listViewScheme'])->name('list_view.scheme');
        // Route::get('/scheme/scheme/{id}', [SchemeController::class, 'showScheme'])->name('show.scheme');
        Route::get('/opertor', [AssociateController::class, 'indexopertor']);
        Route::get('import-csv', [CsvController::class, 'index']);
    });
    Route::get('/productions', [ProductionController::class, 'index']);
    Route::get('/add-production', [ProductionController::class, 'addProduction']);
    Route::post('/add-production', [ProductionController::class, 'storeProduction'])->name('production.store');
    Route::get('/destroy-production/{id}', [ProductionController::class, 'destroyProduction'])->name('production.destroy');
    Route::get('/edit-production/{id}', [ProductionController::class, 'getProduction'])->name('production.edit');
    Route::post('/update-production', [ProductionController::class, 'updateProduction'])->name('production.update');
    Route::get('/attributes', [AttributeController::class, 'index']);
    Route::get('/add-attribute', [AttributeController::class, 'addAttribute']);
    Route::post('/add-attribute', [AttributeController::class, 'storeAttribute'])->name('attribute.store');
    Route::get('/destroy-attribute/{id}', [AttributeController::class, 'destroyAttribute'])->name('attribute.destroy');
    Route::get('/edit-attribute/{id}', [AttributeController::class, 'getAttribute'])->name('attribute.edit');
    Route::post('/update-attribute', [AttributeController::class, 'updateAttribute'])->name('attribute.update');
    Route::get('/attribute/status/{status}/{id}',[AttributeController::class,'changestatus'])->name('attribute.status');
    Route::get('/opertor', [AssociateController::class, 'indexopertor']);
    Route::get('/teams', [TeamController::class, 'index']);
Route::get('/add-team', [TeamController::class, 'addTeam']);
Route::post('/add-team', [TeamController::class, 'storeTeam'])->name('team.store');
Route::get('/team-view',[TeamController::class,'viewTeam'])->name('team.view');
Route::get('/destroy-team/{id}', [TeamController::class, 'destroyTeam'])->name('team.destroy');
Route::get('/edit-team/{id}', [TeamController::class, 'getTeam'])->name('team.edit');
Route::post('/update-team', [TeamController::class, 'updateTeam'])->name('team.update');
Route::get('/team/status/{status}/{id}',[TeamController::class,'changestatus'])->name('team.status');
Route::get('/supert-team/status/{status}/{id}',[TeamController::class,'changesuperteam'])->name('superteam.status');

Route::get('/associates', [AssociateController::class, 'index']);
Route::get('/add-associate', [AssociateController::class, 'addAssociate']);
Route::post('/add-associate', [AssociateController::class, 'storeAssociate'])->name('associate.store');
Route::get('associate-pending-request', [AssociateController::class, 'AssociatePendingRequest']);
Route::post('/associate-approved', [AssociateController::class, 'approvedStatus'])->name('associate.approved');
Route::post('/associate-cancelled', [AssociateController::class, 'cancelledStatus'])->name('associate.cancelled');
Route::get('/export-associate', [AssociateController::class, 'exportAssociate']);
Route::get('/destroy-user/{id}', [UserController::class, 'destroyUser'])->name('user.destroy');
Route::get('/deactivate-user/{id}/{status}', [UserController::class, 'deactivateUser'])->name('user.deactivate');
Route::get('/activate-user/{id}/{status}', [UserController::class, 'activateUser'])->name('user.activate');
Route::get('/user/view-user/{id}', [UserController::class, 'viewUser'])->name('view.user');

Route::get('/edit-user/{id}', [UserController::class, 'editUser'])->name('edit-user.user');
Route::post('/update-user', [UserController::class, 'updateUser'])->name('user.update');

});



// Route for opertor
Route::group(['middleware'=>'opertor_auth'], function(){

    Route::prefix('/opertor')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);

        Route::get('/schemes', [SchemeController::class, 'index'])->name('schemes');
Route::get('/add-scheme', [SchemeController::class, 'addScheme'])->name('add-scheme');
Route::post('/add-scheme', [SchemeController::class, 'storeScheme'])->name('scheme.store');
// Route::get('/destroy-scheme/{id}', [SchemeController::class, 'destroyScheme'])->name('scheme.destroy');
// Route::get('/scheme/edit-scheme/{id}', [SchemeController::class, 'editScheme'])->name('scheme.edit');
// Route::post('/scheme/edit-scheme', [SchemeController::class, 'updateScheme'])->name('scheme.update');

// Route::get('/scheme/view-scheme/{id}', [SchemeController::class, 'viewScheme'])->name('view.scheme');
// Route::get('/scheme/list-view-scheme/{id}', [SchemeController::class, 'listViewScheme'])->name('list_view.scheme');
// Route::get('/scheme/scheme/{id}', [SchemeController::class, 'showScheme'])->name('show.scheme');
Route::get('import-csv', [CsvController::class, 'index']);
    });
   
});

// Route for assoicate
Route::group(['middleware'=>'associate_auth'], function(){

    Route::prefix('/associate')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);

        Route::get('/schemes', [SchemeController::class, 'index'])->name('schemes');
        Route::get('/add-scheme', [SchemeController::class, 'addScheme'])->name('add-scheme');
        Route::post('/add-scheme', [SchemeController::class, 'storeScheme'])->name('scheme.store');
        // Route::get('/destroy-scheme/{id}', [SchemeController::class, 'destroyScheme'])->name('scheme.destroy');
        // Route::get('/scheme/edit-scheme/{id}', [SchemeController::class, 'editScheme'])->name('scheme.edit');
        // Route::post('/scheme/edit-scheme', [SchemeController::class, 'updateScheme'])->name('scheme.update');
        
        // Route::get('/scheme/view-scheme/{id}', [SchemeController::class, 'viewScheme'])->name('view.scheme');
        // Route::get('/scheme/list-view-scheme/{id}', [SchemeController::class, 'listViewScheme'])->name('list_view.scheme');
        // Route::get('/scheme/scheme/{id}', [SchemeController::class, 'showScheme'])->name('show.scheme');
    });
   
});

//Route for production

Route::group(['middleware'=>'production_auth'], function(){

    Route::prefix('/production')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('/schemes', [SchemeController::class, 'index'])->name('schemes');
        Route::get('/add-scheme', [SchemeController::class, 'addScheme'])->name('add-scheme');
        Route::post('/add-scheme', [SchemeController::class, 'storeScheme'])->name('scheme.store');
        // Route::get('/destroy-scheme/{id}', [SchemeController::class, 'destroyScheme'])->name('scheme.destroy');
        // Route::get('/scheme/edit-scheme/{id}', [SchemeController::class, 'editScheme'])->name('scheme.edit');
        // Route::post('/scheme/edit-scheme', [SchemeController::class, 'updateScheme'])->name('scheme.update');

        // Route::get('/scheme/view-scheme/{id}', [SchemeController::class, 'opertorviewshceme'])->name('view.scheme');
        // Route::get('/scheme/list-view-scheme/{id}', [SchemeController::class, 'listViewScheme'])->name('list_view.scheme');
        // Route::get('/scheme/scheme/{id}', [SchemeController::class, 'showScheme'])->name('show.scheme');
        Route::get('import-csv', [CsvController::class, 'index']);
    });
    Route::get('/operators', [UserController::class, 'index']);
    Route::get('/add-operator', [UserController::class, 'addUser']);
    Route::post('/add-operator', [UserController::class, 'storeUser'])->name('user.store');
   
});