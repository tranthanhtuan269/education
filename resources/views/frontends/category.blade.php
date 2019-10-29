@extends('frontends.layouts.app')
@section('title')
{{ $category->name }}
@stop
@section('content')
<div class="background-page">
	<div class="container-fuild bg-category">
		<div class="container fixed-title">
			<div class="highlight">
				<div class="title">
					<i class="fas {{$category->icon}} fa-4x fa-fw"></i>
					<h1>{{ $category->name }}</h1>
				</div>
				<p class="cat-des">{{ $category->description }}</p>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
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