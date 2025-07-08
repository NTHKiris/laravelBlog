<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{

    private $students = [
        ['id' => 1, 'name' => 'Nguyen Thanh Hoang','email'=> 'nguyenhoang@gmail.com' ,'age' => 21],
        ['id' => 2, 'name' => 'Nguyen Huy','email'=> 'nguyenhuy@gmail.com' ,'age' => 21],
        ['id' => 3, 'name' => 'Nguyen Han','email'=> 'nguyenhan@gmail.com' ,'age' => 21],
    ];
    public function index()  {
        return view('students.index',['students' => $this->students]);
    }

    public function show($id){
        $student = null;
        foreach($this->students as $stu) {
            if($stu['id']===(int)$id){
                $student = $stu;
            }
        }

        return view('students.show', ['student' => $student]);
    }
}
