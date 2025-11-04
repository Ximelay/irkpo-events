<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventExpense extends Model
{
    public $timestamps = false;

    protected $table = 'eventExpenses';
    protected $primaryKey = 'ExpenseID';

    protected $fillable = [
        'ExpenseID',
        'itemName',
        'amount',
        'purchaseDate',
        'expenseCategories_expenseCategoryID',
        'users_purchasedBy',
        'events_eventID',
    ];

    public function expensecategoriesExpensecategoryid()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expenseCategories_expenseCategoryID', 'expenseCategoryID');
    }

    public function purchasedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_purchasedBy', 'userID');
    }

    public function events(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'events_eventID', 'eventID');
    }
}
