<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'student_id',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Enrollment thuộc về 1 Course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Enrollment thuộc về 1 Student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
