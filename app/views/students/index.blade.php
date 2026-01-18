@extends('layouts.master')

@section('content')

@if(count($students) === 0)
    <p>No students found. <a href="/?page=create">Add one</a>.</p>
@else
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student['id'] }}</td>
                    <td>{{ $student['name'] }}</td>
                    <td>{{ $student['email'] }}</td>
                    <td>{{ $student['course'] }}</td>
                    <td class="actions">
                        <a href="/?page=edit&id={{ $student['id'] }}">Edit</a>
                        <a href="/?page=delete&id={{ $student['id'] }}" onclick="return confirm('Delete this student?')">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

@endsection