<div class="container">
    <div class="top-course">
        <div class="row">
            <div class="col-xs-12 clearfix title-module-home">
                <div class="pull-left">
                    <h2>Favourite Courses</h2>
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
                                        'id'    => 1,
                                        'image' => 'https://static.unica.vn/upload/images/2019/04/giao-tiep-tieng-han-cho-nguoi-moi-bat-dau_m_1555561894.jpg',
                                        'title' => 'Giao tiếp tiếng Hàn dành cho người mới bắt đầu',
                                        'author' => 'Bảo Minh',
                                        'rating_number' => 3500,
                                        'time' => 2,
                                        'view_number' => 3600,
                                        'price' => 800000,
                                        'sale' => 600000,
                                        'heart' => true,
                                    ]
                                )
                            @endfor
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn">Tất cả</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>