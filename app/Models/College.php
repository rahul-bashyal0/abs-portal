<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'city',
        'state',
    ];
   
public function students()
{
    return $this->hasMany(User::class)->where('role', 'student');
}

public function collegeAdmin()
{
    return $this->hasOne(User::class)->where('role', 'college_admin');
}
}