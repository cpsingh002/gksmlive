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
  use Illuminate\Http\Client\Pool;
  
 use App\Models\PushToken;
 use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Storage;
use App\Models\Notification;


class NotificationController extends Controller
{

    public function Testnotifcation(Request $request)
    {
        $firebaseToken =  User::find(555);
        $token = PushToken::orderBy('id', 'DESC')->first();
        $access_token = $token->token;
        $SERVER_API_KEY = 'AAAAHpXQ_Y8:APA91bEM4h-0ONIdoiQDX-9Hb-p3_I5KULHu-v0Y2pBi4T_d7oh462tNHTeg0wXQzC194Ty5VnjctoKoujZNytjOhuSghUTc5wUZ6zAodFgQylSJJWwi87BoFWElgGpY2pfEeg0mETrs';
        $data = [
            "message" => [
                "token" => $firebaseToken->device_token,
                "notification" => [
                    "title" => 'Booking Canceled',
                    "body" =>  'Hello Your  number  at  has been cancelled by  On GKSM Plot Booking Platform !!',  
                ]
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
                "Authorization: Bearer $access_token",
                'Content-Type: application/json',
            ];
    
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/gksm-3d7c2/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        dd($response);
        curl_close($ch);
    }
    public function gettoken(Request $request)
    {
        $token = PushToken::orderBy('id', 'DESC')->first();
        $ls = strtotime($token->created_at);
        $ns = strtotime(now());
        $dff = $ns -$ls;
        if($dff> 3480){

            $credentialsFilePath = Storage::path('json/gksm-3d7c2-68e8fca9a5ad.json');
            $client = new GoogleClient();
            $client->setAuthConfig($credentialsFilePath);
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $client->refreshTokenWithAssertion();
            $token = $client->getAccessToken();

            $access_token = $token['access_token'];
            $token =new PushToken();
            $token->token = $access_token;
            $token->save();
        }
        return $token;
        

            //  dd($token);
    }

    public function MessageStore(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'title' => 'required',
            'message'=>'required',
            ],['title'=>'Title is required',
                'message'=>'Message Is required']);
        $noto=   Notification::create([
                    'scheme_id' => null,
                    'property_id'=>null,
                    'action_by'=>Auth::user()->id,
                    'msg_to'=>null,
                    'action'=>$request->title,
                    'msg' => $request->message,
                ]);

        $token = PushToken::orderBy('id', 'DESC')->first();
        $access_token = $token->token;
        $SERVER_API_KEY = 'AAAAHpXQ_Y8:APA91bEM4h-0ONIdoiQDX-9Hb-p3_I5KULHu-v0Y2pBi4T_d7oh462tNHTeg0wXQzC194Ty5VnjctoKoujZNytjOhuSghUTc5wUZ6zAodFgQylSJJWwi87BoFWElgGpY2pfEeg0mETrs';
        $data = [
            "message" => [
                "topic" => 'gksm',
                "notification" => [
                    "title" => $request->title,
                    "body" =>$request->message,  
                ],
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
                "Authorization: Bearer $access_token",
                'Content-Type: application/json',
            ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/gksm-3d7c2/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        // dd($response);
        curl_close($ch);
        // $this->mobilesmstoberelase($mailData);
        //  $this->guccle($mailData);
        return   redirect()->back()->with('status', 'Message sent successfully');
    }
        
        
    public function sendNotification($mailData) {

        $token = PushToken::orderBy('id', 'DESC')->first();
        $access_token = $token->token;
        $SERVER_API_KEY = 'AAAAHpXQ_Y8:APA91bEM4h-0ONIdoiQDX-9Hb-p3_I5KULHu-v0Y2pBi4T_d7oh462tNHTeg0wXQzC194Ty5VnjctoKoujZNytjOhuSghUTc5wUZ6zAodFgQylSJJWwi87BoFWElgGpY2pfEeg0mETrs';
        $data = [
            "message" => [
                "topic" => 'GKSMLIVE',
                "notification" => [
                    "title" => $mailData['plot_type'].'Available',
                    "body" =>'Hello, '.$mailData['plot_type'].' number '. $mailData['plot_name'].' at '. $mailData['scheme_name'].' has been cancelled and it going to available in 30 min On GKSM Plot Booking Platform !!',  
                ],
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
                "Authorization: Bearer $access_token",
                'Content-Type: application/json',
            ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/gksm-3d7c2/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        // dd($response);
        curl_close($ch);
        // $this->mobilesmstoberelase($mailData);
        //  $this->guccle($mailData);
        return ;
    }
    
    public function CancelsendNotification($mailData,$token,$number) {
        
        
        $firebaseToken =  $token;
        $token = PushToken::orderBy('id', 'DESC')->first();
        $access_token = $token->token;
        $SERVER_API_KEY = 'AAAAHpXQ_Y8:APA91bEM4h-0ONIdoiQDX-9Hb-p3_I5KULHu-v0Y2pBi4T_d7oh462tNHTeg0wXQzC194Ty5VnjctoKoujZNytjOhuSghUTc5wUZ6zAodFgQylSJJWwi87BoFWElgGpY2pfEeg0mETrs';
        $data = [
            "message" => [
                "token" => $firebaseToken,
                "notification" => [
                    "title" => $mailData['plot_type'].' Booking Canceled',
                    "body" =>  'Hello Your '.$mailData['plot_type'].' number '.$mailData['plot_name'].' at '.$mailData['scheme_name'].' has been cancelled by '.$mailData['name'].' On GKSM Plot Booking Platform !!',  
                ]
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
                "Authorization: Bearer $access_token",
                'Content-Type: application/json',
            ];
    
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/gksm-3d7c2/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        //dd($response);
        curl_close($ch);
        $this->mobilesmscancel($mailData,$number);
        return ;
    }
    
    public function CompletesendNotification($mailData, $token,$number) {
        
        $firebaseToken = $token;
        
        $token = PushToken::orderBy('id', 'DESC')->first();
        $access_token = $token->token;
        $SERVER_API_KEY = 'AAAAHpXQ_Y8:APA91bEM4h-0ONIdoiQDX-9Hb-p3_I5KULHu-v0Y2pBi4T_d7oh462tNHTeg0wXQzC194Ty5VnjctoKoujZNytjOhuSghUTc5wUZ6zAodFgQylSJJWwi87BoFWElgGpY2pfEeg0mETrs';
        $data = [
            "message" => [
                "token" => $firebaseToken,
                "notification" => [
                    "title" => $mailData['plot_type'].' Booking Complete',
                    "body" =>  'Hello, Your booked '. $mailData['plot_type'] .' number '. $mailData['plot_name'].' at '. $mailData['scheme_name'].' has been completed by '.$mailData['name'].' On GKSM Plot Booking Platform !!',  
                ]
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
                "Authorization: Bearer $access_token",
                'Content-Type: application/json',
            ];
    
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/gksm-3d7c2/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        curl_close($ch);
        $this->mobilesmscomplete($mailData,$number);
        return ;
    }
    
    public function WaitingsendNotification($mailData,$token) {
      
        $firebaseToken =  $token;
        $token = PushToken::orderBy('id', 'DESC')->first();
        $access_token = $token->token;
        $SERVER_API_KEY = 'AAAAHpXQ_Y8:APA91bEM4h-0ONIdoiQDX-9Hb-p3_I5KULHu-v0Y2pBi4T_d7oh462tNHTeg0wXQzC194Ty5VnjctoKoujZNytjOhuSghUTc5wUZ6zAodFgQylSJJWwi87BoFWElgGpY2pfEeg0mETrs';
        $data = [
            "message" => [
                "token" => $firebaseToken,
                "notification" => [
                    "title" => $mailData['plot_type'].' Booking in Waiting list',
                    "body" =>  'Hello Your '.$mailData['name'].','.$mailData['plot_type'].' number '.$mailData['plot_name'].' at '.$mailData['scheme_name'].' has been in Waitng list  On GKSM Plot Booking Platform !!',  
                ]
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
                "Authorization: Bearer $access_token",
                'Content-Type: application/json',
            ];
    
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/gksm-3d7c2/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        //dd($response);
        return ;
    }
    
    public function BookingsendNotification($mailData,$token,$number) {
        
        
        $firebaseToken =  $token;
        $token = PushToken::orderBy('id', 'DESC')->first();
        $access_token = $token->token;
        $SERVER_API_KEY = 'AAAAHpXQ_Y8:APA91bEM4h-0ONIdoiQDX-9Hb-p3_I5KULHu-v0Y2pBi4T_d7oh462tNHTeg0wXQzC194Ty5VnjctoKoujZNytjOhuSghUTc5wUZ6zAodFgQylSJJWwi87BoFWElgGpY2pfEeg0mETrs';
        $data = [
            "message" => [
                "token" => $firebaseToken,
                "notification" => [
                    "title" => $mailData['plot_type'].' BooK/Hold',
                    "body" =>  'Hello Your '.$mailData['name'].','.$mailData['plot_type'].' number '.$mailData['plot_name'].' at '.$mailData['scheme_name'].' has been update successfully On GKSM Plot Booking Platform !!',  
                ]
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
                "Authorization: Bearer $access_token",
                'Content-Type: application/json',
            ];
    
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/gksm-3d7c2/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        // dd($response);
       // $this->mobilesmshold($mailData,$number);
        return ;
    }
    
    public function MoveNotification($mailData,$token){
        
        $firebaseToken =  $token;
        
        $token = PushToken::orderBy('id', 'DESC')->first();
        $access_token = $token->token;
        $SERVER_API_KEY = 'AAAAHpXQ_Y8:APA91bEM4h-0ONIdoiQDX-9Hb-p3_I5KULHu-v0Y2pBi4T_d7oh462tNHTeg0wXQzC194Ty5VnjctoKoujZNytjOhuSghUTc5wUZ6zAodFgQylSJJWwi87BoFWElgGpY2pfEeg0mETrs';
        $data = [
            "message" => [
                "token" => $firebaseToken,
                "notification" => [
                    "title" => 'Waiting to assign Plot',
                    "body" =>  'Hello '.$mailData['name'].', your '.$mailData['plot_type'].' number '.$mailData['plot_name'].' at '.$mailData['scheme_name'].' has been assign to you successfully On GKSM Plot Booking Platform !!',  
                ]
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
                "Authorization: Bearer $access_token",
                'Content-Type: application/json',
            ];
    
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/gksm-3d7c2/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        //dd($response);
        $this->Plotassign($mailData['name'],$mailData['mobile']);
        return ;
    }
    
    public function PaymentNotification($mailData,$token){
        
        $firebaseToken =  $token;
        $token = PushToken::orderBy('id', 'DESC')->first();
        $access_token = $token->token;
        $SERVER_API_KEY = 'AAAAHpXQ_Y8:APA91bEM4h-0ONIdoiQDX-9Hb-p3_I5KULHu-v0Y2pBi4T_d7oh462tNHTeg0wXQzC194Ty5VnjctoKoujZNytjOhuSghUTc5wUZ6zAodFgQylSJJWwi87BoFWElgGpY2pfEeg0mETrs';
        $data = [
            "message" => [
                "token" => $firebaseToken,
                "notification" => [
                    "title" => 'Payment Proof Varified by GKSM.',
                    "body" =>  'Hello Your '.$mailData['name'].','.$mailData['plot_type'].' number '.$mailData['plot_name'].' at '.$mailData['scheme_name'].' Payment Proof Varified by GKSM. On GKSM Plot Booking Platform !!',  
                ]
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
                "Authorization: Bearer $access_token",
                'Content-Type: application/json',
            ];
    
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/gksm-3d7c2/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        curl_close($ch);
        //dd($response);

        $this->PaymentApproved($mailData['name'],$mailData['mobile']);
        return ;
        
    }
    public function PaymentCancelNotification($mailData,$token)
    {
      $firebaseToken =  $token;
      
      $token = PushToken::orderBy('id', 'DESC')->first();
        $access_token = $token->token;
        $SERVER_API_KEY = 'AAAAHpXQ_Y8:APA91bEM4h-0ONIdoiQDX-9Hb-p3_I5KULHu-v0Y2pBi4T_d7oh462tNHTeg0wXQzC194Ty5VnjctoKoujZNytjOhuSghUTc5wUZ6zAodFgQylSJJWwi87BoFWElgGpY2pfEeg0mETrs';
        $data = [
            "message" => [
                "token" => $firebaseToken,
                "notification" => [
                    "title" => 'Payment Proof Canceled by GKSM.',
                    "body" =>  'Hello '.$mailData['name'].','.$mailData['plot_type'].' number '.$mailData['plot_name'].' at '.$mailData['scheme_name'].',Payment Proof Canceled by '.$mailData['by'].' and Reason is'.$mailData['reason'].' On GKSM Plot Booking Platform !!',  
                ]
            ]
        ];

        $dataString = json_encode($data);
        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/gksm-3d7c2/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        curl_close($ch);
        //dd($response);
        $this->PaymentReject($mailData['name'],$mailData['mobile']);
        return ;  
    }
    
    public function mobilesmsRegister($mailData, $number)
    {
       
        $headers = [
            'Content-Type: application/json',
        ];
        $fgh=urlencode($mailData['name']);
        $number =$number;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=TR&template_id=12566&sender_id=GKSMPL&language=EN&template=Hello+'.$fgh.'+Thank+you%2C+you+are+Register+Successfully+on+GKSM+Plot%0D%0ABooking+Platform%21%21Please+verify+your+email.%0D%0A%0D%0ARegards%0D%0AGKSM&contact_numbers='.$number);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //dd($ch);
        $response = curl_exec($ch);
        curl_close($ch);
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
        curl_close($ch);
        //dd($response);
        return;
    }
    
    public function mobilesmshold($mailData,$number)
    {
        $fgh=urlencode($mailData['name']);
        $plot_type=strval($mailData['plot_type']);
        $plot_number = strval($mailData['plot_name']);
        $scheme_name = urlencode($mailData['scheme_name']);
        
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
        curl_close($ch);
       // dd($response);
       return;
    }
    
    public function mobilesmscomplete($mailData,$number)
    {
        $fgh=urlencode($mailData['name']);
        $plot_type=strval($mailData['plot_type']);
        $plot_number = strval($mailData['plot_name']);
        $scheme_name = urlencode($mailData['scheme_name']);
        $msg ='%23+Hello+Your+booked+'.$plot_type.'+number+'.$plot_number.'+at'.$scheme_name.'+has+been+completed+by+'.$fgh.'+On+GKSM+Plot+Booking+Platform+%21%21';
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
        curl_close($ch);
        //dd($response);
         return ;
    }
    public function mobilesmscancel($mailData,$number)
    {
        $fgh=urlencode($mailData['name']);
        $plot_type=strval($mailData['plot_type']);
        $plot_number = strval($mailData['plot_name']);
        $scheme_name = urlencode($mailData['scheme_name']);
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
         curl_close($ch);
         
        //dd($response);
        return ;
    }
    public function mobilesmstoberelase($mailData)
    {
        $numbers=User::whereNotNull('mobile_number')->where('is_email_verified',1)->where('is_mobile_verified',1)->where('user_type','!=',5)->where('status',1)->pluck('mobile_number')->all();
        $plot_type=strval($mailData['plot_type']);
        $plot_number = strval($mailData['plot_name']);
        $scheme_name = urlencode($mailData['scheme_name']);
        
        $msg ='%23+Hello+'.$plot_type.'+number+'.$plot_number.'+at%0D%0A'.$scheme_name.'+has+been+cancelled+and+it+going+to+available+in+30+min+On+GKSM+Plot+Booking%0D%0APlatform%21%21%0D%0A%0D%0ARegards%0D%0AGKSM';
                        // $number =implode(",",$numbers);
                        $chunkedUsers = array_chunk($numbers,100);
                        
        $headers = [
            'Content-Type: application/json',
        ];
        foreach($chunkedUsers as $chunk)
        {
                $number =implode(",",$chunk);
                // $number = $number;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=TR&template_id=12571&sender_id=GKSMPL&language=EN&template='.$msg.'&contact_numbers='.$number);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                //dd($ch);
                $response = curl_exec($ch);
                curl_close($ch);
                //  dd($response);
        }
        
        return;
    }
    
    public function mobilesmsuseraccount($name, $number,$staus)
    {
        $fgh=urlencode($name);
        if($staus == 5){
            $msg ='Hello+'.$fgh.'+your+account+has+been+activated%2Finactivated+by+super%0D%0Aadmin+On+GKSM+Plot+Booking+Platform%21%21%0D%0A%0D%0ARegards%0D%0AGKSM';
           
        }else{
            $msg ='Hello+'.$fgh.'+your+account+has+been+activated%2Finactivated+by+super%0D%0Aadmin+On+GKSM+Plot+Booking+Platform%21%21%0D%0A%0D%0ARegards%0D%0AGKSM';  
        }
        $number =$number;
        $headers = [
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=TR&template_id=12572&sender_id=GKSMPL&language=EN&template='.$msg.'&contact_numbers='.$number);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //dd($ch);
        $response = curl_exec($ch);
        curl_close($ch);
       // dd($response);
        return;
    }
    
    public function mobilesmsotlp($mailData,$number)
    {
         $fgh=urlencode($mailData['name']);
         $password = $mailData['rand_id'];
        $number =$number;
        
        $msg ='%23+Hello+'.$fgh.'+%2C+your+one+time+login+password+is%0D%0A'.$password.'+Please+Login+On+GKSM+Plot+Booking+Platform+and+and+change+your+password+%21%0D%0A%0D%0ARegards%0D%0AGKSM';
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
        curl_close($ch);
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
        curl_close($ch);
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
        curl_close($ch);
      //  dd($response);
       return;
    }
    
    public function BookingPushNotification($mailData,$scheme_id,$production_id) {
        // dd('gfgfg');
        $product = ProductionModel ::where('public_id',$production_id)->first();
        $userp = User::where('id',$product->production_id)->whereNotNull('device_token')->where('is_email_verified',1)->where('is_mobile_verified',1)->pluck('device_token')->all();
        $token = User::where('scheme_opertaor','like', '%'.$scheme_id.'%')->whereNotNull('device_token')->where('is_email_verified',1)->where('is_mobile_verified',1)->pluck('device_token')->all();
      //  array_push($token,$userp); 
      $mergeArr = array_merge($token,$userp);
        $firebaseToken =  $mergeArr;
        $SERVER_API_KEY = 'AAAAHpXQ_Y8:APA91bHXNEzIZxOslttr2bykK1p0bwErfZVocRH9dK--cG0EIpPsd_vu3tcGASdVL3qE9JVCLQJ-s4WxkG1TjJ9_ftaX34L740MsMx0pIaEs8rcD2rP2kKWh8GMoUiAldYtlrzH31_EI';
        foreach($firebaseToken as $tok){
        
        $data = [
            "message" => [
                "token" => $tok,
                "notification" => [
                    "title" => $mailData['plot_type'].' BooK/Hold',
                    "body" =>  'Hello Your assocaite '.$mailData['name'].',book/hold '.$mailData['plot_type'].' number '.$mailData['plot_name'].' at '.$mailData['scheme_name'].' On GKSM Plot Booking Platform !!',  
                ]
            ]
        ];
        $token = PushToken::orderBy('id', 'DESC')->first();
        $access_token = $token->token;

        $dataString = json_encode($data);
         $headers = [
                "Authorization: Bearer $access_token",
                'Content-Type: application/json',
            ];
    
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/gksm-3d7c2/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        curl_close($ch);
        // dd($response);
        }
       // dd($response);
      //  $this->mobileBooksms($mailData,$number);
        return ;
    }
    
    public function PayMentPushNotification($mailData, $scheme_id, $production_id) {
        
        $product = ProductionModel ::where('public_id',$production_id)->first();
        $userp = User::where('id',$product->production_id)->whereNotNull('device_token')->where('is_email_verified',1)->where('is_mobile_verified',1)->pluck('device_token')->all();
        $token = User::where('scheme_opertaor','like', '%'.$scheme_id.'%')->whereNotNull('device_token')->where('is_email_verified',1)->where('is_mobile_verified',1)->pluck('device_token')->all();
      //  array_push($token,$userp); 
      $mergeArr = array_merge($token,$userp);
        $firebaseToken =  $mergeArr;
        $SERVER_API_KEY = 'AAAAHpXQ_Y8:APA91bEM4h-0ONIdoiQDX-9Hb-p3_I5KULHu-v0Y2pBi4T_d7oh462tNHTeg0wXQzC194Ty5VnjctoKoujZNytjOhuSghUTc5wUZ6zAodFgQylSJJWwi87BoFWElgGpY2pfEeg0mETrs';
         foreach($firebaseToken as $tok){
        $data = [
            "token" => $tok,
            "message" => [
                "title" => $mailData['plot_type'].' Payment Proof Uploaded',
                "body" =>  'Assoicate'.$mailData['name'].','.$mailData['plot_type'].' number '.$mailData['plot_name'].' at '.$mailData['scheme_name'].' has been submited  Payment proof On GKSM Plot Booking Platform !!',  
            ]
        ];

        $token = PushToken::orderBy('id', 'DESC')->first();
        $access_token = $token->token;
        $dataString = json_encode($data);
         $headers = [
                "Authorization: Bearer $access_token",
                'Content-Type: application/json',
            ];
    
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/gksm-3d7c2/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        curl_close($ch);
        }
       // dd($response);
      //  $this->mobileBooksms($mailData,$number);
        return ;
    }

    public function PaymentApproved($name, $number)
    {

        $fgh=urlencode($name);
        $msg ='Hello+'.$fgh.'+your+plot+booking+Payment+has+been+approved+by+super+admin+On+GKSM+Plot+Booking+Platform%21%21+Regards+GKSM';
        $number =$number;
        $headers = [
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=TR&template_id=14011&sender_id=GKSMPL&language=EN&template='.$msg.'&contact_numbers='.$number);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //dd($ch);
        $response = curl_exec($ch);
        curl_close($ch);
      //  dd($response);
       return;
    }

    public function PaymentReject($name, $number)
    {

        $fgh=urlencode($name);
        $msg ='Hello+'.$fgh.'+your+uploaded+payment+has+been+Cancelled+%2FRejected++by+super+admin+On+GKSM+Plot+Booking+Platform%21%21+Regards+GKSM';
        $number =$number;
        $headers = [
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=TR&template_id=14014&sender_id=GKSMPL&language=EN&template='.$msg.'&contact_numbers='.$number);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //dd($ch);
        $response = curl_exec($ch);
        curl_close($ch);
      //  dd($response);
       return;

       
    }

    public function Plotassign($name, $number)
    {

        $fgh=urlencode($name);
        $msg ='Hello+'.$fgh.'+Plot+has+been+assigned+successfully+to+you+by+super+admin+On+GKSM+Plot+Booking+Platform%21%21+Regards+GKSM';
        $number =$number;
        $headers = [
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=OT&template_id=14012&sender_id=GKSMPL&language=EN&template='.$msg.'&contact_numbers='.$number);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
      //  dd($response);
       return;

    }

    public function Mangementhold($name, $number)
    {
        $fgh=urlencode($name);
        //
        $msg ='Hello+'.$fgh.'+your+plot+has+been+hold+by+Management+by+super+admin+On+GKSM+Plot+Booking+Platform%21%21+Regards+GKSM';
        $number =$number;
        $headers = [
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=OT&template_id=14013&sender_id=GKSMPL&language=EN&template='.$msg.'&contact_numbers='.$number);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
      //  dd($response);
       return;
    }


    public function guccle($mailData)
    {
        $numbers=User::whereNotNull('mobile_number')->where('is_email_verified',1)->where('is_mobile_verified',1)->where('user_type','!=',5)->where('status',1)->pluck('mobile_number')->all();
        $plot_type=strval($mailData['plot_type']);
        $plot_number = strval($mailData['plot_name']);
        $scheme_name = urlencode($mailData['scheme_name']);
        
        $msg ='%23+Hello+'.$plot_type.'+number+'.$plot_number.'+at%0D%0A'.$scheme_name.'+has+been+cancelled+and+it+going+to+available+in+30+min+On+GKSM+Plot+Booking%0D%0APlatform%21%21%0D%0A%0D%0ARegards%0D%0AGKSM';
                        // $number =implode(",",$numbers);
        $chunkedUsers = array_chunk($numbers,500);
        

        foreach($chunkedUsers as $chunk)
        {
            $newc = array_chunk($chunk,100);
            $i =1;
            foreach($newc as $newcf)
            {
                $number =implode(",",$newcf);
                $url[$i] = 'https://m1.sarv.com/api/v2.0/sms_campaign.php?token=8358097006540df8d97be17.58300343&user_id=71354379&route=TR&template_id=12571&sender_id=GKSMPL&language=EN&template='.$msg.'&contact_numbers='.$number;
                $i++;
            }

            $responses = Http::pool(fn (Pool $pool) => [
                $pool->get($url[1]),
                $pool->get($url[2]),
                $pool->get($url[3]),
                $pool->get($url[4]),
                $pool->get($url[5]),

            ]);
             
            // return $responses[0]->ok() &&
            //       $responses[1]->ok() &&
            //       $responses[2]->ok();
        }
        return;
        
        
        
    }
    
}