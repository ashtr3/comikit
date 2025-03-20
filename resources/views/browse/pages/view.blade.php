@extends('layouts.app')

@section('content')

<h1>View Page</h1>

<div>
    <strong>Volume</strong>
    <a href="{{ route('browse.volume.view', $page->chapter->volume) }}">{{ $page->chapter->volume->display_name }}</a>
</div>

<div>
    <strong>Chapter</strong>
    <a href="{{ route('browse.chapter.view', $page->chapter) }}">{{ $page->chapter->display_name }}</a>
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
    <img src="{{ $page->page_image }}" alt="{{ $page->display_name }} image">
</div>

<div>
    <strong>Page Description</strong>
    <p>{{ $page->page_description}}</p>
</div>

<div>
    @if ($page->previous_page && $page->previous_page->is_available)
        <a href="{{ route('browse.page.view', $page->previous_page) }}">
            <button>Previous: {{ $page->previous_page->display_name }}</button>
        </a>
    @endif
    @if ($page->next_page && $page->next_page->is_available)
        <a href="{{ route('browse.page.view', $page->next_page) }}">
            <button>Next: {{ $page->next_page->display_name }}</button>
        </a>
    @endif
</div>

<h2>Comments</h2>

<x-new-comment :commentable="$page" />

@if ($page->comments->isNotEmpty())
    @foreach ($page->comments as $comment)
        <x-comment :comment="$comment" />
    @endforeach
@else
    <small>No comments yet.</small>
@endif

@endsection