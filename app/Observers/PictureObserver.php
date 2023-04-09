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

namespace App\Observers;

use App\Helpers\Files\Storage\StorageDisk;
use App\Helpers\Files\Tools\FileStorage;
use App\Models\Language;
use App\Models\Picture;
use App\Models\Scopes\ActiveScope;
use App\Observers\Traits\PictureTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PictureObserver
{
	use PictureTrait;
	
	/**
	 * Listen to the Entry deleting event.
	 *
	 * @param Picture $picture
	 * @return void
	 */
	public function deleting(Picture $picture)
	{
		// Delete all pictures files
		if (isset($picture->filename)) {
			$this->removePictureWithItsThumbs($picture->filename);
		}
	}
	
	/**
	 * Listen to the Entry saved event.
	 *
	 * @param Picture $picture
	 * @return void
	 */
	public function saved(Picture $picture)
	{
		// Removing Entries from the Cache
		$this->clearCache($picture);
	}
	
	/**
	 * Listen to the Entry deleted event.
	 *
	 * @param Picture $picture
	 * @return void
	 */
	public function deleted(Picture $picture)
	{
		// Removing Entries from the Cache
		$this->clearCache($picture);
	}
	
	/**
	 * Removing the Entity's Entries from the Cache
	 *
	 * @param $picture
	 */
	private function clearCache($picture)
	{
		Cache::forget('post.withoutGlobalScopes.with.city.pictures.' . $picture->post_id);
		Cache::forget('post.with.city.pictures.' . $picture->post_id);
		
		try {
			$languages = Language::withoutGlobalScopes([ActiveScope::class])->get(['abbr']);
		} catch (\Exception $e) {
			$languages = collect([]);
		}
		
		if ($languages->count() > 0) {
			foreach ($languages as $language) {
				Cache::forget('post.withoutGlobalScopes.with.city.pictures.' . $picture->post_id . '.' . $language->abbr);
				Cache::forget('post.with.city.pictures.' . $picture->post_id . '.' . $language->abbr);
			}
		}
	}
}
