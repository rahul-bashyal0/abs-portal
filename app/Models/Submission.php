<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     * Using guarded instead of fillable is easier when you have many fields.
     */
    protected $guarded = [];

    /**
     * Get the student (user) that owns the submission.
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the reviewer (user) that is assigned to the submission.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
  
public function feedback()
{
    return $this->hasMany(Feedback::class);
}
}