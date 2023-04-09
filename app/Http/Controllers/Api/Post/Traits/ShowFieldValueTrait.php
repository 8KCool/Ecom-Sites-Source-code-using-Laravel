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

namespace App\Http\Controllers\Api\Post\Traits;

use App\Models\CategoryField;

trait ShowFieldValueTrait
{
	/**
	 * Get Post's Custom Fields Values
	 *
	 * Note: Called when displaying the Post's details
	 *
	 * @param $catId
	 * @param $postId
	 * @return \Illuminate\Support\Collection
	 */
	public function showFieldsValues($catId, $postId)
	{
		// Get the Post's Custom Fields by its Parent Category
		$customFields = CategoryField::getFields($catId, $postId);
		
		// Get the Post's Custom Fields that have a value
		$postValues = [];
		if ($customFields->count() > 0) {
			foreach ($customFields as $key => $field) {
				if (!empty($field->default_value)) {
					$postValues[$key] = $field;
				}
			}
		}
		
		// Get Result's Data
		$data = [
			'success' => true,
			'result'  => $postValues,
		];
		
		return $this->apiResponse($data);
	}
}
