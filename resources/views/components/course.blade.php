<div class="col-sm-3">
    <div class="info">
        <a href="https://unica.vn/giao-tiep-tieng-han-de-nhu-nhai-keo" class="course-box-slider pop">
            <div class="img-course"><img class="img-responsive"
                    src="{{ $image }}"
                    alt="{{ $title }}"></div>
            <div class="content-course">
                <h3 class="title-course">{{ $title }}</h3>
                <div class="clearfix">
                    <span class="name-teacher">{{ $author }}</span>
                    <span class="pull-right">
                        <span class="star-rate">
                            <i class="fa fa-star co-or" aria-hidden="true"></i>
                            <i class="fa fa-star co-or" aria-hidden="true"></i>
                            <i class="fa fa-star co-or" aria-hidden="true"></i>
                            <i class="fa fa-star co-or" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i> 
                        </span>
                        <span class="n-rate">(<span>{!! number_format($rating_number, 0, ',' , '.') !!}</span>)</span>
                    </span>
                </div>
                <div class="time-view">
                    <span class="time">
                        <i class="fas fa-stopwatch"></i> {{ $time }}h
                    </span>
                    <span class="view pull-right">
                        <i class="fa fa-eye" aria-hidden="true"></i> {!! number_format($view_number, 0, ',' , '.') !!} views
                    </span>
                </div>
                <div class="price-course">
                    <span class="price">
                        {!! number_format($price, 0, ',' , '.') !!}đ
                    </span>
                    <span class="sale pull-right">
                        {!! number_format($sale, 0, ',' , '.') !!}đ
                    </span>
                </div>
            </div>
        </a>
    </div>
</div>