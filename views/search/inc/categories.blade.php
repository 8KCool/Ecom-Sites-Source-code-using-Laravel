@if (isset($cat) && !empty($cat))
	@if (isset($cat->children) && $cat->children->count() > 0)
		
	@else
		@if (isset($cat->parent, $cat->parent->children) && $cat->parent->children->count() > 0)
			
		@else
			
			@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.categories-root', 'search.inc.categories-root'])
			
		@endif
	@endif
@else
	
	@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.categories-root', 'search.inc.categories-root'])
	
@endif
