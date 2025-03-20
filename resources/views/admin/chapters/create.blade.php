@extends('layouts.app')

@section('content')

<a href="{{ route('admin.chapter.index') }}">Back</a>

<h1>Create New Chapter</h1>

<form action="{{ route('admin.chapter.store') }}" method="POST">
    @csrf
    
    <div>
        <label for="volume_id">Volume</label>
        <select name="volume_id" id="volume_id">
            @foreach ($volumes as $volume)
                <option value="{{ $volume->id }}" @if(old('volume_id') && old('volume_id') === $volume->id) selected @endif>
                    {{ $volume->display_name }}
                </option>
            @endforeach
        </select>
    </div>
    
    <div>
        <label for="chapter_number">Chapter Number</label>
        <input type="number" name="chapter_number" id="chapter_number" value="{{ old('chapter_number') }}">
        <button id="pull_chapter_number">
            Pull Next Chapter Number
        </button>
        @error('chapter_number')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="chapter_name">Chapter Name</label>
        <input type="text" name="chapter_name" id="chapter_name" value="{{ old('chapter_name') }}">
        @error('chapter_name')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="chapter_description">Chapter Description</label>
        <textarea name="chapter_description" id="chapter_description">
            {{ old('chapter_description') }}
        </textarea>
        @error('chapter_description')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <button type="submit">
        Submit
    </button>

</form>

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const volume = document.getElementById('volume_id');
        const nextNumBtn = document.getElementById('pull_chapter_number');
        const chapterNum = document.getElementById('chapter_number');

        nextNumBtn.addEventListener('click', function (e) {
            e.preventDefault();

            fetch('{{ route('admin.chapter.next-number', ':volume') }}'.replace(':volume', volume.value), { method: 'GET'})
                .then(response => response.json())
                .then(data => { chapterNum.value = data; })
                .catch(error => console.error('Error:', error));
        });

    });

</script>

@endsection