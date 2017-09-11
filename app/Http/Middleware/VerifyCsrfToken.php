<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/*',
        '/payment/ipay88/response',
        '/payment/ipay88/backend',
        '/checkout',
        '/payment/dragonpay/postback',
        '/payment/dragonpay/post' ,
        '/payment/dragonpay/post',
        '/tablet/get_data' ,
        '/member/payroll/get_cutoff_data',
        '/member/payroll/api_login',
        '/payment/paymaya/webhook/*'
    ];
}
