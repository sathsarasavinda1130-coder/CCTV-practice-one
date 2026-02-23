<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'email',
        'registration_no',
        'photo'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function attendances()
{
    return $this->hasMany(Attendance::class);
}
}
