@extends('layouts.app')

@section('content')

<h1>View Chapter</h1>

<div>
    <strong>Volume</strong>
    <a href="{{ route('browse.volume.view', $chapter->volume) }}">{{ $chapter->volume->display_name }}</a>
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
    @if ($chapter->previous_chapter && $chapter->previous_chapter->is_available)
        <a href="{{ route('browse.chapter.view', $chapter->previous_chapter) }}">
            <button>Previous: {{ $chapter->previous_chapter->display_name }}</button>
        </a>
    @endif
    @if ($chapter->next_chapter && $chapter->next_chapter->is_available)
        <a href="{{ route('browse.chapter.view', $chapter->next_chapter) }}">
            <button>Next: {{ $chapter->next_chapter->display_name }}</button>
        </a>
    @endif
</div>

<table>
    <thead>
        <tr>
            <th>Index</th>
            <th>Page #</th>
            <th>Page Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($chapter->pages()->available()->get() as $page)
            <tr>
                <td>{{ $page->page_index }}</td>
                <td>{{ $page->page_number }}</td>
                <td>{{ $page->page_name }}</td>
                <td>
                    <a href="{{ route('browse.page.view', $page) }}">
                        <button>View</button>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<h2>Comments</h2>

<x-new-comment :commentable="$chapter" />

@if ($chapter->comments->isNotEmpty())
    @foreach ($chapter->comments as $comment)
        <x-comment :comment="$comment" />
    @endforeach
@else
    <small>No comments yet.</small>
@endif

@endsection