@extends('admin.layout.master')                

@section('main_content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Withdrawal Request
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Withdrawal Request</li>
      </ol>
    </section>

     <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Withdrawal Request</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="overflow-x:auto;">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Reciever Id</th>
                  <th>Amount</th>
                  <th>TDS 5%</th>
                  <th>Admin Charges 10%</th>
                  <th>Net Payble</th>
                  <th>Date</th>
                  <th>Reason</th>
                  <th>Details</th>
                  <th>Status</th>

                </tr>
                </thead>
                <tbody>
                  @foreach($data as $key=>$value)
                    <tr>
                      <td>{{$key+1}}</td>
                     
                      <td>{{$value->reciver_id}}</td>
                       
                      <td>{{$value->amount}}</td>
                       <td>{{$value->amount*(5/100)}}</td>
                        <td>{{$value->amount*(10/100)}}</td>
                        <td>{{($value->amount)-($value->amount*(5/100))-($value->amount*(10/100))}}</td>
                      <td>{{$value->date}}</td>
                       <td>{{$value->activity_reason}}</td>
                       <td><a href="{{url('/')}}/admin/view?id={{$value->reciver_id}}&amt={{$value->amount}}" class="btn label-danger">Details</a></td>

                       <td><a href="{{url('/')}}/admin/payment_sent?id={{$value->id}}" class="btn label-danger">Mark to send</a></td>

                     <!--  <td>
                        @if($value->approval=="payment_done")
                          <a href="javescript:void(0)" class="btn label-danger">Pending</a>
                        @else
                          <a href="javescript:void(0)" class="btn label-success">Completed</a>
                        @endif
                      </td> -->
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