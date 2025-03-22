@extends('layouts.app')

@section('content')

<div class="gallery-filters">
    <button id="gallery-expand-btn">
        Expand All
    </button>
    <button id="gallery-collapse-btn">
        Collapse All
    </button>
</div>
@foreach ($groupedPages as $chapters)
    <details class="volume-group" open>
        <summary>
            {{ $chapters->first()->first()->chapter->volume->display_name }}
        </summary>
        @foreach ($chapters as $pages)
            <details class="chapter-group" open>
                <summary>{{ $pages->first()->chapter->display_name }}</summary>
                <div class="page-gallery">
                    @foreach ($pages as $page)
                        <a href="{{ route('browse.page.view', $page) }}">
                            <img src="{{ $page->page_image }}" alt="{{ $page->display_name }} image">
                        </a>                        
                    @endforeach
                </div>
            </details>
        @endforeach
    </details>    
@endforeach


{{-- <h1>Pages</h1>

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
        @foreach ($groupedPages as $volumeId => $chapters)
            <tr>
                <th colspan="4">
                    {{ $chapters->first()->first()->chapter->volume->display_name }}
                </th>
            </tr>
            @foreach ($chapters as $chapterId => $pages)
                <tr>
                    <th colspan="4">
                        {{ $pages->first()->chapter->display_name }}
                    </th>
                </tr>
                @foreach ($pages as $page)
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
            @endforeach
        @endforeach
    </tbody>
</table> --}}

@endsection