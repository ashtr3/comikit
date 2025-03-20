

@extends('layouts.app')

@section('content')

<h1>Chapters</h1>

<a href="{{ route('admin.chapter.create') }}">
    Create New Chapter
</a>

<a href="{{ route('admin.chapter.sort') }}">
    Sort Chapters
</a>

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
                    <td>{{ $chapter->pages()->count() }}</td>
                    <td>
                        <a href="{{ route('admin.chapter.view', $chapter) }}">
                            <button>View</button>
                        </a>
                        <a href="{{ route('admin.chapter.edit', $chapter) }}">
                            <button>Edit</button>
                        </a>
                        <form action="{{ route('admin.chapter.delete', $chapter) }}" method="POST" style="display: inline;">
                            @csrf
                            @method("DELETE")
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

@endsection