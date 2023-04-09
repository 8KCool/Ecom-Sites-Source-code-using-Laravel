<?php
// Clear Filter Button
$clearFilterBtn = \App\Helpers\UrlGen::getCityFilterClearLink($cat ?? null, $city ?? null);
?>
<?php
/*
 * Check if the City Model exists in the Cities eloquent collection
 * If it doesn't exists in the collection,
 * Then, add it into the Cities eloquent collection
 */
if (
	isset($cities, $city)
	&& $cities instanceof \Illuminate\Database\Eloquent\Collection
	&& $city instanceof \App\Models\City
	&& !$cities->contains($city)
) {
	$cities->push($city);
}
?>
<!-- City -->
<div class="block-title sidebar-header">
	<h5>
		<span class="font-weight-bold">
			{{ t('locations') }}
		</span> {!! $clearFilterBtn !!}
	</h5>
</div>
<div class="block-content list-filter locations-list">
	<ul class="browse-list list-unstyled long-list">
		@if (isset($cities) && $cities->count() > 0)
			@foreach ($cities as $iCity)
				<li>
					@if ((isset($city) && !empty($city) && $city->id == $iCity->id) || (request()->input('l') == $iCity->id))
						<strong>
							<a rel="nofollow" href="{!! \App\Helpers\UrlGen::city($iCity, null, $cat ?? null) !!}" title="{{ $iCity->name }}">
								{{ $iCity->name }}
								
							</a>
						</strong>
					@else
						<a rel="nofollow" href="{!! \App\Helpers\UrlGen::city($iCity, null, $cat ?? null) !!}" title="{{ $iCity->name }}">
							{{ $iCity->name }}
							
						</a>
					@endif
				</li>
			@endforeach
		@endif
	</ul>
</div>
<div style="clear:both"></div>