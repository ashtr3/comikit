@extends('layouts.app')

@section('content')

@if ($page->is_patron_only_release)
<div class="page-patron-alert">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><g fill="currentColor" stroke="currentColor"><path stroke-width="3" d="M4 2.5v0"><animate fill="freeze" attributeName="d" dur="0.4s" values="M4 2.5v0;M4 2.5v19"/></path><path fill-opacity="0" stroke-dasharray="40" stroke-dashoffset="40" stroke-width="2" d="M14.88 3.5c3.38 0 6.12 2.74 6.12 6.13c0 3.38 -2.74 6.12 -6.12 6.12c-3.39 0 -6.13 -2.75 -6.13 -6.12c0 -3.39 2.74 -6.13 6.13 -6.13Z"><animate fill="freeze" attributeName="fill-opacity" begin="0.9s" dur="0.5s" values="0;1"/><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.5s" dur="0.4s" values="40;0"/></path></g></svg>
    <span>This page is only available to Patrons until <span class="fw-medium">{{ $page->public_release_at->format('F jS') }}</span>. Please do not distribute.</span>
</div>
@endif

<div class="page-header">
    <ul class="page-breadcrumb">
        <li>
            <a class="link-effect" href="{{ route('browse.volume.view', $page->chapter->volume) }}">
                {{ $page->chapter->volume->display_name }}
            </a>
        </li>
        <li>
            <a class="link-effect" href="{{ route('browse.chapter.view', $page->chapter) }}">
                {{ $page->chapter->display_name }}
            </a>
        </li>
    </ul>
    <h1 class="page-title">
        {{ $page->display_name }}
    </h1>
</div>

<div class="page-image-wrapper">
    @if ($page->next_page && $page->next_page->is_available)
        <a href="{{ route('browse.page.view', $page->next_page) }}">
            {!! $page->image->display_image !!}
        </a>
    @else
        {!! $page->image->display_image !!}
    @endif
</div>

<div class="page-navigation">
    @if ($page->previous_page && $page->previous_page->is_available)
        <a class="link-effect" href="{{ route('browse.page.start') }}">
            <div>
                <span class="sr-only">First page</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M18.41 7.41L17 6l-6 6l6 6l1.41-1.41L13.83 12zm-6 0L11 6l-6 6l6 6l1.41-1.41L7.83 12z"/></svg>
            </div>
        </a>
        <a class="link-effect" href="{{ route('browse.page.view', $page->previous_page) }}">
            <div>
                <span class="sr-only">Previous page</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M15.41 7.41L14 6l-6 6l6 6l1.41-1.41L10.83 12z"/></svg>
            </div>            
        </a>
    @else
        <div class="inactive">
            <span class="sr-only">First page</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M18.41 7.41L17 6l-6 6l6 6l1.41-1.41L13.83 12zm-6 0L11 6l-6 6l6 6l1.41-1.41L7.83 12z"/></svg>
        </div>
        <div class="inactive">
            <span class="sr-only">Previous page</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M15.41 7.41L14 6l-6 6l6 6l1.41-1.41L10.83 12z"/></svg>
        </div>
    @endif
    @if ($page->next_page && $page->next_page->is_available)
        <a class="link-effect" href="{{ route('browse.page.view', $page->next_page) }}">
            <div>
                <span class="sr-only">Previous page</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M10 6L8.59 7.41L13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
            </div>
        </a>
        <a class="link-effect" href="{{ route('browse.page.latest') }}">
            <div>
                <span class="sr-only">Last page</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M5.59 7.41L7 6l6 6l-6 6l-1.41-1.41L10.17 12zm6 0L13 6l6 6l-6 6l-1.41-1.41L16.17 12z"/></svg>
            </div>
        </a>
    @else
        <div class="inactive">
            <span class="sr-only">Previous page</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M10 6L8.59 7.41L13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
        </div>
        <div class="inactive">
            <span class="sr-only">Last page</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M5.59 7.41L7 6l6 6l-6 6l-1.41-1.41L10.17 12zm6 0L13 6l6 6l-6 6l-1.41-1.41L16.17 12z"/></svg>
        </div>
    @endif
    
</div>

{{-- <h1>View Page</h1>

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

<h2>Comments</h2> --}}

<x-new-comment :commentable="$page" />

@if ($page->comments->isNotEmpty())
    @foreach ($page->comments as $comment)
        <x-comment :comment="$comment" />
    @endforeach
@else
    <small>No comments yet.</small>
@endif

@endsection