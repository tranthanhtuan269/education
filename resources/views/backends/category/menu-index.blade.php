@extends('backends.master')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://jqueryui.com/resources/demos/style.css">

@section('content')

<section class="content-header">
</section>
<section class="content page">
    <h1 class="text-center font-weight-600">Tùy biến Menu</h1>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <ul id="sortable">
                @foreach ($categories as $key=>$category)
                    {{-- @if (count($category->childrenHavingCourse) > 0) --}}
                    <li class="ui-state-default" data-category-id="{{ $category->id }}" data-category-key="{{ $key }}">
                        <b>{{$key+1}}</b>
                        <span class="ui-icon ui-icon-arrowthick-2-n-s">
                        </span>{{$category->name}}
                    </li>
                    {{-- @endif --}}
                @endforeach
            </ul>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#sortable" ).sortable({
            update: function( event, ui ) {
                // check key begin vs after

                old_pos = $(ui.item).attr('data-category-key');                

                var data = [];
                var new_pos;
                $.each($( "#sortable li" ), function( index, value ) {

                    if($(value).attr('data-category-key') == old_pos){
                        new_pos = index
                    }
                    if(index != $(value).attr('data-category-key'))
                    data.push({
                        id: $(value).attr('data-category-id'),
                        index: index,                        
                    });
                    $(value).attr('data-category-key', index)

                });
                // console.log(`old_pos: ${old_pos}`)
                // console.log(`new_pos: ${new_pos}`)
                // console.log(data)

                // end check key 
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $.ajax({
                    method: "POST",
                    url: "{{ url('/') }}/admincp/menu-setting/sort-category",
                    data: {
                        data: JSON.stringify( data ),
                        old_pos: old_pos,
                        new_pos: new_pos
                    },
                    dataType: 'json',
                    success: function (response) {

                    },
                    error: function (error) {
                        var obj_errors = error.responseJSON.errors;
                        // console.log(obj_errors)
                        var txt_errors = '';
                        for (k of Object.keys(obj_errors)) {
                            txt_errors += obj_errors[k][0] + '</br>';
                        }
                        Swal.fire({
                            type: 'warning',
                            html: txt_errors,
                            allowOutsideClick: false,
                        })
                    }
                });
            }
        });
        $( "#sortable" ).disableSelection();
    } );
</script>
@endsection