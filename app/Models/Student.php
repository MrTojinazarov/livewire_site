<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ([
        'name',
        'sort',
    ]);

    public function davomats()
    {
        return $this->hasMany(Davomat::class, 'student_id');
    }

    public function checks($date)
    {
        return $this->davomats()->where('date', Carbon::parse($date))->first();
    }
}
