@extends('layouts.app')

@section('content')

<a href="{{ route('admin.page.index') }}">Back</a>

<h1>Create New Page</h1>

<form action="{{ route('admin.page.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div>
        <label for="volume_id">Volume</label>
        <select name="volume_id" id="volume_id">
            <option @if(!old('volume_id')) selected @endif disabled>Select Volume</option>
            @foreach ($volumes as $volume)
                <option value="{{ $volume->id }}" @if(old('volume_id') == $volume->id) selected @endif>
                    {{ $volume->display_name }}
                </option>
            @endforeach
        </select>
        @error('volume_id')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="chapter_id">Chapter</label>
        <select name="chapter_id" id="chapter_id">
            <option @if(!old('chapter_id')) selected @endif disabled>Select Chapter</option>
            @if (old('volume_id'))
                @foreach ($volumes->where('id', old('volume_id'))->first()->chapters as $chapter)
                    <option value="{{ $chapter->id }}" @if(old('chapter_id') == $chapter->id) selected @endif>
                        {{ $chapter->display_name }}
                    </option>
                @endforeach
            @endif
        </select>
        @error('chapter_id')
            <span>{{ $message }}</span>
        @enderror
    </div>
    
    <div>
        <label for="page_number">Page Number</label>
        <input type="number" name="page_number" id="page_number" value="{{ old('page_number') }}">
        <button id="pull_page_number" disabled>
            Pull Next Page Number
        </button>
        @error('page_number')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="page_name">Page Name</label>
        <input type="text" name="page_name" id="page_name" value="{{ old('page_name') }}">
        @error('page_name')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="page_image">Page Image</label>
        <input type="file" name="page_image" id="page_image">
        @error('page_image')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="page_description">Page Description</label>
        <textarea name="page_description" id="page_description">
            {{ old('page_description') }}
        </textarea>
        @error('page_description')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="page_secret">Page Secret</label>
        <textarea name="page_secret" id="page_secret">
            {{ old('page_secret') }}
        </textarea>
        @error('page_secret')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <input type="checkbox" name="is_cover" id="is_cover" @if(old('is_cover')) checked @endif>
        <label for="is_cover">Is Cover</label>
        @error('is_cover')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <input type="checkbox" name="is_special" id="is_special" @if(old('is_special')) checked @endif>
        <label for="is_special">Is Special</label>
        @error('is_special')
            <span>{{ $message }}</span>
        @enderror
    </div>   

    <div>
        <label for="patreon_release_at">Patreon Release Date</label>
        <input type="date" name="patreon_release_at" id="patreon_release_at" value="{{ old('patreon_release_at') }}">
        @error('patreon_release_at')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="public_release_at">Public Release Date</label>
        <input type="date" name="public_release_at" id="public_release_at" value="{{ old('public_release_at') }}">
        @error('public_release_at')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <button type="submit">
        Submit
    </button>

</form>

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const volumeSelect = document.getElementById('volume_id');
        const chapterSelect = document.getElementById('chapter_id');

        const nextNumBtn = document.getElementById('pull_page_number');
        const pageNum = document.getElementById('page_number');

        if (!isNaN(chapterSelect.value)) {
            nextNumBtn.disabled = false;
        }

        volumeSelect.addEventListener('change', function () {
            fetch('{{ route('admin.chapter.by-volume', ':volume') }}'.replace(':volume', volumeSelect.value), { method: 'GET'})
                .then(response => response.json())
                .then(data => {
                    chapterSelect.innerHTML = '<option selected disabled>Select Chapter</option>';
                    nextNumBtn.disabled = true;
                    data.forEach(chapter => {
                        const option = document.createElement('option');
                        option.value = chapter.id;
                        option.textContent = chapter.display_name;
                        chapterSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        });

        chapterSelect.addEventListener('change', function () {
            if (chapterSelect.value) {
                nextNumBtn.disabled = false;
            }
        });

        nextNumBtn.addEventListener('click', function (e) {
            e.preventDefault();
            fetch('{{ route('admin.page.next-number', ':chapter') }}'.replace(':chapter', chapterSelect.value), { method: 'GET'})
                .then(response => response.json())
                .then(data => { pageNum.value = data; })
                .catch(error => console.error('Error:', error));
        });

    });

</script>

@endsection