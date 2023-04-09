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

use App\Helpers\Number;
use App\Helpers\RemoveFromString;
use App\Models\Package;
use App\Models\Picture;
use App\Rules\BetweenRule;
use App\Rules\BlacklistDomainRule;
use App\Rules\BlacklistEmailRule;
use App\Rules\BlacklistTitleRule;
use App\Rules\BlacklistWordRule;
use App\Rules\MbAlphanumericRule;
use App\Rules\EmailRule;
use App\Rules\SluggableRule;
use Mews\Purifier\Facades\Purifier;

class PostRequest extends Request
{
	public static $packages;
	public static $paymentMethods;
	
	protected $cfMessages = [];
	
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
		
		// title
		if ($this->filled('title')) {
			$input['title'] = $this->input('title');
			$input['title'] = strCleanerLite($input['title']);
			$input['title'] = onlyNumCleaner($input['title']);
			$input['title'] = RemoveFromString::contactInfo($input['title'], true);
		}
		
		// description
		if ($this->filled('description')) {
			$input['description'] = $this->input('description');
			$input['description'] = onlyNumCleaner($input['description']);
			if (config('settings.single.wysiwyg_editor') != 'none') {
				try {
					$input['description'] = Purifier::clean($input['description']);
				} catch (\Exception $e) {
				}
			} else {
				$input['description'] = strCleaner($input['description']);
			}
			$input['description'] = RemoveFromString::contactInfo($input['description'], true);
		}
		
		// price
		if ($this->has('price')) {
			if ($this->filled('price')) {
				$input['price'] = $this->input('price');
				// If field's value contains only numbers and dot,
				// Then decimal separator is set as dot.
				if (preg_match('/^[0-9\,]*$/', $input['price'])) {
					$input['price'] = Number::formatForDb($input['price'], ',');
				} else {
					$input['price'] = Number::formatForDb($input['price'], config('currency.decimal_separator', ','));
				}
			} else {
				$input['price'] = null;
			}
		}
		
		// contact_name
		if ($this->filled('contact_name')) {
			$input['contact_name'] = strCleanerLite($this->input('contact_name'));
			$input['contact_name'] = onlyNumCleaner($input['contact_name']);
		}
		
		// phone
		if ($this->filled('phone')) {
			$input['phone'] = phoneFormatInt($this->input('phone'), $this->input('country_code', session('country_code')));
		}
		
		// tags
		if ($this->filled('tags')) {
			$input['tags'] = tagCleaner($this->input('tags'));
		}
		
		// is_permanent
		if ($this->filled('is_permanent')) {
			$input['is_permanent'] = $this->input('is_permanent');
			// For security purpose
			if (config('settings.single.permanent_posts_enabled') == '0') {
				$input['is_permanent'] = 0;
			} else {
				if (config('settings.single.permanent_posts_enabled') == '1' && $this->input('post_type_id') != 1) {
					$input['is_permanent'] = 0;
				}
				if (config('settings.single.permanent_posts_enabled') == '2' && $this->input('post_type_id') != 2) {
					$input['is_permanent'] = 0;
				}
				if (config('settings.single.permanent_posts_enabled') == '3' && $this->input('post_type_id') == 2) {
					$input['is_permanent'] = 1;
				}
			}
		} else {
			$input['is_permanent'] = 0;
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
		$guard = isFromApi() ? 'sanctum' : null;
		
		$rules = [];
		$rules['category_id'] = ['required', 'not_in:0'];
		if (config('settings.single.show_post_types')) {
			$rules['post_type_id'] = ['required', 'not_in:0'];
		}
		$rules['title'] = [
			'required',
			new BetweenRule(2, 150),
			new MbAlphanumericRule(),
			new SluggableRule(),
			new BlacklistTitleRule(),
		];
		$rules['description'] = ['required', new BetweenRule(2, 600000), new MbAlphanumericRule(), new BlacklistWordRule()];
		$rules['contact_name'] = [new BetweenRule(2, 200)];
		$rules['email'] = ['max:100', new BlacklistEmailRule(), new BlacklistDomainRule()];
		$rules['phone'] = ['required','max:15'];
		$rules['city_id'] = ['required', 'not_in:0'];
		
		
		if (!auth($guard)->check()) {
			$rules['accept_terms'] = ['accepted'];
		}
		
		// CREATE
		if (in_array($this->method(), ['POST', 'CREATE'])) {
			// Apply this rules for the 'Single Step Form' (Web & API requests)
			// Or for API requests whatever the form type (ie. Single or Multi Steps)
			if (config('settings.single.publication_form_type') == '2' || isFromApi()) {
				// Pictures
				if ($this->file('pictures')) {
					$files = $this->file('pictures');
					foreach ($files as $key => $file) {
						if (!empty($file)) {
							$rules['pictures.' . $key] = [
								'image',
								'mimes:' . getUploadFileTypes('image'),
								'min:' . (int)config('settings.upload.min_image_size', 0),
								'max:' . (int)config('settings.upload.max_image_size', 1000),
							];
						}
					}
				} else {
					if (config('settings.single.picture_mandatory')) {
						$rules['pictures'] = ['required'];
					}
				}
			}
			
			// Single Step Form
			if (config('settings.single.publication_form_type') == '2') {
				// Package & PaymentMethod
				if (
					isset(self::$packages, self::$paymentMethods)
					&& self::$packages->count() > 0
					&& self::$paymentMethods->count() > 0
				) {
					// Require 'package_id' if Packages are available
					$rules['package_id'] = ['required'];
					
					// Require 'payment_method_id' if the selected package's price > 0
					if ($this->has('package_id')) {
						$package = Package::find($this->input('package_id'));
						if (!empty($package) && $package->price > 0) {
							$rules['payment_method_id'] = ['required', 'not_in:0'];
						}
					}
				}
			}
			
			// CAPTCHA
			$rules = $this->captchaRules($rules);
		}
		
		// UPDATE
		if (in_array($this->method(), ['PUT', 'PATCH', 'UPDATE'])) {
			// Single Step Form
			if (config('settings.single.publication_form_type') == '2') {
				// Pictures
				if ($this->file('pictures')) {
					$files = $this->file('pictures');
					foreach ($files as $key => $file) {
						if (!empty($file)) {
							$rules['pictures.' . $key] = [
								'image',
								'mimes:' . getUploadFileTypes('image'),
								'min:' . (int)config('settings.upload.min_image_size', 0),
								'max:' . (int)config('settings.upload.max_image_size', 1000),
							];
						}
					}
				} else {
					if (config('settings.single.picture_mandatory')) {
						$countPictures = Picture::where('post_id', $this->input('post_id'))->count();
						if ($countPictures <= 0) {
							$rules['pictures'] = ['required'];
						}
					}
				}
			}
		}
		
		// COMMON
		
		// Location
		if (in_array(config('country.admin_type'), ['1', '2']) && config('country.admin_field_active') == 1) {
			$rules['admin_code'] = ['required', 'not_in:0'];
		}
		
		// Email
		if ($this->filled('email')) {
			$rules['email'][] = 'email';
			$rules['email'][] = new EmailRule();
		}
		if (isEnabledField('email')) {
			if (isEnabledField('phone') && isEnabledField('email')) {
				// Email address is required for Guests
				$rules['email'][] = (!auth($guard)->check()) ? 'required' : 'required_without:phone';
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
			if (isEnabledField('phone') && isEnabledField('email')) {
				$rules['phone'][] = 'required_without:email';
			} else {
				$rules['phone'][] = 'required';
			}
		}
		
		// Custom Fields
		if (!isFromApi()) {
			$cfRequest = new CustomFieldRequest();
			$rules = $rules + $cfRequest->rules();
			$this->cfMessages = $cfRequest->messages();
		}
		
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
	
	/**
	 * Get custom attributes for validator errors.
	 *
	 * @return array
	 */
	public function attributes()
	{
		$attributes = [];
		
		if ($this->file('pictures')) {
			$files = $this->file('pictures');
			foreach ($files as $key => $file) {
				$attributes['pictures.' . $key] = t('picture X', ['key' => ($key + 1)]);
			}
		}
		
		return $attributes;
	}
	
	/**
	 * @return array
	 */
	public function messages()
	{
		$messages = [];
		
		// Category & Sub-Category
		if ($this->filled('parent_id') && !empty($this->input('parent_id'))) {
			$messages['category_id.required'] = t('The field is required', ['field' => mb_strtolower(t('sub_category'))]);
			$messages['category_id.not_in'] = t('The field is required', ['field' => mb_strtolower(t('sub_category'))]);
		}
		
		// Single Step Form
		if (config('settings.single.publication_form_type') == '2') {
			// Picture
			if ($this->file('pictures')) {
				$files = $this->file('pictures');
				foreach ($files as $key => $file) {
					// uploaded
					$maxSize = (int)config('settings.upload.max_image_size', 1000); // In KB
					$maxSize = $maxSize * 1024;                                     // Convert KB to Bytes
					$msg = t('large_file_uploaded_error', [
						'field'   => t('picture X', ['key' => ($key + 1)]),
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
								'field'   => t('picture X', ['key' => ($key + 1)]),
								'maxSize' => readableBytes($serverMaxSize),
							]);
						}
					}
					
					$messages['pictures.' . $key . '.uploaded'] = $msg;
				}
			}
			
			// Package & PaymentMethod
			$messages['package_id.required'] = trans('validation.required_package_id');
			$messages['payment_method_id.required'] = t('validation.required_payment_method_id');
			$messages['payment_method_id.not_in'] = t('validation.required_payment_method_id');
		}
		
		// Custom Fields
		if (!isFromApi()) {
			$messages = $messages + $this->cfMessages;
		}
		
		return $messages;
	}
}
