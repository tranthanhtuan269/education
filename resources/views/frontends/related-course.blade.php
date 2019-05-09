<div class="top-course">
    <div class="row" id="box_related_course">
        <div class="col-xs-12 clearfix title-module-home">
            <div class="pull-left">
                <h3>Related Courses</h3>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="tab-content">
                <div id="best-seller" class="tab-pane fade in active">
                    <div class="row">
                        @for($i = 0; $i < 8; $i++)
                            @include(
                                'components.course', 
                                [
                                    'image' => 'https://static.unica.vn/upload/images/2019/04/giao-tiep-tieng-han-cho-nguoi-moi-bat-dau_m_1555561894.jpg',
                                    'title' => 'Giao tiếp tiếng Hàn dành cho người mới bắt đầu',
                                    'author' => 'Bảo Minh',
                                    'rating_number' => 3500,
                                    'time' => 2,
                                    'view_number' => 3600,
                                    'price' => 800000,
                                    'sale' => 600000,
                                ]
                            )
                        @endfor
                        <div class="col-sm-12 btn-seen-all">
                            <button type="button" class="btn">See all</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
