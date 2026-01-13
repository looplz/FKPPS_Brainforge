<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id', 'presentation_date', 'start_time', 'end_time', 'venue', 'created_by'
    ];

    public function submission() { return $this->belongsTo(Submission::class); }
}
