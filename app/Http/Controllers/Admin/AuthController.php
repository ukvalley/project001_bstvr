<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use URL;
use Mail;
use Session;
use Sentinel;
use Validator;
use App\Models\UserModel;
use App\Models\EmailTemplateModel;
use PHPMailer\PHPMailer;

class AuthController extends Controller
{
    public $arr_view_data;
    public $admin_panel_slug;

    public function __construct(UserModel $user_model,
                               EmailTemplateModel $email_template_model)
    {
      $this->UserModel          = $user_model;
      $this->EmailTemplateModel = $email_template_model;
      $this->arr_view_data      = [];
      $this->admin_panel_slug   = config('app.project.admin_panel_slug');

    }
    

    public function login()
    {
      $this->arr_view_data['admin_panel_slug'] = $this->admin_panel_slug;
      $this->arr_view_data['page_title'] = "Login";
      
    	return view('admin.login',$this->arr_view_data);
    }

    public function login_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'  => 'required|max:255',
            'password'  => 'required',
        ]);

        if ($validator->fails()) 
        {
            return redirect(config('app.project.admin_panel_slug').'/login')
                        ->withErrors($validator)
                        ->withInput($request->all());
        }
       
        if(isset($_POST["remember_me"]))
        {
          if($_POST["remember_me"]=='on')
          {
            $hour = time() + 3600 * 24 * 30;
            setcookie('username',$request->input('username'), $hour);
            setcookie('password',$request->input('password'), $hour);
          }
        }

        $credentials = [
            'email'=> $request->input('username'),
            'password' => $request->input('password'),
        ];
        $check_authentication = Sentinel::authenticate($credentials);

        if($check_authentication)
        {

          $user = Sentinel::check();
         
            return redirect('admin/dashboard');die;
         /* if($user->is_admin=='1')
          {
          }
          else
          {
            Sentinel::logout();
            Session::flash('error', 'Invalid Login Credentials.');
            return redirect('admin');
          }*/
        }
        else
        {
          Session::flash('error', 'Invalid Login Credentials.');
        } 
      Sentinel::logout();
      return redirect('admin');
    }

    public function dashboard()
    {
      $this->arr_view_data['admin_panel_slug'] = $this->admin_panel_slug;
      $this->arr_view_data['page_title']       = "dashboard";

       $user = Sentinel::check();
       die;
       if($user->is_admin==1)
       {
          return view('admin.dashboard',$this->arr_view_data);
       }
       else
       {
          return view('admin.customer_user.dashboard',$this->arr_view_data);
       }
      
    }

    public function registration()
    {
      $this->arr_view_data['admin_panel_slug'] = $this->admin_panel_slug;
      $this->arr_view_data['page_title']       = "Login";
      
      return view('admin.register',$this->arr_view_data);
    }

    public function register_process(Request $request)
    {
    
     /* $validator = Validator::make($request->all(), [
            'username'       => 'required',
            'user_id'        => 'required',
            'sponcer_id'     => 'required',
            'mobile'         => 'required',
            'email'          => 'required',
            'password'       => 'required',
            
        ]);
      
      if ($validator->fails()) 
      {
          return redirect(config('app.project.admin_panel_slug').'/registration')
                      ->withErrors($validator)
                      ->withInput($request->all());
      }
      */


      $count = $this->UserModel->where(['email'=>$request->input('sponcer_id')])->first();
      $count_self = $this->UserModel->where(['mobile' =>$request->input('mobile')])->count();
     
      if($count['is_active']!='2')
      {
   
        Session::flash('error', "Sponcer id not yet activated! Please wait for some time.");
        return redirect()->back();
      }

      $count = $this->UserModel->where(['email'=>$request->input('sponcer_id')])->count();
    
      if($count==0)
      {
        Session::flash('error', "No parent user exist.");
        return redirect()->back();
      }
 
      $count1 = $this->UserModel->where(['email'=>$request->input('user_id')])->count();
   
      if($count1)
      {
        Session::flash('error', "User already exist.");
        return redirect()->back();
      }
 
      $arr_data               = [];
      $arr_data['user_name']  = $request->input('username');
      $arr_data['mobile']     = $request->input('mobile');
      $arr_data['email']      = $request->input('user_id');
      $arr_data['password']   = $request->input('password');
     
      
      $arr_data['is_active']  = 1;
      
   
      
 
      $user_status = Sentinel::registerAndActivate($arr_data);


      //binery user tree registering

      $binery_sponcer=  $this->check_position($request->input('sponcer_id'),$request->input('position'));
  
      $arr_data                              = [];
      $arr_data[$request->input('position')] = $request->input('user_id');

       $this->UserModel->where(['email'=>$binery_sponcer])->update($arr_data);

      // ends here
      
      if(isset($user_status->id) && !empty($user_status->id))
      {
        $arr_user_data                   = [];
        $arr_user_data['user_name']      = $request->input('username');

        $arr_user_data['binary_sponcer'] = $binery_sponcer;
        $arr_user_data['my_side']        = $request->input('position');


        

        $arr_user_data['middle_name']    = $request->input('middlename');
        $arr_user_data['last_name']      = $request->input('lastname');
        $arr_user_data['gender']         = $request->input('gender');
        $arr_user_data['dob']            = $request->input('dob');
        
        $arr_user_data['mobile']         = $request->input('mobile');
        $arr_user_data['email1']         = $request->input('email1');

        $arr_user_data['email']          = $request->input('user_id');
        $arr_user_data['password12']     = $request->input('password');

         
        $arr_user_data['spencer_id']     = $request->input('sponcer_id');
        $arr_user_data['spencer_name']   = $request->input('spencer_name');

        
        $arr_user_data['country']        = $request->input('country');
        $arr_user_data['state']          = $request->input('state');
        $arr_user_data['city']           = $request->input('city');
        $arr_user_data['address']        = $request->input('address');
        $arr_user_data['pincode']        = $request->input('pincode');
    
        $arr_user_data['joining_date']   = null;//date('Y-m-d');
        $arr_user_data['recommit_count'] = 0;
        $email                           = $request->input('email');
        $characters                      = '0123456789';
        $charactersLength                = strlen($characters);
        $randomString                    = '';
     
       
       
     
        for ($i = 0; $i < 6; $i++)
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        
        $arr_user_data['transaction_pin'] = $randomString;

        $arr_user_data['password']        = password_hash($request->input('password'), PASSWORD_DEFAULT);

        
        $this->UserModel->where(['id'=>$user_status->id])->update($arr_user_data);
        
        
        
	     	$tree_count = $this->UserModel->where(['spencer_id'=>$request->input('sponcer_id')])->count();
       $A = $this->UserModel->where(['email'=>$request->input('sponcer_id')])->update(['tree_count'=>$tree_count]);

       
       
        $data_setting = \DB::table('site_setting')->where('id','=','1')->first();
            
         $message = "Welcome to ".$data_setting->site_name." Your User Name:".$request->input('username').",User Id:".$request->input('user_id').", Transaction Pin:".$randomString." Password is:".$request->input('password')."";
     
        
        $url='http://sms.ukvalley.com/api/sendhttp.php?authkey='.$data_setting->sms_auth.'&mobiles='.$request->input('mobile').'&message='.$message.'&sender='.$data_setting->sms_sender_id.'&route=6';
        
        $this->mail($request->input('email1'));
        
        $user_name= $request->input('email1');
        
        $arr_user_data['title'] = "The registration is successfully";
         
         $data = [
           'email' => $request->input('user_id'),
           'password' => $request->input('password')
            ];
            
          
           $email =  $request->input('email');
         
        
        
        $ch = curl_init();
        curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        
        $output = curl_exec($ch);

        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }

        //create matching income instance

                        $arr_transaction                    = [];
                        $arr_transaction['reciver_id']      = $request->input('user_id');
                        $arr_transaction['sender_id']       = '';
                        $arr_transaction['amount']          = "0";
                        $arr_transaction['day_amt']         = "0";
                        $arr_transaction['day_amt_date']    = date('Y-m-d');
                        $arr_transaction['activity_reason'] = 'matching';
                        $arr_transaction['date']            = date('Y-m-d');
                        $arr_transaction['approval']        = 'pending';
                        $arr_transaction['generator']       = 'system';
                        \DB::table('transaction')->insert($arr_transaction);


                        //create binary income for parents

      
      
      }
      Session::flash('success', ''.$message);
      return redirect('admin/login')->with( [ 'id' => $request->input('user_id') ] );
    }
    
    
    
     public function mail()
    {
        /* $arr_user_data['title'] = "The registration is successfully";
         Mail::send('mail', $arr_user_data, function($message) {
 
            $message->to('mahajandivya192@gmail.com', 'Receiver Name')
 
                    ->subject('Registration Successfull');
                    $message->from('support@globalfx.world','Globalfx');
        });
 */
    }



    public function choose_plan(Request $request)
    {
      $epin        = $request->input('epin');
      $userid      = $request->input('userid');
      $plan_amount = $request->input('package');

      $plan       = \DB::table('package')->where('amount','=',$plan_amount)->first();

      $user_data  = \DB::table('users')->where('email','=',$userid)->first();

      $epin_data  = \DB::table('epin')->where('epin_id','=',$epin)->first();

      if (isset($epin_data)) {

        if ($epin_data->amount == $plan_amount) 
        {

               

            $arr_user_data['plan']   = $plan->package_name;
            $arr_user_data['amount'] = $plan_amount;
    

           $this->UserModel->where(['email'=>$userid])->update($arr_user_data);    
      

           $this->activate_user_with_epin($epin,$userid);     

           $this->binary_income($user_data->binary_sponcer,$user_data->email,$user_data->my_side,$plan->bv);

           Session::flash('success', "Package is Activated");
           return redirect()->back();
          
        }

        else{

          Session::flash('error', "Wrong Epin Amount Inserted");
        return redirect()->back(); 
        }
        

      }
      else
      {

        Session::flash('error', "Wrong Epin");
        return redirect()->back(); 
      }

      

    }


    public function check_function()
    {

     $data_ = $this->check_position($_GET['sponcer_id'],$_GET['position']);
   // echo $data_;

      
          $data['name']   = "User will be added at ".$data_." ".$_GET['position'];
          $data['status'] = "success";


             return $data;
      
    }



   public  function check_position($email,$position)
   {

    $user= \DB::table('users')->where('email','=',$email)->first();

    if ($user->{$position}!=null) 
    {
      
      $user = \DB::table('users')->where('email','=',$user->{$position})->first();
    
      return $this->check_position($user->email,$position);
    
    }

    else
    {

  
      $available_at= $user->email;

      return $available_at;
  
      }

   }


   public function test1()
   {
      $a= $this->binary_income("admin","umesh","_left","1800");
      //print_r($a);
   }




     public function getSelfLeftRightCount($user_id)
      {
          
        $user=  \DB::table('users')->where(['email'=>$user_id])->first();

        $self_left_count  = 0;
        $self_right_count = 0;

        $child_data = \DB::table('users')->where(['spencer_id'=>$user_id])->get();

        foreach ($child_data as $key => $value) 
        {
          
          if ($value->my_side == "_left" AND $value->is_active == 2) 
          {
            $self_left_count = $self_left_count + 1;
           
          }

          if ($value->my_side == "_right"  AND $value->is_active == 2) 
          {
            $self_right_count = $self_right_count + 1;
          }

        }

        $arr_count               = [];
        $arr_count['self_left']  = $self_left_count;
        $arr_count['self_right'] = $self_right_count;


        return $arr_count;
      

      }



   public function binary_income($binary_sponcer, $user_id, $side, $package_amt)
   {
    
          $total_count         = 1;
          $temp_side           = $side;
          $temp_binary_sponcer = $binary_sponcer;
          $temp_package_amt    = $package_amt;


          // find binary sponcer and check its right left bv... if matched then give matching income

              while ($total_count>0)
              {
                
                $user   = \DB::table('users')->where('email','=',$temp_binary_sponcer)->first();

               

                $today  = date('Y-m-d');

                $amount = 0;

               
              

                  
              

                  //check user has binary sponcer or not 

                      if(isset($user->binary_sponcer))
                      {

                        //get all the details of user 

                             $left_count     = $this->getLeftCount($user->email);

                             $right_count    = $this->getRightCount($user->email);


                             $left_business  = $this->getLeftBusiness($user->email);

                             $right_business = $this->getRightBusiness($user->email);


                             $self_left_right = $this->getSelfLeftRightCount($user->email);

                             $capping = \DB::table('package')->where('package_name','=',$user->plan)->first();
                          

                              //check users left count and right count here ratio is 1:1 we can set it to 2:1 and 1:2 also

                                    if($left_count>0 && $right_count>0)
                                    {

                                      //check on which side transaction is being happening
                                      
                                    if($temp_side=='_left')

                                      {

                                        //check if right side business is greater than left side then matching will be same as left side business

                                        if($left_business<=$right_business)

                                        { 

                                         

                                         $arr_transaction                    = [];
                                         $arr_transaction['reciver_id']      = $user->email;
                                         $arr_transaction['level_id']        = $user_id;
                                         $arr_transaction['sender_id']       = '';
                                         $arr_transaction['amount']          = $left_business*(10/100);
                                         $arr_transaction['activity_reason'] = 'matching';
                                         $arr_transaction['date']            = date('Y-m-d');
                                         $arr_transaction['approval']        = 'pending';
                                         $arr_transaction['generator']       = 'system';
                                         $arr_transaction['percentage']      = '10';
                                         $arr_transaction['plan_amt']        = $temp_package_amt;


                                         // Now set Daily Business by setting day_amount and day_amount_date

                                        $day_amount = \DB::table('transaction')->where('reciver_id','=',$temp_binary_sponcer)->where('activity_reason','=',"matching")->first();

                                        //if day_amount_date means today has some business then add in that business
                                        
                                         if($day_amount->day_amt_date == $today)
                                         {
                                          $current_amt= $day_amount->amount;
                                          $amount = $day_amount->day_amt;
                                          $arr_transaction['day_amt']      = $amount + ($left_business*(10/100)-$current_amt);

                                         }
                                         // if today has not business then update business for today
                                         else
                                         {
                                          $current_amt = $day_amount->amount;
                                          $amount      = 0;

                                          $arr_transaction['day_amt']      = ($left_business*(10/100)-$current_amt);
                                          $arr_transaction['day_amt_date'] = $today;
                                         }

                                        //if capping hits day_limit then add this amount to flush data

                                          if($arr_transaction['day_amt'] >= $capping->capping)

                                         {

                                         $arr_transaction_capping                    = [];
                                         $arr_transaction_capping['sender_id']       = $user->email;
                                         $arr_transaction_capping['level_id']        = $user_id;
                                         $arr_transaction_capping['activity_reason'] = "flush";
                                         $arr_transaction_capping['date']            = date('Y-m-d');
                                         $arr_transaction_capping['amount']          = $arr_transaction['day_amt']-$capping->capping;

                                          $flush_data= \DB::table('transaction')
                                          ->where('date','=',$today)
                                          ->where('sender_id','=',$user->email)->first();
                                                
                                                if (isset($flush_data)) 
                                                {
                                                  
                                                  \DB::table('transaction')->where('date','=',$today)->where('sender_id','=',$user->email)->update($arr_transaction_capping);
                                                 }        

                                                 else
                                                 {        

                                                  \DB::table('transaction')->insert($arr_transaction_capping);        

                                                 }

                                         }





                                         
                                         \DB::table('transaction')->where('reciver_id','=',$user->email)->where('activity_reason','=',"matching")->update($arr_transaction);
                                                   
                                        

                                        }                       

                                      }                       

                                    else
                                    {                         

                                        if($right_business<=$left_business)
                                        {

                                       
                                        
                                         $arr_transaction                    = [];
                                         $arr_transaction['reciver_id']      = $user->email;
                                         $arr_transaction['level_id']        = $user_id;
                                         $arr_transaction['sender_id']       = '';
                                         $arr_transaction['amount']          = $right_business*(10/100);
                                         $arr_transaction['activity_reason'] = 'matching';
                                         $arr_transaction['date']            = date('Y-m-d');
                                         $arr_transaction['approval']        = 'pending';
                                         $arr_transaction['generator']       = 'system';
                                         $arr_transaction['percentage']      = '10';
                                         $arr_transaction['plan_amt']        = $temp_package_amt;



                                        $day_amount = \DB::table('transaction')->where('reciver_id','=',$temp_binary_sponcer)->where('activity_reason','=',"matching")->first();
                                        
                                         
                                         if($day_amount->day_amt_date == $today)
                                         {
                                          $current_amt= $day_amount->amount;
                                          $amount = $day_amount->day_amt;
                                          $arr_transaction['day_amt']      = $amount + ($right_business*(10/100)-$current_amt);
                                         }
                                         else
                                         {
                                          $current_amt = $day_amount->amount;
                                          $amount      = 0;

                                          $arr_transaction['day_amt']      = ($right_business*(10/100)-$current_amt);
                                          $arr_transaction['day_amt_date'] = $today;
                                         }


                                         if($arr_transaction['day_amt'] >= $capping->capping)

                                         {

                                         $arr_transaction_capping                    = [];
                                         $arr_transaction_capping['sender_id']       = $user->email;
                                         $arr_transaction_capping['activity_reason'] = "flush";
                                         $arr_transaction_capping['level_id']        = $user_id;
                                         $arr_transaction_capping['date']            = date('Y-m-d');
                                         $arr_transaction_capping['amount']          = $arr_transaction['day_amt']-$capping->capping;

                                         $flush_data= \DB::table('transaction')->where('date','=',$today)->where('sender_id','=',$user->email)->first();
                                         if (isset($flush_data)) {
                                          
                                          \DB::table('transaction')->where('date','=',$today)->where('sender_id','=',$user->email)->update($arr_transaction_capping);
                                         }

                                         else{

                                          \DB::table('transaction')->insert($arr_transaction_capping);

                                         }
                                         
                                         }


                                         \DB::table('transaction')->where('reciver_id','=',$user->email)->where('activity_reason','=',"matching")->update($arr_transaction);
                                                

                                        }
                                                

                                    }
                                 

                             }


                          
                            $temp_binary_sponcer = $user->binary_sponcer;
                            
                                  

                        }

              if($temp_binary_sponcer=="")
                {
                  $total_count=0;
                }

          }

      }




  




    public function getLeftCount($user_id)
      {
          
        $user=  \DB::table('users')->where(['email'=>$user_id])->first();

        if ($user->_left!=null) {
          $left = \DB::table('users')->where(['email'=>$user->_left])->first();
           $left->email;
          $user_array1 = [];
          $user_array = [];
          $count=0;
         $a= $this->get_all_child($left->email,$user_array);
        if(isset($a))
          {
            $count = 1+sizeof($a);
          }
          else
          {
            $count=1;
          }

         return $count;
        }

        else
        {
          return $count=0;

        }
      

      }


     

         public function getRightCount($user_id)
       {
          
        $user=  \DB::table('users')->where(['email'=>$user_id])->first();

        if ($user->_right!=null) {
          $right = \DB::table('users')->where(['email'=>$user->_right])->first();
         $right->email;
          $user_array1 = [];
          $user_array = [];
          $count=0;
         $a= $this->get_all_child($right->email,$user_array);
         if(isset($a))
          {
            $count = 1+sizeof($a);
          }
          else
          {
            $count=1;
          }

         return $count;
        }

        else
        {
          return $count=0;

        }

      }



        public function get_all_child($user_id, array $user_array)
      {
    
        $get_left_right_data = \DB::table('users')->where(['email'=>$user_id])->first();

        
        if ($get_left_right_data->_left!=null) {

        $left = $get_left_right_data->_left;
         
        $temp_arr =[];
        $temp_arr['user_id']   =  $left;
        $temp_arr['side']   =     "left";
         $temp_arr['self_bv']   = $this->getBV($left);

        array_push($user_array, $temp_arr);

       $user_array= $this->get_all_child($left,$user_array);


        
        }

        if ($get_left_right_data->_right!=null) 
        {
        $right = $get_left_right_data->_right;
         
        $temp_arr =[];
        $temp_arr['user_id']   =  $right;
        $temp_arr['side']   =     "right";
         $temp_arr['self_bv']   = $this->getBV($right);
        
       array_push($user_array, $temp_arr);
    
      $user_array= $this->get_all_child($right,$user_array);

       
       }
       

       return $user_array;

      }


       public function getBV($user_id)
      {


         $trans = \DB::table('transaction')->where(['sender_id'=>$user_id])->where(['activity_reason'=>"add_package"])->where(['approval'=>"completed"])->get();

         $amount = 0;

         foreach ($trans as $key => $value) {
           # code...

          $amount =$amount+$value->amount;
         }



         return $amount;


      }



      public function activate_user_with_epin($e_pin, $user_email)
  
    {

       $data_ = \DB::table('users')->where('email','=',$user_email)->where('is_active','!=','2')->first();


      
     
        //update epin used details
        $arr_transaction            = [];
        $arr_transaction['usedfor'] = 'registration';
        $arr_transaction['used_by'] = $user_email;

        \DB::table('epin')->where('epin_id','=',$e_pin)->update($arr_transaction);

       //update user becomes active details in user table
        $arr_transaction               = [];
        $arr_transaction['epin']       = $e_pin;
        $arr_transaction['is_active']  = "2";
        $arr_transaction['topup_date'] = date('Y-m-d');

        $data = $this->UserModel->where('email','=',$user_email)->update($arr_transaction);
        
        $user_details= $this->UserModel->where('email','=',$user_email)->first();
        
        $message= "Hello ".$user_email." Your ID is activated with EPIN";

       // $this->send_otp($message,$user_details->mobile);


        $epin_data = \DB::table('epin')->where('epin_id','=',$e_pin)->first();

        $plan_data = \DB::table('package')->where('amount','=',$epin_data->amount)->first();



          $arr_transaction                    = [];
           
          $arr_transaction['sender_id']       = $user_email;
          $arr_transaction['amount']          = $plan_data->bv;
          $arr_transaction['plan_amt']          = $plan_data->amount;
          $arr_transaction['activity_reason'] = 'add_package';
          $arr_transaction['date']            = date('Y-m-d');
          $arr_transaction['approval']        = 'completed';
          $arr_transaction['generator']       = 'system';
          
         
        

          \DB::table('transaction')->insert($arr_transaction);


    
        

        
    }



    public function getLeftBusiness($user_id)
      {
          
        $user=  \DB::table('users')->where(['email'=>$user_id])->first();

        if ($user->_left!=null) {
          $left = \DB::table('users')->where(['email'=>$user->_left])->first();
          $first_left_bv = $this->getBV($left->email);
          $user_array1 = [];
          $user_array = [];
          $amount=0;
          $temp_amt =0;
         $a= $this->get_all_child($left->email,$user_array);
         
        if(isset($a))
          {
            foreach ($a as $key => $value) {
              $temp_amt = $temp_amt+$value['self_bv'];
              
            }
            $amount = $first_left_bv+$temp_amt;
          }
          else
          {
            $amount=$first_left_bv;
          }

         return $amount;
        }

        else
        {
          return $amount=0;

        }
      

      }



        public function getRightBusiness($user_id)
       {
          
        $user=  \DB::table('users')->where(['email'=>$user_id])->first();



        if ($user->_right!=null) {
          $right = \DB::table('users')->where(['email'=>$user->_right])->first();
          $first_right_bv = $this->getBV($right->email);
          $user_array1 = [];
          $user_array = [];
          $amount=0;
          $temp_amt = 0;
          $a= $this->get_all_child($right->email,$user_array);

         // print_r($a);
         if(isset($a))
          {
            foreach ($a as $key => $value) {
              $temp_amt= $temp_amt + $value['self_bv'];
            }
            $amount = $first_right_bv+$temp_amt;
          }
          else
          {
            $amount=$first_right_bv;
          }

         return $amount;
        }

        else
        {
          return $amount=0;

        }

      }





   
    


public function forgot_tpin()
    {
      $this->arr_view_data['admin_panel_slug'] = $this->admin_panel_slug;
      $this->arr_view_data['page_title'] = "Forget Password";
      
      return view('admin.forgot_tpin',$this->arr_view_data);
    }


public function forget_transaction_pin(Request $request)
    {

    	if(empty($_POST['username']) || empty($_POST['mobile']))
    	{
    		echo "Invalid Parameters!";

    	}
    	
      $characters = '0123456789';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < 6; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }

      $arr_user_data                 = [];
      $password                      = $randomString;
      $arr_user_data['email']        = $request->input('username');
      $arr_user_data['mobile']       = $request->input('mobile');

      $count = $this->UserModel->where($arr_user_data)->count();
      
      if($count)
      {
        $this->UserModel->where($arr_user_data)->update(['transaction_pin'=>$password]);
        Session::flash('success', 'Password has been sent to user mobile.');
        $mobileno = $request->input('mobile');
      
       









      $data_setting = \DB::table('site_setting')->where('id','=','1')->first();


        $msg="Dear Sir, Your new transaction pin is ".$randomString." for ".$arr_user_data['email']." Please Login Your Account.";
        $url='http://sms.ukvalley.com/api/sendhttp.php?authkey='.$data_setting->sms_auth.'&mobiles='.$request->input('mobile').'&message='.$msg.'&sender='.$data_setting->sms_sender_id.'&route=6';
        
        $ch = curl_init();
        curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

       $output = curl_exec($ch);

        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }
          
          
        
          
          
          Session::flash('success', 'Transaction pin has been sent successfully.');
         return redirect('admin');
      }
      else
      {
           Session::flash('error', 'Please enter valid details!!!.');
          return redirect('admin/forgot_tpin');
      }
}




     public function forget_password()
    {
      $this->arr_view_data['admin_panel_slug'] = $this->admin_panel_slug;
      $this->arr_view_data['page_title'] = "Forget Password";
      
      return view('admin.forgot',$this->arr_view_data);
    }




    public function forget_password_process(Request $request)
    {
    	if(empty($_POST['username']) || empty($_POST['mobile']))
    	{
    		echo "Invalid Parameters!";

    	}
    	
      $characters = '0123456789';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < 6; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }

      $arr_user_data                 = [];
      $password                      = password_hash($randomString, PASSWORD_DEFAULT);
      $arr_user_data['email']        = $request->input('username');
      $arr_user_data['mobile']       = $request->input('mobile');

      $count = $this->UserModel->where($arr_user_data)->count();
      $user= $this->UserModel->where(['email'=>$request->input('username')])->first();
      if($count)
      {
        $this->UserModel->where($arr_user_data)->update(['password'=>$password]);
        Session::flash('success', 'Password has been sent to user mobile.');
        $mobileno = $request->input('mobile');
      
       







        $data_setting = \DB::table('site_setting')->where('id','=','1')->first();


        
        
        $data = [
           'email' => $user->email,
           'password' => $randomString
            ];
            
          
           $email =  $user->email1;
         
         Mail::send('forgot_mail',['data' => $data], function($message) use ($email) {
 
            $message->to($email, 'Receiver Name')
 
                    ->subject('Globalfx.world forgot your mail');
                    $message->from('support@globalfx.world','Globalfx');
        });


        $msg="Dear Sir, Your new password is ".$randomString." for ".$arr_user_data['email']." Please Login Your Account.";
        $url='http://sms.ukvalley.com/api/sendhttp.php?authkey='.$data_setting->sms_auth.'&mobiles='.$request->input('mobile').'&message='.$msg.'&sender='.$data_setting->sms_sender_id.'&route=6';
        $ch = curl_init();
        curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $output = curl_exec($ch);

        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }
          
          
         echo 'true';
      }
      else
      {
         echo 'error,Please enter valid details!!!';
      }
    }

 public function forget_password_process1(Request $request)
    {

    	if(empty($_POST['username']) || empty($_POST['mobile']))
    	{
    		echo "Invalid Parameters!";

    	}
    	
      $characters = '0123456789';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < 6; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }

      $arr_user_data                 = [];
      $password                      = password_hash($randomString, PASSWORD_DEFAULT);
      $arr_user_data['email']        = $request->input('username');
      $arr_user_data['mobile']       = $request->input('mobile');

      $count = $this->UserModel->where($arr_user_data)->count();
      $user= $this->UserModel->where(['email'=>$request->input('username')])->first();
      
      if($count)
      {
        $this->UserModel->where($arr_user_data)->update(['password'=>$password]);
        Session::flash('success', 'Password has been sent to user mobile.');
        $mobileno = $request->input('mobile');
      
       








        $data_setting = \DB::table('site_setting')->where('id','=','1')->first();


         $data_setting = \DB::table('site_setting')->where('id','=','1')->first();


       
        
        $data = [
           'email' => $user->email,
           'password' => $randomString
            ];
            
          
           $email =  $user->email1;
         
         Mail::send('forgot_mail',['data' => $data], function($message) use ($email) {
 
            $message->to($email, 'Receiver Name')
 
                    ->subject('Globalfx.world forgot your mail');
                     $message->from('support@globalfx.world','Globalfx');
        });


        $msg="Dear Sir, Your new password is ".$randomString." for ".$arr_user_data['email']." Please Login Your Account.";
        $url='http://sms.ukvalley.com/api/sendhttp.php?authkey='.$data_setting->sms_auth.'&mobiles='.$request->input('mobile').'&message='.$msg.'&sender='.$data_setting->sms_sender_id.'&route=6';
        
        $ch = curl_init();
        curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $output = curl_exec($ch);
        
       

        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }
          
          
          Session::flash('success', 'Password has been sent successfully.');
         return redirect('admin');
      }
      else
      {
           Session::flash('error', 'Please enter valid details!!!.');
          return redirect('admin');
      }
}
      



    public function logout()
    {
      Sentinel::logout();
      return redirect(url($this->admin_panel_slug.'/login'));
    }
}
