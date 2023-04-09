<?php

namespace App\Http\Controllers\Web;

use App\Helpers\ArrayHelper;
use App\Helpers\UrlGen;
use App\Models\Post;
use App\Models\Category;
use App\Models\HomeSection;
use App\Models\SubAdmin1;
use App\Models\City;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Torann\LaravelMetaTags\Facades\MetaTag;

class HomeController extends FrontController
{
	/**
	 * HomeController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$data = [];
		$countryCode = config('country.code');
		
		// Get all homepage sections
		$cacheId = $countryCode . '.homeSections';
		$data['sections'] = Cache::remember($cacheId, $this->cacheExpiration, function () use ($countryCode) {
			$sections = collect();
			
			// Check if the Domain Mapping plugin is available
			if (config('plugins.domainmapping.installed')) {
				try {
					$sections = \extras\plugins\domainmapping\app\Models\DomainHomeSection::where('country_code', $countryCode)->orderBy('lft')->get();
				} catch (\Exception $e) {
				}
			}
			
			// Get the entry from the core
			if ($sections->count() <= 0) {
				$sections = HomeSection::orderBy('lft')->get();
			}
			
			return $sections;
		});
		
		$searchFormOptions = [];
		if ($data['sections']->count() > 0) {
			foreach ($data['sections'] as $section) {
				// Clear method name
				$method = str_replace(strtolower($countryCode) . '_', '', $section->method);
				
				// Check if method exists
				if (!method_exists($this, $method)) {
					continue;
				}
				
				// Call the method
				try {
					if (isset($section->value)) {
						$this->{$method}($section->value);
					} else {
						$this->{$method}();
					}
					
					// Get the search area background image
					if ($method == 'getSearchForm') {
						$searchFormOptions = $section->value;
					}
				} catch (\Exception $e) {
					flash($e->getMessage())->error();
					continue;
				}
			}
		}
		
		// Get SEO
		$this->setSeo($searchFormOptions);
		
		return appView('home.index', $data);
	}
	
	/**
	 * Get search form (Always in Top)
	 *
	 * @param array $value
	 */
	protected function getSearchForm($value = [])
	{
		view()->share('searchFormOptions', $value);
	}
	
	/**
	 * Get locations & SVG map
	 *
	 * @param array $value
	 */
	protected function getLocations($value = [])
	{
		// Get the default Max. Items
		$maxItems = 14;
		if (isset($value['max_items'])) {
			$maxItems = (int)$value['max_items'];
		}
		
		// Get the Default Cache delay expiration
		$cacheExpiration = $this->getCacheExpirationTime($value);
		
		// Modal - States Collection
		$cacheId = config('country.code') . '.home.getLocations.modalAdmins';
		$modalAdmins = Cache::remember($cacheId, $cacheExpiration, function () {
			return SubAdmin1::currentCountry()->orderBy('name')->get(['code', 'name'])->keyBy('code');
		});
		view()->share('modalAdmins', $modalAdmins);
		
		// Get cities
		if (config('settings.listing.count_cities_posts')) {
			$cacheId = config('country.code') . 'home.getLocations.cities.withCountPosts';
			$cities = Cache::remember($cacheId, $cacheExpiration, function () use ($maxItems) {
				return City::currentCountry()->withCount('posts')->take($maxItems)->orderByDesc('population')->orderBy('name')->get();
			});
		} else {
			$cacheId = config('country.code') . 'home.getLocations.cities';
			$cities = Cache::remember($cacheId, $cacheExpiration, function () use ($maxItems) {
				return City::currentCountry()->take($maxItems)->orderByDesc('population')->orderBy('name')->get();
			});
		}
		$cities = collect($cities)->push(ArrayHelper::toObject([
			'id'             => 0,
			'name'           => t('More cities') . ' &raquo;',
			'subadmin1_code' => 0,
		]));
		
		// Get cities number of columns
		$numberOfCols = 4;
		if (file_exists(config('larapen.core.maps.path') . strtolower(config('country.code')) . '.svg')) {
			if (isset($value['show_map']) && $value['show_map'] == '1') {
				$numberOfCols = (isset($value['items_cols']) && !empty($value['items_cols'])) ? (int)$value['items_cols'] : 3;
			}
		}
		
		// Chunk
		$maxRowsPerCol = round($cities->count() / $numberOfCols, 0); // PHP_ROUND_HALF_EVEN
		$maxRowsPerCol = ($maxRowsPerCol > 0) ? $maxRowsPerCol : 1;  // Fix array_chunk with 0
		$cities = $cities->chunk($maxRowsPerCol);
		
		view()->share('cities', $cities);
		view()->share('citiesOptions', $value);
	}
	
	/**
	 * Get sponsored posts
	 *
	 * @param array $value
	 */
	protected function getSponsoredPosts($value = [])
	{
		$type = 'sponsored';
		
		// Get the default Max. Items
		$maxItems = 48;
		
		// Get the default orderBy value
		$orderBy = 'random';
		
		// Get the default Cache delay expiration
		$cacheExpiration = $this->getCacheExpirationTime($value);
		
		// Get featured posts
		$cacheId = config('country.code') . '.home.getPosts.' . $type;
		$posts = Cache::remember($cacheId, $cacheExpiration, function () use ($maxItems, $type, $orderBy) {
			return Post::getLatestOrSponsored($maxItems, $type, $orderBy);
		});
		
		$sponsored = null;
		if ($posts->count() > 0) {
			$sponsored = [
				'title' => t('Home - Sponsored Ads'),
				'link'  => UrlGen::search(),
				'posts' => $posts,
			];
			$sponsored = ArrayHelper::toObject($sponsored);
		}
		
		view()->share('featured', $sponsored);
		view()->share('featuredOptions', $value);
	}
	
	/**
	 * Get latest posts
	 *
	 * @param array $value
	 */
	protected function getLatestPosts($value = [])
	{
		$type = 'sponsored';
		
		// Get the default Max. Items
		$maxItems = 48;
		
		// Get the default orderBy value
		$orderBy = 'random';

		// Get the Default Cache delay expiration
		$cacheExpiration = $this->getCacheExpirationTime($value);
		
		// Get latest posts
		$cacheId = config('country.code') . '.home.getPosts.' . $type;
		$posts = Cache::remember($cacheId, $cacheExpiration, function () use ($maxItems, $type, $orderBy) {
			return Post::getLatestOrSponsored($maxItems, $type, $orderBy);
		});
		
		$latest = null;
		if (!empty($posts)) {
			$latest = [
				'title' => t('Home - Latest Ads'),
				'link'  => UrlGen::search(),
				'posts' => $posts,
			];
			$latest = ArrayHelper::toObject($latest);
		}
		
		view()->share('latest', $latest);
		view()->share('latestOptions', $value);
	}
	
	/**
	 * Get list of categories
	 *
	 * @param array $value
	 */
	protected function getCategories($value = [])
	{
		// Get the default Max. Items
		$maxItems = null;
		if (isset($value['max_items'])) {
			$maxItems = (int)$value['max_items'];
		}
		
		// Number of columns
		$numberOfCols = 3;
		
		// Get the Default Cache delay expiration
		$cacheExpiration = $this->getCacheExpirationTime($value);
		
		$cacheId = 'categories.parents.' . config('app.locale') . '.take.' . $maxItems;
		
		if (isset($value['type_of_display']) && in_array($value['type_of_display'], ['cc_normal_list', 'cc_normal_list_s'])) {
			
			$categories = Cache::remember($cacheId, $cacheExpiration, function () {
				$categories = Category::orderBy('lft')->get();
				
				return $categories;
			});
			$categories = collect($categories)->keyBy('id');
			$categories = $subCategories = $categories->groupBy('parent_id');
			
			if ($categories->has(null)) {
				if (!empty($maxItems)) {
					$categories = $categories->get(null)->take($maxItems);
				} else {
					$categories = $categories->get(null);
				}
				$subCategories = $subCategories->forget(null);
				
				$maxRowsPerCol = round($categories->count() / $numberOfCols, 0, PHP_ROUND_HALF_EVEN);
				$maxRowsPerCol = ($maxRowsPerCol > 0) ? $maxRowsPerCol : 1;
				$categories = $categories->chunk($maxRowsPerCol);
			} else {
				$categories = collect();
				$subCategories = collect();
			}
			
			view()->share('categories', $categories);
			view()->share('subCategories', $subCategories);
			
		} else {
			
			$categories = Cache::remember($cacheId, $cacheExpiration, function () use ($maxItems) {
				if (!empty($maxItems)) {
					$categories = Category::where(function ($query) {
						$query->where('parent_id', 0)->orWhereNull('parent_id');
					})->take($maxItems)->orderBy('lft')->get();
				} else {
					$categories = Category::where(function ($query) {
						$query->where('parent_id', 0)->orWhereNull('parent_id');
					})->orderBy('lft')->get();
				}
				
				return $categories;
			});
			
			if (isset($value['type_of_display']) && $value['type_of_display'] == 'c_picture_icon') {
				$categories = collect($categories)->keyBy('id');
			} else {
				// $maxRowsPerCol = round($categories->count() / $numberOfCols, 0); // PHP_ROUND_HALF_EVEN
				$maxRowsPerCol = ceil($categories->count() / $numberOfCols);
				$maxRowsPerCol = ($maxRowsPerCol > 0) ? $maxRowsPerCol : 1; // Fix array_chunk with 0
				$categories = $categories->chunk($maxRowsPerCol);
			}
			
			view()->share('categories', $categories);
			
		}
		
		// Count Posts by category (if the option is enabled)
		$countPostsByCat = collect();
		if (config('settings.listing.count_categories_posts')) {
			$cacheId = config('country.code') . '.count.posts.by.cat.' . config('app.locale');
			$countPostsByCat = Cache::remember($cacheId, $cacheExpiration, function () {
				$countPostsByCat = Category::countPostsByCategory();
				
				return $countPostsByCat;
			});
		}
		view()->share('countPostsByCat', $countPostsByCat);
		
		// Export the Options
		view()->share('categoriesOptions', $value);
	}
	
	/**
	 * Get mini stats data
	 *
	 * @param array $value
	 */
	protected function getStats($value = [])
	{
		// Count posts
		$countPosts = Post::currentCountry()->unarchived()->count();
		
		// Count cities
		$countCities = City::currentCountry()->count();
		
		// Count users
		$countUsers = User::count();
		
		// Share vars
		view()->share('countPosts', $countPosts);
		view()->share('countCities', $countCities);
		view()->share('countUsers', $countUsers);
		
		// Export the Options
		view()->share('statsOptions', $value);
	}
	
	/**
	 * Set SEO information
	 *
	 * @param array $searchFormOptions
	 */
	protected function setSeo($searchFormOptions = [])
	{
		$title = getMetaTag('title', 'home');
		$description = getMetaTag('description', 'home');
		$keywords = getMetaTag('keywords', 'home');
		
		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', strip_tags($description));
		MetaTag::set('keywords', $keywords);
		
		// Open Graph
		$this->og->title($title)->description($description);
		$this->og->image(asset('images/Bannercover.png'));
		
		view()->share('og', $this->og);
	}
	
	/**
	 * @param array $value
	 * @return int
	 */
	private function getCacheExpirationTime($value = [])
	{
		// Get the default Cache Expiration Time
		$cacheExpiration = 0;
		if (isset($value['cache_expiration'])) {
			$cacheExpiration = (int)$value['cache_expiration'];
		}
		
		return $cacheExpiration;
	}
}
