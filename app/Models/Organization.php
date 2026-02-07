<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $table = 'organizations';
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'org_id');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'org_id');
    }
}
