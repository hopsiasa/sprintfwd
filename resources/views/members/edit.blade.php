@extends('layouts.app')

@section('content')
    <h1>Edit Member</h1>
    <form action="{{ route('members.update', $member->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="{{ $member->first_name }}" required>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="{{ $member->last_name }}" required>
        <label for="team">Team:</label>
        <select name="team_id" id="team">
            @foreach($teams as $team)
                <option
                    {{ $team->id === $member->team->id ? 'selected' : '' }}
                    value="{{ $team->id }}"
                >
                    {{ $team->name }}
                </option>
            @endforeach
        </select>
        <button type="submit">Update Member</button>
    </form>
@endsection
