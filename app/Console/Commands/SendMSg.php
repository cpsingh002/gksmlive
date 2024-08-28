<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class SendMSg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'smsmsg:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'SMS send after cancel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
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
        return 0;
    }
}
