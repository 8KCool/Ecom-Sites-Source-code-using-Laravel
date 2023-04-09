
@extends('layouts.master')

@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
	<div class="main-container">
		<div class="container">
			<div class="row">

				@if (session()->has('flash_notification'))
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif

				<div class="col-md-12 page-content ocultar-phone1">
                   <h2 class="title-5"> Minhas pesquisas guardadas </h2>
                 <div style="background: white;border-bottom: 45px solid #f2f4f5;margin-top: -25px;padding-bottom: 0px;" class="ocultar-phone1 inner-box">
					@includeFirst([config('larapen.core.customizedViewPath') . 'account.inc.sidebar', 'account.inc.sidebar'])
				</div></div>

				<div style="padding-bottom: 150px!important;" class="col-md-12 page-content">
					<div class="page-content">
						<h2 class="title-2 ocultar-pc2"> Minhas pesquisas guardadas </h2>
						
							@if (!isset($savedSearch) || $savedSearch->getCollection()->count() <= 0)
								<div class="col-md-12">
									<div style="padding-top: 20px;" class="text-center mb30">
										<span style="font-size: 18px; font-weight: 500;">À procura de alguma coisa? Guarde uma pesquisa.</span></br></br>
<span style="font-size: 15px; font-weight: 400;">É aqui que vão aparecer os anúncios relacionados com as tuas pesquisas guardadas.</span></br>
<a href="https://paiaki.com/search" class="promover" style="padding: 10px;margin-top: 20px;display: inline-block;font-weight: 800!important;"> <i class="far fa-heart" title="Guardar pesquisa"></i> Pesquise por qualquer coisa </a>
									</div>
								</div>
							@else
							
							<div class="page-content">
									<div style="background:#f2f4f5!important;" class="category-list make-grid">
										@if (isset($posts) and $posts->total() > 0)
											@foreach($posts->items() as $key => $post)
												@continue(empty($post->city))
												<?php
												// Main Picture
												if ($post->pictures->count() > 0) {
													$postImg = imgUrl($post->pictures->get(0)->filename, 'medium');
												} else {
													$postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
												}
												?>
												<div class="item-list">
													<div class="row">
														<div class="col-md-2 no-padding photobox">
															<div class="add-image">
																<a href="{{ \App\Helpers\UrlGen::post($post) }}">
																	<img class="img-thumbnail no-margin" src="{{ $postImg }}" style="    border-radius: 4px 4px 0 0;" alt="img">
																</a>
															</div>
														</div>
														
														<div style="background-color: #fff!important;" class="col-md-8 add-desc-box">
															<div class="items-details">
																<h5 class="add-title">
																	<a href="{{ \App\Helpers\UrlGen::post($post) }}">{{ $post->title }}</a>
																</h5>
																
																<span class="info-row">
																		<span class="date"> {!! $post->created_at_formatted !!}
																		</span><br>
																		
																<span class="item-location"{!! (config('lang.direction')=='rtl') ? ' dir="rtl"' : '' !!}>
							<a href="{!! \App\Helpers\UrlGen::city($post->city, null, $cat ?? null) !!}" class="info-link">
								{{ $post->city->name }}
							</a> {{ (isset($post->distance)) ? '- ' . round($post->distance, 2) . getDistanceUnit() : '' }}
						</span>
																</span>
																
																<h4 style="font-weight: 500!important;font-size: 13px;" class="item-price">
																@if (is_numeric($post->price) && $post->price > 0)
																	{!! \App\Helpers\Number::money($post->price) !!}
																@elseif (is_numeric($post->price) && $post->price == 0)
																	{!! ('Contacte') !!}
																@else
																	{!! ('Contacte') !!}
																@endif
															</h4>
																
															</div>
														</div>

															
														
													</div>
												</div>
											@endforeach
										@else
											
										@endif
									</div>
									
									<div style="clear:both;"></div>
									
									<nav class="pagination-bar mb-4" aria-label="">
										<?php
										if (isset($posts)) {
											echo $posts->appends(collect(request()->query())->map(function($item) {
												return is_null($item) ? '' : $item;
											})->toArray())->links();
										}
										?>
									</nav>
								</div>
								
								<div class="page-content">
									<ul class="list-group list-group-unstyle">
										@foreach ($savedSearch->items() as $search)
											<li class="list-group-item {{ (request()->get('q')==$search->keyword) ? 'active' : '' }}">
												<a href="{{ url('account/saved-search/?'.$search->query.'&pag='.request()->get('pag')) }}" class="">
													<span> {{ \Illuminate\Support\Str::limit(strtoupper($search->keyword), 20) }} </span>
													<span class="badge badge-pill badge-warning" id="{{ $search->id }}">{{ $search->count }}+</span>
												</a>
												<span class="delete-search-result">
													<a href="{{ url('account/saved-search/'.$search->id.'/delete') }}">&times;</a>
												</span>
											</li>
										@endforeach
									</ul>
									<div class="pagination-bar text-center">
										{{ (isset($savedSearch)) ? $savedSearch->links() : '' }}
									</div>
								</div>

							@endif
							
						
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<style>.list-inline {margin-bottom: -1px!important;} .user-panel-sidebar {background: #fff!important;} .row-featured-category {background: #ffffff!important;padding-left: 10px;} .user-panel-sidebar ul li a {background: #fff!important;}  @media screen and (min-width: 768px){.default-inner-box {padding: 27px!important;}} .card-header {padding: 0px; 
    margin-bottom: 20px;
    padding-bottom: 10px!important;}
.page-content .inner-box .title-2 {
    margin: 5px 0 -3px!important;
}
    .page-item.disabled .page-link {
    background-color: #f2f4f5!important;
    border-color: #f2f4f5!important;
}

.pagination-bar .pagination li a {
    color: #002f34!important;
    border-color: #f2f4f5!important;
    background: #f2f4f5!important;
}
.home-search {display:none!important;
</style>

@endsection

@section('after_scripts')
	<script>
		/* Default view (See in /js/script.js) */
		@if (isset($posts) and count($posts) > 0)
			listView('.grid-view');
		@endif
		/* Save the Search page display mode */
		var listingDisplayMode = readCookie('listing_display_mode');
		if (!listingDisplayMode) {
			createCookie('listing_display_mode', '{{ config('settings.listing.display_mode', '.grid-view') }}', 7);
		}
	</script>
	<!-- include footable   -->
	<script src="{{ url('assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
	<script src="{{ url('assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
	<script type="text/javascript">
        $(function () {
			$('#addManageTable').footable().bind('footable_filtering', function (e) {
				var selected = $('.filter-status').find(':selected').text();
				if (selected && selected.length > 0) {
					e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
					e.clear = !e.filter;
				}
			});

			$('.clear-filter').click(function (e) {
				e.preventDefault();
				$('.filter-status').val('');
				$('table.demo').trigger('footable_clear_filter');
			});

		});
	</script>
	<!-- include custom script for ads table [select all checkbox]  -->
	<script>
		function checkAll(bx) {
			var chkinput = document.getElementsByTagName('input');
			for (var i = 0; i < chkinput.length; i++) {
				if (chkinput[i].type == 'checkbox') {
					chkinput[i].checked = bx.checked;
				}
			}
		}
	</script>
@endsection
