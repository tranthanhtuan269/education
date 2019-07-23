<div class="container">
        <div class="top-course">
            <div class="row">
                <div class="col-xs-12 clearfix title-module-home">
                    <div class="pull-left">
                        <h2>Khóa học đã mua</h2>
                    </div>
                    <div class="pull-right">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#best-seller">Đang được xử lý</a></li>
                            <li><a data-toggle="tab" href="#menu1">Gần đây</a></li>
                            <li><a data-toggle="tab" href="#menu2">Được tặng</a></li>
                        </ul>
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
                                            'setup' => true,
                                        ]
                                    )
                                @endfor
                                <div class="col-sm-12 text-center">
                                    <button type="button" class="btn">Tất cả</button>
                                </div>
                            </div>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                            2
                        </div>
                        <div id="menu2" class="tab-pane fade">
                            3
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>