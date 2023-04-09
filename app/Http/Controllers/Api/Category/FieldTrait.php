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

namespace App\Http\Controllers\Api\Category;

use App\Models\CategoryField;
use Illuminate\Http\Request;

trait FieldTrait
{
	/**
	 * List category's fields
	 *
	 * @bodyParam language_code string The code of the user's spoken language. Example: en
	 * @bodyParam post_id int required The unique ID of the post. Example: 1
	 *
	 * Note:
	 * - Called when showing Post's creation or edit forms
	 * - POST method is used instead of GET du to the big JSON fields (errors & old)
	 *
	 * @param $categoryId
	 * @param \Illuminate\Http\Request $request
	 * @return mixed
	 */
	public function getCustomFields($categoryId, Request $request)
	{
		$languageCode = $request->input('language_code', config('app.locale'));
		$postId = $request->input('post_id', null);
		
		// Custom Fields vars
		$errors = $request->input('errors');
		$errors = convertUTF8HtmlToAnsi($errors); // Convert UTF-8 HTML to ANSI
		$errors = stripslashes($errors);
		$errors = collect(json_decode($errors, true));
		// ...
		$oldInput = $request->input('old');
		$oldInput = convertUTF8HtmlToAnsi($oldInput); // Convert UTF-8 HTML to ANSI
		$oldInput = stripslashes($oldInput);
		$oldInput = json_decode($oldInput, true);
		
		// Get the Category's Custom Fields buffer
		$fields = CategoryField::getFields($categoryId, $postId, $languageCode);
		
		$success = ($errors->count() <= 0);
		
		// Get Result's Data
		$data = [
			'success' => $success,
			'result'  => $fields->toArray(),
			'errors'  => $errors->toArray(),
			'old'     => $oldInput,
		];
		
		return $this->apiResponse($data);
	}
}
