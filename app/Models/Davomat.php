<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Davomat extends Model
{
    protected $fillable = ([
        'student_id',
        'date',
        'value'
    ]);

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
