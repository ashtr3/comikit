@extends('layouts.app')

@section('content')

<a href="{{ route('admin.page.index') }}">Back</a>

<h1>Sort Pages</h1>

<form id="sort-pages" action="{{ route('admin.page.sort.update') }}" method="POST">
    @csrf
    @method('PUT')
    <ol>
        @foreach ($groupedPages as $chapters)
            <li>
                {{ $chapters->first()->first()->chapter->volume->display_name }}
                <ol>
                    @foreach ($chapters as $pages)
                        <li>
                            {{ $pages->first()->chapter->display_name }}
                            <ul class="sortable">
                                @foreach ($pages as $page) 
                                    <li data-id="{{ $page->id }}">
                                        {{ $page->display_name }}
                                    </li>
                                @endforeach
                            </ul>                            
                        </li>
                    @endforeach
                </ol>
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

    document.getElementById('sort-pages').addEventListener('submit', function() {
        const itemIds = Array.from(document.querySelectorAll('.sortable li'))
            .map(item => item.dataset.id);
        document.getElementById('order-input').value = JSON.stringify(itemIds);
    });

});

</script>

@endsection