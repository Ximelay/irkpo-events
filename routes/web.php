<?php

use App\Http\Controllers\Curators\CuratorController;
use App\Http\Controllers\Events\EventController;
use App\Http\Controllers\Events\EventRegistrationController;
use App\Http\Controllers\Events\EventTypeController;
use App\Http\Controllers\Faculties\FacultyController;
use App\Http\Controllers\Faculties\SpecialtyController;
use App\Http\Controllers\Groups\GroupController;
use App\Http\Controllers\Inventories\InventoryCategoryController;
use App\Http\Controllers\Inventories\InventoryController;
use App\Http\Controllers\Organizers\OrganizerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Users\UserController;
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

    // CRUD маршруты для типов мероприятий
    Route::resource('event-types', EventTypeController::class)->parameters([
        'event-types' => 'eventType:eventTypeID'
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
