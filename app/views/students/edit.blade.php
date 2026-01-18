@extends('layouts.master')

@section('content')

<h2>Edit Student</h2>
<form method="post" action="/?page=update&id={{ $student['id'] }}">
    <div>
        <label>Name</label>
        <input type="text" name="name" value="{{ $student['name'] }}" required>
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ $student['email'] }}" required>
    </div>
    <div>
        <label>Course</label>
        <input type="text" name="course" value="{{ $student['course'] }}" required>
    </div>
    <div style="margin-top:10px;">
        <button type="submit">Update</button>
    </div>
</form>

@endsection