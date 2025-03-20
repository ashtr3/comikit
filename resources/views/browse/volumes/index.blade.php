@extends('layouts.app')

@section('content')

<h1>Volumes</h1>

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
                <td>
                    {{ $volume->chapters()->withAvailablePages()->count() }}
                </td>
                <td>
                    <a href="{{ route('browse.volume.view', $volume) }}">
                        <button>View</button>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection