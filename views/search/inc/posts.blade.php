<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.optimization.cache_expiration');
}
?>
@if (isset($posts) && $posts->total() > 0)
	<?php
	if (!isset($cats)) {
		$cats = collect([]);
	}

	foreach($posts->items() as $key => $post):
		if (empty($post->city)) continue;
		
		// Main Picture
		if ($post->pictures->count() > 0) {
			$postImg = imgUrl($post->pictures->get(0)->filename, 'medium');
		} else {
			$postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
		}
	?>
	
	<?php
		$boxClass = ($post->featured == 1) ? '' : '';
	?>
	
	<div class="item-list">
		@if ($post->featured == 1)
				<div class="cornerRibbons orange">
					<a rel="nofollow" target="_blank" href="https://paiaki.com/page/destaque">Destaque</a>
				</div>
		@endif
		
		<div class="row {{ $boxClass }}">
			<div class="col-sm-2 col-12 no-padding photobox">
				<div class="add-image"> <!-- Entregas ao domicilio -->
											@if (!empty($post->tags))
												<?php $tags = array_map('trim', explode(',', $post->tags)); ?>
												@if (!empty($tags))
																<span class="photo-count"><svg width="16px" height="16px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="css-1eqb88w"><path d="M21 15.999h-.343A3.501 3.501 0 0 0 17.5 14a3.501 3.501 0 0 0-3.156 1.997l-4.687.002A3.5 3.5 0 0 0 6.5 14a3.5 3.5 0 0 0-3.158 2L3 16.002V5h11v6l1 1h6v3.999zM17.5 19c-.827 0-1.5-.673-1.5-1.5s.673-1.5 1.5-1.5 1.5.673 1.5 1.5-.673 1.5-1.5 1.5zm-11 0c-.827 0-1.5-.673-1.5-1.5S5.673 16 6.5 16s1.5.673 1.5 1.5S7.327 19 6.5 19zm12-12 2.25 3H16V7h2.5zm1-2H16V4l-1-1H2L1 4v13.002l1.001 1 1.039-.001A3.503 3.503 0 0 0 6.5 21a3.502 3.502 0 0 0 3.46-3l4.08-.003A3.503 3.503 0 0 0 17.5 21a3.502 3.502 0 0 0 3.46-3.001H22l1-1V9.665L19.5 5z" fill="#002f34" fill-rule="evenodd"></path></svg> </span>
												@endif
											@endif
				    
					<a rel="nofollow" href="{{ \App\Helpers\UrlGen::post($post) }}">
						<img style="border-radius: 4px 4px 0px 0px;" class="img-thumbnail no-margin" src="{{ $postImg }}" title="{{ $post->title }}" alt="{{ $post->title }}">
					</a>
				</div>
			</div>
	
			<div class="col-sm-7 col-12 add-desc-box">
				<div class="items-details">
					<a rel="nofollow" style="font-size:13px;" class="add-title info-row" href="{{ \App\Helpers\UrlGen::post($post) }}">{{ \Illuminate\Support\Str::limit($post->title, 70) }}</a>
					
					<span class="info-row">
						@if (!config('settings.listing.hide_dates'))
							<span class="date"{!! (config('lang.direction')=='rtl') ? ' dir="rtl"' : '' !!}>
								{!! $post->created_at_formatted !!}
							</span><br>
						@endif
						<span style="display:none!important;" class="category">
							{{ (!empty($post->category->parent)) ? $post->category->parent->name : $post->category->name }}
							</span>
						<span class="item-location"{!! (config('lang.direction')=='rtl') ? ' dir="rtl"' : '' !!}>
							<a rel="nofollow" href="{!! \App\Helpers\UrlGen::city($post->city, null, $cat ?? null) !!}" class="info-link">
								{{ $post->city->name }}
							</a> {{ (isset($post->distance)) ? '- ' . round($post->distance, 2) . getDistanceUnit() : '' }}
						</span>
					</span>
					
					<span style="font-weight: 500!important;font-size: 13px;" class="item-price flex-wrap">
										@if (isset($post->category, $post->category->type))
											@if (!in_array($post->category->type, ['not-salable']))
												@if (is_numeric($post->price) && $post->price > 0)
													{!! \App\Helpers\Number::money($post->price) !!}
												@elseif(is_numeric($post->price) && $post->price == 0)
													{!! t('free_as_price') !!}
												@else
												{{ 'Contacte' }}
												@endif
											@endif
										@else
											{{ 'Contacte' }}
										@endif
										
										<a rel="nofollow" style="font-size: 15px;color: #a2b1b9;" class="make-favorite cobertura" id="{{ $post->id }}" href="javascript:void(0)">
															@if (auth()->check())
																@if (isset($post->savedByLoggedUser) && $post->savedByLoggedUser->count() > 0)
																	<i class="fa fa-heart tooltipHere"  title="Remover dos favoritos"></i>
																@else
																	<i class="far fa-heart" class="tooltipHere" title="Guardar anúncio"></i>
																@endif
															@else
																<i class="far fa-heart" class="tooltipHere" title="Guardar anúncio"></i>
															@endif
										</a>
											
									</span>
					
				</div>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
@else
	<div class="p-4" style="width: 100%;background: #f7f7f7;margin-top: 40px;">
		{{ t('no_result_refine_your_search') }} </br> <p style="font-weight: 400!important;font-size: 14px;">Escreva de forma correcta ou tente procurar através das categorias de anúncios.</p>
	</div>
@endif

@section('after_scripts')
	@parent
	<script>
		/* Default view (See in /js/script.js) */
		@if ($count->get('all') > 0)
			@if (config('settings.listing.display_mode') == '.grid-view')
				gridView('.grid-view');
			@elseif (config('settings.listing.display_mode') == '.list-view')
				listView('.list-view');
			@elseif (config('settings.listing.display_mode') == '.compact-view')
				compactView('.compact-view');
			@else
				gridView('.grid-view');
			@endif
		@else
			listView('.list-view');
		@endif
		/* Save the Search page display mode */
		var listingDisplayMode = readCookie('listing_display_mode');
		if (!listingDisplayMode) {
			createCookie('listing_display_mode', '{{ config('settings.listing.display_mode', '.grid-view') }}', 7);
		}
		
		/* Favorites Translation */
		var lang = {
			labelSavePostSave: "{!! t('Save ad') !!}",
			labelSavePostRemove: "{!! t('Remove favorite') !!}",
			loginToSavePost: "{!! t('Please log in to save the Ads') !!}",
			loginToSaveSearch: "{!! t('Please log in to save your search') !!}",
			confirmationSavePost: "{!! t('Post saved in favorites successfully') !!}",
			confirmationRemoveSavePost: "{!! t('Post deleted from favorites successfully') !!}",
			confirmationSaveSearch: "{!! t('Search saved successfully') !!}",
			confirmationRemoveSaveSearch: "{!! t('Search deleted successfully') !!}"
		};
	</script>
@endsection
