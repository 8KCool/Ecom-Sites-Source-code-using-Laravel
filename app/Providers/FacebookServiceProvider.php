<?php

namespace App\Providers;
use Facebook\Facebook;
use Illuminate\Support\ServiceProvider;

class FacebookServiceProvider extends ServiceProvider
{
    protected $api;

    public function __construct(Facebook $fb)
    {
        $fb->setDefaultAccessToken(Auth::user()->token);
        $this->api = $fb;
    }

    public function publishToPage($page, $title){
        try {
            $post = $this->api->post('/' . $page . '/feed', array('message' => $title));
            $post = $post->getGraphNode()->asArray();
        } catch (FacebookSDKException $e) {
            dd($e);
        }
    }
}
