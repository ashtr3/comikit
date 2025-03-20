@extends('layouts.app')

@section('content')

<a href="{{ route('admin.volume.index') }}">Back</a>

<h1>Edit Volume</h1>

<form action="{{ route('admin.volume.update', $volume) }}" method="POST">
    @csrf
    @method('PUT')
    
    <input type="hidden" name="id" value="{{ $volume->id }}">

    <div>
        <label for="volume_number">Volume Number</label>
        <input type="number" name="volume_number" id="volume_number" value="{{ old('volume_number', $volume->volume_number) }}">
        <button id="pull_volume_number">
            Pull Next Volume Number
        </button>
        @error('volume_number')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="volume_name">Volume Name</label>
        <input type="text" name="volume_name" id="volume_name" value="{{ old('volume_name', $volume->volume_name) }}">
        @error('volume_name')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="volume_description">Volume Description</label>
        <textarea name="volume_description" id="volume_description">
            {{ old('volume_description', $volume->volume_description) }}
        </textarea>
        @error('volume_description')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <button type="submit">
        Submit
    </button>

</form>

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const nextNumBtn = document.getElementById('pull_volume_number');
        const volumeNum = document.getElementById('volume_number');

        nextNumBtn.addEventListener('click', function (e) {
            e.preventDefault();

            fetch('{{ route('admin.volume.next-number') }}', { method: 'GET'})
                .then(response => response.json())
                .then(data => { volumeNum.value = data; })
                .catch(error => console.error('Error:', error));
        });

    });

</script>

@endsection