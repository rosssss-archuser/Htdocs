<?php
namespace App\Models;

class Student
{
    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function all()
    {
        $stmt = $this->conn->prepare("SELECT * FROM students ORDER BY id DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE id = ? LIMIT 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($name, $email, $course)
    {
        $stmt = $this->conn->prepare("INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $name, $email, $course);
        return $stmt->execute();
    }

    public function update($id, $name, $email, $course)
    {
        $stmt = $this->conn->prepare("UPDATE students SET name = ?, email = ?, course = ? WHERE id = ?");
        $stmt->bind_param('sssi', $name, $email, $course, $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM students WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
