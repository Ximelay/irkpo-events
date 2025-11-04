<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    public $timestamps = false;
    protected $table = 'feedbacks';
    protected $primaryKey = 'feedbackID';

    protected $fillable = [
        'feedbackID',
        'comment',
        'rating',
        'createdAt',
        'registrationID',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(EventRegistration::class, 'registrationID', 'registrationID');
    }
}
