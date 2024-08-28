<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SMSSendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        
        $this->data = $data;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $numbers=User::whereNotNull('mobile_number')->where('is_email_verified',1)->where('is_mobile_verified',1)->where('user_type','!=',5)->where('status',1)->pluck('mobile_number')->all();
        $plot_type=strval($$this->data['plot_type']);
        $plot_number = strval($$this->data['plot_name']);
        $scheme_name = urlencode($$this->data['scheme_name']);
        
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
    }
}
