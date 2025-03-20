@extends('layouts.app')

@section('content')

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
    @if ($volume->previous_volume && $volume->previous_volume->is_available)
        <a href="{{ route('browse.volume.view', $volume->previous_volume) }}">
            <button>Previous: {{ $volume->previous_volume->display_name }}</button>
        </a>
    @endif
    @if ($volume->next_volume && $volume->next_volume->is_available)
        <a href="{{ route('browse.volume.view', $volume->next_volume) }}">
            <button>Next: {{ $volume->next_volume->display_name }}</button>
        </a>
    @endif
</div>

<table>
    <thead>
        <tr>
            <th>Index</th>
            <th>Chapter #</th>
            <th>Chapter Name</th>
            <th>Pages</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($volume->chapters()->withAvailablePages()->get() as $chapter)
            <tr>
                <td>{{ $chapter->chapter_index }}</td>
                <td>{{ $chapter->chapter_number }}</td>
                <td>{{ $chapter->chapter_name }}</td>
                <td>
                    {{ $chapter->pages()->available()->count() }}
                </td>
                <td>
                    <a href="{{ route('browse.chapter.view', $chapter) }}">
                        <button>View</button>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<h2>Comments</h2>

<x-new-comment :commentable="$volume" />

@if ($volume->comments->isNotEmpty())
    @foreach ($volume->comments as $comment)
        <x-comment :comment="$comment" />
    @endforeach
@else
    <small>No comments yet.</small>
@endif

@endsection