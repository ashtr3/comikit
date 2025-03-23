@extends('layouts.app')

@section('content')

<a href="{{ route('admin.page.index') }}">Back</a>

<h1>View Page</h1>

<div>
    <strong>Volume</strong>
    <a href="{{ route('admin.volume.view', $page->chapter->volume) }}">{{ $page->chapter->volume->display_name }}</a>
</div>

<div>
    <strong>Chapter</strong>
    <a href="{{ route('admin.chapter.view', $page->chapter) }}">{{ $page->chapter->display_name }}</a>
</div>

<div>
    <strong>Page Number</strong>
    <span>{{ $page->page_number}}</span>
</div>

<div>
    <strong>Page Name</strong>
    <span>{{ $page->page_name}}</span>
</div>

<div>
    <strong>Page Image</strong>
    {!! $page->image->display_image !!}
</div>

<div>
    <strong>Page Description</strong>
    <p>{{ $page->page_description}}</p>
</div>

<div>
    <a href="{{ route('admin.page.edit', $page) }}">
        <button>Edit</button>
    </a>
    <form action="{{ route('admin.page.delete', $page) }}" method="POST" style="display: inline;">
        @csrf
        @method("DELETE")
        <button type="submit">Delete</button>
    </form>
</div>

@endsection