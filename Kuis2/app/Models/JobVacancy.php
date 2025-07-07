<?php
namespace App\Models;

use App\Models\AvailablePosition;
use App\Models\JobCategory; // Added this line for JobCategory model
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model {
    protected $fillable = ['job_category_id', 'company', 'address', 'description'];

    // Relasi ke Available Positions
    public function availablePositions() {
        return $this->hasMany(AvailablePosition::class);
    }

    // Relasi ke Job Category
    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }
}