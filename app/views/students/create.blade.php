@extends('layouts.master')

@section('content')

<h2>Add Student</h2>
<form method="post" action="/?page=store">
    <div>
        <label>Name</label>
        <input type="text" name="name" required>
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" required>
    </div>
    <div>
        <label>Course</label>
        <input type="text" name="course" required>
    </div>
    <div style="margin-top:10px;">
        <button type="submit">Save</button>
    </div>
</form>

@endsection