@extends('layouts.app')

@section('content')

<h1>Chapters</h1>

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
        @foreach ($groupedChapters as $chapters)
            <tr>
                <th colspan="5">
                    {{ $chapters->first()->volume->display_name }}
                </th>
            </tr>
            @foreach ($chapters as $chapter)
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
        @endforeach
    </tbody>
</table>

@endsection