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

namespace App\Http\Requests\Admin;

use App\Helpers\Number;
use App\Rules\BetweenRule;

class PostRequest extends Request
{
	/**
	 * Prepare the data for validation.
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{
		$input = $this->all();
		
		// price
		if ($this->has('price')) {
			if ($this->filled('price')) {
				$input['price'] = $this->input('price');
				// If field's value contains only numbers and dot,
				// Then decimal separator is set as dot.
				if (preg_match('/^[0-9\.]*$/', $input['price'])) {
					$input['price'] = Number::formatForDb($input['price'], '.');
				} else {
					$input['price'] = Number::formatForDb($input['price'], config('currency.decimal_separator', '.'));
				}
			} else {
				$input['price'] = null;
			}
		}
		
		request()->merge($input); // Required!
		$this->merge($input);
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [];
		$rules['category_id'] = ['required', 'not_in:0'];
		if (config('settings.single.show_post_types')) {
			$rules['post_type_id'] = ['required', 'not_in:0'];
		}
		$rules['title'] = ['required', new BetweenRule(2, 150)];
		$rules['description'] = ['required', new BetweenRule(2, 60000000000000000000)];
		$rules['contact_name'] = ['required', new BetweenRule(2, 200)];
		$rules['email'] = ['required', 'email', 'max:100'];
		
		/*
		 * Tags (Only allow letters, numbers, spaces and ',;_-' symbols)
		 *
		 * Explanation:
		 * [] 	=> character class definition
		 * p{L} => matches any kind of letter character from any language
		 * p{N} => matches any kind of numeric character
		 * _- 	=> matches underscore and hyphen
		 * + 	=> Quantifier — Matches between one to unlimited times (greedy)
		 * /u 	=> Unicode modifier. Pattern strings are treated as UTF-16. Also causes escape sequences to match unicode characters
		 */
		if ($this->filled('tags')) {
			$rules['tags'] = ['regex:/^[\p{L}\p{N} ,;_-]+$/u'];
		}
		
		return $rules;
	}
}
