<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'title', 'document_path', 'presentation_type',
        'supervisor_id', 'supervisor_status',
        'examiner_1_id', 'examiner_2_id', 'manager_status'
    ];

    public function student() { return $this->belongsTo(User::class, 'student_id'); }
    public function supervisor() { return $this->belongsTo(User::class, 'supervisor_id'); }
    public function schedule() { return $this->hasOne(Schedule::class); }
}
