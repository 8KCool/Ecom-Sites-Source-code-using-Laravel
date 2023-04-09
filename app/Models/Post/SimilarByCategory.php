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

namespace App\Models\Post;

use App\Models\Category;
use App\Models\Post;

trait SimilarByCategory
{
	/**
	 * Get similar Posts (Posts in the same Category)
	 *
	 * @param int $limit
	 * @return \Illuminate\Support\Collection
	 */
	public function getSimilarByCategory($limit = 10)
	{
		$posts = Post::query();
		
		$postsTable = (new Post())->getTable();
		
		$select = [
			$postsTable . '.id',
			$postsTable . '.country_code',
			'category_id',
			'title',
			$postsTable . '.price',
			'city_id',
			'featured',
			'reviewed',
			'tags',
			'verified_email',
			'verified_phone',
			$postsTable . '.created_at',
			$postsTable . '.archived_at',
		];
		
		if (is_array($select) && count($select) > 0) {
			foreach ($select as $column) {
				$posts->addSelect($column);
			}
		}
		
		// Get the sub-categories of the current ad parent's category
		$similarCatIds = [];
		if (!empty($this->category)) {
			if ($this->category->id == $this->category->id) {
				$similarCatIds[] = $this->category->id;
			} else {
				if (!empty($this->category->parent_id)) {
					$similarCatIds = Category::where('parent_id', $this->category->parent_id)->get()
						->keyBy('id')
						->keys()
						->toArray();
					$similarCatIds[] = (int)$this->category->parent_id;
				} else {
					$similarCatIds[] = (int)$this->category->id;
				}
			}
		}
		
		// Default Filters
		$posts->currentCountry()->verified()->unarchived();
		if (config('settings.single.posts_review_activation')) {
			$posts->reviewed();
		}
		
		// Get ads from same category
		if (!empty($similarCatIds)) {
			if (count($similarCatIds) == 1) {
				if (isset($similarCatIds[0]) && !empty(isset($similarCatIds[0]))) {
					$posts->where('category_id', (int)$similarCatIds[0]);
				}
			} else {
				$posts->whereIn('category_id', $similarCatIds);
			}
		}
		
		// Relations
		$posts->with('category')->has('category');
		$posts->with('pictures');
		$posts->with('city')->has('city');
		
		if (isset($this->id)) {
			$posts->where($postsTable . '.id', '!=', $this->id);
		}
		
		// Set ORDER BY
		$posts->orderBy('created_at', 'DESC');
		
		$posts = $posts->take((int)$limit)->get();
		
		// Randomize the Posts
		$posts = collect($posts)->shuffle();
		
		return $posts;
	}
}
