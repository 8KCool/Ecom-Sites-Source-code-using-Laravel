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

namespace App\Http\Controllers\Web\Account;

class CloseController extends AccountBaseController
{
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		view()->share('pagePath', 'close');
		
		return appView('account.close');
	}
	
	/**
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function submit()
	{
		if (request()->input('close_account_confirmation') == 1) {
			// Call API endpoint
			$endpoint = '/users/' . auth()->user()->id;
			$data = makeApiRequest('delete', $endpoint, request()->all());
			
			// dd($data);
			
			// Parsing the API's response
			$message = !empty(data_get($data, 'message')) ? data_get($data, 'message') : 'Unknown Error.';
			
			// HTTP Error Found
			if (!data_get($data, 'isSuccessful')) {
				flash($message)->error();
				
				return redirect()->back()->withInput();
			}
			
			// Notification Message
			if (data_get($data, 'success')) {
				if (auth()->check()) {
					auth()->guard()->logout();
				}
				
				flash($message)->success();
			} else {
				flash($message)->error();
			}
		}
		
		return redirect('/');
	}
}
