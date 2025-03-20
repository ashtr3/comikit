@extends('layouts.app')

@section('content')

<a href="{{ route('admin.volume.index') }}">Back</a>

<h1>Sort Volumes</h1>

<form id="sort-volumes" action="{{ route('admin.volume.sort.update') }}" method="POST">
    @csrf
    @method('PUT')
    <ul class="sortable">
        @foreach ($volumes as $volume)
            <li data-id="{{ $volume->id }}">
                {{ $volume->display_name }}
            </li>
        @endforeach
    </ul>
    <input type="hidden" name="order" id="order-input">
    <button type="submit">Update Order</button>
</form>

<script>

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.sortable').forEach(list => {
        new Sortable(list, {
            animation: 150 
        });
    });

    document.getElementById('sort-volumes').addEventListener('submit', function() {
        const itemIds = Array.from(document.querySelectorAll('.sortable li'))
            .map(item => item.dataset.id);
        document.getElementById('order-input').value = JSON.stringify(itemIds);
    });

});

</script>

@endsection