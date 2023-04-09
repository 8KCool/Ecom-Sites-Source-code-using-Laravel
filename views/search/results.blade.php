
@extends('layouts.master')

@section('search')
	@parent
	@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.form', 'search.inc.form'])
@endsection

@section('content')
	<style>
	.photo-count {
    background: #fff!important;
    border: 0 none;
    border-radius: 50%;
    opacity: inherit;
    padding: 3px 4px;
    position: absolute;
    right: 10px;
    top: 7px;
}
.mobile-filter-bar {
    border-top: solid 1px #f2f4f5!important;
    border: solid 1px #f2f4f5!important;
}
.ocultar-tab {
    display: none!important;}
.sidebar-modern-inner .block-title h5 {margin-bottom: -12px!important;}
.ocultar-pesquisa {
    display: none!important;}
.save-search-bar {
    border-top: solid 1px #f2f4f5!important;}
.inline {display: inline;}
.wrapper .sitepopularbox__wrapper {
    text-align: left;
    width: 1238px;
    font-size: 12px;
    margin-right: auto;
    margin-left: auto;
    padding-right: 24px;
    padding-left: 24px;}
.sitepopularbox__item {
    flex: 1;
    border-top: none;
    padding: 0;
    font-size: 14px;
    line-height: 24px;}
.pding15_0 {padding: 15px 0px;}
.overh {overflow: hidden;}
 .sitepopularbox__item {
    flex: 1;
    border-top: none;
    padding: 0;
    font-size: 14px;
    line-height: 24px;}
.homepage .wrapper .homepage .sitepopularbox__wrapper .homepage .sitepopularbox__wrapper .offersview .wrapper .offersview .offersview .offersview .sitepopularbox__wrapper .offersview .sitepopularbox__wrapper .detailpage .wrapper .detailpage .detailpage .detailpage .sitepopularbox__wrapper .detailpage .sitepopularbox__wrapper {
    width: 1029px;}
.homepage .wrapper, .homepage .homepage .sitepopularbox__wrapper .homepage .sitepopularbox__wrapper {
    position: relative;}
.sitepopularbox__wrapper {display: flex;}
.wrapper .sitepopularbox__wrapper {
    text-align: left;
    width: 1238px;
    font-size: 12px;
    margin-right: auto;
    margin-left: auto;
    padding-right: 24px;
    padding-left: 24px;}
.promover {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 500;
    font-style: normal;
    line-height: 1.25;
    border: none;
    padding: 0 30px;
    height: 35px;
    cursor: pointer;
    -webkit-box-shadow: inset 0 0 0 2px #002f34;
    -moz-box-shadow: inset 0 0 0 2px #002f34;
    -ms-box-shadow: inset 0 0 0 2px #002f34;
    -o-box-shadow: inset 0 0 0 2px #002f34;
    box-shadow: inset 0 0 0 2px #002f34;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    -ms-border-radius: 4px;
    -o-border-radius: 4px;
    border-radius: 4px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -ms-box-sizing: border-box;
    -o-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    -ms-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;}
input:checked {border: 5px solid #002f34!important;}
input[type="radio" i] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    border: 2px solid #999;
    transition: 0.2s all linear;
    margin-top: 2px;}
input[type="checkbox" i] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 30%;
    width: 16px;
    height: 16px;
    border: 2px solid #999;
    transition: 0.2s all linear;
    margin-top: 2px;}
.search-row .search-col:first-child .form-control {
    border-radius: 5px!important;
    border-right: 1px solid #f9f9f9!important;}
.search-row .icon-append {
    color: #6d6d6d!important;}
.mobile-filter-bar {
    border: solid 0px #f2f4f5!important;
    border-top: solid 0px #f2f4f5!important;}
.dropdown-toggle::after {display: none!important;}
.fbold {font-weight: 500!important;font-size: 14px;} 
</style>

	<div class="main-container">
	
		@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.breadcrumbs', 'search.inc.breadcrumbs'])
		@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.categories', 'search.inc.categories'])
		@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
		
		<div class="container">
			<div class="row">

				<!-- Sidebar -->
                @if (config('settings.listing.left_sidebar'))
                    @includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.sidebar', 'search.inc.sidebar'])
                    <?php $contentColSm = 'col-md-9'; ?>
                @else
                    <?php $contentColSm = 'col-md-12'; ?>
                @endif

				<!-- Content -->
				<div class="col-md-9">
					<div class="category-list make-grid">
						<div class="tab-box">

							<!-- Nav tabs -->
							<ul id="postType" class="hidden-sm nav nav-tabs add-tabs tablist" role="tablist">
                                <?php
                                $liClass = 'class="nav-item"';
                                $spanClass = 'alert-danger';
								if (config('settings.single.show_post_types')) {
									if (!request()->filled('type') or request()->get('type') == '') {
										$liClass = 'class="nav-item active"';
										$spanClass = 'badge-danger';
									}
                                } else {
									$liClass = 'class="nav-item active"';
									$spanClass = 'badge-danger';
								}
                                ?>
								<li {!! $liClass !!}>
									<a rel="nofollow" href="{!! qsUrl(request()->url(), request()->except(['page', 'type']), null, false) !!}"
									   role="tab"
									   data-toggle="tab"
									   class="nav-link"
									>
										{{ t('All Ads') }} <span class="badge badge-pill {!! $spanClass !!}">{{ $count->get('all') }}</span>
									</a>
								</li>
								@if (config('settings.single.show_post_types'))
									@if (isset($postTypes) and $postTypes->count() > 0)
										@foreach ($postTypes as $postType)
											<?php
												$postTypeUrl = qsUrl(
													request()->url(),
													array_merge(request()->except(['page']), ['type' => $postType->id]),
													null,
													false
												);
												$postTypeCount = ($count->has($postType->id)) ? $count->get($postType->id) : 0;
											?>
											@if (request()->filled('type') && request()->get('type') == $postType->id)
												<li class="nav-item active">
													<a rel="nofollow" href="{!! $postTypeUrl !!}" role="tab" data-toggle="tab" class="nav-link">
														{{ $postType->name }}
														<span class="badge badge-pill badge-danger">
															{{ $postTypeCount }}
														</span>
													</a>
												</li>
											@else
												<li class="nav-item">
													<a rel="nofollow" href="{!! $postTypeUrl !!}" role="tab" data-toggle="tab" class="nav-link">
														{{ $postType->name }}
														<span class="badge badge-pill alert-danger">
															{{ $postTypeCount }}
														</span>
													</a>
												</li>
											@endif
										@endforeach
									@endif
								@endif
							</ul>
							
							<div class="tab-filter">
								<select id="orderBy" title="sort by" class="niceselecter select-sort-by" data-style="btn-select" data-width="auto">
									<option value="{!! qsUrl(request()->url(), request()->except(['orderBy', 'distance']), null, false) !!}">{{ t('Sort by') }}</option>
									<option{{ (request()->get('orderBy')=='priceAsc') ? ' selected="selected"' : '' }}
											value="{!! qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'priceAsc']), null, false) !!}">
										{{ t('price_low_to_high') }}
									</option>
									<option{{ (request()->get('orderBy')=='priceDesc') ? ' selected="selected"' : '' }}
											value="{!! qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'priceDesc']), null, false) !!}">
										{{ t('price_high_to_low') }}
									</option>
									@if (request()->filled('q'))
										<option{{ (request()->get('orderBy')=='relevance') ? ' selected="selected"' : '' }}
												value="{!! qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'relevance']), null, false) !!}">
											{{ t('Relevance') }}
										</option>
									@endif
									<option{{ (request()->get('orderBy')=='date') ? ' selected="selected"' : '' }}
											value="{!! qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'date']), null, false) !!}">
										{{ t('Date') }}
									</option>
									@if (isset($city, $distanceRange) and !empty($city) and !empty($distanceRange))
										@foreach($distanceRange as $key => $value)
											<option{{ (request()->get('distance', config('settings.listing.search_distance_default', 100))==$value) ? ' selected="selected"' : '' }}
													value="{!! qsUrl(request()->url(), array_merge(request()->except('distance'), ['distance' => $value]), null, false) !!}">
												{{ t('around_x_distance', ['distance' => $value, 'unit' => getDistanceUnit()]) }}
											</option>
										@endforeach
									@endif
								
										<option{{ (request()->get('orderBy')=='rating') ? ' selected="selected"' : '' }}
												value="https://paiaki.com/tag/entregas">
									Entregas ao domicílio
										</option>
								</select>
								
							</div>

						</div>

<?php
// Keywords
$keywords = rawurldecode(request()->get('q'));

?>
                <div style="margin-bottom: 20px;" class=" rounded-bottom ocultar-pc-maior">
				<div class="text-center">
					<div class="search-row">
						<form id="q" name="search" action="{{ \App\Helpers\UrlGen::search() }}" method="GET">
							<div class="row m-0">
								<div class="col-sm-12 col-12 search-col relative">
									<img title="Paiaki Angola" alt="Paiaki Angola"  class="lazyload" src="/images/pesquisa.svg" width="18px" style="position: absolute;top: 16px;left: 15px;">
									<input autocomplete="off" style="height: 50px!important;font-size: 15px;" type="text" name="q" class="form-control has-icon" placeholder="O que procuras?" value="{{ $keywords }}">
								</div>
							
							</div>
						</form>
					</div>
		           </div>
            	</div>
            	
            	<div style="margin-bottom: 0px;line-height: 0px;" class="mobile-filter-bar">
						   
						   	@if (config('settings.listing.left_sidebar'))
								<div style="margin-right: 6px;" class="botao-recente3 filter-toggle">
									<a rel="nofollow">
										{{ t('Filters') }} 
									</a><svg xmlns="http://www.w3.org/2000/svg" height="9" style="margin-left: 4px;" viewBox="0 0 24 24" width="10"><path fill="currentColor" d="M9.12601749,6 C9.57006028,4.27477279 11.1361606,3 13,3 C15.209139,3 17,4.790861 17,7 C17,9.209139 15.209139,11 13,11 C11.1361606,11 9.57006028,9.72522721 9.12601749,8 L2,8 L2,6 L9.12601749,6 Z M4.12601749,16 C4.57006028,14.2747728 6.13616057,13 8,13 C10.209139,13 12,14.790861 12,17 C12,19.209139 10.209139,21 8,21 C6.13616057,21 4.57006028,19.7252272 4.12601749,18 L2,18 L2,16 L4.12601749,16 Z M14,18 L14,16 L22,16 L22,18 L14,18 Z M8,19 C9.1045695,19 10,18.1045695 10,17 C10,15.8954305 9.1045695,15 8,15 C6.8954305,15 6,15.8954305 6,17 C6,18.1045695 6.8954305,19 8,19 Z M19,8 L19,6 L22,6 L22,8 L19,8 Z M13,9 C14.1045695,9 15,8.1045695 15,7 C15,5.8954305 14.1045695,5 13,5 C11.8954305,5 11,5.8954305 11,7 C11,8.1045695 11.8954305,9 13,9 Z"></path></svg>
								</div>
								@endif
								
								<div style="margin-right: 6px;" class="botao-recente3 filter-toggle">
									<a rel="nofollow">
										Categorias
									</a><svg xmlns="http://www.w3.org/2000/svg" height="9" style="margin-left: 4px;" viewBox="0 0 24 24" width="10"><path fill="currentColor" d="M9.12601749,6 C9.57006028,4.27477279 11.1361606,3 13,3 C15.209139,3 17,4.790861 17,7 C17,9.209139 15.209139,11 13,11 C11.1361606,11 9.57006028,9.72522721 9.12601749,8 L2,8 L2,6 L9.12601749,6 Z M4.12601749,16 C4.57006028,14.2747728 6.13616057,13 8,13 C10.209139,13 12,14.790861 12,17 C12,19.209139 10.209139,21 8,21 C6.13616057,21 4.57006028,19.7252272 4.12601749,18 L2,18 L2,16 L4.12601749,16 Z M14,18 L14,16 L22,16 L22,18 L14,18 Z M8,19 C9.1045695,19 10,18.1045695 10,17 C10,15.8954305 9.1045695,15 8,15 C6.8954305,15 6,15.8954305 6,17 C6,18.1045695 6.8954305,19 8,19 Z M19,8 L19,6 L22,6 L22,8 L19,8 Z M13,9 C14.1045695,9 15,8.1045695 15,7 C15,5.8954305 14.1045695,5 13,5 C11.8954305,5 11,5.8954305 11,7 C11,8.1045695 11.8954305,9 13,9 Z"></path></svg>
								</div>
						   
						   <div class="botao-recente3 dropdown">
										<a rel="nofollow" data-toggle="dropdown" class="dropdown-toggle">Ordenar</a><i style="margin-left: 5px;font-size: 9px;" class="fas fa-chevron-down"></i>
										<ul class="dropdown-menu">
											<li>
												<a rel="nofollow" href="{!! qsUrl(request()->url(), request()->except(['orderBy', 'distance']), null, false) !!}" rel="nofollow">
													{{ t('Sort by') }}
												</a>
											</li>
											<li>
												<a rel="nofollow" href="{!! qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'priceAsc']), null, false) !!}" rel="nofollow">
													{{ t('price_low_to_high') }}
												</a>
											</li>
											<li>
												<a rel="nofollow" href="{!! qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'priceDesc']), null, false) !!}" rel="nofollow">
													{{ t('price_high_to_low') }}
												</a>
											</li>
											@if (request()->filled('q'))
												<li>
													<a rel="nofollow" href="{!! qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'relevance']), null, false) !!}" rel="nofollow">
														{{ t('Relevance') }}
													</a>
												</li>
											@endif
											<li>
												<a rel="nofollow" href="{!! qsUrl(request()->url(), array_merge(request()->except('orderBy'), ['orderBy'=>'date']), null, false) !!}" rel="nofollow">
													{{ t('Date') }}
												</a>
											</li>
													<li>
														<a href="/tag/entregas" rel="nofollow">Entregas ao domicílio
														</a>
													</li>
										</ul>
									</div>

						</div>

                  <div style="margin-left:5px;padding-top: 7px;" class="ocultar-pc-maior">
									<a rel="nofollow" style="font-size: 16px;" href="https://paiaki.com/search" class="current"><span style="font-weight: 400!important;">{{ $count->get('all') }} anúncios encontrados</span></a><br>
									<p style="font-size: 12.5px;" class="current"></p>
								</div>
 
					<div class="hidden-sm listing-filter">
							<div class="pull-left col-xs-6">
								<div class="breadcrumb-list">
								</div>
								
                                <div style="clear:both;"></div>
							</div>

							<div style="clear:both"></div>
						</div>
					
						<!-- Mobile Filter Bar -->
						<div class="menu-overly-mask"></div>
						<!-- Mobile Filter bar End-->

						<div id="postsList" class="adds-wrapper row no-margin">
							@includeFirst([config('larapen.core.customizedViewPath') . 'search.inc.posts', 'search.inc.posts'])
						</div>

					<div class="tab-box save-search-bar text-center">
							@if (request()->filled('q') and request()->get('q') != '' and $count->get('all') > 0)
								<a rel="nofollow" class="promover" style="padding: 10px;margin-top: 20px;display: inline-block;font-weight: 800!important;" name="{!! qsUrl(request()->url(), request()->except(['_token', 'location']), null, false) !!}" id="saveSearch"
								   count="{{ $count->get('all') }}"> <i class="far fa-heart" title="Guardar pesquisa"></i>
									Guardar pesquisa
								</a>
							@endif
						</div>
					</div>
					
					<nav class="pagination-bar mb-5 pagination-sm" aria-label="">
						{!! $posts->appends(request()->query())->links() !!}
					</nav>

					<div style="margin-bottom:20px;" class="sitepopularbox__item sitepopularbox__item--searches overh brtop-1 pding15_0">
                            <h3 class="lheight16 c73 fbold inline">Pesquisas populares:</h3>
                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=ps4&location=&l=&r=" class="link gray2 tunder"><span>PS4</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Fifa&location=&l=&r=" title="Dyson" class="link gray2 tunder"><span>Fifa</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Arrenda&location=&l=&r=" title="Arrenda" class="link gray2 tunder"><span>Arrenda</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=i10&location=&l=&r=" title="i10" class="link gray2 tunder"><span>i10</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Bicicleta&location=&l=&r=" title="Bicicleta" class="link gray2 tunder"><span>Bicicleta</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Bmw&location=&l=&r=" title="Bmw" class="link gray2 tunder"><span>Bmw</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Mercedes&location=&l=&r=" title="Mercedes" class="link gray2 tunder"><span>Mercedes</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Autocarro&location=&l=&r=" title="Autocaravanas usadas" class="link gray2 tunder"><span>Autocarros usadas</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Elantra&location=&l=&r=" title="Elantra" class="link gray2 tunder"><span>Elantra</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Piscina&location=&l=&r=" title="Piscina" class="link gray2 tunder"><span>Piscina</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Kia+Rio&location=&l=&r=" title="Caravana" class="link gray2 tunder"><span>Kia Rio</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Fatos&location=&l=&r=" title="Fatos" class="link gray2 tunder"><span>Fatos</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Sofas&location=&l=&r=" title="Sofas" class="link gray2 tunder"><span>Sofas</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Computador&location=&l=&r=" title="Computador" class="link gray2 tunder"><span>Computador</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=iPhone&location=&l=&r=" title="iPhone" class="link gray2 tunder"><span>iPhone</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Memoria+RAM&location=&l=&r=" title="Memória RAM" class="link gray2 tunder"><span>Memória RAM</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Vivenda&location=&l=&r=" title="Vivenda" class="link gray2 tunder"><span>Vivenda</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Apartamento&location=&l=&r=" title="Apartamento" class="link gray2 tunder"><span>Apartamento</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/location/luanda/11" title="Luanda" class="link gray2 tunder"><span>Luanda</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Sapato&location=Luanda&l=11&r=" title="Sapato" class="link gray2 tunder"><span>Sapato, </span></a>   
                                                            
                                                            <a rel="nofollow" href="https://paiaki.com/category/moda/roupa" title="Roupas de mulheres" class="link gray2 tunder"><span>Roupas de mulheres, </span></a>     
                                                            
                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Relogios&location=&l=&r=" title="Relógios" class="link gray2 tunder"><span>Relógios, </span></a>
                                                            
                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Jeep&location=&l=&r=" title="Jeep" class="link gray2 tunder"><span>Jeep, </span></a> 
                                                            
                                                             <a rel="nofollow" href="https://paiaki.com/search?c=&q=Range+Rover&location=&l=&r=" title="Range Rover" class="link gray2 tunder"><span>Range Rover, </span></a>  
                                                             
                                                              <a rel="nofollow" href="https://paiaki.com/search?c=&q=condom%C3%ADnio&location=&l=&r=" title="Casas no condominio" class="link gray2 tunder"><span>Casas no condominio</span></a>   
                                                              </div>
					
					  <div class="sitepopularbox__item sitepopularbox__item--searches overh brtop-1 pding15_0">
                        <h3 class="lheight16 c73 fbold inline">Categorias populares:</h3>
                                                    <a rel="nofollow" href="https://paiaki.com/category/carros/hyundai" class="link gray2 tunder"><span>Carros Hyundai</span></a>,   <a rel="nofollow" href="https://paiaki.com/category/telemoveis" title="Telemóveis e Tablets em Angola" class="link gray2 tunder"><span>Telemóveis e Tablets</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/ferramentas" title="Angola Classificados Paiaki" class="link gray2 tunder"><span>Equipamentos e Ferramentas</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/moda" title="Moda em Angola" class="link gray2 tunder"><span>Moda e Beleza</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/eletronicos" title="Eletrónicos e Tecnologia em Angola" class="link gray2 tunder"><span>Eletrónicos e Tecnologia</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/lazer" title="Lazer em Angola" class="link gray2 tunder"><span>Lazer e Desporto</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/servicos" title="Serviços em Portugal" class="link gray2 tunder"><span>Serviços</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/animais" title="Animais em Angola" class="link gray2 tunder"><span>Animais</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/moda" title="Moda em Angola" class="link gray2 tunder"><span>Moda</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/mobilias" title="Móveis, Casa e Jardim em Angola" class="link gray2 tunder"><span>Móveis e Mobilias</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/eletronicos/electronica" title="Tecnologia em Angola" class="link gray2 tunder"><span>Electronicos</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/veiculos/" title="Carros, motos e barcos em Angola" class="link gray2 tunder"><span>Carros, Motos e Barcos</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/imoveis/" title="Imóveis em Angola" class="link gray2 tunder"><span>Imóveis e Casas</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/empregos" title="Emprego em Angola" class="link gray2 tunder"><span>Emprego</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/eletronicos/videojogos-consolas/" title="Consolas em Portugal" class="link gray2 tunder"><span>Consolas</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/outras-vendas/" title="Outras Vendas em Portugal" class="link gray2 tunder"><span>Outras Vendas</span></a>                                            </div>
					
					<div style="background: #f7f7f7; padding: 10px;" class="post-promo text-left">
						<h2 style="font-size: 12px;padding-bottom: 0px;";>Anunciar o teu negócio é grátis no Paiaki Angola.</br></h2>
						<h6 style="font-size: 12px;padding-bottom: 0px;";>O melhor site de compra e venda em Angola.</h6>
					</div>
					
					<div class="espaco"> </div>
    
    	    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4663353052124843"
     crossorigin="anonymous"></script>
<!-- PAIAKI HORIZONTAL -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-4663353052124843"
     data-ad-slot="4947098633"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>

				</div>
				
				<div style="clear:both;"></div>

			</div>
		</div>
	</div>
	
@endsection

@section('modal_location')
	@includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.modal.location', 'layouts.inc.modal.location'])
@endsection

@section('after_scripts')
	<script>
		$(document).ready(function () {
			$('#postType a').click(function (e) {
				e.preventDefault();
				var goToUrl = $(this).attr('href');
				redirect(goToUrl);
			});
			$('#orderBy').change(function () {
				var goToUrl = $(this).val();
				redirect(goToUrl);
			});
		});
		
		@if (config('settings.optimization.lazy_loading_activation') == 1)
		$(document).ready(function () {
			$('#postsList').each(function () {
				var $masonry = $(this);
				var update = function () {
					$.fn.matchHeight._update();
				};
				$('.item-list', $masonry).matchHeight();
				this.addEventListener('load', update, true);
			});
		});
		@endif
	</script>
@endsection