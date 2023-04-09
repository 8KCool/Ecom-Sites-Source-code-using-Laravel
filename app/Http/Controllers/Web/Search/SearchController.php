<?php

namespace App\Http\Controllers\Web\Search;

use App\Helpers\Search\PostQueries;
use Torann\LaravelMetaTags\Facades\MetaTag;

class SearchController extends BaseController
{
	public $isIndexSearch = true;
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		view()->share('isIndexSearch', $this->isIndexSearch);
		
		// Search
		$data = (new PostQueries($this->preSearch))->fetch();
		
		// Get Titles
		$title = $this->getTitle();
		$this->getBreadcrumb();
		$this->getHtmlTitle();
		$keywords = getMetaTag('keywords', 'home');
		
		// Meta Tags
		$title = $this->getTitle() .' - Paiaki';
		MetaTag::set('title', $title);
		MetaTag::set('description', $title);
		
		// Open Graph
		$this->og->image(asset('images/Bannercover.png'));
		
		return appView('search.results', $data);
	}
}
