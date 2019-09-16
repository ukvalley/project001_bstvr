@extends('admin.layout.master')                

@section('main_content')

<!-- Select2 -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Epin Generate
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Epin Generate</li>
      </ol>
    </section>


            



     <!-- Main content -->
     <section class="content">
      <div class="row">
        <div class="col-md-12">
           <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-envelope"></i>

              <h3 class="box-title">Epin Generate</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
               {{--  <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                  <i class="fa fa-times"></i></button> --}}
              </div>
              <!-- /. tools -->
              <form class="col s12" method="post" action="{{url('/')}}/admin/generate_epin" data-parsley-validate="">
                 @include('admin.layout._operation_status')
              {{ csrf_field() }}

              
              <div class="row" style="margin-top: 20px">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Quantity</label> <br>
                     <input id="quantity" name="quantity" type="text" class="form-control" placeholder="Enter quantity less than 999 at a time" required="true">
                  </div>
                </div>
              </div>
              
             
              <div class="row" style="margin-top: 20px">
                <div class="col-md-6">
                  <div class="form-group">
            <label>Package</label>
            <select id="amount" name="amount"  class="form-control select2" type="text" required="true">
             <?php
                    $plans = \DB::table('package')->get();
              ?>
              @foreach($plans as $key=>$value)
                      <option value="{{$value->amount}}">{{$value->amount}} Rs {{$value->package_name}}</option>
            @endforeach
           
           </select>
           </div>
                </div>
              </div>







    <?php 
    $user_data = \DB::table('users')->where('email','<>','admin')->get();
    $user = Sentinel::check();
    ?>
        <div class="row" style="margin-top: 20px">
                <div class="col-md-6">
              <div class="form-group">
                <label>User ID</label>
                <select name="issue_to" id="issue_to" class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true">
                   <option>{{$user->email}}</option>
                   @foreach($user_data as $key=>$value)
                  
                  <option>{{$value->email}}</option>
                  @endforeach
                 
                </select>
              </div>
              </div>
            </div>
             
              <div class="row" style="margin-top: 20px">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="submit" class="btn cyan waves-effect waves-light right" id="submit" name="submit">
                  </div>
                </div>
              </div>
              </form>
            </div>
        </div>   
        </div>
       
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
   
  </div>
  <!-- /.content-wrapper -->
 
 

@stop 