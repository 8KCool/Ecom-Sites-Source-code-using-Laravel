<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.optimization.cache_expiration');
}
if (config('settings.listing.display_mode') == '.grid-view') {
	$colDescBox = 'col-sm-7';
	$colPriceBox = 'col-sm-3';
} else {
	$colDescBox = 'col-sm-7';
	$colPriceBox = 'col-sm-3';
}
$hideOnMobile = '';
if (isset($latestOptions, $latestOptions['hide_on_mobile']) and $latestOptions['hide_on_mobile'] == '1') {
	$hideOnMobile = ' hidden-sm';
}
?>
@if (isset($latest) && !empty($latest) && $latest->posts->count() > 0)
	<div class="container {{ $hideOnMobile }}">
	    <div style="padding-top: 50px;padding-left: 4px;" id="homepage" class="inner ocultar-phone1 enable-long-words col-xl-12">
						<h2><span class="title-2">Destaques</span></h2>
						<span class="sell-your-item" style="font-size: 13px;right: 1px;top: 42px;"><a href="https://paiaki.com/page/destaque" rel="nofollow" target="_blank">Quer vender mais rápido? Destaque seu anúncio</a></span> 
					</div>
                <div style="margin-bottom: 10px;margin-top: 20px" id="homepage" class="inner ocultar-pc2 col-xl-12">
							<span style="margin-left:-9px;font-size: 25px;font-weight: 500;">Destaques </span>
					</div>
		<div style="padding-left: 0px;" class="col-xl-12 layout-section">
			<div class="row-featured row-featured-category">
        		<div id="postsList" class="adds-wrapper row no-margin make-grid">
					@foreach($latest->posts as $key => $post)
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
								<div class="col-sm-2 col-12 no-padding photobox">
									<div class="add-image">
									    <!-- Entregas ao domicilio -->
											@if (!empty($post->tags))
												<?php $tags = array_map('trim', explode(',', $post->tags)); ?>
												@if (!empty($tags))
																<span class="photo-count"><svg width="16px" height="16px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="css-1eqb88w"><path d="M21 15.999h-.343A3.501 3.501 0 0 0 17.5 14a3.501 3.501 0 0 0-3.156 1.997l-4.687.002A3.5 3.5 0 0 0 6.5 14a3.5 3.5 0 0 0-3.158 2L3 16.002V5h11v6l1 1h6v3.999zM17.5 19c-.827 0-1.5-.673-1.5-1.5s.673-1.5 1.5-1.5 1.5.673 1.5 1.5-.673 1.5-1.5 1.5zm-11 0c-.827 0-1.5-.673-1.5-1.5S5.673 16 6.5 16s1.5.673 1.5 1.5S7.327 19 6.5 19zm12-12 2.25 3H16V7h2.5zm1-2H16V4l-1-1H2L1 4v13.002l1.001 1 1.039-.001A3.503 3.503 0 0 0 6.5 21a3.502 3.502 0 0 0 3.46-3l4.08-.003A3.503 3.503 0 0 0 17.5 21a3.502 3.502 0 0 0 3.46-3.001H22l1-1V9.665L19.5 5z" fill="#002f34" fill-rule="evenodd"></path></svg> </span>
												@endif
											@endif
										<a rel="nofollow" href="{{ \App\Helpers\UrlGen::post($post) }}">
											<img class="img-thumbnail no-margin" src="{{ $postImg }}" title="{{ $post->title }}" alt="{{ $post->title }}">
										</a>
									</div>
								</div>
								<div class="col-sm-7 col-12 add-desc-box">
									<div style="padding-left:1px;padding-right:1px;" class="items-details">
									    <span style="font-size: 11px;" class="info-row ocultar-phone1">
												<span title="Anúncio em destaque" class="date"><i style="font-size: 11px;color: #838383!important;" class="fas fa-globe-africa"></i> Patrocinado
												</span>
										</span>
										<span style="font-size: 10px;" class="info-row ocultar-pc2">
												<span title="Anúncio em destaque" class="date"><i style="font-size: 9px;color: #838383!important;" class="fas fa-globe-africa"></i> Patrocinado
												</span>
										</span>

											<a rel="nofollow" style="font-size:13px;" class="add-title info-row" href="{{ \App\Helpers\UrlGen::post($post) }}">{{ \Illuminate\Support\Str::limit($post->title, 70) }}</a>
									
										<span class="info-row">
											<span class="item-location">
												<a rel="nofollow" href="{!! \App\Helpers\UrlGen::city($post->city) !!}" class="info-link">
													{{ $post->city->name }}
												</a>
												{{ (isset($post->distance)) ? '- ' . round($post->distance, 2) . getDistanceUnit() : '' }}
											</span>
										</span>
										<span style="display:none!important;" class="category"> {{ (!empty($post->category->parent)) ? $post->category->parent->name : $post->category->name }} </span>
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
					@endforeach
			
					<div style="clear: both"></div>
				</div>
				
						<div class="text-center" style="margin-top:25px;margin-bottom:60px;">
							<a rel="nofollow" style="font-size:17px; font-weight:800;" href="/search">
							 Ver todos anúncios <img title="Paiaki Angola" alt="Paiaki Angola" width="18" height="18" style="height: 18px!important;" src="public/images/seta2.svg">
							</a>
						</div>
				
				<div class="text-left m-l-0">
									<div class="sitepopularbox__item sitepopularbox__item--searches overh brtop-1 pding15_0">
                            <h3 class="lheight16 c73 fbold inline">Pesquisas populares:</h3>
                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=ps4&location=&l=&r=" class="link gray2 tunder"><span>PS4</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Fifa&location=&l=&r=" title="Dyson" class="link gray2 tunder"><span>Fifa</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Arrenda&location=&l=&r=" title="Arrenda" class="link gray2 tunder"><span>Arrenda</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=i10&location=&l=&r=" title="i10" class="link gray2 tunder"><span>i10</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Bicicleta&location=&l=&r=" title="Bicicleta" class="link gray2 tunder"><span>Bicicleta</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Bmw&location=&l=&r=" title="Bmw" class="link gray2 tunder"><span>Bmw</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Mercedes&location=&l=&r=" title="Mercedes" class="link gray2 tunder"><span>Mercedes</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Autocarro&location=&l=&r=" title="Autocaravanas usadas" class="link gray2 tunder"><span>Autocarros usadas</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Elantra&location=&l=&r=" title="Elantra" class="link gray2 tunder"><span>Elantra</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Piscina&location=&l=&r=" title="Piscina" class="link gray2 tunder"><span>Piscina</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Kia+Rio&location=&l=&r=" title="Caravana" class="link gray2 tunder"><span>Kia Rio</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Fatos&location=&l=&r=" title="Fatos" class="link gray2 tunder"><span>Fatos</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Sofas&location=&l=&r=" title="Sofas" class="link gray2 tunder"><span>Sofas</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Computador&location=&l=&r=" title="Computador" class="link gray2 tunder"><span>Computador</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=iPhone&location=&l=&r=" title="iPhone" class="link gray2 tunder"><span>iPhone</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Memoria+RAM&location=&l=&r=" title="Memória RAM" class="link gray2 tunder"><span>Memória RAM</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Vivenda&location=&l=&r=" title="Vivenda" class="link gray2 tunder"><span>Vivenda</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Apartamento&location=&l=&r=" title="Apartamento" class="link gray2 tunder"><span>Apartamento</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/location/luanda/11" title="Luanda" class="link gray2 tunder"><span>Luanda</span></a>,                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Sapato&location=Luanda&l=11&r=" title="Sapato" class="link gray2 tunder"><span>Sapato, </span></a>   
                                                            
                                                            <a rel="nofollow" href="https://paiaki.com/category/moda/roupa" title="Roupas de mulheres" class="link gray2 tunder"><span>Roupas de mulheres, </span></a>     
                                                            
                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Relogios&location=&l=&r=" title="Relógios" class="link gray2 tunder"><span>Relógios, </span></a>
                                                            
                                                            <a rel="nofollow" href="https://paiaki.com/search?c=&q=Jeep&location=&l=&r=" title="Jeep" class="link gray2 tunder"><span>Jeep, </span></a> 
                                                            
                                                             <a rel="nofollow" href="https://paiaki.com/search?c=&q=Range+Rover&location=&l=&r=" title="Range Rover" class="link gray2 tunder"><span>Range Rover, </span></a>  
                                                             
                                                              <a rel="nofollow" href="https://paiaki.com/search?c=&q=condom%C3%ADnio&location=&l=&r=" title="Casas no condominio" class="link gray2 tunder"><span>Casas no condominio</span></a> 
                                                            
                                                            </div>
 
                                                            </div>
					
					  <div class="sitepopularbox__item--searches overh brtop-1 pding15_0">
                        <h3 class="lheight16 c73 fbold inline">Categorias populares:</h3>
                                                   <a rel="nofollow" href="https://paiaki.com/category/carros/hyundai" class="link gray2 tunder"><span>Carros Hyundai</span></a>,   <a rel="nofollow" href="https://paiaki.com/category/telemoveis" title="Telemóveis e Tablets em Angola" class="link gray2 tunder"><span>Telemóveis e Tablets</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/ferramentas" title="Angola Classificados Paiaki" class="link gray2 tunder"><span>Equipamentos e Ferramentas</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/moda" title="Moda em Angola" class="link gray2 tunder"><span>Moda e Beleza</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/eletronicos" title="Eletrónicos e Tecnologia em Angola" class="link gray2 tunder"><span>Eletrónicos e Tecnologia</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/lazer" title="Lazer em Angola" class="link gray2 tunder"><span>Lazer e Desporto</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/servicos" title="Serviços em Portugal" class="link gray2 tunder"><span>Serviços</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/animais" title="Animais em Angola" class="link gray2 tunder"><span>Animais</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/moda" title="Moda em Angola" class="link gray2 tunder"><span>Moda</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/mobilias" title="Móveis, Casa e Jardim em Angola" class="link gray2 tunder"><span>Móveis e Mobilias</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/eletronicos/electronica" title="Tecnologia em Angola" class="link gray2 tunder"><span>Electronicos</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/veiculos/" title="Carros, motos e barcos em Angola" class="link gray2 tunder"><span>Carros, Motos e Barcos</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/imoveis/" title="Imóveis em Angola" class="link gray2 tunder"><span>Imóveis e Casas</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/empregos" title="Emprego em Angola" class="link gray2 tunder"><span>Emprego</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/eletronicos/videojogos-consolas/" title="Consolas em Portugal" class="link gray2 tunder"><span>Consolas</span></a>,                                                    <a rel="nofollow" href="https://paiaki.com/category/outras-vendas/" title="Outras Vendas em Portugal" class="link gray2 tunder"><span>Outras Vendas</span></a>                                            </div>
							</div>
			</div>
		</div>
	</div>
@endif

<style>
.photo-count {
    background: #fff!important;
    border: 0 none;
    border-radius: 50%;
    opacity: inherit;
    padding: 3px 4px;
    position: absolute;
    right: 21px;
    top: 18px;
}

@media (max-width: 1017px){.photo-count {
    background: #fff!important;
    border: 0 none;
    border-radius: 50%;
    opacity: inherit;
    padding: 3px 4px;
    position: absolute;
    right: 11px;
    top: 8px;
}}
.add-image {border-radius: 4px 4px 0px 0px!important;}
.img-thumbnail {border-radius: 0px;}
@media (max-width: 1017px){ .img-thumbnail {border-radius: 4px 4px 0px 0px!important;}}
@media (max-width: 1017px){ .add-image a img {border-radius: 4px 4px 0px 0px!important;}}
@media (min-width: 1020px){.add-image {padding: 12px;background: white;}}
@media (min-width: 1020px){.make-grid .item-list .add-desc-box {
    padding: 10px 13px;padding-top: 0px;}}
.fbold {font-weight: 500!important;font-size: 14px;}
.inline {display: inline;}
.wrapper .sitepopularbox__wrapper {text-align: left;width: 1238px;font-size: 12px;margin-right: auto;margin-left: auto;padding-right: 24px;padding-left: 24px;}
.sitepopularbox__item {flex: 1;border-top: none;padding: 0;font-size: 14px;line-height: 24px;}
.pding15_0 {padding: 15px 0px;}
.overh {overflow: hidden;}
.homepage .wrapper .homepage .sitepopularbox__wrapper .homepage .sitepopularbox__wrapper .offersview .wrapper .offersview .offersview .offersview .sitepopularbox__wrapper .offersview .sitepopularbox__wrapper .detailpage .wrapper .detailpage .detailpage .detailpage .sitepopularbox__wrapper .detailpage .sitepopularbox__wrapper {
    width: 1029px;}
.homepage .wrapper, .homepage .homepage .sitepopularbox__wrapper .homepage .sitepopularbox__wrapper {
    position: relative;}
.sitepopularbox__wrapper {
    display: flex;}
.wrapper .sitepopularbox__wrapper {
    text-align: left;
    width: 1238px;
    font-size: 12px;
    margin-right: auto;
    margin-left: auto;
    padding-right: 24px;
    padding-left: 24px;}
</style>

@section('after_scripts')
    @parent
    <script>
		/* Default view (See in /js/script.js) */
		@if (isset($posts) && count($posts) > 0)
			@if (config('settings.listing.display_mode') == '.grid-view')
				gridView('.grid-view');
			@endif
		@endif
		
		/* Save the Search page display mode */
		var listingDisplayMode = readCookie('listing_display_mode');
		if (!listingDisplayMode) {
			createCookie('listing_display_mode', '{{ config('settings.listing.display_mode', '.grid-view') }}', 7);}
		
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