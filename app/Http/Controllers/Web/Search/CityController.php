<?php

namespace App\Http\Controllers\Web\Search;

use App\Helpers\Search\PostQueries;
use Torann\LaravelMetaTags\Facades\MetaTag;

class CityController extends BaseController
{
	public $isCitySearch = true;
	
	/**
	 * City URL
	 * Pattern: (countryCode/)free-ads/city-slug/ID
	 *
	 * @param $countryCode
	 * @param $citySlug
	 * @param null $cityId
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index($countryCode, $citySlug, $cityId = null)
	{
		// Check if City is found
		if (empty($this->city)) {
			abort(404, t('city_not_found'));
		}
		
		// Search
		$data = (new PostQueries($this->preSearch))->fetch();
		
		// Get Titles
		$bcTab = $this->getBreadcrumb();
		$htmlTitle = $this->getHtmlTitle();
		$keywords = getMetaTag('keywords', 'home');
		view()->share('bcTab', $bcTab);
		view()->share('htmlTitle', $htmlTitle);
		
		// Meta Tags
		$title = 'Compre e venda em '. $this->city->name . ' no Paiaki';
		$description = t('ads_in_location', ['location' => $this->city->name])
			. ', ' . config('country.name')
			. '. ' . t('looking_for_product_or_service')
			. ' - ' . $this->city->name
			. ', ' . config('country.name');
		MetaTag::set('keywords', $keywords);
		
		MetaTag::set('title', $title);
		MetaTag::set('description', $description);
		
		// Open Graph
		$this->og->image(asset('images/Bannercover.png'));
		
		return appView('search.results', $data);
	}
}
