<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
  use Illuminate\Support\Facades\Http;
  use App\Models\PropertyModel;
  use App\Models\SchemeModel;
  use App\Models\ProductionModel;

 

class NotificationController extends Controller
{
        
    public function sendNotification($mailData) {
        
        $firebaseToken = User::whereNotNull('device_token')->where('is_email_verified',1)->where('is_mobile_verified',1)->pluck('device_token')->all();
        //dd($firebaseToken);
        $number=User::whereNotNull('mobile_number')->where('is_email_verified',1)->where('is_mobile_verified',1)->pluck('mobile_number')->all();
        // $this->mobilesmstoberelase($mailData, $number);
        $SERVER_API_KEY = 'AAAAiI8FVRQ:APA91bE62o6IhUJS9vjzB6mCTGiqZ7x6i8JxwouI-eMAL63YNz-ymvpU0Uw3O889Jch6WkAXFRPTBF7IastsXVEh6hdG02qs7zfAey43F63jNzf5MEIbAl72bFFsoU3HZtsbSlgD-m_x';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $mailData['plot_type'].' Booking Canceled',
                "body" =>'Hello, '.$mailData['plot_type'].' number '. $mailData['plot_name'].' at '. $mailData['scheme_name'].' has been cancelled and it going to available in 30 min On GKSM Plot Booking Platform !!',  
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        //dd($response);
        $this->mobilesmstoberelase($mailData, $number);
        return ;
    }
    
    public function CancelsendNotification($mailData,$token,$number) {
        
        $firebaseToken =  [$token];
        $SERVER_API_KEY = 'AAAAiI8FVRQ:APA91bE62o6IhUJS9vjzB6mCTGiqZ7x6i8JxwouI-eMAL63YNz-ymvpU0Uw3O889Jch6WkAXFRPTBF7IastsXVEh6hdG02qs7zfAey43F63jNzf5MEIbAl72bFFsoU3HZtsbSlgD-m_x';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $mailData['plot_type'].' Booking Canceled',
                "body" =>  'Hello Your '.$mailData['plot_type'].' number '.$mailData['plot_name'].' at '.$mailData['scheme_name'].' has been cancelled by '.$mailData['name'].' On GKSM Plot Booking Platform !!',  
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        //dd($response);
        
        $this->mobilesmscancel($mailData,$number);
        return ;
    }
    
    public function CompletesendNotification($mailData, $token,$number) {
        $firebaseToken = [$token];
        $SERVER_API_KEY = 'AAAAiI8FVRQ:APA91bE62o6IhUJS9vjzB6mCTGiqZ7x6i8JxwouI-eMAL63YNz-ymvpU0Uw3O889Jch6WkAXFRPTBF7IastsXVEh6hdG02qs7zfAey43F63jNzf5MEIbAl72bFFsoU3HZtsbSlgD-m_x';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $mailData['plot_type'].' Booking Complete',
                "body" =>  'Hello, Your booked '. $mailData['plot_type'] .' number '. $mailData['plot_name'].' at '. $mailData['scheme_name'].' has been completed by '.$mailData['name'].' On GKSM Plot Booking Platform !!',  
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        $this->mobilesmscomplete($mailData,$number);
        return ;
    }
    
    public function WaitingsendNotification($mailData,$token) {
        
        $firebaseToken =  [$token];
        $SERVER_API_KEY = 'AAAAiI8FVRQ:APA91bE62o6IhUJS9vjzB6mCTGiqZ7x6i8JxwouI-eMAL63YNz-ymvpU0Uw3O889Jch6WkAXFRPTBF7IastsXVEh6hdG02qs7zfAey43F63jNzf5MEIbAl72bFFsoU3HZtsbSlgD-m_x';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $mailData['plot_type'].' Booking in Waiting list',
                "body" =>  'Hello Your '.$mailData['name'].','.$mailData['plot_type'].' number '.$mailData['plot_name'].' at '.$mailData['scheme_name'].' has been in Waitng list  On GKSM Plot Booking Platform !!',  
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        //dd($response);
        return ;
    }
    
     public function BookingsendNotification($mailData,$token,$number) {
        
        $firebaseToken =  [$token];
        $SERVER_API_KEY = 'AAAAiI8FVRQ:APA91bE62o6IhUJS9vjzB6mCTGiqZ7x6i8JxwouI-eMAL63YNz-ymvpU0Uw3O889Jch6WkAXFRPTBF7IastsXVEh6hdG02qs7zfAey43F63jNzf5MEIbAl72bFFsoU3HZtsbSlgD-m_x';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $mailData['plot_type'].' BooK/Hold',
                "body" =>  'Hello Your '.$mailData['name'].','.$mailData['plot_type'].' number '.$mailData['plot_name'].' at '.$mailData['scheme_name'].' has been update successfully On GKSM Plot Booking Platform !!',  
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        //dd($response);
      //  $this->mobileBooksms($mailData,$number);
        return ;
    }
    
    public function MoveNotification($mailData,$token){
        
        $firebaseToken =  [$token];
        $SERVER_API_KEY = 'AAAAiI8FVRQ:APA91bE62o6IhUJS9vjzB6mCTGiqZ7x6i8JxwouI-eMAL63YNz-ymvpU0Uw3O889Jch6WkAXFRPTBF7IastsXVEh6hdG02qs7zfAey43F63jNzf5MEIbAl72bFFsoU3HZtsbSlgD-m_x';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => 'Waiting to assign Plot',
                "body" =>  'Hello Your '.$mailData['name'].','.$mailData['plot_type'].' number '.$mailData['plot_name'].' at '.$mailData['scheme_name'].' has been assign to you successfully On GKSM Plot Booking Platform !!',  
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        //dd($response);
        return ;
    }
    
    public function PaymentNotification($mailData,$token){
        
        $firebaseToken =  [$token];
        $SERVER_API_KEY = 'AAAAiI8FVRQ:APA91bE62o6IhUJS9vjzB6mCTGiqZ7x6i8JxwouI-eMAL63YNz-ymvpU0Uw3O889Jch6WkAXFRPTBF7IastsXVEh6hdG02qs7zfAey43F63jNzf5MEIbAl72bFFsoU3HZtsbSlgD-m_x';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => 'Payment Proof Varified by GKSM.',
                "body" =>  'Hello Your '.$mailData['name'].','.$mailData['plot_type'].' number '.$mailData['plot_name'].' at '.$mailData['scheme_name'].' Payment Proof Varified by GKSM. On GKSM Plot Booking Platform !!',  
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        //dd($response);
        return ;
        
    }
    public function PaymentCancelNotification($mailData,$token)
    {
      $firebaseToken =  [$token];
        $SERVER_API_KEY = 'AAAAiI8FVRQ:APA91bE62o6IhUJS9vjzB6mCTGiqZ7x6i8JxwouI-eMAL63YNz-ymvpU0Uw3O889Jch6WkAXFRPTBF7IastsXVEh6hdG02qs7zfAey43F63jNzf5MEIbAl72bFFsoU3HZtsbSlgD-m_x';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => 'Payment Proof Canceled by GKSM.',
                "body" =>  'Hello Your '.$mailData['name'].','.$mailData['plot_type'].' number '.$mailData['plot_name'].' at '.$mailData['scheme_name'].'and Reason is'.$mailData['reason'].' Payment Proof canceled by GKSM. On GKSM Plot Booking Platform !!',  
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        //dd($response);
        return ;  
    }
    
    public function mobilesmsRegister($mailData, $number)
    {
       
        $headers = [
            'Content-Type: application/json',
        ];
        $fgh=urlencode($mailData['name']);
        $number =$number;
        //Hello+'.$fgh.'+Thank+you%2C+you+are+Register+Successfully+on+GKSM+Plot%0D%0ABooking+Platform%21%21Please+verify+your+email.%0D%0A%0D%0ARegards%0D%0AGKSM
        $msg = 'Hello+'.fgh.'+Thank+you%2C+you+are+Register+Successfully+on+GKSM+Plot%0D%0ABooking+Platform%21%21Please+verify+your+email.%0D%0A%0D%0ARegards%0D%0AGKSM';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=TR&template_id=12566&sender_id=GKSMPL&language=EN&template='.$msg.'&contact_numbers='.$number);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //dd($ch);
        $response = curl_exec($ch);
       // dd($response);
       return;
    }
    public function mobilesmsRegisterapproved($mailData, $number)
    {
       
        $headers = [
            'Content-Type: application/json',
        ];
        $fgh=urlencode($mailData['name']);
        $number =$number;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=TR&template_id=12567&sender_id=GKSMPL&language=EN&template=Hello+'.$fgh.'+your+register+request+has+been+approved+On%0D%0AGKSM+Plot+Booking+Platform%21%21%0D%0A%0D%0ARegards%0D%0AGKSM&contact_numbers='.$number);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //dd($ch);
        $response = curl_exec($ch);
        //dd($response);
        return;
    }
    
    public function mobilesmshold($mailData,$number)
    {
        $fgh=urlencode($mailData['name']);
        $plot_type=strval($mailData['plot_type']);
        $plot_number = strval($mailData['plot_name']);
        $scheme_name = urlencode($mailData['scheme_name']);
        //%23+Hello+'.$fgh.'%2C+You+have+successfully+hold+'.$plot_type.'+number+'.$plot_number.'%2C+at%0D%0A'.$scheme_name.'+On+GKSM+Plot+Booking+Platform+%21%21
        $msg ='%23+Hello+'.$fgh.'%2C+You+have+successfully+hold+'.$plot_type.'+number+'.$plot_number.'%2C+at%0D%0A'.$scheme_name.'+On+GKSM+Plot+Booking+Platform+%21%21';
        $number =$number;
        $headers = [
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=TR&template_id=12569&sender_id=GKSMPL&language=EN&template='.$msg.'&contact_numbers='.$number);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //dd($ch);
        $response = curl_exec($ch);
       // dd($response);
       return;
    }
    
     public function mobilesmscomplete($mailData,$number)
    {
        $fgh=urlencode($mailData['name']);
        $plot_type=strval($mailData['plot_type']);
        $plot_number = strval($mailData['plot_name']);
        $scheme_name = urlencode($mailData['scheme_name']);
        //%23+Hello+Your+booked+'.$plot_type.'+number+'.$plot_number.'+at%0D%0A.$scheme_name.'+has+been+completed+by+'.$fgh.'+On+GKSM+Plot+Booking+Platform+%21%21';
        $msg = '%23+Hello+Your+booked+'.$plot_type.'+number+'.$plot_number.'+at%0D%0A'.$scheme_name.'+has+been+completed+by+'.$fgh.'+On+GKSM+Plot+Booking+Platform+%21%21';
        $number =$number;
        $headers = [
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=TR&template_id=12568&sender_id=GKSMPL&language=EN&template='.$msg.'&contact_numbers='.$number);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //dd($ch);
        $response = curl_exec($ch);
        //dd($response);
         return ;
    }
    public function mobilesmscancel($mailData,$number)
    {
        $fgh=urlencode($mailData['name']);
        $plot_type=strval($mailData['plot_type']);
        $plot_number = strval($mailData['plot_name']);
        $scheme_name = urlencode($mailData['scheme_name']);
        //%23+Hello+Your+Booked%2F+Hold+'.$plot_type.'+number+'.$plot_number.'+at%0D%0A'.$scheme_name.'+has+been+cancelled+by+'.$fgh.'+On+GKSM+Plot+Booking+Platform+%21%21
        $msg ='%23+Hello+Your+Booked%2F+Hold+'.$plot_type.'+number+'.$plot_number.'+at%0D%0A'.$scheme_name.'+has+been+cancelled+by+'.$fgh.'+On+GKSM+Plot+Booking+Platform+%21%21';
        //$msg =strval($msgd);
        //dd($msg);
        $number =$number;
        $headers = [
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=TR&template_id=12570&sender_id=GKSMPL&language=EN&template='.$msg.'&contact_numbers='.$number);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //dd($ch);
         $response = curl_exec($ch);
         
        //dd($response);
        return ;
    }
    public function mobilesmstoberelase($mailData, $numbers)
    {
        $plot_type=strval($mailData['plot_type']);
        $plot_number = strval($mailData['plot_name']);
        $scheme_name = urlencode($mailData['scheme_name']);
        
        $msg ='%23+Hello+'.$plot_type.'+number+'.$plot_number.'+at%0D%0A'.$scheme_name.'+has+been+cancelled+and+it+going+to+available+in+30+min+On+GKSM+Plot+Booking%0D%0APlatform%21%21%0D%0A%0D%0ARegards%0D%0AGKSM';
                        //$number =$number;
        $headers = [
            'Content-Type: application/json',
        ];
        foreach($numbers as $number)
        {
            $number = $number;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=TR&template_id=12571&sender_id=GKSMPL&language=EN&template='.$msg.'&contact_numbers='.$number);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            //dd($ch);
            $response = curl_exec($ch);
            //dd($response);
        }
        
        return;
    }
    
    public function mobilesmsuseraccount($name, $number,$staus)
    {
        $fgh=urlencode($name);

        if($staus == 5){
            $msg ='Hello+'.$fgh.'+your+account+has+been+activated+by+super+admin+On+GKSM+Plot+Booking+Platform%21%21+Regards+GKSM';
            //Hello+'.$fgh.'+your+account+has+been+activated+by+super+admin+On+GKSM+Plot+Booking+Platform%21%21+Regards+GKSM
            $tem_id = '13664';

        }else{
            $msg ='Hello+'.$fgh.'+your+account+has+been+deactivated+by+super+admin+On+GKSM+Plot+Booking+Platform%21%21+Regards+GKSM'; 
            //Hello+'.$fgh.'+your+account+has+been+deactivated+by+super+admin+On+GKSM+Plot+Booking+Platform%21%21+Regards+GKSM
            $tem_id = '13677'; 
            
        }
        $number =$number;
        $headers = [
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=TR&template_id='.$tem_id.'&sender_id=GKSMPL&language=EN&template='.$msg.'&contact_numbers='.$number);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //dd($ch);
        $response = curl_exec($ch);
       // dd($response);
        return;
    }
    
    public function mobilesmsotlp($mailData,$number)
    {
         $fgh=urlencode($mailData['name']);
         $password = $mailData['rand_id'];
        $number =$number;
        $msg ='%23+Hello+'.$fgh.'+%2C+your+one+time+login+password+is%0D%0A'.$password.'+Please+Login+On+GKSM+Plot+Booking+Platform+and+and+change+your+password+%21%0D%0A%0D%0ARegards%0D%0AGKSM';
        //%23+Hello+'.$fgh.'+%2C+your+one+time+login+password+is%0D%0A'.$password.'+Please+Login+On+GKSM+Plot+Booking+Platform+and+and+change+your+password+%21%0D%0A%0D%0ARegards%0D%0AGKSM
        $number =$number;
        $headers = [
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=TR&template_id=12573&sender_id=GKSMPL&language=EN&template='.$msg.'&contact_numbers='.$number);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //dd($ch);
        $response = curl_exec($ch);
        //dd($response);
        return;
    }
    
    public function mobilesmsotpvefiy($mailData,$number)
    {
         $fgh=urlencode($mailData['name']);
         $otp = $mailData['token'];
        $msg ='Hello+'.$fgh.'%2C+your+one+time+code+for+mobile+verification+is+'.$otp.'+on+GKSM+Plot+Booking+Platform%21';
        
        $number =$number;
        $headers = [
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=OT&template_id=12579&sender_id=GKSMPL&language=EN&template='.$msg.'&contact_numbers='.$number);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //dd($ch);
        $response = curl_exec($ch);
        //dd($response);
        return;
    }


    public function mobileBooksms($mailData, $number)
    {
    
    
        $fgh=urlencode($mailData['name']);
        $plot_type=strval($mailData['plot_type']);
        $plot_number = strval($mailData['plot_name']);
        $scheme_name = urlencode($mailData['scheme_name']);
        //%23+Hello+%2C+'.$fgh.'+You+have+successfully++Booked+'.$plot_type.'+number+'.$plot_number.'+%2C+at+'.$scheme_name.'+On+GKSM+Plot+Booking+Platform+%21%21
        $msg ='%23+Hello+%2C+'.$fgh.'+You+have+successfully++Booked+'.$plot_type.'+number+'.$plot_number.'+%2C+at+'.$scheme_name.'+On+GKSM+Plot+Booking+Platform+%21%21';
        $number =$number;
        $headers = [
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=TR&template_id=13679&sender_id=GKSMPL&language=EN&template='.$msg.'&contact_numbers='.$number);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //dd($ch);
        $response = curl_exec($ch);
       // dd($response);
       return;
    }
    
    public function BookingPushNotification($mailData,$scheme_id,$production_id) {
        
        $product = ProductionModel ::where('public_id',$production_id)->first();
        $userp = User::where('id',$product->production_id)->whereNotNull('device_token')->where('is_email_verified',1)->where('is_mobile_verified',1)->pluck('device_token')->all();
        $token = User::where('scheme_opertaor','like', '%'.$scheme_id.'%')->whereNotNull('device_token')->where('is_email_verified',1)->where('is_mobile_verified',1)->pluck('device_token')->all();
      //  array_push($token,$userp); 
      //$mergeArr = array_merge($token,$userp);
        $firebaseToken =  $token;
        $SERVER_API_KEY = 'AAAAHpXQ_Y8:APA91bHXNEzIZxOslttr2bykK1p0bwErfZVocRH9dK--cG0EIpPsd_vu3tcGASdVL3qE9JVCLQJ-s4WxkG1TjJ9_ftaX34L740MsMx0pIaEs8rcD2rP2kKWh8GMoUiAldYtlrzH31_EI';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $mailData['plot_type'].' BooK/Hold',
                "body" =>  'Hello Your '.$mailData['name'].','.$mailData['plot_type'].' number '.$mailData['plot_name'].' at '.$mailData['scheme_name'].' has been update successfully On GKSM Plot Booking Platform !!',  
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
       // dd($response);
      //  $this->mobileBooksms($mailData,$number);
        return ;
    }

    public function PayMentPushNotification($mailData,$scheme_id,$production_id) {
        
        $product = ProductionModel ::where('public_id',$production_id)->first();
        $userp = User::where('id',$product->production_id)->whereNotNull('device_token')->where('is_email_verified',1)->where('is_mobile_verified',1)->pluck('device_token')->all();
        $token = User::where('scheme_opertaor','like', '%'.$scheme_id.'%')->whereNotNull('device_token')->where('is_email_verified',1)->where('is_mobile_verified',1)->pluck('device_token')->all();
      //  array_push($token,$userp); 
      //$mergeArr = array_merge($token,$userp);
        $firebaseToken =  $token;
        $SERVER_API_KEY = 'AAAAHpXQ_Y8:APA91bHXNEzIZxOslttr2bykK1p0bwErfZVocRH9dK--cG0EIpPsd_vu3tcGASdVL3qE9JVCLQJ-s4WxkG1TjJ9_ftaX34L740MsMx0pIaEs8rcD2rP2kKWh8GMoUiAldYtlrzH31_EI';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $mailData['plot_type'].' BooK/Hold',
                "body" =>  'Hello Your '.$mailData['name'].','.$mailData['plot_type'].' number '.$mailData['plot_name'].' at '.$mailData['scheme_name'].' has been update successfully On GKSM Plot Booking Platform !!',  
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
       // dd($response);
      //  $this->mobileBooksms($mailData,$number);
        return ;
    }
}