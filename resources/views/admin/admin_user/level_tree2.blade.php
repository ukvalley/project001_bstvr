@extends('admin.layout.master')                

@section('main_content')


 <script src="{{url('/')}}/dist/tooltip.js" type="text/javascript"></script>
<link href="{{url('/')}}/dist/tooltip.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#tooltable table tr th, #tooltable table tr td{
border:1px solid #5D5858;
padding:5px;text-align: center;
}
.half-circle {
			   width: 50%;
			   height: 20px;
  			   border-top-left-radius: 50px;
			   border-top-right-radius: 50px;
			   border: 3px solid #3570AF;
			   border-bottom: 0;
}

.table-striped tr th{
text-align:center}
</style>

<div style="display:none;">
	    <div id="sub0"><span id='tooltable'><table><tr><th>Parent ID</th><td>0</td></tr><tr><th>Left</th><td>472</td></tr><tr><th>Right</th><td>39</td></tr><tr><th>Pack</th><td>10000</td></tr></table></span></div>
	    <div id="sub1"><span id='tooltable'><table><tr><th>Parent ID</th><td>topid</td></tr><tr><th>Left</th><td>463</td></tr><tr><th>Right</th><td>8</td></tr><tr><th>Pack</th><td>0</td></tr></table></span></div>
		<div id="sub2"><span id='tooltable'><table><tr><th>Parent ID</th><td>topid</td></tr><tr><th>Left</th><td>19</td></tr><tr><th>Right</th><td>19</td></tr><tr><th>Pack</th><td>0</td></tr></table></span></div>
		<div id="sub3"><span id='tooltable'><table><tr><th>Parent ID</th><td>topid</td></tr><tr><th>Left</th><td>34</td></tr><tr><th>Right</th><td>428</td></tr><tr><th>Pack</th><td>0</td></tr></table></span></div>		
		<div id="sub4"><span id='tooltable'><table><tr><th>Parent ID</th><td>test</td></tr><tr><th>Left</th><td>3</td></tr><tr><th>Right</th><td>4</td></tr><tr><th>Pack</th><td>0</td></tr></table></span></div>		
		<div id="sub5"><span id='tooltable'><table><tr><th>Parent ID</th><td>test1</td></tr><tr><th>Left</th><td>17</td></tr><tr><th>Right</th><td>1</td></tr><tr><th>Pack</th><td>0</td></tr></table></span></div>		
		<div id="sub6"><span id='tooltable'><table><tr><th>Parent ID</th><td>topid</td></tr><tr><th>Left</th><td>4</td></tr><tr><th>Right</th><td>14</td></tr><tr><th>Pack</th><td>0</td></tr></table></span></div>		
		<div id="sub7"><span id='tooltable'><table><tr><th>Parent ID</th><td>topid</td></tr><tr><th>Left</th><td>33</td></tr><tr><th>Right</th><td>0</td></tr><tr><th>Pack</th><td>0</td></tr></table></span></div>		
		<div id="sub8"><span id='tooltable'><table><tr><th>Parent ID</th><td>test2</td></tr><tr><th>Left</th><td>427</td></tr><tr><th>Right</th><td>0</td></tr><tr><th>Pack</th><td>0</td></tr></table></span></div>		
		<div id="sub9"><span id='tooltable'><table><tr><th>Parent ID</th><td>test4</td></tr><tr><th>Left</th><td>2</td></tr><tr><th>Right</th><td>0</td></tr><tr><th>Pack</th><td>0</td></tr></table></span></div>		
		<div id="sub10"><span id='tooltable'><table><tr><th>Parent ID</th><td>test4</td></tr><tr><th>Left</th><td>2</td></tr><tr><th>Right</th><td>1</td></tr><tr><th>Pack</th><td>0</td></tr></table></span></div>		
		<div id="sub11"><span id='tooltable'><table><tr><th>Parent ID</th><td>test5</td></tr><tr><th>Left</th><td>16</td></tr><tr><th>Right</th><td>0</td></tr><tr><th>Pack</th><td>0</td></tr></table></span></div>		
		<div id="sub12"><span id='tooltable'><table><tr><th>Parent ID</th><td>test5</td></tr><tr><th>Left</th><td>0</td></tr><tr><th>Right</th><td>0</td></tr><tr><th>Pack</th><td>0</td></tr></table></span></div>		
		<div id="sub13"><span id='tooltable'><table><tr><th>Parent ID</th><td>test3</td></tr><tr><th>Left</th><td>3</td></tr><tr><th>Right</th><td>0</td></tr><tr><th>Pack</th><td>0</td></tr></table></span></div>		
		<div id="sub14"><span id='tooltable'><table><tr><th>Parent ID</th><td>binary</td></tr><tr><th>Left</th><td>0</td></tr><tr><th>Right</th><td>13</td></tr><tr><th>Pack</th><td>0</td></tr></table></span></div>		
				
</div>





<div class="content-wrapper">
   <section class="content-header">
        <h1>
         Tree View
        </h1>
   </section>
	<section class="content">
		<div class="row">
           <div class="col-md-12">
			<div class="clear"></div>

		


			<div class="box  box-success" style="background-color:#DAFAC2"><br><br>
			<div class="col-md-3">
</div>
	<div class="col-md-6">
	
	<table class="table table-striped">
	
	
	<tr class="danger"><th width="33%">Left Member {{$left_count}}</th><th rowspan="3" width="34%">
	<form action="tree.php" method="POST" >
	
			<div class="input-group">
						  <input class="form-control" type="text" name="srch" placeholder="Search ID">
		                  
						 <div class="input-group-btn">
		                  <button type="button" class="btn btn-danger" id="usrname"><i class="fa fa-search"></i></button>
		                </div><!-- /btn-group -->
			</div>
		
	</form>
	<h1>binary</h1><br>Name : {{$root_user or 'NA'}}</th><th width="33%">Right Member {{$right_count}}</th></tr>
	
	<tr class="info"><th>Left Business {{$left_business}}</th><th>Right Business {{$right_business}}</th></tr>
	</table><br>
			

</div>
<div class="col-md-1">
</div>
<div class="col-md-2">
<table class="table table-striped">
<tr class="success"><th style="text-align:left"><img src="{{url('/')}}/images/green.png" width="25px"/>Paid Member</th></tr>
<tr class="danger"><th style="text-align:left"><img src="{{url('/')}}/images/red.png" width="25px"/> Block Member</th></tr>
<tr class="info"><th style="text-align:left"><img src="{{url('/')}}/images/gray.png" width="25px"/> Joined Member</th></tr>
</table>
</div>

  
				
		        <table style="width: 100%; margin-left:0px; border:none;" cellpadding="0" cellspacing="0" border=0 id="yahoo">
			        <tr>
			        	<!-- Root Member -->

			             <td  colspan=8 align="center" style="height: 23px; valign=middle">
			             	<code class='text-info'>{{$root_user or 'NA'}}</code> <br>
			             	
							<img src="{{url('/')}}/images/green.png" onmouseover="tooltip.pop(this, '#sub0', {offsetY:-10, smartPosition:false})"> <br>
			               </td>
			        </tr>
			       <tr>
			            <td colspan=8 align="center" valign="middle">
			                <div class="half-circle" style="width:50%"></div></td>
			        </tr>

			        <tr>
			        	

			        		<?php $user_data = \DB::table('users')->where(['email'=>$root_user])->first();  ?>

			        		<!-- left and right members of root -->
			        		@if(!empty($user_data))
			        		<?php $user_data1 = \DB::table('users')->where(['email'=>$user_data->_left])->first();  ?>
			        		 <?php $user_data2 = \DB::table('users')->where(['email'=>$user_data->_right])->first();  ?>
			        		@endif


			        		 <!-- last 4 members -->
			        		 @if(!empty($user_data1))
			        		 <?php $user_data3 = \DB::table('users')->where(['email'=>$user_data1->_left])->first();  ?>
			        		 <?php $user_data4 = \DB::table('users')->where(['email'=>$user_data1->_right])->first();  ?>
			        		 @endif

			        		 @if(!empty($user_data2))
			        		 <?php $user_data5 = \DB::table('users')->where(['email'=>$user_data2->_left])->first();  ?>
			        		 <?php $user_data6 = \DB::table('users')->where(['email'=>$user_data2->_right])->first();  ?>
			        		 @endif





			        		<!-- Level One Members left-->

			                  <td colspan=4 align="center" valign="middle" style="height: 61px;  text-align: center;"><code class='text-info'>{{$user_data->_left or 'NA'}}</code> <br><a style='color:;' onmouseover="tooltip.pop(this, '#sub1', {offsetY:-10, smartPosition:false})" href="{{url('/')}}/admin/level_tree?id={{$user_data->_left or 'NA'}}">

			                  @if(isset($user_data1->is_active))
			                  	@if($user_data1->is_active=="2")
			                  	<img src="{{url('/')}}/images/green.png" > </a></td>
			                  	@elseif($user_data1->is_active=="1")
			                  	<img src="{{url('/')}}/images/gray.png" > </a></td>
			                  	@elseif($user_data1->is_active=="0")
			                  	<img src="{{url('/')}}/images/red.png" > </a></td>
			                  	@else
			                  	<a href="{{url('/')}}/admin/add_user"><h4>Join Here</h4></a>
			                  	@endif
			                  	@else
							   <a href="{{url('/')}}/admin/add_user"><h4>Join Here</h4></a>
			                  @endif
			                

			                <!--   <tr>
					                 <td colspan=4 align="center" valign="middle">
					               <div class="half-circle"></div></td>
					                <td align="center"  valign="middle" colspan=4	>
					                <div class="half-circle"></div></td>
				   			</tr> 
 -->


				   			

			        		<!-- Level One Members right-->
			                  <td colspan=4 align="center" valign="middle" style="height: 61px;  text-align: center;"><code class='text-info'>{{$user_data->_right or 'NA'}}</code> <br><a style='color:;' onmouseover="tooltip.pop(this, '#sub1', {offsetY:-10, smartPosition:false})" href="{{url('/')}}/admin/level_tree?id={{$user_data->_right or 'NA'}}">
			                  @if(isset($user_data2->is_active))
			                  	@if($user_data2->is_active=="2")
			                  	<img src="{{url('/')}}/images/green.png" > </a></td>
			                  	@elseif($user_data2->is_active=="1")
			                  	<img src="{{url('/')}}/images/gray.png" > </a></td>
			                  	@elseif($user_data2->is_active=="0")
			                  	<img src="{{url('/')}}/images/red.png" > </a></td>
			                  	@else
			                  	<a href="{{url('/')}}/admin/add_user"><h4>Join Here</h4></a>
			                  	@endif
			                  	@else
							    <a href="{{url('/')}}/admin/add_user"><h4>Join Here</h4></a>
			                  @endif

			                

			                  <tr>
					                 <td colspan=4 align="center" valign="middle">
					               <div class="half-circle"></div></td>
					                <td align="center"  valign="middle" colspan=4	>
					                <div class="half-circle"></div></td>
				   			</tr> 

				   			

			                

			                <!--  Level Two Members -->
			                			
			                 			 <td align="center" valign="middle" colspan=2>
			                            <code class='text-info'>{{$user_data1->_left or 'NA'}}</code><br><a style='color:;' href="{{url('/')}}/admin/level_tree?id={{$user_data1->_left or 'NA'}}" onmouseover="tooltip.pop(this, '#sub3', {offsetY:-10, smartPosition:false})" >
			                            	@if(isset($user_data3->is_active))
			                            		@if($user_data3->is_active=="2")
			                  					<img src="{{url('/')}}/images/green.png" > </a></td>
							                  	@elseif($user_data3->is_active=="1")
							                  	<img src="{{url('/')}}/images/gray.png" > </a></td>
							                  	@elseif($user_data3->is_active=="0")
							                  	<img src="{{url('/')}}/images/red.png" > </a></td>
							                  	@else
							                  	<a href="{{url('/')}}/admin/add_user"><h4>Join Here</h4></a>
							                  	@endif

							                  	@else
							                  	<a href="{{url('/')}}/admin/add_user"><h4>Join Here</h4></a>
							                  	
							                  @endif


			                              <td align="center" valign="middle" colspan=2>
			                            <code class='text-info'>{{$user_data1->_right or 'NA'}}</code><br><a style='color:;' href="{{url('/')}}/admin/level_tree?id={{$user_data1->_right or 'NA'}}" onmouseover="tooltip.pop(this, '#sub3', {offsetY:-10, smartPosition:false})" >]

			                            	@if(isset($user_data4->is_active))

			                            		@if($user_data4->is_active=="2")
			                  					<img src="{{url('/')}}/images/green.png" > </a></td>
							                  	@elseif($user_data4->is_active=="1")
							                  	<img src="{{url('/')}}/images/gray.png" > </a></td>
							                  	@elseif($user_data4->is_active=="0")
							                  	<img src="{{url('/')}}/images/red.png" > </a></td>
							                  	@else
							                  	<a href="{{url('/')}}/admin/add_user"><h4>Join Here</h4></a>
							                  	@endif

							                  	@else
							                  	<a href="{{url('/')}}/admin/add_user"><h4>Join Here</h4></a>

							                  @endif


			                           
			                              <td align="center" valign="middle" colspan=2>
			                            <code class='text-info'>{{$user_data2->_left or 'NA'}}</code><br><a style='color:;' href="{{url('/')}}/admin/level_tree?id={{$user_data2->_left or 'NA'}}" onmouseover="tooltip.pop(this, '#sub3', {offsetY:-10, smartPosition:false})" >

			                            	@if(isset($user_data5->is_active))

			                            	@if($user_data5->is_active=="2")
			                  					<img src="{{url('/')}}/images/green.png" > </a></td>
							                  	@elseif($user_data5->is_active=="1")
							                  	<img src="{{url('/')}}/images/gray.png" > </a></td>
							                  	@elseif($user_data5->is_active=="0")
							                  	<img src="{{url('/')}}/images/red.png" > </a></td>
							                  	@else
							                  	<a href="{{url('/')}}/admin/add_user"><h4>Join Here</h4></a>
							                  	@endif

							                  	@else
							                  	<a href="{{url('/')}}/admin/add_user"><h4>Join Here</h4></a>

							                  @endif



			                              <td align="center" valign="middle" colspan=2>
			                            <code class='text-info'>{{$user_data2->_right or 'NA'}}</code><br><a style='color:;' href="{{url('/')}}/admin/level_tree?id={{$user_data2->_right or 'NA'}}" onmouseover="tooltip.pop(this, '#sub3', {offsetY:-10, smartPosition:false})" >
			                            	@if(isset($user_data6->is_active))
			                            		@if($user_data6->is_active=="2")
			                  					<img src="{{url('/')}}/images/green.png" > </a></td>
							                  	@elseif($user_data6->is_active=="1")
							                  	<img src="{{url('/')}}/images/gray.png" > </a></td>
							                  	@elseif($user_data6->is_active=="0")
							                  	<img src="{{url('/')}}/images/red.png" > </a></td>
							                  	@else
							                  	<a href="{{url('/')}}/admin/add_user"><h4>Join Here</h4></a>
							                  	@endif

							                  	@else
							                  	<a href="{{url('/')}}/admin/add_user"><h4>Join Here</h4></a>

							                  @endif
			                

			            

			                
			      
		        </table><br><br><br><br>
      
			  </div>
		   </div>
	    </div>
   </section>
</div>

@stop 