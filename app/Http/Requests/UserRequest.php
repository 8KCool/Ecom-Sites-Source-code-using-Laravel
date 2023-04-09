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

namespace App\Http\Requests;

use App\Rules\BetweenRule;
use App\Rules\BlacklistDomainRule;
use App\Rules\BlacklistEmailRule;
use App\Rules\EmailRule;
use App\Rules\UsernameIsAllowedRule;
use App\Rules\UsernameIsValidRule;

class UserRequest extends Request
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		if (in_array($this->method(), ['POST', 'CREATE'])) {
			return true;
		} else {
			$guard = isFromApi() ? 'sanctum' : null;
			
			return auth($guard)->check();
		}
	}
	
	/**
	 * Prepare the data for validation.
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{
		// Don't apply this to the Admin Panel
		if (isFromAdminPanel()) {
			return;
		}
		
		$input = $this->all();
		
		// name
		if ($this->filled('name')) {
			$input['name'] = strCleanerLite($this->input('name'));
			$input['name'] = onlyNumCleaner($input['name']);
		}
		
		// phone
		if ($this->filled('phone')) {
			$input['phone'] = phoneFormatInt($this->input('phone'), $this->input('country_code', session('country_code')));
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
		
		// CREATE
		if (in_array($this->method(), ['POST', 'CREATE'])) {
			$rules = $this->storeRules();
		}
		
		// UPDATE
		if (in_array($this->method(), ['PUT', 'PATCH', 'UPDATE'])) {
			$rules = $this->updateRules();
		}
		
		// Require 'photo' if exists
		if ($this->hasFile('photo')) {
			$rules['photo'] = [
				'required',
				'image',
				'mimes:' . getUploadFileTypes('image'),
				'min:' . (int)config('settings.upload.min_image_size', 0),
				'max:' . (int)config('settings.upload.max_image_size', 1000),
			];
		}
		
		return $rules;
	}
	
	/**
	 * @return array
	 */
	private function storeRules()
	{
		$rules = [
			'name'         => ['required', new BetweenRule(2, 200)],
			'country_code' => ['sometimes', 'required', 'not_in:0'],
			'phone'        => ['max:20'],
			'email'        => ['max:100', new BlacklistEmailRule(), new BlacklistDomainRule()],
			'password'     => [
				'required',
				'min:' . config('larapen.core.passwordLength.min', 6),
				'max:' . config('larapen.core.passwordLength.max', 60),
				'confirmed',
			],
		];
		
		// Email
		if ($this->filled('email')) {
			$rules['email'][] = 'email';
			$rules['email'][] = new EmailRule();
			$rules['email'][] = 'unique:users,email';
		}
		if (isEnabledField('email')) {
			if (isEnabledField('phone') and isEnabledField('email')) {
				$rules['email'][] = 'required_without:phone';
			} else {
				$rules['email'][] = 'required';
			}
		}
		
		// Phone
		if (config('settings.sms.phone_verification') == 1) {
			if ($this->filled('phone')) {
				$countryCode = $this->input('country_code', config('country.code'));
				if ($countryCode == 'UK') {
					$countryCode = 'GB';
				}
				$rules['phone'][] = 'phone:' . $countryCode;
			}
		}
		if (isEnabledField('phone')) {
			if (isEnabledField('phone') and isEnabledField('email')) {
				$rules['phone'][] = 'required_without:email';
			} else {
				$rules['phone'][] = 'required';
			}
		}
		if ($this->filled('phone')) {
			$rules['phone'][] = 'unique:users,phone';
		}
		
		// Username
		if (isEnabledField('username')) {
			if ($this->filled('username')) {
				$rules['username'] = [
					'between:3,100',
					'unique:users,username',
					new UsernameIsValidRule(),
					new UsernameIsAllowedRule(),
				];
			}
		}
		
		// CAPTCHA
		$rules = $this->captchaRules($rules);
		
		return $rules;
	}
	
	/**
	 * @return array
	 */
	private function updateRules()
	{
		$rules = [
			'name'      => ['required', 'max:100'],
			'phone'     => ['max:20'],
			'email'     => ['max:100', new BlacklistEmailRule(), new BlacklistDomainRule()],
			'username'  => [new UsernameIsValidRule(), new UsernameIsAllowedRule()],
		];
		
		$guard = isFromApi() ? 'sanctum' : null;
		$user = auth($guard)->user();
		
		// Check if these fields has changed
		$emailChanged = ($this->input('email') != $user->email);
		$phoneChanged = ($this->input('phone') != $user->phone);
		$usernameChanged = ($this->filled('username') && $this->input('username') != $user->username);
		
		// email
		if ($this->filled('email')) {
			$rules['email'][] = 'email';
			$rules['email'][] = new EmailRule();
		}
		if (isEnabledField('email')) {
			if (isEnabledField('phone') && isEnabledField('email')) {
				$rules['email'][] = 'required_without:phone';
			} else {
				$rules['email'][] = 'required';
			}
		}
		if ($emailChanged) {
			$rules['email'][] = 'unique:users,email';
		}
		
		// phone
		if (config('settings.sms.phone_verification') == 1) {
			if ($this->filled('phone')) {
				$countryCode = $this->input('country_code', config('country.code'));
				if ($countryCode == 'UK') {
					$countryCode = 'GB';
				}
				$rules['phone'][] = 'phone:' . $countryCode;
			}
		}
		if (isEnabledField('phone')) {
			if (isEnabledField('phone') && isEnabledField('email')) {
				$rules['phone'][] = 'required_without:email';
			} else {
				$rules['phone'][] = 'required';
			}
		}
		if ($phoneChanged) {
			$rules['phone'][] = 'unique:users,phone';
		}
		
		// username
		if ($this->filled('username')) {
			$rules['username'][] = 'between:3,100';
		}
		if ($usernameChanged) {
			$rules['username'][] = 'required';
			$rules['username'][] = 'unique:users,username';
		}
		
		// password
		if ($this->filled('password')) {
			$rules['password'] = [
				'min:' . config('larapen.core.passwordLength.min', 6),
				'max:' . config('larapen.core.passwordLength.max', 60),
				'confirmed',
			];
		}
		
		return $rules;
	}
	
	/**
	 * Get custom attributes for validator errors.
	 *
	 * @return array
	 */
	public function attributes()
	{
		$attributes = [];
		
		if ($this->hasFile('photo')) {
			$attributes['photo'] = strtolower(t('Photo'));
		}
		
		return $attributes;
	}
	
	/**
	 * Get custom messages for validator errors.
	 *
	 * @return array
	 */
	public function messages()
	{
		$messages = [];
		
		if ($this->hasFile('photo')) {
			// uploaded
			$maxSize = (int)config('settings.upload.max_image_size', 1000); // In KB
			$maxSize = $maxSize * 1024; // Convert KB to Bytes
			$msg = t('large_file_uploaded_error', [
				'field'   => strtolower(t('Photo')),
				'maxSize' => readableBytes($maxSize),
			]);
			
			$uploadMaxFilesizeStr = @ini_get('upload_max_filesize');
			$postMaxSizeStr = @ini_get('post_max_size');
			if (!empty($uploadMaxFilesizeStr) && !empty($postMaxSizeStr)) {
				$uploadMaxFilesize = (int)strToDigit($uploadMaxFilesizeStr);
				$postMaxSize = (int)strToDigit($postMaxSizeStr);
				
				$serverMaxSize = min($uploadMaxFilesize, $postMaxSize);
				$serverMaxSize = $serverMaxSize * 1024 * 1024; // Convert MB to KB to Bytes
				if ($serverMaxSize < $maxSize) {
					$msg = t('large_file_uploaded_error_system', [
						'field'   => strtolower(t('Photo')),
						'maxSize' => readableBytes($serverMaxSize),
					]);
				}
			}
			
			$messages['photo.uploaded'] = $msg;
		}
		
		return $messages;
	}
}
