@extends('layouts.main')
@section('title','Sell')
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
                        <h4 class="card-title">Edit @yield('title')</h4>
                        <a  href="{{ route('sells.index') }}" class="btn btn-primary btn-round ml-auto">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        
                    </div>
                </div>

                    <!--begin::Form-->
                    {!! Form::model($data, ['method' => 'PATCH','id'=>'form','enctype'=>'multipart/form-data','route' => ['sells.update', $data->id]]) !!}
                        {{  Form::hidden('update_by', Auth::user()->id ) }}
                        <div class="card-body">

                            <div class=" row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('customer_id','Customer Name ')) !!}
                                        {!! Form::select('customer_id', $customers,null, array('class' => 'form-control','autofocus' => '')) !!}
                                        @if ($errors->has('customer_id'))  
                                            {!! "<span class='span_danger'>". $errors->first('customer_id')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                               
                            </div>
                            <div class=" row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('order_no',' Customer Order No: <span class="text-danger">*</span>')) !!}
                                        {!! Form::text('order_no', null, array('placeholder' => 'Enter customer order no','class' => 'form-control')) !!}
                                        @if ($errors->has('order_no'))  
                                            {!! "<span class='span_danger'>". $errors->first('order_no')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('payment_method_id','Payment Method ')) !!}
                                        {!! Form::select('payment_method_id', $payment_methods,null, array('class' => 'form-control')) !!}
                                        @if ($errors->has('payment_method_id'))  
                                            {!! "<span class='span_danger'>". $errors->first('payment_method_id')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class=" row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('payment_detail','Transaction Id/ Receiver <span class="text-danger">*</span>')) !!}
                                        {{ Form::text('payment_detail', null, array('placeholder' => 'Enter transaction Id/ receiver','class' => 'form-control'  )) }}
                                        @if ($errors->has('payment_detail'))  
                                            {!! "<span class='span_danger'>". $errors->first('payment_detail')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('pay_amount',' Payment Amount')) !!}
                                        {!! Form::number('pay_amount', null, array('placeholder' => 'Enter payment amount','class' => 'form-control', 'onchange'=>'calc_value()')) !!}
                                        @if ($errors->has('pay_amount'))  
                                            {!! "<span class='span_danger'>". $errors->first('pay_amount')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            

                            <div class=" row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('invoice_date',' Invoice Date <span class="text-danger">*</span>')) !!}
                                        {!! Form::date('invoice_date',date('Y-m-d'), array('placeholder' => 'Enter purchase','class' => 'form-control')) !!}
                                        @if ($errors->has('invoice_date'))  
                                            {!! "<span class='span_danger'>". $errors->first('invoice_date')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        {!! Html::decode(Form::label('sell_date',' Sell Date <span class="text-danger">*</span>')) !!}
                                        {!! Form::date('sell_date', date('Y-m-d'), array('placeholder' => 'Enter sell date','class' => 'form-control')) !!}
                                        @if ($errors->has('sell_date'))  
                                            {!! "<span class='span_danger'>". $errors->first('sell_date')."</span>"!!} 
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <br>

                            <h4 class="card-title"> Select Item</h4>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <table id="" class="table">
                                        <tbody>
                                            <tr>
                                                <td width="60%" style="text-align:left"> 
                                                    {!! Form::select("item", $items,null, array("class"=> "form-control","id"=>"item")) !!}
                                                </td>
                                                <td width="35%" style="text-align:left"> 
                                                    {!! Form::select("unit", $units,null, array("class"=> "form-control","id"=>"unit")) !!}
                                                </td>
                                                <td width="5%"><input class="btn btn-success btn-sm" type="button" onclick="add_item_row();" value="+"></td>
                                            </tr>
                                        <tbody>
                                    </table>
                                </div>
                            </div>


                            <h4 class="card-title">Item Details</h4>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table id="itemTable" class="table">
                                            <thead>
                                                <tr>
                                                    <th width="45%">Items </th>
                                                    <th width="14%">Piece  </th>
                                                    <th width="14%">Unit Price </th>
                                                    <th width="14%">Qty</th>
                                                    <!-- <th width="14%">Unit Price</th> -->
                                                    <th width="5%"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(isset($selected_items)){
                                                    foreach($selected_items as $key => $value){ ?>
                                                    <script type="text/javascript">
                                                        $rowno=$("#itemTable tr").length;
                                                        // $rowno=$rowno+1;
                                                        $("#itemTable tr:last").after("<tr id='row_itemTable"+$rowno+"'>"+
                                                            "<td> " +
                                                                '<input type="hidden" id="item_id['+$rowno+']" name="item_id[]" value ="{{$value->item_id}}" class="form-control" readonly>'+
                                                                '<input type="hidden" id="unit_id['+$rowno+']" name="unit_id[]" value ="{{$value->unit_id}}" class="form-control" readonly>'+
                                                                '<input type="text" id="item_name['+$rowno+']" name="item_name[]" value ="{{$value->item_name}} - {{$value->unit_name}}" class="form-control" readonly>'+
                                                            "</td>"+
                                                            "<td> " +
                                                                '<input type="number" id="unit_piece[]" name="unit_piece[]" value ="{{$value->unit_piece}}" class="form-control" readonly>'+
                                                            "</td>"+
                                                            "<td> " +
                                                                '<input type="number" id="sell_price[]" name="sell_price[]" value ="{{$value->sell_price}}" class="form-control" >'+
                                                            "</td>"+
                                                            "<td> " +
                                                                '<input type="number" id="sell_qty[]" name="sell_qty[]" value ="{{$value->sell_qty}}" class="form-control" onchange="calc_value()" >'+
                                                            "</td>"+
                                                        
                                                            "<td  width='40px'>"+
                                                                "<input class='btn btn-danger btn-sm' type='button' value='-' onclick=delete_item_row('row_itemTable"+$rowno+"')>"+
                                                            "</td>"+
                                                        "</tr>");
                                                        
                                                    </script>
                                                <?php } }?>
                                            <tbody>
                                        </table>
                                    </div>
                                    <div id="calc">
                                        <table id="calcTable" class="table">
                                            <tbody>
                                                <tr>
                                                    <td colspan="4" style="text-align:right"> </td>
                                                    <td width="5%"><input class="btn btn-success btn-sm" type="button" onclick="calc();" value="Calculate"></td>
                                                </tr>
                                            <tbody>
                                        </table>
                                    </div>
                                    <div id="summary"></div>
                                </div>
                            </div>
                            
                        </div>

                        

                        <div class="card-footer">
                            <div class="row">
                                
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-primary mr-2">Save</button>
                                    <button type="reset" class="btn btn-danger">Cancel</button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>
</div>
  
 <!-- item table -->
    <script type="text/javascript">
        function add_item_row(){
            var check       = 0;
            var $item       = document.getElementById('item').value; 
            var $unit       = document.getElementById('unit').value; 
            var itm_id      = $("input[name='item_id\\[\\]']")
                                .map(function(){
                                    return $(this).val();
                                }).get();
                            
            if((itm_id.length>0)){    
                console.log(itm_id.length);
                console.log("if"); 
                for(var id of itm_id){
                    console.log("item id: " +$item); 
                    console.log("id: " +id);   
                    if($item != id){
                        check = 1;
                    }else{
                        check = 0;
                        break;
                    }
                }          
                // itm_id.forEach(function(id) {
                //     console.log("item id: " +$item); 
                //     console.log("id: " +id);    
                //     if($item != id){
                //         check = 1;
                //     }else{
                //         check = 0;
                //     }
                // });
            }else{
                check = 1;
                console.log("else");           
            }
            if(check == 1){
                // console.log(item);
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ url('fetch_item_unit_detail') }}",
                    method: 'POST',
                    data: {item:$item,unit:$unit, _token:token},
                    success: function(data) {
                        console.log(data.unit.id);
                        var unit_id = data.unit.id;
                        var piece = 0;
                        // console.log(data.data.tot_piece);
                        if ( unit_id ==1 || unit_id ==2){
                            console.log('cartoon/ bora');
                            piece = data.data.tot_piece;
                            
                            // console.log("piece: " + data.data.tot_piece);
                        }else if( unit_id == 3 ){
                            piece = 12;
                            // console.log('dozen');
                        }else{
                            piece = 1;
                            // console.log('piece');
                        }
                        price = Math.round(piece * data.data.unit_sell_price);
                        
                        var $name = data.data.name;

                        $rowno=$("#itemTable tr").length;
                        // $rowno=$rowno+1;
                        $("#itemTable tr:last").after("<tr id='row_itemTable"+$rowno+"'>"+
                                "<td> " +
                                    '<input type="hidden" id="item_id['+$rowno+']" name="item_id[]" value ="'+data.data.id+'" class="form-control" readonly>'+
                                    '<input type="hidden" id="unit_id['+$rowno+']" name="unit_id[]" value ="'+data.unit.id+'" class="form-control" readonly>'+
                                    '<input type="text" id="item_name['+$rowno+']" name="item_name[]" value ="'+data.data.name+' - '+data.unit.name+'" class="form-control" readonly>'+
                                "</td>"+
                                "<td> " +
                                    '<input type="number" id="unit_piece[]" name="unit_piece[]" value ="'+piece+'" class="form-control" readonly>'+
                                "</td>"+
                                "<td> " +
                                    '<input type="number" id="sell_price[]" name="sell_price[]" value ="'+price+'" class="form-control" >'+
                                "</td>"+
                                "<td> " +
                                    '<input type="number" id="sell_qty[]" name="sell_qty[]" value ="1" class="form-control" onchange="calc_value()" >'+
                                "</td>"+
                              
                                "<td  width='40px'>"+
                                    "<input class='btn btn-danger btn-sm' type='button' value='-' onclick=delete_item_row('row_itemTable"+$rowno+"')>"+
                                "</td>"+
                        "</tr>");
                        if($rowno==1){
                            $("#calc").html(
                                '<table id="calcTable" class="table">'+
                                    '<tbody>'+
                                        '<tr>'+
                                            '<td colspan="4" style="text-align:right"> </td>'+
                                            '<td width="5%"><input class="btn btn-success btn-sm" type="button" onclick="calc();" value="Calculate"></td>'+
                                        '</tr>'+
                                    '<tbody>'+
                                '</table>'
                            );
                        }
                    }
                });
                calc_value();
            }else{
                alert("This item is already added.");
            }
        }
        function delete_item_row(rowno){
            $('#'+rowno).remove();
            if(document.getElementById('summaryTable') ){
                calc();
            }
           
            $rowno=$("#itemTable tr").length;
            // console.log($rowno);
            if($rowno==1){
                $('#calcTable').remove(); 
                $('#summaryTable').remove(); 
            }
        }
        function calc_value(){
            if(document.getElementById('summaryTable') ){
                calc();
            }

        }
        function calc(){
            // if(document.getElementById('summaryTable') ){
                var sell_qty        = 0;
                var item_qty        = 0;
                var net_amount      = 0;
                var tot_sell_price  = 0;


                sell_qty                = $("input[name='sell_qty\\[\\]']")
                                            .map(function(){
                                                return $(this).val();
                                            }).get();

                var sell_price          = $("input[name='sell_price\\[\\]']")
                                            .map(function(){
                                                return $(this).val();
                                            }).get();
                
                for (x in sell_price) {
                        var qty = parseInt(sell_qty[x]);
                        var price = parseInt(sell_price[x]);

                    item_qty             = qty * price;
                    tot_sell_price      += item_qty;
                    }
                var pay_amount          = document.getElementById('pay_amount').value; 
                $("#summary").html(
                        '<table id="summaryTable" class="table" style="margin-left: 70%; max-width: 30%">'+
                            '<tbody>'+
                                '<tr>'+
                                    '<td style="width: 15%">Total Amount</td>'+
                                    '<td style="width: 15%">'+tot_sell_price+'</td>'+
                                    '<input type="hidden" name = "total_amount" value="'+tot_sell_price+'">'+
                                '<tr>'+


                                '<tr>'+
                                    '<th style="width: 15%"> Payment </th>'+
                                    '<th style="width: 15%">'+pay_amount+'</th>'+
                                    '<input type="hidden" name = "pay_amount" value="'+pay_amount+'">'+
                                '<tr>'+
                            '<tbody>'+
                        '</table>'
                    );
            }
        // }

       
    </script>

@endsection
