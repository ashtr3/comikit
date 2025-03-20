<?php

namespace App\Services;

use GuzzleHttp\Client;
use Laravel\Socialite\Facades\Socialite;

class PatreonService 
{
    public static function redirect()
    {
        return Socialite::driver('patreon')
            ->scopes(['identity', 'identity.memberships', 'campaigns'])
            ->redirect();
    }

    public static function register()
    {
        $user = Socialite::driver('patreon')->user();

        $is_creator = $user->getId() === env('PATREON_CREATOR_ID');

        if (!$is_creator) {
            $campaignId = env('PATREON_CAMPAIGN_ID');
            $client = new Client();

            $response = $client->get('https://www.patreon.com/api/oauth2/api/campaigns/'.$campaignId.'/pledges', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $user->token,
                ],
            ]);

            $campaign_pledges = json_decode($response->getBody(), true);

            $campaign_pledge_ids = array_map(function ($pledge) {
                return $pledge['id'];
            }, $campaign_pledges['data']);

            $response = $client->get('https://www.patreon.com/api/oauth2/api/current_user', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $user->token,
                ],
            ]);

            $user_pledges = json_decode($response->getBody(), true);

            $user_pledge_ids = array_map(function ($pledge) {
                return $pledge['id'];
            }, $user_pledges['data']['relationships']['pledges']['data']);

            $is_pledged = !empty(array_intersect($campaign_pledge_ids, $user_pledge_ids));
        }
        else {
            $is_pledged = false;
        }

        session([
            'patreon' => [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'avatar' => $user->getAvatar(),
                'token' => $user->token,
                'is_creator' => $is_creator,
                'is_pledged' => $is_pledged,
            ],
        ]);

        return redirect('/');
    }

    public static function logout() 
    {
        session()->forget('patreon');

        return redirect('/');
    }

    public static function hasAuthenticated() 
    {
        return !empty(session('patreon'));
    }

    public static function hasPledged()
    {
        if (self::hasAuthenticated()) {
            $is_creator = session('patreon.is_creator');
            $is_pledged = session('patreon.is_pledged');
            return $is_creator || $is_pledged;
        }
        else {
            return false;
        }
    }

    public static function isCreator() 
    {
        if (self::hasAuthenticated()) {
            $is_creator = session('patreon.is_creator');
            return $is_creator;
        }
        else {
            return false;
        }
    }
}