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

namespace App\Http\Controllers\Api\Picture;

use App\Http\Requests\PhotoRequest;
use App\Http\Resources\PictureResource;
use App\Http\Resources\PostResource;
use App\Models\Picture;
use App\Models\Post;
use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\ReviewedScope;
use App\Models\Scopes\VerifiedScope;

trait MultiStepsPicturesTrait
{
	/**
	 * Store Pictures (from Multi Steps Form)
	 *
	 * @param \App\Http\Requests\PhotoRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function storeMultiStepsPictures(PhotoRequest $request)
	{
		// Get customized request variables
		$countryCode = $request->input('country_code', config('country.code'));
		$countPackages = $request->input('count_packages', 0);
		$countPaymentMethods = $request->input('count_payment_methods', 0);
		$postId = $request->input('post_id');
		
		$user = null;
		if (auth('sanctum')->check()) {
			$user = auth('sanctum')->user();
		}
		
		$post = null;
		if (!empty($user) && !empty($postId)) {
			$post = Post::countryOf($countryCode)->withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->where('user_id', $user->id)
				->where('id', $postId)
				->first();
		}
		
		if (empty($post)) {
			return $this->respondNotFound(t('Post not found'));
		}
		
		$pictures = Picture::where('post_id', $post->id);
		
		// Get pictures limit
		$countExistingPictures = $pictures->count();
		$picturesLimit = (int)config('settings.single.pictures_limit', 5) - $countExistingPictures;
		
		// Get pictures initial position
		$latestPosition = $pictures->orderByDesc('position')->first();
		$initialPosition = (!empty($latestPosition) && (int)$latestPosition->position > 0) ? (int)$latestPosition->position : 0;
		$initialPosition = ($countExistingPictures >= $initialPosition) ? $countExistingPictures : $initialPosition;
		
		// Save all pictures
		$pictures = [];
		$files = $request->file('pictures');
		if (is_array($files) && count($files) > 0) {
			foreach ($files as $key => $file) {
				if (empty($file)) {
					continue;
				}
				
				// Delete old file if new file has uploaded
				// Check if current Post have a pictures
				$picturePosition = $initialPosition + (int)$key + 1;
				$picture = Picture::query()
					->where('post_id', $post->id)
					->where('id', $key)
					->first();
				if (!empty($picture)) {
					$picturePosition = $picture->position;
					$picture->delete();
				}
				
				// Post Picture in database
				$picture = new Picture([
					'post_id'  => $post->id,
					'filename' => $file,
					'position' => $picturePosition,
				]);
				if (isset($picture->filename) && !empty($picture->filename)) {
					$picture->save();
				}
				
				$pictures[] = (new PictureResource($picture));
				
				// Check the pictures limit
				if ($key >= ($picturesLimit - 1)) {
					break;
				}
			}
		}
		
		if (!empty($pictures)) {
			$data = [
				'success' => true,
				'message' => t('The pictures have been updated'),
				'result'  => $pictures,
			];
		} else {
			$data = [
				'success' => false,
				'message' => t('error_found'),
				'result'  => null,
			];
		}
		
		$extra = [];
		
		$extra['post']['result'] = (new PostResource($post))->toArray($request);
		
		// Should it be go on Payment page or not?
		if (
			is_numeric($countPackages)
			&& is_numeric($countPaymentMethods)
			&& $countPackages > 0
			&& $countPaymentMethods > 0
		) {
			$extra['steps']['payment'] = true;
			$extra['nextStepLabel'] = t('Next');
		} else {
			$extra['steps']['payment'] = false;
			$extra['nextStepLabel'] = t('Done');
		}
		
		if (request()->header('X-AppType') == 'web') {
			// Get the FileInput plugin's data
			$fileInput = [];
			$fileInput['initialPreview'] = [];
			$fileInput['initialPreviewConfig'] = [];
			
			$pictures = collect($pictures);
			if ($pictures->count() > 0) {
				foreach ($pictures as $picture) {
					// Get Deletion Url
					$initialPreviewConfigUrl = url('posts/' . $post->id . '/photos/' . $picture->id . '/delete');
					
					// Build Bootstrap-FileInput plugin's parameters
					$fileInput['initialPreview'][] = imgUrl($picture->filename, 'medium');
					$fileInput['initialPreviewConfig'][] = [
						'caption' => basename($picture->filename),
						'size'    => (isset($this->disk) && $this->disk->exists($picture->filename)) ? (int)$this->disk->size($picture->filename) : 0,
						'url'     => $initialPreviewConfigUrl,
						'key'     => $picture->id,
						'extra'   => ['id' => $picture->id],
					];
				}
			}
			$extra['fileInput'] = $fileInput;
		}
		
		$data['extra'] = $extra;
		
		return $this->apiResponse($data);
	}
	
	/**
	 * Delete a Picture (from Multi Steps Form)
	 *
	 * @param $pictureId
	 * @return mixed
	 * @throws \Exception
	 */
	public function deleteMultiStepsPicture($pictureId)
	{
		// Get customized request variables
		$postId = request()->input('post_id');
		
		$user = null;
		if (auth('sanctum')->check()) {
			$user = auth('sanctum')->user();
		}
		
		// Get Post
		$post = null;
		if (!empty($user) && !empty($postId)) {
			$post = Post::query()
				->withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->where('user_id', $user->id)
				->where('id', $postId)
				->first();
		}
		
		if (empty($post)) {
			return $this->respondNotFound(t('Post not found'));
		}
		
		$pictures = Picture::withoutGlobalScopes([ActiveScope::class])->where('post_id', $postId);
		
		if ($pictures->count() <= 0) {
			return $this->respondUnAuthorized();
		}
		
		if ($pictures->count() == 1) {
			if (config('settings.single.picture_mandatory')) {
				return $this->respondUnAuthorized(t('the_latest_picture_removal_text'));
			}
		}
		
		$pictures = $pictures->get();
		foreach ($pictures as $picture) {
			if ($picture->id == $pictureId) {
				$res = $picture->delete();
				break;
			}
		}
		
		$message = t('The picture has been deleted');
		
		return $this->respondSuccess($message);
	}
	
	/**
	 * Reorder Pictures - Bulk Update
	 *
	 * @return mixed
	 */
	public function reorderMultiStepsPictures()
	{
		// Get customized request variables
		$postId = request()->input('post_id');
		
		if (request()->header('X-Action') != 'bulk') {
			return $this->respondUnauthorized();
		}
		
		$bodyJson = request()->input('body');
		if (!isValidJson($bodyJson)) {
			return $this->respondError('Invalid JSON format for the "body" field.');
		}
		
		$bodyArray = json_decode($bodyJson);
		if (!is_array($bodyArray) || empty($bodyArray)) {
			return $this->respondNoContent();
		}
		
		$user = null;
		if (auth('sanctum')->check()) {
			$user = auth('sanctum')->user();
		}
		
		$pictures = [];
		foreach ($bodyArray as $item) {
			if (!isset($item->id) || !isset($item->position)) {
				continue;
			}
			if (empty($item->id) || !is_numeric($item->position)) {
				continue;
			}
			
			$picture = null;
			if (!empty($user) && !empty($postId)) {
				$picture = Picture::where('id', $item->id)
					->whereHas('post', function ($query) use ($user) {
						$query->where('user_id', $user->id);
					})->first();
			}
			
			if (!empty($picture)) {
				$picture->position = $item->position;
				$picture->save();
				
				$pictures[] = (new PictureResource($picture));
			}
		}
		
		// Get endpoint output data
		$data = [
			'success' => !empty($pictures),
			'message' => !empty($pictures) ? t('Your picture has been reorder successfully') : null,
			'result'  => !empty($pictures) ? $pictures : null,
		];
		
		return $this->apiResponse($data);
	}
}
