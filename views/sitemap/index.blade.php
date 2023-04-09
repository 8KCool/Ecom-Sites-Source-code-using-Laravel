
@extends('layouts.master')

@section('search')
	@parent
@endsection

@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
	<div class="main-container inner-page">
	    

		<div class="container">
			<div class="section-content">
				<div class="row">

					@includeFirst([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'])
					
					<div class="col-xl-12">
					    
					    <div style="background: #f2f4f5!important;" class="inner-box relative">
						<h1 class="title-2">Mapa do site</h1>
					    
						<div class="content-box">
							<div class="row-featured-category">
								<div class="col-xl-12">
									<div class="list-categories-children styled">
										<div class="row">
											@foreach ($cats as $key => $col)
												<div class="col-md-4 col-sm-4 {{ (count($cats) == $key+1) ? 'last-column' : '' }}">
													@foreach ($col as $iCat)
														
														<?php
															$randomId = '-' . substr(uniqid(rand(), true), 5, 5);
														?>
														
														<div class="cat-list">
															<h3 style="font-weight: 500!important;" class="cat-title rounded">
																<a href="{{ \App\Helpers\UrlGen::category($iCat) }}">
																	{{ $iCat->name }} <span class="count"></span>
																</a>
																@if (isset($subCats) and $subCats->has($iCat->id))
																	<span class="btn-cat-collapsed collapsed"
																		  data-toggle="collapse"
																		  data-target=".cat-id-{{ $iCat->id . $randomId }}"
																		  aria-expanded="false"
																	>
																		<span class="icon-down-open-big"></span>
																	</span>
																@endif
															</h3>
															<ul class="cat-collapse collapse show cat-id-{{ $iCat->id . $randomId }} long-list-home">
																@if (isset($subCats) and $subCats->has($iCat->id))
																	@foreach ($subCats->get($iCat->id) as $iSubCat)
																		<li>
																			<a href="{{ \App\Helpers\UrlGen::category($iSubCat) }}">
																				{{ $iSubCat->name }}
																			</a>
																		</li>
																	@endforeach
																@endif
															</ul>
														</div>
													@endforeach
												</div>
											@endforeach
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
                 </div>
					@if (isset($cities))
						@includeFirst([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'])
						<div id="locais" class="col-xl-12">
							<div class="content-box mb-0">
								<div class="row-featured-category">
									<div class="col-xl-12 box-title">
										<div class="inner">
											<h2>
												<span class="title-3" style="font-weight: 500!important;">
													</i> Províncias de Angola
												</span>
											</h2>
										</div>
									</div>
									
									<div class="col-xl-12">
										<div class="list-categories-children">
											<div class="row">
												@foreach ($cities as $key => $cols)
													<ul class="cat-list col-lg-3 col-md-4 col-sm-6 {{ ($cities->count() == $key+1) ? 'cat-list-border' : '' }}">
														@foreach ($cols as $j => $city)
															<li>
																<a href="{{ \App\Helpers\UrlGen::city($city) }}" title="{{ t('Free Ads') }} {{ $city->name }}">
																	{{ $city->name }}
																</a>
															</li>
														@endforeach
													</ul>
												@endforeach
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					@endif

				</div>
				
			
			</div>
		</div>
		
	</div>
@endsection

<style>.cat-list h3, .title-3 {
    font-family: 'Geomanist', Arial, sans-serif !important;
    font-weight: 600!important;
    font-size: 16px!important;}
.row-featured-category .list-categories-children.styled .cat-list h3.cat-title {
    background-color: #f2f4f5!important;
    padding-top: 10px;
    padding-left: 0px!important;
    padding-right: 10px;
    margin-bottom: 8px;}
.home-search {display: none;}
.row-featured-category .list-categories-children.styled p.maxlist-more {
    margin-left: 0px!important;
    font-size: 11px;
    margin-top: -30px;}
</style>

@section('before_scripts')
	@parent
	<script>
		var maxSubCats = 15;
	</script>
@endsection
