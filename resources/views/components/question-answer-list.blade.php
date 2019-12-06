@foreach($comments as $comment)
<div class="box clearfix">
    @if($comment->userRole && $comment->userRole->user)
    <div class="col-sm-4">
        @if($comment->userRole->user)
            <img class="avatar" src="{{ url('/') }}/frontend/{{ $comment->userRole->user->avatar }}" alt="" />
        @else
            <img class="avatar" src="{{ url('/') }}/frontend/images/avatar.jpg" alt="" />
        @endif
        <div class="info-account">
            <p class="interval">{{ $comment->created_at }}</p>
            @if ($comment->userRole->user)
            <p class="name">{{ $comment->userRole->user->name }}</p>
            @else
            <p class="name">Học viên Courdemy</p>
            @endif
        </div>
    </div>
    @else
    <div class="col-sm-4">
        <img class="avatar" src="{{ url('/') }}/frontend/images/avatar.jpg" alt="" />
        <div class="info-account">
            <p class="interval">{{ $comment->created_at }}</p>
            <p class="name">Học viên Courdemy</p>
        </div>
    </div>
    @endif
    <div class="col-sm-8">
        @include(
            'components.vote', 
            [
                'rate' => $comment->score,
            ]
        )
        <div class="comment">
            {!! $comment->content !!}
        </div>
        @if( Auth::check() && \App\Helper\Helper::getUserRoleOfCourse($course->id) )
        <div class="btn-action">
            <button type="button" class="btn btn-default btn-reply" data-comment-id="{{ $comment->id }}">
                <i class="fas fa-comment"></i>
                <span>Trả lời</span>
            </button>
            <!-- <button type="button" class="btn @if($comment->likeCheckUser() == 1) btn-primary active @else btn-default @endif btn-like" data-comment-id="{{ $comment->id }}">
                <i class="fas fa-thumbs-up"></i>
                <span>Thích</span>
            </button> -->
            <button type="button" class="btn @if($comment->likeCheckUser() == 1) btn-primary active @else btn-default @endif btn-default btn-like" data-comment-id="{{ $comment->id }}">
                <i class="fas fa-thumbs-up"></i>
                <span>Thích</span>
            </button>
            <!-- <button type="button" class="btn @if($comment->unlikeCheckUser() == 1) btn-primary active @else btn-default @endif btn-dislike" data-comment-id="{{ $comment->id }}">
                <i class="fas fa-thumbs-down"></i>
                <span>Không thích</span>
            </button> -->
            <button type="button" class="btn @if($comment->unlikeCheckUser() == 1) btn-primary active @else btn-default @endif btn-default btn-dislike" data-comment-id="{{ $comment->id }}">
                <i class="fas fa-thumbs-down"></i>
                <span>Không thích</span>
            </button>
            <button type="button" class="btn btn-default btn-reportcomment" data-comment-id="{{ $comment->id }}">
                <i class="fas fa-flag"></i>
                <span>Báo vi phạm</span>
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
            @foreach($comment->children->take(3) as $reply)
            <div class="comment-reply">
                <div class="row">
                    @if($reply->userRole && $reply->userRole->user)
                        <div class="col-md-1">
                            @if($comment->userRole->user)
                                <img class="avatar" src="{{ url('/') }}/frontend/{{ $reply->userRole->user->avatar }}" alt="" />
                            @else
                                <img class="avatar" src="{{ url('/') }}/frontend/images/avatar.jpg" alt="" />
                            @endif
                        </div>
                        <div class="col-md-11">
                            <div class="info-account">
                                <span class="interval pull-right">{{ $reply->created_at }}</span>
                                @if ($comment->userRole->user)
                                <span class="name pull-left" style="padding-left:15px;">{{ $reply->userRole->user->name }}</span>
                                @else
                                <span class="name pull-left" style="padding-left:15px;">Học viên Courdemy</span>
                                @endif
                                <div class="clearfix"></div>
                                <div class="comment">
                                    {!! $reply->content !!}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-1">
                            <img class="avatar" src="{{ url('/') }}/frontend/images/avatar.jpg" alt="" />
                        </div>
                        <div class="col-md-11">
                            <div class="info-account">
                                <span class="interval pull-right">{{ $reply->created_at }}</span>
                                <span class="name pull-left" style="padding-left:15px;">Học viên Courdemy</span>
                                <div class="clearfix"></div>
                                <div class="comment">
                                    {!! $reply->content !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                @if(Auth::check() && false)
                <div class="btn-action">
                    <button type="button" class="btn btn-default btn-reply" data-comment-id="{{ $comment->id }}">
                        <i class="fas fa-comment"></i>
                        <span>Trả lời</span>
                    </button>
                    <button type="button" class="btn btn-default btn-like" data-comment-id="{{ $comment->id }}">
                        <i class="fas fa-thumbs-up"></i>
                        <span>Thích</span>
                    </button>
                    <button type="button" class="btn btn-default btn-dislike" data-comment-id="{{ $comment->id }}">
                        <i class="fas fa-thumbs-down"></i>
                        <span>Không thích</span>
                    </button>
                    <button type="button" class="btn btn-default" data-comment-id="{{ $comment->id }}">
                        <i class="fas fa-flag"></i>
                        <span>Báo vi phạm</span>
                    </button>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @if ($comment->children->count() > 3)
            <div class="col-sm-12 btn-see-more-level-2 text-center" data-skip="3" data-take="3" data-comment-id="{{ $comment->id }}">
                <button type="button" class="btn btn-sm">Xem thêm</button>
            </div>
        @endif
    </div>
    <div class="col-sm-12"><hr></div>
</div>
@endforeach