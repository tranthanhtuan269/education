@foreach($comments as $comment)
<div class="box clearfix">
    @if($comment->userRole && $comment->userRole->user)
    <div class="col-sm-3">
        <img class="avatar" src="{{ url('/') }}/{{ $comment->userRole->user->avatar }}" alt="" />
        <div class="info-account">
            <p class="interval">{{ $comment->created_at }}</p>
            <p class="name">{{ $comment->userRole->user->name }}</p>
        </div>
    </div>
    @else
    <div class="col-sm-3">
        <img class="avatar" src="{{ url('/') }}/frontends/images/avatar.jpg" alt="" />
        <div class="info-account">
            <p class="interval">{{ $comment->created_at }}</p>
            <p class="name">Anonymous</p>
        </div>
    </div>
    @endif
    <div class="col-sm-9">
        @include(
            'components.vote', 
            [
                'rate' => $comment->score,
            ]
        )
        <div class="comment">
            {!! $comment->content !!}
        </div>
        @if(Auth::check())
        <div class="btn-action">
            <button type="button" class="btn btn-default btn-reply" data-comment-id="{{ $comment->id }}">
                <i class="fas fa-comment"></i>
                <span>Reply</span>
            </button>
            <button type="button" class="btn @if($comment->likeCheckUser() == 1) btn-primary @else btn-default @endif btn-like" data-comment-id="{{ $comment->id }}">
                <i class="fas fa-thumbs-up"></i>
                <span>Like</span>
            </button>
            <button type="button" class="btn @if($comment->unlikeCheckUser() == 1) btn-primary @else btn-default @endif btn-dislike" data-comment-id="{{ $comment->id }}">
                <i class="fas fa-thumbs-down"></i>
                <span>Dislike</span>
            </button>
        </div>
        <div id="reply-textbox-{{ $comment->id }}" class="reply-textbox hide">
            <textarea name="reply-{{ $comment->id }}" id="reply-{{ $comment->id }}" class="form-control" placeholder="Nội dung"></textarea>
            <div class="btn-submit text-center mt-10 mb-20">
                <input class="btn btn-primary create-reply-btn" type="submit" value="Gửi trả lời" id="create-reply-{{ $comment->id }}" data-id="{{ $comment->id }}"/>
            </div>
        </div>
        @endif

        <div class="reply-hold-{{ $comment->id }}">
            @foreach($comment->children as $reply)
            <div class="comment-reply">
                <div>
                    @if($reply->userRole->user)
                    <img class="avatar" src="{{ url('/') }}/{{ $reply->userRole->user->avatar }}" alt="" />
                    <div class="info-account">
                        <p class="interval">{{ $reply->created_at }}</p>
                        <p class="name">{{ $reply->userRole->user->name }}</p>
                    </div>
                    @else
                    <img class="avatar" src="{{ url('/') }}/frontend/images/avatar.jpg" alt="" />
                    <div class="info-account">
                        <p class="interval">{{ $reply->created_at }}</p>
                        <p class="name">Anonymous</p>
                    </div>
                    @endif
                </div>
                <div class="comment">
                    {!! $reply->content !!}
                </div>
                @if(Auth::check() && false)
                <div class="btn-action">
                    <button type="button" class="btn btn-default btn-reply" data-comment-id="{{ $comment->id }}">
                        <i class="fas fa-comment"></i>
                        <span>Reply</span>
                    </button>
                    <button type="button" class="btn btn-default btn-like" data-comment-id="{{ $comment->id }}">
                        <i class="fas fa-thumbs-up"></i>
                        <span>Like</span>
                    </button>
                    <button type="button" class="btn btn-default btn-dislike" data-comment-id="{{ $comment->id }}">
                        <i class="fas fa-thumbs-down"></i>
                        <span>Dislike</span>
                    </button>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    <div class="col-sm-12"><hr></div>
</div>
@endforeach