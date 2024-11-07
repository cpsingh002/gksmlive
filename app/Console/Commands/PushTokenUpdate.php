<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
 use App\Models\PushToken;
 use Carbon\Carbon;

class PushTokenUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pushtoken:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push Auth Token update after every 58 mintes';

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
        return;
    }
}
