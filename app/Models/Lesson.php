<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'video_url',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Lesson thuộc về 1 Course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
