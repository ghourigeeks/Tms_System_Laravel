<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

@if ($message = Session::get('success'))
  <script>
    var text = "<?php echo $message;?>";
    toastr.success(text)
  </script>
  <?php session()->forget('success');?>
@endif



@if ($message = Session::get('permission'))
  <script>
    var text = "<?php echo $message;?>";
    toastr.error(text)
  </script>
  <?php session()->forget('success');?>

@endif

@if (count($errors) > 0)
<div class="row mt-5 mx-2" >
  

  <div class="col-sm-12 col-md-12">
    <div class="card card-stats card-round">
      <div class="card-body">
        <div class="row">
          <div class="col-2">
          
          <div class="icon-big text-center">
              <i class="flaticon-error text-danger"></i>
            </div>
          </div>
          <div class="col col-stats">
            <div class="numbers">
             
              <div class="alert-text">
                <strong>Whoops!</strong> 
                Something went wrong.
                <br><br>
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</div>

    <!-- <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="alert alert-danger">
               
            </div>         
        </div>
    </div> -->
@endif

