@extends('layouts.main')
@section('title','Role')
@section('content')
    @include( '../sweet_script')
    <style>
        #myTable tr th:not(:first-child),
        #myTable tr td:not(:first-child) div{
            text-align:center;
            justify-content:center;
        }
    </style>
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">@yield('title')</h4>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Add @yield('title')</h4>
                                
                            <a  href="{{ route('roles.index') }}" class="btn btn-primary btn-xs ml-auto">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            <button name="checkAll" id="checkAll" class="btn btn-primary btn-xs ml-2">
                                <i class="fas fa-check"></i>Check / Un-Check All
                            </button>
                                                          
                          
                        </div>
                    </div>

                    <!--begin::Form-->
                    
                    {!! Form::open(array('id'=>'form','enctype'=>'multipart/form-data')) !!}
                        {{  Form::hidden('created_by', Auth::user()->id ) }}
                        {{  Form::hidden('action', "store" ) }}

                        <div class="card-body">
                            <div class=" row">
                                <div class="col">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('name','Role Name <span class="text-danger">*</span>')) !!}
                                        {{ Form::text('name', null, array('placeholder' => 'role name','class' => 'form-control','autofocus' => ''  )) }}
                                            @if ($errors->has('name'))  
                                                {!! "<span class='span_danger'>". $errors->first('name')."</span>"!!} 
                                            @endif

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive">
                                        <table id="myTable" class="table table-separate table-head-custom dt-responsive " style="width: 100%;" cellspacing="0">
                                            <tr>
                                                <th>Role name</th>
                                                <th>List / Show</th>
                                                <th>Create / Store</th>
                                                <th>Edit / Update</th>
                                                <th>Delete</th>
                                            </tr>
                                            <?php   
                                                    $i=0;
                                                    $val = $permission[0]['name'];
                                                    $explodedFirstValue = explode("-", $val);
                                                    $firstVal = $explodedFirstValue[0];  // exploded permission name
                                            ?>
                                            <tr>
                                                <td> {{ ucfirst($firstVal)}}</td>
                                                <?php
                                                    foreach($permission as $value){
                                                        $currentVal = $value->name;
                                                     
                                                        $explodedLastValue = explode("-", $currentVal);
                                                        $LastVal = $explodedLastValue[0];
                                                        if( $firstVal == $LastVal){ ?>
                                                            
                                                                    
                                                <td>
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox checkbox-success">
                                                            
                                                            {{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <?php }else{
                                                        $firstVal = $LastVal;
                                                ?>
                                            </tr>
                                            <tr>
                                                <td> <label>{{ ucfirst($firstVal)}}</label></td>
                                                <td>
                                                    <div class="checkbox-inline">
                                                        <label class="checkbox checkbox-success">
                                                            {{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                                            <span></span>  
                                                        </label>
                                                    </div>
                                                </td>
                                                <?php if ($LastVal == 'profile'){ echo "<td> </td><td> </td><td></td>";}}?>
                                                <?php } ?>
                                            </tr>
                                        </table>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-primary btn-sm mr-2">Save</button>
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
        $("#checkAll").click(function(){
            if ($("input[type=checkbox]").prop("checked")) {
                console.log("un-checked");
                $('input:checkbox').prop('checked', false);
            } else { 
                console.log("checked"); 
                $('input:checkbox').prop('checked',true);
            } 
        });

        $(document).ready(function () {  

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // getting and viewing profile_pic
            $("#profile_pic").change(function() {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        $('#blah').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]); // convert to base64 string
                }
            });


            $('#form').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('roles.store') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        if(data.success){
                            this.reset();
                            toastr.success(data.success);
                        }
                    },
                    error: function(data) {
                        var txt         = '';
                        console.log(data.responseJSON.errors[0])
                        for (var key in data.responseJSON.errors) {
                            txt += data.responseJSON.errors[key];
                            txt +='<br>';
                        }
                        toastr.error(txt);
                    }
                });
            });
        });
    </script>
@endsection
