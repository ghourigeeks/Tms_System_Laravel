@extends('layouts.main')
@section('title','Category')
@section('content')
    @include( '../sweet_script')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">@yield('title')</h4>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Edit @yield('title')</h4><span style="margin-left:10px" class="loader"></span>
                            <a  href="{{ route('categories.index') }}" class="btn btn-primary btn-xs ml-auto">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            
                        </div>
                    </div>
                    <!--begin::Form-->
                    {!! Form::model($category, ['method' => 'PATCH','id'=>'form','enctype'=>'multipart/form-data']) !!}
                        {{  Form::hidden('updated_by', Auth::user()->id ) }}
                        {{  Form::hidden('action', "update" ) }}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('name','Category name <span class="text-danger">*</span>')) !!}
                                        {{ Form::text('name', null, array('placeholder' => 'Enter category name','class' => 'form-control','autofocus' => ''  )) }}
                                        @if ($errors->has('name'))  
                                            {!! "<span class='span_danger'>". $errors->first('name')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('active','Active<span class="text-danger">*</span>')) !!}
                                        <span class="switch switch-sm switch-icon switch-success">
                                            <?php
                                                $actv= 0;
                                                if(($category->active == "Active") || ($category->active == 1)){
                                                    $actv= 1;
                                                }
                                            ?>
                                         
                                            <label>
                                                {!! Form::checkbox('active',1,$actv,  array('class' => 'form-control')) !!}
                                                <span></span>
                                            </label>
                                        </span>
                                    
                                        @if ($errors->has('active'))  
                                            {!! "<span class='span_danger'>". $errors->first('active')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="pull-right"><a class="text-light btn btn-primary btn-sm add_cat_row" id="">+</a></div>
                                    <table class="table" id="sub_cat_table">
                                        <thead>
                                            <tr>
                                                <th>{!! Html::decode(Form::label('sub_cat','Sub Category name')) !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sub_category as $key => $value)
                                                <tr>
                                                    <td width="95%">
                                                        {{ Form::text('sub_cat[]', $value->name, array('placeholder' => 'Enter category name','class' => 'form-control','autofocus' => ''  )) }}
                                                    </td>
                                                    <td>
                                                        <a class="text-light btn btn-danger btn-sm del_cat_row">-</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                           
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-primary  btn-sm mr-2">Save</button>
                                    <button type="reset" class="btn btn-danger btn-sm">Cancel</button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>
        
    <script>
        $(document).ready(function () {  
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#form').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                
                $.ajax({
                    type: 'POST',
                    url: "{{ route('categories.update',$category->id) }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend:function(){
                        $('.loader').show();
                    },
                    success: (data) => {
                        if(data.success){
                            // this.reset();
                            toastr.success(data.success);
                            $('.loader').hide();
                        }else{
                            if (typeof (data.error) !== 'undefined') {
                                toastr.error(data.error);
                            }
                        }
                    },
                    error: function(data) {
                        var txt         = '';
                        // console.log(data.responseJSON.errors[0])
                        for (var key in data.responseJSON.errors) {
                            txt += data.responseJSON.errors[key];
                            txt +='<br>';
                        }
                        $('.loader').hide();
                        toastr.error(txt);
                    }
                });
            });

            $('.add_cat_row').click(function(){
                $('#sub_cat_table tbody tr:last').after(
                                                '<tr>'+
                                                    '<td width="95%">'+
                                                        '{{ Form::text('sub_cat[]', null, array('placeholder' => 'Enter category name','class' => 'form-control','autofocus' => ''  )) }}'+
                                                    '</td>'+
                                                    '<td>'+
                                                        '<a class="text-light btn btn-danger btn-sm del_cat_row">-</a>'+
                                                    '</td>'+
                                                '</tr>'
                    );
                $(".del_cat_row").click(function(){
                    $(this).closest('tr').remove();
                });
            });
            $(".del_cat_row").click(function(){
                $(this).closest('tr').remove();
            });
        });
    </script>

@endsection
