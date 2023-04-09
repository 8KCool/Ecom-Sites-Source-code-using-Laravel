<?php


namespace App\Http\Requests;

use App\Rules\BetweenRule;
use App\Rules\BlacklistDomainRule;
use App\Rules\BlacklistEmailRule;
use App\Rules\EmailRule;

class ContactRequest extends Request
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'first_name' => ['required', new BetweenRule(2, 100)],
			'last_name'  => ['required', new BetweenRule(2, 100)],
			'email'      => ['required', 'email', new EmailRule(), new BlacklistEmailRule(), new BlacklistDomainRule()],
			'message'    => ['required', new BetweenRule(5, 50000)],
		];
		
		if (isFromApi()) {
			$rules['country_code'] = ['required'];
			$rules['country_name'] = ['required'];
		}
		
		// CAPTCHA
		$rules = $this->captchaRules($rules);
		
		return $rules;
	}
}
