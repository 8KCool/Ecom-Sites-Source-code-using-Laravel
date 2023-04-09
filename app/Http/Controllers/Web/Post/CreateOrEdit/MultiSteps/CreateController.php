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

use App\Helpers\UrlGen;
use App\Http\Controllers\Api\Payment\SingleStepPaymentTrait;
use App\Http\Controllers\Api\Post\CreateOrEdit\Traits\MakePaymentTrait;
use App\Http\Controllers\Api\Post\CreateOrEdit\Traits\RequiredInfoTrait;
use App\Http\Controllers\Web\Auth\Traits\VerificationTrait;
use App\Http\Controllers\Web\Post\CreateOrEdit\MultiSteps\Traits\Create\ClearTmpInputTrait;
use App\Http\Controllers\Web\Post\CreateOrEdit\MultiSteps\Traits\Create\SubmitTrait;
use App\Http\Controllers\Web\Post\CreateOrEdit\MultiSteps\Traits\WizardTrait;
use App\Http\Controllers\Web\Post\CreateOrEdit\Traits\PricingPageUrlTrait;
use App\Http\Requests\PackageRequest;
use App\Http\Requests\PhotoRequest;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\PostType;
use App\Models\Package;
use App\Models\UserWallet;
use App\Models\Scopes\VerifiedScope;
use App\Http\Controllers\Web\FrontController;
use App\Models\Scopes\ReviewedScope;
use App\Observers\Traits\PictureTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Torann\LaravelMetaTags\Facades\MetaTag;

class CreateController extends FrontController
{
	use VerificationTrait;
	use RequiredInfoTrait;
	use WizardTrait;
	use SingleStepPaymentTrait, MakePaymentTrait;
	use PricingPageUrlTrait;
	use PictureTrait, ClearTmpInputTrait;
	use SubmitTrait;
	
	protected $baseUrl = '/posts/create';
	protected $tmpUploadDir = 'temporary';
	
	/**
	 * CreateController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Check if guests can post Ads
		if (config('settings.single.guests_can_post_ads') != '1') {
			$this->middleware('auth')->only(['getForm', 'postForm']);
		}
		
		$this->middleware(function ($request, $next) {
			$this->commonQueries();
			
			return $next($request);
		});
		
		$this->baseUrl = url($this->baseUrl);
	}
	
	/**
	 * Common Queries
	 */
	public function commonQueries()
	{
		$this->setPostFormRequiredInfo();
		$this->paymentSettings();
		
		if (config('settings.single.show_post_types')) {
			// Get Post Types
			$cacheId = 'postTypes.all.' . config('app.locale');
			$postTypes = Cache::remember($cacheId, $this->cacheExpiration, function () {
				return PostType::orderBy('lft')->get();
			});
			view()->share('postTypes', $postTypes);
		}
		
		// Meta Tags
		MetaTag::set('title', getMetaTag('title', 'create'));
		MetaTag::set('description', strip_tags(getMetaTag('description', 'create')));
		MetaTag::set('keywords', getMetaTag('keywords', 'create'));
	}
	
	/**
	 * Check for current step
	 *
	 * @param Request $request
	 * @return int
	 */
	public function step(Request $request)
	{
		if ($request->get('error') == 'paymentCancelled') {
			if ($request->session()->has('postId')) {
				$request->session()->forget('postId');
			}
		}
		
		$postId = $request->session()->get('postId');
		
		$step = 0;
		
		$data = $request->session()->get('postInput');
		if (isset($data) || !empty($postId)) {
			$step = 1;
		} else {
			return $step;
		}
		
		$data = $request->session()->get('picturesInput');
		if (isset($data) || !empty($postId)) {
			$step = 2;
		} else {
			return $step;
		}
		
		$data = $request->session()->get('paymentInput');
		if (isset($data) || !empty($postId)) {
			$step = 3;
		} else {
			return $step;
		}
		
		return $step;
	}
	
	/**
	 * Post's Step
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return mixed
	 */
	public function getPostStep(Request $request)
	{
		// Check if the 'Pricing Page' must be started first, and make redirection to it.
		$pricingUrl = $this->getPricingPage($this->getSelectedPackage());
		if (!empty($pricingUrl)) {
			return redirect($pricingUrl)->header('Cache-Control', 'no-store, no-cache, must-revalidate');
		}
		
		// Check if the form type is 'Single Step Form', and make redirection to it (permanently).
		if (config('settings.single.publication_form_type') == '2') {
			return redirect(url('create'), 301)->header('Cache-Control', 'no-store, no-cache, must-revalidate');
		}
		
		$this->shareWizardMenu($request);
		
		$postInput = $request->session()->get('postInput');
		
		return appView('post.createOrEdit.multiSteps.create', compact('postInput'));
	}
	
	/**
	 * Post's Step (POST)
	 *
	 * @param \App\Http\Requests\PostRequest $request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function postPostStep(PostRequest $request)
	{
		$request->session()->put('postInput', $request->all());
		$postInput = (array)$request->session()->get('postInput');
		//print_r($postInput);
		//die();
		// Get the next URL
		$nextUrl = url('posts/create/photos');
		$nextUrl = qsUrl($nextUrl, request()->only(['package']), null, false);
		
		return redirect($nextUrl);
	}
	
	/**
	 * Pictures' Step
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
	 */
	public function getPicturesStep(Request $request)
	{
		if ($this->step($request) < 1) {
			$backUrl = url($this->baseUrl);
			$backUrl = qsUrl($backUrl, request()->only(['package']), null, false);
			
			return redirect($backUrl);
		}
		
		$this->shareWizardMenu($request);
		
		// Create an unique temporary ID
		if (!$request->session()->has('uid')) {
			$request->session()->put('uid', uniqueCode(9));
		}
		
		$picturesInput = $request->session()->get('picturesInput');
		
		// Get next step URL
		if (
			isset($this->countPackages, $this->countPaymentMethods)
			&& $this->countPackages > 0
			&& $this->countPaymentMethods > 0
		) {
			$nextUrl = url('posts/create/payment');
			$nextStepLabel = t('Next');
		} else {
			$nextUrl = url('posts/create/finish');
			$nextStepLabel = t('submit');
		}
		$nextUrl = qsUrl($nextUrl, request()->only(['package']), null, false);
		
		view()->share('nextStepUrl', $nextUrl);
		view()->share('nextStepLabel', $nextStepLabel);
		
		return appView('post.createOrEdit.multiSteps.photos.create', compact('picturesInput'));
	}
	
	/**
	 * Pictures' Step (POST)
	 *
	 * @param \App\Http\Requests\PhotoRequest $request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function postPicturesStep(PhotoRequest $request)
	{
		if (!$request->ajax()) {
			if ($this->step($request) < 1) {
				$backUrl = url($this->baseUrl);
				$backUrl = qsUrl($backUrl, request()->only(['package']), null, false);
				
				return redirect($backUrl);
			}
		}
		$postInput = (array)$request->session()->get('postInput');
		//print_r($postInput);
		$savedPicturesInput = (array)$request->session()->get('picturesInput');
		//print_r($savedPicturesInput);
		//die;
		$picturesInput = [];
		
		// Get pictures limit
		$countExistingPictures = is_array($savedPicturesInput) ? count($savedPicturesInput) : 0;
		$picturesLimit = (int)config('settings.single.pictures_limit', 5) - $countExistingPictures;
		
		// Use unique ID to store post's pictures
		if ($request->session()->has('uid')) {
			$this->tmpUploadDir = $this->tmpUploadDir . '/' . $request->session()->get('uid');
		}
		
		// Save uploaded files
		$files = $request->file('pictures');
		if (is_array($files) && count($files) > 0) {
			foreach ($files as $key => $file) {
				if (empty($file)) {
					continue;
				}
				
				$picturesInput[] = uploadPostPicture($this->tmpUploadDir, $file);
				
				// Check the pictures limit
				if ($key >= ($picturesLimit - 1)) {
					break;
				}
			}
			
			$newPicturesInput = array_merge($savedPicturesInput, $picturesInput);
			
			$request->session()->put('picturesInput', $newPicturesInput);
		}
		
		// AJAX response
		$data = [];
		$data['initialPreview'] = [];
		$data['initialPreviewConfig'] = [];
		if ($request->ajax()) {
			if (is_array($picturesInput) && count($picturesInput) > 0) {
				foreach ($picturesInput as $key => $filePath) {
					if (empty($filePath)) {
						continue;
					}
					
					// Get Deletion Url
					$initialPreviewConfigUrl = url('posts/create/photos/' . $key . '/delete');
					
					// Build Bootstrap-FileInput plugin's parameters
					$data['initialPreview'][] = imgUrl($filePath, 'medium');
					$data['initialPreviewConfig'][] = [
						'caption' => basename($filePath),
						'size'    => (isset($this->disk) && $this->disk->exists($filePath)) ? (int)$this->disk->size($filePath) : 0,
						'url'     => $initialPreviewConfigUrl,
						'key'     => $key,
						'extra'   => ['id' => $key],
					];
				}
			}
		}
		
		// Response
		if ($request->ajax()) {
			
			// AJAX response
			return response()->json($data);
			
		} else {
			
			// Get the next URL & button label
			if (
				isset($this->countPackages, $this->countPaymentMethods)
				&& $this->countPackages > 0
				&& $this->countPaymentMethods > 0
			) {
				if (is_array($picturesInput) && count($picturesInput) > 0) {
					flash(t('The pictures have been updated'))->success();
				}
				
				$nextUrl = url('posts/create/payment');
				$nextUrl = qsUrl($nextUrl, request()->only(['package']), null, false);
				
				return redirect($nextUrl);
			} else {
				$request->session()->flash('message', t('your_ad_has_been_created'));
				
				return $this->storeInputDataInDatabase($request);
			}
			
		}
	}
	
	/**
	 * Payment's Step
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
	 */
	public function getPaymentStep(Request $request)
	{
		if ($this->step($request) < 2) {
			if (config('settings.single.picture_mandatory')) {
				$backUrl = url($this->baseUrl . '/photos');
				$backUrl = qsUrl($backUrl, request()->only(['package']), null, false);
				
				return redirect($backUrl);
			}
		}
		
		$this->shareWizardMenu($request);
		
		$payment = $request->session()->get('paymentInput');
		
		return appView('post.createOrEdit.multiSteps.packages.create', compact('payment'));
	}
	
	/**
	 * Payment's Step (POST)
	 *
	 * @param \App\Http\Requests\PackageRequest $request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function postPaymentStep(PackageRequest $request)
	{
		if ($this->step($request) < 2) {
			if (config('settings.single.picture_mandatory')) {
				$backUrl = url($this->baseUrl . '/photos');
				$backUrl = qsUrl($backUrl, request()->only(['package']), null, false);
				
				return redirect($backUrl);
			}
		}

		$flag=1;
		$message= "";
		$package_id= $request->input("package_id");
        if(!empty($package_id)){
        	$package= Package::where('id',$package_id)->first();
            $userId = auth()->check() ? auth()->user()->id : null;
            if(!empty($package)){
            	$packagePrice= $package->price;
            	$userWallet = UserWallet::where('user_id',$userId)->first();
            	if(!empty($userWallet)){
            		if($packagePrice<=$userWallet->amount){
            			$flag=1;
            		} else {
            			$flag=0;
            			$message= "Não tem saldo suficiente na sua carteira. Carregue a sua conta!";
            		}
            	} else {
            		$flag=0;
            		$message= "Não tem saldo suficiente na sua carteira. Carregue a sua conta!";
            	}
            } else {
            	$flag=0;
            	$message= "Pacote errado";
            }
        }
       
		if($flag){
			$request->session()->put('paymentInput', $request->validated());		
			return $this->storeInputDataInDatabase($request);
		} else {
			flash($message)->error();			
			return redirect()->back();
		}
		
	}
	
	/**
	 * End of the steps (Confirmation)
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
	 */
	public function finish(Request $request)
	{
		if (!session()->has('message')) {
			return redirect('/');
		}
		
		// Clear the steps wizard
		if (session()->has('postId')) {
			// Get the Post
			$post = Post::withoutGlobalScopes([VerifiedScope::class, ReviewedScope::class])
				->where('id', session()->get('postId'))
				->first();
			
			if (empty($post)) {
				abort(404, t('Post not found'));
			}
			
			session()->forget('postId');
		}
		
		// Redirect to the Post,
		// - If User is logged
		// - Or if Email and Phone verification option is not activated
		if (auth()->check() || (config('settings.mail.email_verification') != 1 && config('settings.sms.phone_verification') != 1)) {
			if (!empty($post)) {
				flash(session()->get('message'))->success();
				
				return redirect(UrlGen::postUri($post));
			}
		}
		
		// Meta Tags
		MetaTag::set('title', session()->get('message'));
		MetaTag::set('description', session()->get('message'));
		
		return appView('post.createOrEdit.multiSteps.finish');
	}
	
	/**
	 * Remove a picture
	 *
	 * @param $pictureId
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function removePicture($pictureId, Request $request)
	{
		$picturesInput = $request->session()->get('picturesInput');
		
		$message = t('The picture cannot be deleted');
		$result = ['status' => 0, 'message' => $message];
		
		if (isset($picturesInput[$pictureId])) {
			$res = true;
			try {
				$this->removePictureWithItsThumbs($picturesInput[$pictureId]);
			} catch (\Exception $e) {
				$res = false;
			}
			
			if ($res) {
				unset($picturesInput[$pictureId]);
				
				if (!empty($picturesInput)) {
					$request->session()->put('picturesInput', $picturesInput);
				} else {
					$request->session()->forget('picturesInput');
				}
				
				$message = t('The picture has been deleted');
				
				if (request()->ajax()) {
					$result['status'] = 1;
					$result['message'] = $message;
					
					return response()->json($result);
				} else {
					flash($message)->success();
					
					return redirect()->back();
				}
			}
		}
		
		if (request()->ajax()) {
			return response()->json($result);
		} else {
			flash($message)->error();
			
			return redirect()->back();
		}
	}
	
	/**
	 * Reorder pictures
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function reorderPictures(Request $request)
	{
		$params = $request->input('params');
		
		$result = ['status' => 0];
		
		if (isset($params['stack']) && count($params['stack']) > 0) {
			// Use unique ID to store post's pictures
			if ($request->session()->has('uid')) {
				$this->tmpUploadDir = $this->tmpUploadDir . '/' . $request->session()->get('uid');
			}
			
			$newPicturesInput = [];
			$statusOk = false;
			foreach ($params['stack'] as $position => $item) {
				if (array_key_exists('caption', $item) && !empty($item['caption'])) {
					$newPicturesInput[] = $this->tmpUploadDir . '/' . $item['caption'];
					$statusOk = true;
				}
			}
			if ($statusOk) {
				$request->session()->put('picturesInput', $newPicturesInput);
				$result['status'] = 1;
				$result['message'] = t('Your picture has been reorder successfully');
			}
		}
		
		return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
	}
}
