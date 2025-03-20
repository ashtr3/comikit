@extends('layouts.app')

@section('content')

<a href="{{ route('admin.chapter.index') }}">Back</a>

<h1>View Chapter</h1>

<div>
    <strong>Volume</strong>
    <a href="{{ route('admin.volume.view', $chapter->volume) }}">{{ $chapter->volume->display_name }}</a>
</div>

<div>
    <strong>Chapter Number</strong>
    <span>{{ $chapter->chapter_number}}</span>
</div>

<div>
    <strong>Chapter Name</strong>
    <span>{{ $chapter->chapter_name}}</span>
</div>

<div>
    <strong>Chapter Description</strong>
    <p>{{ $chapter->chapter_description}}</p>
</div>

<div>
    <a href="{{ route('admin.chapter.edit', $chapter) }}">
        <button>Edit</button>
    </a>
    <form action="{{ route('admin.chapter.delete', $chapter) }}" method="POST" style="display: inline;">
        @csrf
        @method("DELETE")
        <button type="submit">Delete</button>
    </form>
</div>

@endsection