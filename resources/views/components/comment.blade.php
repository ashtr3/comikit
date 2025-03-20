<div>
    <strong>{{ $comment->patron_name }}</strong>
    <p>{!! nl2br(e($comment->body)) !!}</p>
    <div>
        <small>{{ $comment->created_at->diffForHumans() }}</small>
    </div>
    @if (session('patreon'))
        <div>
            <button id="reply-toggle-{{ $comment->id }}">
                Reply
            </button>
            <div id="reply-form-{{ $comment->id }}" style="display: none;">
                <x-new-comment :commentable="$comment->commentable" :parent="$comment" />
            </div>            
        </div>
    @endif
    <script>
        const toggle = document.getElementById('reply-toggle-{{ $comment->id }}');
        const replyForm = document.getElementById('reply-form-{{ $comment->id }}');

        toggle.addEventListener('click', function() {
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</div>