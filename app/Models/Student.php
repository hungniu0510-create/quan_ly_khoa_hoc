<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * 1 Student -> nhiều Enrollment
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Student <-> Course (Many-to-Many qua bảng enrollments)
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
                    ->withTimestamps();
    }
}
