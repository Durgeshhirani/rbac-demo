<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'org_id',
        'lead_name',
        'company',
        'phone',
        'status',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }
}
