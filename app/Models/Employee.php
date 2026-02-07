<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'org_id',
        'name',
        'designation',
        'phone'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }
}
