<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\{
    AdminController,
    NoticeController,
    NotesController,
    ReminderController,
    EmployeeController,
    AttendanceController,
    CustomerController,
    CountriesController,
    StatesController,
    ProjectController,
    SuparAdminController,
    ManagerController,
    TeamLeaderController,
    SeniorSalesOfficerController,
    SalesExecutiveController,
    TagController,
    ApploginController,
    ModuleController,
    UserModuleController,
    SuparadminLeadController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('check-api', [AdminController::class, 'checkApi']);

// get country
Route::get('get-country', [CountriesController::class, 'getCountry']);
Route::get('get-country-india', [CountriesController::class, 'getCountryIndia']);
Route::get('get-states-by-country/{id}', [StatesController::class, 'getStates']);


// suparadmin
Route::post('create-suparadmin', [SuparAdminController::class, 'createSuparadmin']);
Route::post('update-suparadmin', [SuparAdminController::class, 'updateSuparadmin']);
Route::delete('delete-suparadmin/{id}', [SuparAdminController::class, 'deleteSuparadmin']);
Route::get('get-all-suparadmin', [SuparAdminController::class, 'getSuparadminAll']);
Route::get('get-one-suparadmin/{id}', [SuparAdminController::class, 'getSuparadminOne']);

// manager
Route::post('create-manager', [ManagerController::class, 'createManager']);
Route::get('get-one-manager/{id}', [ManagerController::class, 'getmanagersOne']);
Route::post('update-manager', [ManagerController::class, 'updateManager']);
Route::delete('delete-manager/{id}', [ManagerController::class, 'deleteManager']);
Route::get('get-all-manager', [ManagerController::class, 'getManager']);

// teamleader
Route::post('create-teamleader', [TeamLeaderController::class, 'createTeamleader']);
Route::post('update-teamleader', [TeamLeaderController::class, 'updateTeamleader']);
Route::delete('delete-teamleader/{id}', [TeamLeaderController::class, 'deleteTeamleader']);
Route::get('get-all-teamleader', [TeamLeaderController::class, 'getTeamleader']);
Route::get('get-all-teamleader-one/{id}', [TeamLeaderController::class, 'getTeamleaderOne']);


// seniorsalesofficer
Route::post('create-seniorsalesofficer', [SeniorSalesOfficerController::class, 'createSeniorsalesofficer']);
Route::post('update-seniorsalesofficer', [SeniorSalesOfficerController::class, 'updateSeniorsalesofficer']);
Route::delete('delete-seniorsalesofficer/{id}', [SeniorSalesOfficerController::class, 'deleteSeniorsalesofficer']);
Route::get('get-all-seniorsalesofficer', [SeniorSalesOfficerController::class, 'getSeniorsalesofficer']);
Route::get('get-one-seniorsalesofficer/{id}', [SeniorSalesOfficerController::class, 'getOneSeniorsalesofficer']);

// salesexecutive
Route::post('create-salesexecutive', [SalesExecutiveController::class, 'createSalesexecutive']);
Route::post('update-salesexecutive', [SalesExecutiveController::class, 'updateSalesexecutive']);
Route::delete('delete-salesexecutive/{id}', [SalesExecutiveController::class, 'deleteSalesexecutive']);
Route::get('get-all-salesexecutive', [SalesExecutiveController::class, 'getSalesexecutive']);
Route::get('get-one-salesexecutive/{id}', [SalesExecutiveController::class, 'getOneSalesexecutive']);


// login api
Route::post('app-login', [ApploginController::class, 'appLogin']);


Route::post('upload-supar-admin-sheet', [SuparadminLeadController::class, 'uploadExcelBySuparadmin']);

Route::post('upload-by-manager-excel', [SuparadminLeadController::class, 'uploadExcelByManager']);

// tag
Route::post('create-tag', [TagController::class, 'createTag']);
Route::post('update-tag', [TagController::class, 'updateTag']);
Route::delete('delete-tag/{id}', [TagController::class, 'deleteTag']);
Route::get('get-all-tag', [TagController::class, 'getTag']);
Route::get('get-one-tag/{id}', [TagController::class, 'getOneTag']);
// module
Route::post('create-module', [ModuleController::class, 'createModules']);
Route::put('update-module/{id}', [ModuleController::class, 'updateModules']);
Route::delete('delete-module/{id}', [ModuleController::class, 'deleteModules']);
Route::get('get-all-module', [ModuleController::class, 'getModules']);
Route::get('get-one-module/{id}', [ModuleController::class, 'getOneModules']);
// user module
Route::post('create-user-module', [UserModuleController::class, 'createUsermodules']);
Route::put('update-user-module/{id}', [UserModuleController::class, 'updateUsermodules']);
Route::delete('delete-user-module/{id}', [UserModuleController::class, 'deleteUsermodules']);
Route::get('get-all-user-module/{employee_id}', [UserModuleController::class, 'getUsermodules']);
Route::get('get-already-user-module/{employee_id}/{module_id}', [UserModuleController::class, 'getAlreadyUsermodules']);

// admin
Route::post('create-admin', [AdminController::class, 'adminSignup']);
Route::post('admin-login', [AdminController::class, 'adminLogin']);
Route::get('get-all-employee', [AdminController::class, 'getEmployee']);



Route::post('create-notice', [NoticeController::class, 'createNotice']);
Route::get('get-all-notice', [NoticeController::class, 'getAllNotice']);
Route::delete('delete-notice/{id}', [NoticeController::class, 'deleteNotice']);

// notes
Route::post('create-notes', [NotesController::class, 'createNotes']);
Route::post('update-notes', [NotesController::class, 'updateNotes']);
Route::delete('delete-notes/{id}', [NotesController::class, 'deleteNotes']);
Route::get('get-all-notes/{id}', [NotesController::class, 'getNotes']);

// reminder
Route::post('create-reminder', [ReminderController::class, 'createreminder']);
Route::post('update-reminder', [ReminderController::class, 'updatereminder']);
Route::delete('delete-reminder/{id}', [ReminderController::class, 'deletereminder']);
Route::get('get-all-reminder/{id}', [ReminderController::class, 'getreminder']);

// message
Route::post('create-message', [NoticeControlleNotesControllerr::class, 'createmessage']);
Route::get('get-all-message', [NoticeController::class, 'getAllmessage']);
Route::delete('delete-message/{id}', [NoticeController::class, 'deletemessage']);

// employees
Route::post('create-employee', [EmployeeController::class, 'employeeSignup']);
Route::post('employee-login', [EmployeeController::class, 'employeeLogin']);
Route::post('update-employee', [EmployeeController::class, 'updateEmployee']);
Route::get('get-all-employee', [EmployeeController::class, 'getAllEmployee']);

// attemdance
Route::post('check-in-attendance', [AttendanceController::class, 'checkInAttendance']);
Route::post('check-attendance-already', [AttendanceController::class, 'checkAttendanceAlready']);


// customer
Route::post('create-customer', [CustomerController::class, 'createCustomer']);
Route::post('update-customer', [CustomerController::class, 'updateCustomer']);
Route::get('get-all-customer', [CustomerController::class, 'getCustomer']);
Route::delete('delete_customer/{id}', [CustomerController::class, 'deleteCustomer']);


// PROJECTs
Route::post('create-project', [ProjectController::class, 'createProject']);
Route::post('update-project', [ProjectController::class, 'updateProject']);
Route::post('update-project-status', [ProjectController::class, 'updateProjectStatus']);
Route::get('get-all-project', [ProjectController::class, 'getProject']);
Route::delete('delete-project/{id}', [ProjectController::class, 'deleteProject']);