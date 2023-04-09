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

namespace App\Helpers\Search;

use App\Helpers\DBTool;
use App\Helpers\Search\Traits\Filters;
use App\Helpers\Search\Traits\GroupBy;
use App\Helpers\Search\Traits\Having;
use App\Helpers\Search\Traits\OrderBy;
use App\Helpers\Search\Traits\Relations;
use App\Helpers\Search\Traits\Select;
use App\Models\Post;
use App\Models\PostType;
use Illuminate\Support\Facades\DB;

class PostQueries
{
	use Select, Relations, Filters, GroupBy, Having, OrderBy;
	
	protected static $cacheExpiration = 300; // 5mn (60s * 5)
	
	public $country;
	public $lang;
	public $perPage = 12;
	
	// Pre-Search Objects
	public $cat = null;
	public $city = null;
	public $admin = null;
	
	// Default Columns Selected
	protected $select = [];
	protected $groupBy = [];
	protected $having = [];
	protected $orderBy = [];
	
	protected $posts;
	protected $postsTable;
	
	// 'queryStringKey' => ['name' => 'column', 'order' => 'direction']
	public $orderByParametersFields = [];
	
	/**
	 * PostQueries constructor.
	 *
	 * @param array $preSearch
	 */
	public function __construct($preSearch = [])
	{
		// Pre-Search
		if (isset($preSearch['cat']) && !empty($preSearch['cat'])) {
			$this->cat = $preSearch['cat'];
		}
		if (isset($preSearch['city']) && !empty($preSearch['city'])) {
			$this->city = $preSearch['city'];
		}
		if (isset($preSearch['admin']) && !empty($preSearch['admin'])) {
			$this->admin = $preSearch['admin'];
		}
		
		// Entries per page
		$perPage = config('settings.listing.items_per_page');
		if (is_numeric($perPage) && $perPage > 1 && $perPage <= 60) {
			$this->perPage = $perPage;
		}
		
		// Init. Builder
		$this->posts = Post::query();
		$this->postsTable = (new Post())->getTable();
		
		// Add Default Select Columns
		$this->setSelect();
		
		// Relations
		$this->setRelations();
	}
	
	/**
	 * Get the results
	 *
	 * @return array
	 */
	public function fetch()
	{
		// Apply Requested Filters
		$this->applyFilters();
		
		// Apply Aggregation & Reorder Statements
		$this->applyGroupBy();
		$this->applyHaving();
		$this->applyOrderBy();
		
		if (config('settings.single.show_post_types')) {
			// Get Count PostTypes Results
			$count = $this->countFetch();
		}
		
		// Get Results
		$posts = $this->posts->paginate((int)$this->perPage);
		
		// Use the current URL in the pagination
		// $posts->setPath(request()->url());
		
		// Remove Distance from Request
		$this->removeDistanceFromRequest();
		
		// Get Count Results
		if (config('settings.single.show_post_types')) {
			$count['all'] = $posts->total();
			if (request()->filled('type') && isset($count[request()->get('type')])) {
				$total = 0;
				foreach ($count as $typeId => $countItems) {
					if ($typeId == request()->get('type')) {
						continue;
					}
					$total += $countItems;
				}
				$count['all'] = $total;
			}
		} else {
			$count = collect(['all' => $posts->total()]);
		}
		
		// Results Data
		$data = [
			'posts' => $posts,
			'count' => collect($count),
		];
		
		return $data;
	}
	
	/**
	 * Count the results
	 *
	 * @return array
	 */
	private function countFetch()
	{
		$count = [];
		
		// Count entries by post type
		$postTypes = PostType::orderBy('name')->get();
		if ($postTypes->count() > 0) {
			$pattern = '/`post_type_id`[\s]*=[\s]*[0-9\']+[\s]+/ui';
			foreach ($postTypes as $postType) {
				$iPosts = clone $this->posts;
				
				$sql = DBTool::getRealSql($iPosts->toSql(), $iPosts->getBindings());
				
				if (preg_match($pattern, $sql)) {
					$sql = preg_replace($pattern, '`post_type_id` = ' . $postType->id . ' ', $sql);
				} else {
					$iPosts->where('post_type_id', $postType->id);
					$sql = DBTool::getRealSql($iPosts->toSql(), $iPosts->getBindings());
				}
				
				$iPostsSql = 'SELECT COUNT(*) AS total FROM (' . $sql . ') AS x';
				$iPostsRes = self::execute($iPostsSql);
				
				$count[$postType->id] = (isset($iPostsRes[0])) ? $iPostsRes[0]->total : 0;
			}
		}
		
		return $count;
	}
	
	/**
	 * @param $sql
	 * @param array $bindings
	 * @return array|null
	 */
	private static function execute($sql, $bindings = [])
	{
		try {
			$result = DB::select(DB::raw($sql), $bindings);
		} catch (\Exception $e) {
			$result = null;
			
			// DEBUG
			// dd($e->getMessage());
		}
		
		return $result;
	}
}
