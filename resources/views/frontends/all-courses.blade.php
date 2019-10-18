@if (count($best_seller_course) > 0 || count($new_course) > 0 ||  count($trending_courses) > 0)
<?php
    $list_bought = [];
    if(Auth::check() && strlen(Auth::user()->bought) > 0){
        $list_bought = \json_decode(Auth::user()->bought);
    }
?>
<div class="container">
    <div class="top-course">
        <div class="row">
            <div class="col-sm-12 clearfix title-module-home">
                <div class="pull-left" id="allCoursesTitle">
                    <h2></h2>
                </div>
                <div class="pull-right">
                    <ul class="nav nav-tabs">
                        <li class="active" data-title="Các khoá học bán chạy"><a data-toggle="tab" href="#best-seller">Bán chạy</a></li>
                        <li data-title="Các khóa học mới nhất"><a data-toggle="tab" href="#menu1">Mới nhất</a></li>
                        <li data-title="Các khóa học thịnh hành"><a data-toggle="tab" href="#menu2">Thịnh hành</a></li>
                    </ul>
                    <script>
                        $(document).ready(function(){
                            switchAllCoursesTitle()
                            $(document).on('click', '.nav.nav-tabs li', function(){
                                switchAllCoursesTitle()
                            })
                        })
                        function switchAllCoursesTitle(){
                            $('.nav.nav-tabs li').each(function(index, element){
                                if($(this).hasClass('active')){
                                    var title = $(this).attr('data-title')
                                    $('#allCoursesTitle h2').text(title)
                                }                       
                            })
                        }
                    </script>
                </div>
                <br>
            </div>
            <div class="col-sm-12">
                <div class="tab-content">
                    <div id="best-seller" class="tab-pane fade in active">
                        @if( count($best_seller_course) > 0 )
                            @foreach ($best_seller_course as $key => $best_seller)
                            @if($key%4 == 0)
                            <div class="row">
                            @endif
                                @include(
                                    'components.course', 
                                    [   
                                        'course' => $best_seller,
                                        'list_course' => $list_bought
                                    ]
                                )
                            @if($key%4 == 3)
                            </div>
                            @endif
                            @endforeach
                            @if($key%4 < 3)
                            </div>
                            @endif
                        @endif
                        @if (Request::is('/') || Request::is('home'))
                            <div class="col-sm-12 text-center">
                                <a href="{{ url('list-course?type=best-seller') }}" class="btn btn-default btn-seeall">Tất cả</a>
                            </div>
                        @endif
                        @if ( Request::is('category/*') && $key == 7 )
                            <div class="col-sm-12 text-center">
                                <a href="{{ url('list-course-category?type=best-seller&cat_id='.$category->id.'') }}" class="btn btn-default btn-seeall">Tất cả</a>
                            </div>
                        @endif
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        @if( count($best_seller_course) > 0 )
                            @foreach ($new_course as $key => $new)
                            @if($key%4 == 0)
                            <div class="row">
                            @endif
                                <?php
                                    // $lecturers = count($new->Lecturers()) > 1 ? 'Nhiều tác giả' : count($new->Lecturers()) > 0 ? ($new->Lecturers()[0]->user ? $new->Lecturers()[0]->user->name : "Courdemy") : "Courdemy";
                                ?>
                                @include(
                                    'components.course', 
                                    [   
                                        'course' => $new,
                                        'list_course' => $list_bought
                                    ]
                                )
                            @if($key%4 == 3)
                            </div>
                            @endif
                            @endforeach
                            @if($key%4 < 3)
                            </div>
                            @endif
                        @endif
                        @if (Request::is('/') || Request::is('home'))
                        <div class="col-sm-12 text-center">
                            <a href="{{ url('list-course?type=new') }}" class="btn btn-default btn-seeall">Tất cả</a>
                        </div>
                        @endif
                        @if ( Request::is('category/*') && $key == 7 )
                        <div class="col-sm-12 text-center">
                            <a href="{{ url('list-course-category?type=new&cat_id='.$category->id.'') }}" class="btn btn-default btn-seeall">Tất cả</a>
                        </div>
                        @endif
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        @if ($trending_courses->count() == 0)
                            <div class="text-center">
                                <p style="margin: 7em auto; font-size: 20px;">Không có khoá học nào phù hợp!</p>
                            </div>
                        @else
                            @foreach ($trending_courses as $key => $feature)
                            @if($key%4 == 0)
                            <div class="row">
                            @endif
                                <?php
                                    // $lecturers = count($feature->Lecturers()) > 1 ? 'Nhiều tác giả' : count($feature->Lecturers()) > 0 ? ($feature->Lecturers()[0]->user ? $feature->Lecturers()[0]->user->name : "Courdemy" ) : "Courdemy"; 
                                ?>
                                @include(
                                    'components.course', 
                                    [
                                        'course' => $feature,
                                        'list_course' => $list_bought
                                    ]
                                )
                            @if($key%4 == 3)
                            </div>
                            @endif
                            @endforeach
                            @if($key%4 < 3)
                            </div>
                            @endif
                        @endif
                        @if (Request::is('/') || Request::is('home'))
                        <div class="col-sm-12 text-center">
                            <a href="{{ url('list-course?type=trendding') }}" class="btn btn-default btn-seeall">Tất cả</a>
                        </div>
                        @endif
                        @if ( Request::is('category/*') && $key == 7 )
                        <div class="col-sm-12 text-center">
                            <a href="{{ url('list-course-category?type=trendding&cat_id='.$category->id.'') }}" class="btn btn-default btn-seeall">Tất cả</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif