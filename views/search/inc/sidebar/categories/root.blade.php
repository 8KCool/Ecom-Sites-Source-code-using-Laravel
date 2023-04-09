<!-- Category -->
<div id="catsList">
	<div class="block-title sidebar-header">
		<h5>
			<span class="font-weight-bold">
				{{ t('all_categories') }}
			</span> {!! $clearFilterBtn ?? '' !!}
		</h5>
	</div>
	<div class="block-content list-filter categories-list">
		<ul class="list-unstyled">
			@if (isset($cats) && $cats->count() > 0)
				@foreach ($cats as $iCat)
					<li>
						@if (isset($cat) && !empty($cat) && $iCat->id == $cat->id)
							<strong>
								<a rel="nofollow" href="{{ \App\Helpers\UrlGen::category($iCat, null, $city ?? null) }}" title="{{ $iCat->name }}">
									<span class="title">{{ $iCat->name }}</span>
									@if (config('settings.listing.count_categories_posts'))
										<span class="count">({{ $countPostsByCat->get($iCat->id)->total ?? 0 }})</span>
									@endif
								</a>
							</strong>
						@else
							<a rel="nofollow" href="{{ \App\Helpers\UrlGen::category($iCat, null, $city ?? null) }}" title="{{ $iCat->name }}">
								<span class="title">{{ $iCat->name }}</span>
								@if (config('settings.listing.count_categories_posts'))
									<span class="count">({{ $countPostsByCat->get($iCat->id)->total ?? 0 }})</span>
								@endif
							</a>
						@endif
					</li>
				@endforeach
			@endif
		</ul>
	</div>
</div>