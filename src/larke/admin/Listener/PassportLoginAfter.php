<?php

declare (strict_types = 1);

namespace Larke\Admin\Listener;

use Larke\Admin\Event;

/*
 * 更新登陆信息
 *
 * @create 2020-11-10
 * @author deatil
 */
class PassportLoginAfter
{
    public function handle(Event\PassportLoginAfter $event)
    {
        // jwt 数据
        $jwt = $event->jwt;
        
        // 权限 token 签发时间
        $decodeAccessToken = app('larke-admin.auth-token')
                ->decodeAccessToken($jwt['access_token']);
        $decodeAccessTokenIat = $decodeAccessToken->getClaim('iat')
                ->getTimestamp();
        
        // 权限 token 签发时间
        $decodeRefreshToken = app('larke-admin.auth-token')
                ->decodeRefreshToken($jwt['refresh_token']);
        $decodeRefreshTokenIat = $decodeRefreshToken->getClaim('iat')
                ->getTimestamp();
        
        $event->admin->update([
            'refresh_time' => $decodeAccessTokenIat, 
            'refresh_ip' => request()->ip(),
            'last_active' => $decodeRefreshTokenIat, 
            'last_ip' => request()->ip(),
        ]);
    }
}
