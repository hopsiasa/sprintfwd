@extends('layouts.app')

@section('content')
    <h1>Edit Project</h1>
    <form action="{{ route('projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $project->name }}" required>
        <button type="submit">Update Project</button>
    </form>
@endsection
