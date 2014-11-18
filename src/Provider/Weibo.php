<?php

namespace League\OAuth2\Client\Provider;

use League\OAuth2\Client\Entity\User;
use League\OAuth2\Client\Token\AccessToken;

class Weibo extends AbstractProvider
{
    public $responseType = 'json';

    public function urlAuthorize()
    {
        return 'https://api.weibo.com/oauth2/authorize';
    }

    public function urlAccessToken()
    {
        return 'https://api.weibo.com/oauth2/access_token';
    } 

    public function urlUserDetails(AccessToken $token)
    {
        return 'https://api.weibo.com/2/users/show.json?access_token='.$token->accessToken.'&uid='.$token->uid;
    }

    public function userDetails($response, AccessToken $token)
    {
        $user = new User;

        $user->uid = $response->id;
        $user->nickname = $response->screen_name;
        $user->name = $response->name;
        $user->email = isset($response->emailAddress) ? $response->emailAddress : null;
        $user->location = isset($response->location) ? $response->location : null;
        $user->description = isset($response->description) ? $response->description : null;
        $user->imageUrl = $response->profile_image_url;
        $user->urls = $response->profile_url;
        return $user;
    }

    public function userUid($response, AccessToken $token)
    {
        return $response->id;
    }

    public function userEmail($response, AccessToken $token)
    {
        return;
    }

    public function userScreenName($response, AccessToken $token)
    {
        return $response->screen_name;
    }
}
