<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseCategory extends Model
{
    public $timestamps = false;
    protected $table = 'expenseCategories';
    protected $primaryKey = 'expenseCategoryID';

    protected $fillable = [
        'expenseCategoryID',
        'categoryName',
    ];

    public function expenses(): HasMany
    {
        return $this->hasMany(EventExpense::class, 'expenseCategories_expenseCategoryID', 'expenseCategoryID');
    }
}
