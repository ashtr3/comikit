@extends('layouts.app')

@section('content')

<a href="{{ route('admin.volume.index') }}">Back</a>

<h1>View Volume</h1>

<div>
    <strong>Volume Number</strong>
    <span>{{ $volume->volume_number}}</span>
</div>

<div>
    <strong>Volume Name</strong>
    <span>{{ $volume->volume_name}}</span>
</div>

<div>
    <strong>Volume Description</strong>
    <p>{{ $volume->volume_description}}</p>
</div>

<div>
    <a href="{{ route('admin.volume.edit', $volume) }}">
        <button>Edit</button>
    </a>
    <form action="{{ route('admin.volume.delete', $volume) }}" method="POST" style="display: inline;">
        @csrf
        @method("DELETE")
        <button type="submit">Delete</button>
    </form>
</div>

@endsection