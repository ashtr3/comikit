@extends('layouts.app')

@section('content')

<a href="{{ route('admin.chapter.index') }}">Back</a>

<h1>Sort Chapters</h1>

<form id="sort-chapters" action="{{ route('admin.chapter.sort.update') }}" method="POST">
    @csrf
    @method('PUT')
    <ol>
        @foreach ($groupedChapters as $chapters)
            <li>
                {{ $chapters->first()->volume->display_name }}
                <ul class="sortable">
                    @foreach ($chapters as $chapter)
                        <li data-id="{{ $chapter->id }}">
                            {{ $chapter->display_name }}
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ol>
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

    document.getElementById('sort-chapters').addEventListener('submit', function() {
        const itemIds = Array.from(document.querySelectorAll('.sortable li'))
            .map(item => item.dataset.id);
        document.getElementById('order-input').value = JSON.stringify(itemIds);
    });

});

</script>

@endsection