<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
  

class NotificationController extends Controller
{
        
    public function sendNotification($mailData) {
        
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
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
        return ;
    }
    
    public function CancelsendNotification($mailData,$token) {
        
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
        return ;
    }
    
    public function CompletesendNotification($mailData, $token) {
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
        return ;
    }
    
}