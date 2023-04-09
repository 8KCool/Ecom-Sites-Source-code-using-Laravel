<?php
// Clear Filter Button
$clearFilterBtn = \App\Helpers\UrlGen::getCategoryFilterClearLink($cat ?? null, $city ?? null);
?>
@if (isset($cat) and !empty($cat))
	<?php
	$catParentUrl = \App\Helpers\UrlGen::getCatParentUrl($cat->parent ?? null, $city ?? null);
	?>
	
	<!-- SubCategory -->
	<div id="subCatsList">
		@if (isset($cat->children) && $cat->children->count() > 0)
			
			<div class="block-title sidebar-header">
				<h5>
				<span class="font-weight-bold">
					@if (isset($cat->parent) && !empty($cat->parent))
						<a rel="nofollow" href="{{ \App\Helpers\UrlGen::category($cat->parent, null, $city ?? null) }}">
							<i class="fas fa-chevron-left"></i> {{ $cat->parent->name }}
						</a>
					@else
						<a rel="nofollow" href="{{ $catParentUrl }}">
							<i class="fas fa-chevron-left"></i> {{ t('all_categories') }}
						</a>
					@endif
				</span> {!! $clearFilterBtn !!}
				</h5>
			</div>
			<div class="block-content list-filter categories-list">
				<ul class="list-unstyled">
					<li>
						<a rel="nofollow" href="{{ \App\Helpers\UrlGen::category($cat, null, $city ?? null) }}" title="{{ $cat->name }}">
							<span class="title font-weight-bold">{{ $cat->name }}</span>
							@if (config('settings.listing.count_categories_posts'))
								<span class="count">&nbsp;({{ $countPostsByCat->get($cat->id)->total ?? 0 }})</span>
							@endif
						</a>
						<ul class="list-unstyled long-list">
							@foreach ($cat->children as $iSubCat)
								<li>
									<a rel="nofollow" href="{{ \App\Helpers\UrlGen::category($iSubCat, null, $city ?? null) }}" title="{{ $iSubCat->name }}">
										{{ \Illuminate\Support\Str::limit($iSubCat->name, 100) }}
										@if (config('settings.listing.count_categories_posts'))
											<span class="count">({{ $countPostsByCat->get($iSubCat->id)->total ?? 0 }})</span>
										@endif
									</a>
								</li>
							@endforeach
						</ul>
					</li>
				</ul>
			</div>
			
		@else
			
			@if (isset($cat->parent, $cat->parent->children) && $cat->parent->children->count() > 0)
				<div class="block-title sidebar-header">
					<h5>
						<span class="font-weight-bold">
							@if (isset($cat->parent->parent) && !empty($cat->parent->parent))
								<a rel="nofollow" href="{{ \App\Helpers\UrlGen::category($cat->parent->parent, null, $city ?? null) }}">
									<i class="fas fa-chevron-left"></i> {{ $cat->parent->parent->name }}
								</a>
							@elseif (isset($cat->parent) && !empty($cat->parent))
								<a rel="nofollow" href="{{ \App\Helpers\UrlGen::category($cat->parent, null, $city ?? null) }}">
									<i class="fas fa-chevron-left"></i> {{ $cat->parent->name }}
								</a>
							@else
								<a rel="nofollow" href="{{ $catParentUrl }}">
									<i class="fas fa-chevron-left"></i> {{ t('all_categories') }}
								</a>
							@endif
						</span> {!! $clearFilterBtn !!}
					</h5>
				</div>
				<div class="block-content list-filter categories-list">
					<ul class="list-unstyled">
						@foreach ($cat->parent->children as $iSubCat)
							<li>
								@if ($iSubCat->id == $cat->id)
									<strong>
										<a rel="nofollow" href="{{ \App\Helpers\UrlGen::category($iSubCat, null, $city ?? null) }}" title="{{ $iSubCat->name }}">
											{{ \Illuminate\Support\Str::limit($iSubCat->name, 100) }}
											@if (config('settings.listing.count_categories_posts'))
												<span class="count">({{ $countPostsByCat->get($iSubCat->id)->total ?? 0 }})</span>
											@endif
										</a>
									</strong>
								@else
									<a rel="nofollow" href="{{ \App\Helpers\UrlGen::category($iSubCat, null, $city ?? null) }}" title="{{ $iSubCat->name }}">
										{{ \Illuminate\Support\Str::limit($iSubCat->name, 100) }}
										@if (config('settings.listing.count_categories_posts'))
											<span class="count">({{ $countPostsByCat->get($iSubCat->id)->total ?? 0 }})</span>
										@endif
									</a>
								@endif
							</li>
						@endforeach
					</ul>
				</div>
			@else
				
				@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.sidebar.categories.root', 'search.inc.sidebar.categories.root'])
			
			@endif
			
		@endif
	</div>
	
@else
	
	@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.sidebar.categories.root', 'search.inc.sidebar.categories.root'])
	
@endif
<div style="clear:both"></div>