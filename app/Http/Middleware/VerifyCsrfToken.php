<?php
/**
 * LaraClassified - Classified Ads Web Application
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: https://bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
	/**
	 * Indicates whether the XSRF-TOKEN cookie should be set on the response.
	 *
	 * @var bool
	 */
	protected $addHttpCookie = true;
	
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '*',
        '/wallet/vpos_webhook'
    ];
	
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 *
	 * @throws \Illuminate\Session\TokenMismatchException
	 */
	public function handle($request, Closure $next)
	{
		if (
			config('settings.security.csrf_protection')
			&& request()->header('X-AppType') != 'docs'
		) {
			$this->except = [];
		}
		
		return parent::handle($request, $next);
	}
}
