<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CuratorController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\InventoryCategoryController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD маршруты для мероприятий
    Route::resource('events', EventController::class)->parameters([
        'events' => 'event:eventID'
    ]);

    Route::resource('faculties', FacultyController::class)->parameters([
        'faculties' => 'faculty:facultyID'
    ]);
    Route::resource('specialties', SpecialtyController::class)->parameters([
        'specialties' => 'specialty:specialityID'
    ]);
    Route::resource('groups', GroupController::class)->parameters([
        'groups' => 'group:groupID'
    ]);
    Route::resource('curators', CuratorController::class)->parameters([
        'curators' => 'curator:curatorID'
    ]);

    Route::resource('inventory-categories', InventoryCategoryController::class)->parameters([
        'inventory-categories' => 'inventoryCategory:inventoryCategoryID'
    ]);
    Route::resource('inventories', InventoryController::class)->parameters([
        'inventories' => 'inventory:inventoryID'
    ]);

    Route::resource('organizers', OrganizerController::class)->parameters([
        'organizers' => 'organizer:organizerID'
    ]);

    Route::resource('users', UserController::class)->parameters([
        'users' => 'user:userID'
    ]);

    Route::resource('event-registrations', EventRegistrationController::class)->parameters([
        'event-registrations' => 'eventRegistration:registrationID'
    ]);
});

require __DIR__.'/auth.php';
