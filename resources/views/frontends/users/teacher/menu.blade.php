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
        <li class="@if(Request::is('user/teacher/course')) active  @endif"><a href="{{ url('user/teacher/course') }}" ><i class="fa fa-book" aria-hidden="true"></i> Course</a></li>
        <li class="@if(Request::is('user/teacher/profile')) active  @endif"><a href="{{ url('user/teacher/profile') }}" class=""><i class="fa fa-user" aria-hidden="true"></i> Profile</a></li>
        {{-- <li class="hidden-sm "><a href="{{ url('coming-soon') }}" class=""><i class="fa fa-search-plus" aria-hidden="true"></i> Discover</a></li>
        <li class="hiden-md hidden-sm "><a href="{{ url('coming-soon') }}" class=""><i class="fa fa-gift" aria-hidden="true"></i> Gift</a></li> --}}
        {{-- <li class="hiden-md hidden-sm "><a href="{{ url('coming-soon') }}" class=""><i class="far fa-money-bill-alt"></i> Recharge</a></li> --}}
        {{-- <li class="hidden-md hidden-sm ">
            <a href="{{ url('coming-soon') }}" class=""> <i class="fa fa-history" aria-hidden="true"></i> Order history</a>
        </li> --}}
        <li class="@if(Request::is('user/teacher/mail-box')) active  @endif">
            <a href="{{ url('user/teacher/mail-box') }}" class=""> <i class="fas fa-envelope"></i> Mailbox</a>
        </li>
    </ul>
</div>