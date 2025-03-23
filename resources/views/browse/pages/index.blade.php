@extends('layouts.app')

@section('content')

<div class="gallery-filters">
    <button id="gallery-expand-btn">
        Expand All
    </button>
    <button id="gallery-collapse-btn">
        Collapse All
    </button>
</div>
@foreach ($groupedPages as $chapters)
    <details class="volume-group" open>
        <summary>
            {{ $chapters->first()->first()->chapter->volume->display_name }}
        </summary>
        @foreach ($chapters as $pages)
            <details class="chapter-group" open>
                <summary>{{ $pages->first()->chapter->display_name }}</summary>
                <div class="page-gallery">
                    @foreach ($pages as $page)
                        <a href="{{ route('browse.page.view', $page) }}">
                            <img src="{{ $page->page_image }}" alt="{{ $page->display_name }} image">
                        </a>                        
                    @endforeach
                </div>
            </details>
        @endforeach
    </details>    
@endforeach

<script>

document.addEventListener('DOMContentLoaded', function () {
    
    document.getElementById('gallery-expand-btn').addEventListener('click', function() {
        document.querySelectorAll('details').forEach(el => {
            el.setAttribute('open', '');
        });
    });

    document.getElementById('gallery-collapse-btn').addEventListener('click', function() {
        document.querySelectorAll('details').forEach(el => {
            el.removeAttribute('open');
        });
    });

});

</script>

@endsection