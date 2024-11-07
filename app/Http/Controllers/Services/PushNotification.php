<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Google\Auth\CredentialsLoader;
use Google\Auth\Middleware\AuthTokenMiddleware;

class PushNotification extends Controller
{
    private array $firebaseCredentials;
    private array $notificationScopes = ["https://www.googleapis.com/auth/firebase.messaging"];

    public function __construct()
    {
        // Fetch and create credentials array from credentials.json file
        $credentialsData = Storage::path('json/gksm-3d7c2-68e8fca9a5ad.json');
        $this->firebaseCredentials = json_decode((string) $credentialsData, true);
    }

    public function getFirebaseHttpClient(): Client
    {
        $creds = CredentialsLoader::makeCredentials($this->notificationScopes, $this->firebaseCredentials);
        // Fetch oauth access token
        $tokenresponse = $creds->fetchAuthToken();
        $accessToken = $tokenresponse['access_token'];

        // create middleware
        $middleware = new AuthTokenMiddleware($creds);
        $stack = HandlerStack::create();
        $stack->push($middleware);

        // create the HTTP client. this will be used to send all requests. Note we are using access token as authorization header.
        $httpClient = new Client([
            'handler' => $stack,
            'base_uri' => 'https://fcm.googleapis.com/',
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
                'access_token_auth' => 'true',
                'details' => 'true'
            ],
        ]);
        return $httpClient;
    }

    public function sendFirebaseNotification($notificationData)
    {
        $firebaseClient = $this->getFirebaseHttpClient();
        // Send the notification
        $response = $firebaseClient->post('/v1/projects/' . $this->firebaseCredentials['project_id'] . '/messages:send', [
            'json' => ['message' => $notificationData]
        ]);
        return ($response->getBody()->getContents());
    }

    /**Subscribe a token to a topic
     * When sending notification, we send with to option to a token or topic
     * While sending notifications to topic, only devices with tokens subscribed to the topic will receive notifications
     */
    public function sendFirebaseTopicSubscription($token, $topic)
    {
        $firebaseClient = $this->getFirebaseHttpClient();
        $response = $firebaseClient->post('https://iid.googleapis.com/iid/v1/' . $token . '/rel/topics/' . $topic);
        return ($response->getBody()->getContents());
    }
}
