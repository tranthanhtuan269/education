@extends('frontends.layouts.app')
@section('content')
<div class="background-page">
	{{-- <img class="bg-category" src="{{ asset('frontend/images/banner_profile_teacher.png') }}"> --}}
	{{-- <div class="hightlight">
		<h1 style='font-family:proxima-nova,"Helvetica Neue",Helvetica,sans-serif'>{{ $category->name }}</h1>
	</div> --}}
	<div class='container-fuild'>
		<img class="bg-category" src="{{ asset('frontend/images/banner_profile_teacher.png') }}">
		<div class="container fixed-title">
			<div class="highlight">
				<div class="row title">
					<i class="fas {{$category->icon}} fa-4x fa-fw"></i>
					<h1>{{ $category->name }}</h1>
				</div>
				<p class="cat-des">{{ $category->description }}</p>
				{{-- @if (count($tags) > 0)
				<div class="slider">
					@foreach ($tags as $key => $tag)
						@if ($key % 5 == 0)
							<div class="row">
								<div class="col-sm-5">
									<a href="{{ url('/') }}/tags/{{ $tag->slug }}" title="{{ $tag->name }}" class="thumbnail-img">
										<img class="" src="{{ url('/frontend/'.$tag->image) }}" alt="{{ $tag->name }}" height="290">
										<div class="explore">
											<h4 class="big-course">{{ $tag->name }}</h4>
											@if($tag->course_count)
											<p class="big-course">Hơn {{ $tag->course_count }} khóa học</p>
											@endif
										</div>
									</a>
								</div>
								<div class="col-sm-7 hidden-xs">
									<div class="row">
						@else
								<div class="col-sm-6 item">
									<a href="{{ url('/') }}/tags/{{ $tag->slug }}" title="{{ $tag->name }}" class="thumbnail-img">
										<img class="box-full-height" src="{{ url('/frontend/'.$tag->image) }}" alt="{{ $tag->name }}" >
										<div class="explore">
											<h4>{{ $tag->name }}</h4>
											@if($tag->course_count)
											<p>Hơn {{ $tag->course_count }} khóa học</p>
											@endif
										</div>
									</a>
								</div>
								@if (($key + 1) % 5 == 0)
											</div>
										</div>
									</div>
								@endif
						@endif
					@endforeach
				</div>
				<script type="text/javascript">
					$('.slider').slick({
						autoplay: true,
						arrows: false,
						dots: true,
						fade: true
					});
				</script>
				@endif --}}
			</div>
		</div>
	</div>
</div>


{{-- @include('frontends.feature-courses') --}}

@include('frontends.all-courses')

@if ($tags->count() > 0)
<div class="container category-tag" style="margin-bottom: 2em;" style="display: inline-block;">
	{{-- <div class="row" style="margin-left: 1em"> --}}
		<span style="font-size: large"><strong>Tags: &nbsp;</strong></span>
		<span>
			@foreach ($tags as $tag)
			<a href="{{ url('/') }}/tags/{{ $tag->slug }}" title="{{ $tag->name }}" class="thumbnail-img">
		
			<button class="btn btn-primary" style="margin-top: 5px;">{{$tag->name}}</button>
		
			</a>
			@endforeach
		</span>
	{{-- </div> --}}
</div>
@endif
@include('frontends.popular-teacher')
@include('frontends.info-others')

@endsection