@extends('admin.layout.master')                

@section('main_content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Booster Income
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Booster Income</li>
      </ol>
    </section>

     <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Booster Income</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="overflow-x:auto;">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                 <!-- <th>Sender Id</th>-->
                  <th>Year</th>
                  <th>Month</th>
                  <th>Right Business</th>
                  <th>Left Business</th>
                  <th>Total Business</th>
                  <th>Booster Income</th>
                  
                </tr>
                </thead>
                <tbody>
                  @foreach($data as $key=>$value)
                    <tr>
                      <td>{{$key+1}}</td>
                      
                      <td>{{$value['year']}}</td>
                      <td>{{$value['monthname']}}</td>
                        <td>{{$value['business_left']}}</td>
                        <td>{{$value['business_right']}}</td>
                        <td>{{$value['total_business']}}</td>
                      <td>{{$value['booster_income']}}</td>

                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
   
  </div>
  <!-- /.content-wrapper -->

@stop 