<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DegreeProgram extends Model
{
    protected $table = 'degree_programs';

    protected $fillable = [
        'code',
        'name',
        'level',
        'study_year',
        'academic_department',
        'department_sort_order',
        'include_in_planning',
    ];
}
