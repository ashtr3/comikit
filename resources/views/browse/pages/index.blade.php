@extends('layouts.app')

@section('content')

<h1>Pages</h1>

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
</table>

@endsection