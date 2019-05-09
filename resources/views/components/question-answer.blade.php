<div class="container">
    <div class="course-learning-question" id="box_question">
        <h3 class="title">Questions & Answers</h3>
        <div class="text-box">
            <form>
                <div class="form-group">
                    <textarea class="form-control" rows="6" placeholder="Type here" required></textarea>
                    {{-- <input type="text" class="form-control" id="name" placeholder="Type here"> --}}
                </div>
                <div class="btn-submit">
                    <input class="submit-question" type="submit" value="SUBMIT A QUESTION" />
                </div>
            </form>
        </div>
    </div>
    <div class="course-learning-review">
        <div class="reviews">
                <h3>Reviews</h3>
                <div class="box clearfix">
                    <div class="col-sm-3">
                        <img class="avatar" src="https://www.w3schools.com/howto/img_avatar.png" alt="" />
                        <div class="info-account">
                            <p class="interval">1 week ago</p>
                            <p class="name">Bảo Minh</p>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        @include(
                            'components.vote', 
                            [
                                'rate' => 2,
                            ]
                        )
                        <p class="comment">
                            Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ. Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ
                        </p>
                        <div class="btn-action">
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-comment"></i>
                                <span>Share</span>
                            </button>
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-thumbs-up"></i>
                                <span>Reply</span>
                            </button>
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-thumbs-down"></i>
                                <span>Dislike</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <hr>
                    </div>
                </div>
                <div class="box clearfix">
                    <div class="col-sm-3">
                        <img class="avatar" src="https://www.w3schools.com/howto/img_avatar.png" alt="" />
                        <div class="info-account">
                            <p class="interval">1 week ago</p>
                            <p class="name">Bảo Minh</p>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        @include(
                            'components.vote', 
                            [
                                'rate' => 2,
                            ]
                        )
                        <p class="comment">
                            Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ. Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ
                        </p>
                        <div class="btn-action">
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-comment"></i>
                                <span>Share</span>
                            </button>
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-thumbs-up"></i>
                                <span>Reply</span>
                            </button>
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-thumbs-down"></i>
                                <span>Dislike</span>
                            </button>
                        </div>
                        <div class="comment-reply">
                            <div>
                                <img class="avatar" src="https://www.w3schools.com/howto/img_avatar.png" alt="" />
                                <div class="info-account">
                                    <p class="interval">1 week ago</p>
                                    <p class="name">Bảo Minh</p>
                                </div>
                            </div>
                            <p class="comment">
                                Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ. Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ
                            </p>
                            <div class="btn-action">
                                <button type="button" class="btn btn-default">
                                    <i class="fas fa-comment"></i>
                                    <span>Share</span>
                                </button>
                                <button type="button" class="btn btn-default">
                                    <i class="fas fa-thumbs-up"></i>
                                    <span>Reply</span>
                                </button>
                                <button type="button" class="btn btn-default">
                                    <i class="fas fa-thumbs-down"></i>
                                    <span>Dislike</span>
                                </button>
                            </div>
                        </div>
                        <div class="comment-reply">
                            <div>
                                <img class="avatar" src="https://www.w3schools.com/howto/img_avatar.png" alt="" />
                                <div class="info-account">
                                    <p class="interval">1 week ago</p>
                                    <p class="name">Bảo Minh</p>
                                </div>
                            </div>
                            <p class="comment">
                                Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ. Khóa học em học được rất tốt rất dễ hiểu và em sẽ học lâu dài ở đây ạ
                            </p>
                            <div class="btn-action">
                                <button type="button" class="btn btn-default">
                                    <i class="fas fa-comment"></i>
                                    <span>Share</span>
                                </button>
                                <button type="button" class="btn btn-default">
                                    <i class="fas fa-thumbs-up"></i>
                                    <span>Reply</span>
                                </button>
                                <button type="button" class="btn btn-default">
                                    <i class="fas fa-thumbs-down"></i>
                                    <span>Dislike</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 btn-seen-all">
                <button type="button" class="btn">Seen all student feedback</button>
            </div>
    </div>
</div>