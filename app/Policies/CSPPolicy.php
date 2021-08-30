<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Csp\Policies\Policy;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;


class CSPPolicy extends Policy
{
    use HandlesAuthorization;

    public function configure()
    {
        $this
            ->addDirective(Directive::BASE, Keyword::SELF)
            // ->addDirective(Directive::CONNECT, [
            //     'self',
            //     'ws://' . env('APP_DOMAIN'),
            //     'wss://' . env('APP_DOMAIN'),
            //     'ws://ws-eu.pusher.com:6001/',
            //     'wss://ws-eu.pusher.com',
            // ])
            ->addDirective(Directive::FORM_ACTION, Keyword::SELF)
            // ->addDirective(Directive::IMG, [
            //     Keyword::SELF,
            //     'data:',
            //     'blob:'
            // ])
            ->addDirective(Directive::MEDIA, Keyword::SELF)
            ->addDirective(Directive::SCRIPT, [
                Keyword::SELF,
                'code.jquery.com',
                'cdn.jsdelivr.net',
                'cdnjs.cloudflare.com'
            ])
            ->addDirective(Directive::OBJECT, Keyword::NONE);
    }
}
