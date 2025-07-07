<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    protected $fillable = ['job_category'];

    // Jika ingin menambahkan relasi ke validations
    public function validations()
    {
        return $this->hasMany(\Modules\Validation\Models\Validation::class);
    }
}
