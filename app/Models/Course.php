<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'description',
        'image',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // ==================== BOOT ====================
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            $course->slug = Str::slug($course->name);
        });

        static::updating(function ($course) {
            $course->slug = Str::slug($course->name);
        });
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * 1 Course -> nhiều Lesson
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    /**
     * 1 Course -> nhiều Enrollment
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Course <-> Student (Many-to-Many qua bảng enrollments)
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments')
                    ->withTimestamps();
    }

    // ==================== SCOPES ====================

    /**
     * Scope: chỉ lấy khóa học đã published
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope: lọc theo khoảng giá
     */
    public function scopePriceBetween($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    /**
     * Scope: tìm kiếm theo tên
     */
    public function scopeSearchByName($query, $name)
    {
        return $query->where('name', 'LIKE', '%' . $name . '%');
    }

    /**
     * Scope: lọc theo trạng thái
     */
    public function scopeFilterStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    // ==================== ACCESSORS ====================

    public function getLessonsCountAttribute()
    {
        return $this->lessons()->count();
    }

    public function getEnrollmentsCountAttribute()
    {
        return $this->enrollments()->count();
    }

    public function getTotalRevenueAttribute()
    {
        return $this->enrollments()->count() * $this->price;
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/default-course.png');
    }
}
