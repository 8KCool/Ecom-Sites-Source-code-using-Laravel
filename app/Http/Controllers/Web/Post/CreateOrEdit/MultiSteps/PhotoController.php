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

namespace App\Http\Controllers\Web\Post\CreateOrEdit\MultiSteps;

// Increase the server resources
$iniConfigFile = __DIR__ . '/../../../../../Helpers/Functions/ini.php';
if (file_exists($iniConfigFile)) {
	$configForUpload = true;
	include_once $iniConfigFile;
}

use App\Helpers\UrlGen;
use App\Http\Controllers\Api\Post\CreateOrEdit\Traits\RequiredInfoTrait;
use App\Http\Controllers\Api\Post\CreateOrEdit\Traits\PricingTrait;
use App\Http\Controllers\Web\Post\CreateOrEdit\MultiSteps\Traits\WizardTrait;
use App\Http\Controllers\Web\Post\CreateOrEdit\Traits\PricingPageUrlTrait;
use App\Http\Requests\PhotoRequest;
use App\Models\Post;
use App\Models\Scopes\ReviewedScope;
use App\Models\Scopes\VerifiedScope;
use App\Http\Controllers\Web\FrontController;
use Illuminate\Http\Request;
use Torann\LaravelMetaTags\Facades\MetaTag;

class PhotoController extends FrontController
{
	use RequiredInfoTrait;
	use WizardTrait;
	use PricingTrait;
	use PricingPageUrlTrait;
	
	public $data = [];
	public $package = null;
	
	/**
	 * PhotoController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->middleware(function ($request, $next) {
			$this->commonQueries();
			
			return $next($request);
		});
		
		$this->middleware('only.ajax')->only('delete');
	}
	
	/**
	 * Common Queries
	 */
	public function commonQueries()
	{
		// $isNewEntry = isPostCreationRequest();
		
		// $this->paymentSettings($isNewEntry);
		$this->setPostFormRequiredInfo();
		
		// Selected Package
		$this->package = $this->getSelectedPackage();
		view()->share('selectedPackage', $this->package);
		
		// Set the Package's pictures limit
		$this->getCurrentPaymentInfo(null, $this->package);
	}
	
	/**
	 * Show the form the create a new ad post.
	 *
	 * @param $postId
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
	 */
	public function getForm($postId, Request $request)
	{
		// Check if the 'Pricing Page' must be started first, and make redirection to it.
		$pricingUrl = $this->getPricingPage($this->package);
		if (!empty($pricingUrl)) {
			return redirect($pricingUrl)->header('Cache-Control', 'no-store, no-cache, must-revalidate');
		}
		
		// Check if the form type is 'Single Step Form', and make redirection to it (permanently).
		if (config('settings.single.publication_form_type') == '2') {
			$postEditionUrl = url('edit/' . $postId);
			$postEditionUrl = qsUrl($postEditionUrl, request()->only(['package']), null, false);
			
			return redirect($postEditionUrl, 301)->header('Cache-Control', 'no-store, no-cache, must-revalidate');
		}
		
		$data = [];
		
		// Get Post
		$post = null;
		if (auth()->check()) {
			$user = auth()->user();
			$post = Post::currentCountry()->withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->where('user_id', $user->id)
				->where('id', $postId)
				->with(['pictures'])
				->first();
		}
		
		if (empty($post)) {
			abort(404, t('Post not found'));
		}
		
		view()->share('post', $post);
		$this->shareWizardMenu($request, $post);
		
		// Set the Package's pictures limit
		if (!empty($this->package)) {
			$this->getCurrentPaymentInfo(null, $this->package);
		} else {
			// Share the Post's Latest Payment Info (If exists)
			// & Set the Package's pictures limit
			$this->getCurrentPaymentInfo($post);
		}
		
		// Get Next URL
		if (
			$this->countPackages > 0
			&& $this->countPaymentMethods > 0
		) {
			$nextUrl = 'posts/' . $postId . '/payment';
			$nextStepLabel = t('Next');
		} else {
			$nextUrl = UrlGen::postUri($post);
			$nextStepLabel = t('Finish');
		}
		view()->share('nextStepUrl', $nextUrl);
		view()->share('nextStepLabel', $nextStepLabel);
		
		
		// Meta Tags
		MetaTag::set('title', t('update_my_ad'));
		MetaTag::set('description', t('update_my_ad'));
		
		return appView('post.createOrEdit.multiSteps.photos.edit', $data);
	}
	
	/**
	 * Store a new ad post.
	 *
	 * @param $postId
	 * @param \App\Http\Requests\PhotoRequest $request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function postForm($postId, PhotoRequest $request)
	{
		// Add required data in the request for API
		$inputArray = [
			'count_packages'        => $this->countPackages ?? 0,
			'count_payment_methods' => $this->countPaymentMethods ?? 0,
			'post_id'               => $postId,
		];
		request()->merge($inputArray);
		
		// Call API endpoint
		$endpoint = '/pictures';
		$data = makeApiRequest('post', $endpoint, request()->all(), [], true);
		
		// Parsing the API's response
		$message = !empty(data_get($data, 'message')) ? data_get($data, 'message') : 'Unknown Error.';
		
		// HTTP Error Found
		if (!data_get($data, 'isSuccessful')) {
			// AJAX Response
			if (request()->ajax()) {
				return response()->json(['error' => $message]);
			}
			
			flash($message)->error();
			
			return redirect()->back()->withInput();
		}
		
		// Notification Message
		if (data_get($data, 'success')) {
			flash($message)->success();
		} else {
			// AJAX Response
			if (request()->ajax()) {
				return response()->json(['error' => $message]);
			}
			
			flash($message)->error();
		}
		
		$post = data_get($data, 'extra.post.result');
		
		// Get Next URL
		if (data_get($data, 'extra.steps.payment')) {
			$nextUrl = url('posts/' . $postId . '/payment');
		} else {
			$nextUrl = UrlGen::post($post);
		}
		$nextStepLabel = data_get($data, 'extra.nextStepLabel');
		
		view()->share('nextStepUrl', $nextUrl);
		view()->share('nextStepLabel', $nextStepLabel);
		
		
		// AJAX Response
		if (request()->ajax()) {
			$data = data_get($data, 'extra.fileInput');
			
			return response()->json($data);
		}
		
		// Non AJAX Response
		return redirect($nextUrl);
	}
	
	/**
	 * Delete picture
	 *
	 * @param $postId
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 */
	public function delete($postId, $id)
	{
		// Add required data in the request for API
		$inputArray = ['post_id' => $postId];
		request()->merge($inputArray);
		
		// Call API endpoint
		$endpoint = '/pictures/' . $id;
		$data = makeApiRequest('delete', $endpoint, request()->all());
		
		// Parsing the API's response
		$message = !empty(data_get($data, 'message')) ? data_get($data, 'message') : 'Unknown Error.';
		
		$result = ['status' => 0];
		
		// HTTP Error Found
		if (!data_get($data, 'isSuccessful')) {
			if (request()->ajax()) {
				$result['error'] = $message;
				
				return response()->json($result);
			}
			
			return redirect()->back();
		}
		
		// Notification Message
		if (data_get($data, 'success')) {
			if (request()->ajax()) {
				$result['status'] = 1;
				$result['message'] = $message;
				
				return response()->json($result);
			} else {
				flash($message)->success();
			}
		} else {
			if (request()->ajax()) {
				$result['error'] = $message;
				
				return response()->json($result);
			} else {
				flash($message)->error();
			}
		}
		
		return redirect()->back();
	}
	
	/**
	 * Reorder pictures
	 *
	 * @param $postId
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function reorder($postId, Request $request)
	{
		$result = ['status' => 0, 'message' => null];
		
		$params = $request->input('params');
		
		if (
			isset($params['stack'])
			&& is_array($params['stack'])
			&& count($params['stack']) > 0
		) {
			$body = [];
			foreach ($params['stack'] as $position => $item) {
				if (array_key_exists('key', $item) && $item['key'] != '') {
					$body[] = [
						'id'       => $item['key'],
						'position' => $position,
					];
				}
			}
			
			if (!empty($body)) {
				$inputArray = [
					'post_id' => $postId,
					'body'    => json_encode($body),
				];
				request()->merge($inputArray);
				
				// Call API endpoint
				$endpoint = '/pictures/reorder';
				$headers = ['X-Action' => 'bulk'];
				$data = makeApiRequest('post', $endpoint, $request->all(), $headers);
				
				// Parsing the API's response
				$message = !empty(data_get($data, 'message')) ? data_get($data, 'message') : 'Unknown Error.';
				
				if (data_get($data, 'isSuccessful') && data_get($data, 'success')) {
					$result = [
						'status'  => 1,
						'message' => $message,
					];
				} else {
					$result['error'] = $message;
				}
			}
		}
		
		return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
	}
}
