@extends('layouts.main')
@section('title','Report')
@section('content')
@include( '../sweet_script')

<style>
    @media print
    {    
        .no-print, .no-print *
        {
            display: none !important;
        }
    }
    
</style>


<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">@yield('title')</h4>
    </div>
    <div class="row" id="main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header ">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">
                        <?php $title = "";
                            if($entity == "customer")
                                $title = "All Customer";
                            elseif($entity == "company")
                                $title = "All Company";
                            elseif($entity == "company_single")
                                $title = "Company";
                            elseif($entity == "customer_single")
                                $title = "Customer";

                        ?>
                         
                        <?php if($entity == "company_single" || $entity == "customer_single"){ ?>
                            {{$title}}: <b> {{$rec[0]->name}} - ({{ $date}})</b> 
                        <?php }elseif($entity == "company" || $entity == "customer"){  ?>
                            {{ $title }} @yield('title') of <b>{{ $date}}</b>
                        <?php }elseif($entity == "daily_report"){  ?>
                            Daily Report of <b>{{$date}}</b>
                        <?php }?>
                         </h4>

                        <div class="btn-group btn-group ml-auto d-print-none">
                            <a  href="{{ route('reports.index') }}" class="btn btn-primary btn-sm ">
                            <i class="fas fa-arrow-left"></i></a>
                            <button  class="btn btn-info btn-sm "  onclick="printDiv('main')">
                            <i class="fa fa-print"></i></button>
                        </div>
                      
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="table-responsive">
                                <?php if ($entity == "company" || $entity == "customer"){?>
                                    <table class="table dt-responsive">
                                        <thead>
                                            <tr>
                                                <th>Sr#</th>
                                                <th>{{ $entity }}</th>
                                                <th>Previous Amount</th>
                                                <th>Invoice Amount</th>
                                                <th>Pay Amount</th>
                                                <th>Remaining Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rec as $key => $value)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $value->name }}</td>
                                                    <td>{{ $value->pbalance}}</td>
                                                    <td>{{ $value->debit }}</td>
                                                    <td>{{ $value->credit }}</td>
                                                    <td>{{ ((($value->pbalance)+($value->debit))-($value->credit)) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table><br><br>
                                <?php }elseif ($entity == "company_single" || $entity == "customer_single"){?>
                                 
                                    <table class="table dt-responsive">
                                        <thead>
                                            <tr>
                                                <th width="5%">Sr#</th>
                                                <th  width="15%">Date</th>
                                                <th  width="20%">Previous Amount</th>
                                                <!-- <th>detail</th> -->
                                                <!-- <th>Ref</th> -->
                                                <th width="20%">Credit Amount</th>
                                                <th width="20%">Debit Amount</th>
                                                <th width="20%">Remaining Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody> <?php $pBal = 0?>
                                            @foreach($rec as $key => $value)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td> {{date('Y-m-d',  strtotime($value->date))}}</td>
                                                    <td>{{ $pBal }}</td>
                                                    <!-- <th>Detail </th> transactionid/ receiver -->  
                                                    <!-- <th>Ref</th> -->
                                                    <td>{{ $value->credit }}</td>
                                                    <td>-{{ $value->debit }}</td>
                                                    <td>{{ (($pBal + $value->credit)-($value->debit)) }}</td>
                                                    <?php $pBal += (($value->credit)-($value->debit)); ?>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                <?php }elseif ($entity == "daily_report"){?>
                                    <table class="table dt-responsive">
                                        <!-- <tr>
                                            <th>Old Purchasing Amount</th>
                                            <th>{{ $rec['oPurchase'] }}</th>
                                        </tr>
                                        <tr>
                                            <th>Old Selling Amount</th>
                                            <th>{{ $rec['oSell'] }}</th>
                                        </tr>
                                        
                                        <tr><td colspan=2></td></tr> -->

                                        <tr>
                                            <th width="50%">Opening Amount</th>
                                            <?php $oBal =  $rec['oSell'] - $rec['oPurchase']; ?>
                                            <th>{{ $oBal }}</th>
                                        </tr>

                                        
                                        <tr>
                                            <th>Purchasing Amount</th>
                                            <th>{{ $rec['cPurchase'] }}</th>
                                        </tr>
                                        <tr>
                                            <th>Selling Amount</th>
                                            <th>{{ $rec['cSell'] }}</th>
                                        </tr>
                                        <tr><td colspan=2></td></tr>
                                        <tr>
                                            <th>Cash in hand</th>
                                            <th>{{(($oBal +$rec['cSell']) - $rec['cPurchase'])}}</th>
                                        </tr>
                                    </table>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  
    <script>
		function printDiv(divName){
            // var div = document.getElementById('btns');
            //     div.remove();
            // $(".btns").remove();
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;
          
            // console.log( printContents.children(".btns")) ;
            // console.log(printContents)
			document.body.innerHTML = printContents;
            
			window.print();
            // $(".btns").append();
			document.body.innerHTML = originalContents;

		}
    </script>
@endsection
