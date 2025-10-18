<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function submission() { return $this->belongsTo(Submission::class); }
    public function reviewer() { return $this->belongsTo(User::class, 'user_id'); }
}