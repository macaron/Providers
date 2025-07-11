<?php

namespace SocialiteProviders\ClickUp;

use GuzzleHttp\RequestOptions;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    public const IDENTIFIER = 'CLICKUP';

    protected const BASE_URL = 'https://api.clickup.com/api';

    protected $scopes = ['profile'];

    protected function getAuthUrl($state): string
    {
        return $this->buildAuthUrlFromBase(self::BASE_URL, $state);
    }

    protected function getTokenUrl(): string
    {
        return self::BASE_URL.'/v2/oauth/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(self::BASE_URL.'/v2/user', [
            RequestOptions::HEADERS => [
                'Authorization' => $token,
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id'                => $user['user']['id'],
            'nickname'          => $user['user']['username'],
            'name'              => $user['user']['username'],
            'email'             => $user['user']['email'],
            'avatar'            => $user['user']['profilePicture'],
            'color'             => $user['user']['color'] ?? null,
            'initials'          => $user['user']['initials'] ?? null,
            'weekStartDay'      => $user['user']['week_start_day'] ?? 0,
            'globalFontSupport' => $user['user']['global_font_support'] ?? true,
            'timezone'          => $user['user']['timezone'] ?? null,
        ]);
    }
}
