

@extends('layouts.app')

@section('content')

<h1>Pages</h1>

<a href="{{ route('admin.page.create') }}">
    Create New Page
</a>

<a href="{{ route('admin.page.sort') }}">
    Sort Pages
</a>

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
        @foreach ($groupedPages as $chapters)
            <tr>
                <th colspan="4">
                    {{ $chapters->first()->first()->chapter->volume->display_name }}
                </th>
            </tr>
            @foreach ($chapters as $pages)
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
                            <a href="{{ route('admin.page.view', $page) }}">
                                <button>View</button>
                            </a>
                            <a href="{{ route('admin.page.edit', $page) }}">
                                <button>Edit</button>
                            </a>
                            <form action="{{ route('admin.page.delete', $page) }}" method="POST" style="display: inline;">
                                @csrf
                                @method("DELETE")
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>

@endsection