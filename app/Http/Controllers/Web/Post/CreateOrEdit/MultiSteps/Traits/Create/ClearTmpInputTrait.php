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

namespace App\Http\Controllers\Web\Post\CreateOrEdit\MultiSteps\Traits\Create;

trait ClearTmpInputTrait
{
	/**
	 * Clear Temporary Inputs & Files
	 */
	public function clearTemporaryInput()
	{
		if (session()->has('postInput')) {
			session()->forget('postInput');
		}
		
		if (session()->has('picturesInput')) {
			$picturesInput = (array)session()->get('picturesInput');
			if (!empty($picturesInput)) {
				try {
					foreach ($picturesInput as $key => $filePath) {
						$this->removePictureWithItsThumbs($filePath);
					}
				} catch (\Exception $e) {
					if (!empty($e->getMessage())) {
						flash($e->getMessage())->error();
					}
				}
				session()->forget('picturesInput');
			}
		}
		
		if (session()->has('paymentInput')) {
			session()->forget('paymentInput');
		}
		
		if (session()->has('uid')) {
			session()->forget('uid');
		}
	}
}
