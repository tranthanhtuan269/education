<p>Teacher : {{ Auth::user()->name }} </p>
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
</div>
<div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav nav-tabs" style="border-bottom: 0px !important">
        <li class="@if(Request::is('user/teacher/course')) active  @endif"><a href="{{ url('user/teacher/course') }}" ><i class="fa fa-book fa-fw" aria-hidden="true"></i>Khóa học</a></li>
        <li class="@if(Request::is('user/teacher/profile')) active  @endif"><a href="{{ url('user/teacher/profile') }}" class=""><i class="fa fa-user fa-fw" aria-hidden="true"></i>Hồ sơ</a></li>
        {{-- <li class="hidden-sm "><a href="{{ url('coming-soon') }}" class=""><i class="fa fa-search-plus fa-fw" aria-hidden="true"></i>Khám phá</a></li>
        <li class="hiden-md hidden-sm "><a href="{{ url('coming-soon') }}" class=""><i class="fa fa-gift fa-fw" aria-hidden="true"></i>Quà tặng</a></li> --}}
        {{-- <li class="hiden-md hidden-sm "><a href="{{ url('coming-soon') }}" class=""><i class="far fa-money-bill-alt fa-fw"></i> Nạp tiền</a></li> --}}
        {{-- <li class="hidden-md hidden-sm ">
            <a href="{{ url('coming-soon') }}" class=""> <i class="fa fa-history fa-fw" aria-hidden="true"></i>Lịch sử giao dịch</a>
        </li> --}}
        <li class="@if(Request::is('user/teacher/mail-box')) active  @endif">
            <a href="{{ url('user/teacher/mail-box') }}" class=""> <i class="fas fa-envelope fa-fw"></i>Hộp thư</a>
        </li>
    </ul>
</div>