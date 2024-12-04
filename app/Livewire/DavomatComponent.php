<?php

namespace App\Livewire;

use App\Models\Student;
use Carbon\Carbon;
use Livewire\Component;

class DavomatComponent extends Component
{

    public $date;
    public $students;
    public $name;
    public $editName;

    public $studentId;
    public $davomatDate;

    public $createNewStudent = false;
    public $studentUpdateId = false;

    public function mount()
    {
        $this->date = Carbon::now();
        $this->students = Student::orderBy('sort', 'asc')->get(); 
    }

    public function render()
    {

        $daysInMonth = $this->date->daysInMonth;
        $days = [];

        for ($i = 1; $i <= $daysInMonth; $i++){
            $days[] = Carbon::create($this->date->year, $this->date->month, $i);
        }


        return view('livewire.davomat', ['days' => $days]);
    }

    public function changeDate($date)
    {
        $this->date = Carbon::parse($date);
    }

    public function inputView($id, $date)
    {
        $this->studentId = $id;
        $this->davomatDate = $date;
    }

    public function createDavomat(Student $student, $date, $value )
    {
        $student->davomats()->updateOrCreate(
            ['date' => Carbon::parse($date)],
            ['value' => $value]
        );

        $this->studentId = '';
        $this->davomatDate = '';
    }

    public function createInput()
    {
        $this->createNewStudent = true;
    }

    public function studentStore()
    {   
        $count = Student::count();
        if(!empty($this->name))
        {
            Student::create([
                'name' => $this->name,
                'sort' => $count,
            ]);
        }
        $this->name = '';
        $this->createNewStudent = false;
        $this->mount();
    }

    public function editStudentName(Student $student)
    {
        $this->studentUpdateId = $student->id;
        $this->editName = $student->name;
    }

    
}
