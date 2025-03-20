<div>
    @if (session('patreon'))
    <form action="{{ route('comment.store', ['id' => $commentable->id, 'type' => strtolower(class_basename($commentable))]) }}" method="POST">
        @csrf
        <textarea name="body">
            {{ old('body') }}
        </textarea>
        @error('body')
            {{ $message }}
        @enderror
        <button type="submit">Submit</button>
    </form>
    @endif
</div>