<?php
namespace App\Controllers;

use App\Models\Student;

class StudentController
{
    protected $model;
    protected $blade;

    public function __construct(Student $model, $blade)
    {
        $this->model = $model;
        $this->blade = $blade;
    }

    public function index()
    {
        $students = $this->model->all();
        echo $this->blade->make('students.index', ['students' => $students])->render();
    }

    public function create()
    {
        echo $this->blade->make('students.create')->render();
    }

    public function store()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $course = $_POST['course'] ?? '';

        $this->model->create($name, $email, $course);
        header('Location: /?page=students');
        exit;
    }

    public function edit($id)
    {
        $student = $this->model->find($id);
        if (!$student) {
            echo 'Student not found';
            return;
        }
        echo $this->blade->make('students.edit', ['student' => $student])->render();
    }

    public function update($id)
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $course = $_POST['course'] ?? '';

        $this->model->update($id, $name, $email, $course);
        header('Location: /?page=students');
        exit;
    }

    public function delete($id)
    {
        $this->model->delete($id);
        header('Location: /?page=students');
        exit;
    }
}
