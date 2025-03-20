

@extends('layouts.app')

@section('content')

<h1>Volumes</h1>

<a href="{{ route('admin.volume.create') }}">
    Create New Volume
</a>

<a href="{{ route('admin.volume.sort') }}">
    Sort Volumes
</a>

<table>
    <thead>
        <tr>
            <th>Index</th>
            <th>Volume #</th>
            <th>Volume Name</th>
            <th>Chapters</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($volumes as $volume)
            <tr>
                <td>{{ $volume->volume_index }}</td>
                <td>{{ $volume->volume_number }}</td>
                <td>{{ $volume->volume_name }}</td>
                <td>{{ $volume->chapters()->count() }}</td>
                <td>
                    <a href="{{ route('admin.volume.view', $volume) }}">
                        <button>View</button>
                    </a>
                    <a href="{{ route('admin.volume.edit', $volume) }}">
                        <button>Edit</button>
                    </a>
                    <form action="{{ route('admin.volume.delete', $volume) }}" method="POST" style="display: inline;">
                        @csrf
                        @method("DELETE")
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection