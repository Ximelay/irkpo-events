<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Curator extends Model
{
    public $timestamps = false;
    protected $table = 'curators';
    protected $primaryKey = 'curatorID';

    protected $fillable = [
        'curatorID',
        'curator_firstName',
        'curator_lastName',
        'curator_middleName',
        'groups_groupID',
    ];

    public function groups(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'groups_groupID', 'groupID');
    }
}
