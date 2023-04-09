<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.optimization.cache_expiration');
}
$hideOnMobile = '';
if (isset($featuredOptions, $featuredOptions['hide_on_mobile']) and $featuredOptions['hide_on_mobile'] == '1') {
	$hideOnMobile = ' hidden-sm';
}
?>
@if (isset($featured) and !empty($featured) and $featured->posts->count() > 0)
	<div class="container destaque-fundo">
	    <div style="margin-bottom: -17px; margin-top:-17px;" id="homepage" class="inner espaco ocultar-phone1 naoaqui"><h3><span class="title-3">Anúncio destacado</span></h3></div>
	    	<div style="margin-bottom: -17px; padding-top: 25px;"  class="naoaqui inner ocultar-pc2 col-xl-12">
						<h5>
							<span style="margin-left:-9px; font-weight: 400; font-size: 19px;">Anúncios destacados</span>
						</h5>
							<h6>
							<span style="margin-left:-9px; font-weight: 400; font-size: 19px;">Anúncios disponíveis</span>
						</h6>
					</div>
		<div style="padding-left: 5px;" class="col-xl-12 content-box layout-section">
			<div style="margin-top: -12px;" class="row row-featured row-featured-category">
				<div style="margin-bottom: -18px;" class="col-xl-12 box-title">
					<div class="inner">
						<h2>
							<a style="font-size: 18px;" href="{{ $featured->link }}" class="naoquero title-3">{!! $featured->title !!}</a>
						</h2>
						<span class="sell-your-item ocultar-phone1" style="font-size: 13px;right: 1px;top: 4px;"><a href="{{ $featured->link }}">Ver mais</a></span> 
					</div>
				</div>
				<div style="clear: both"></div>
				<div class="relative content featured-list-row clearfix">
					<div class="large-12 columns">
						<div class="no-margin featured-list-slider owl-carousel owl-theme">
							@foreach($featured->posts as $key => $post)
								<?php
									// Fixed 2
										if (!$countries->has($post->country_code)) continue;
								// Main Picture
								if ($post->pictures->count() > 0) {
									$postImg = imgUrl($post->pictures->get(0)->filename, 'medium');
								} else {
									$postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
								}
								?>
								<div class="item">
							@if ($post->featured == 1)
			@if (isset($post->latestPayment, $post->latestPayment->package) && !empty($post->latestPayment->package))
				@if ($post->latestPayment->package->ribbon != '')
				<div style="top: 15px!important;left: 13px!important;" class="cornerRibbons orange">
					<a target="_blank" href="https://paiaki.com/page/destaque">Destaque</a>
				</div>
				@endif
			@endif
		@endif
									<a href="{{ \App\Helpers\UrlGen::post($post) }}">
										<span class="item-carousel-thumb"> <!-- Entregas ao domicilio -->
											@if (!empty($post->tags))
												<?php $tags = array_map('trim', explode(',', $post->tags)); ?>
												@if (!empty($tags))
																<span class="photo-count"><svg width="16px" height="16px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="css-1eqb88w"><path d="M21 15.999h-.343A3.501 3.501 0 0 0 17.5 14a3.501 3.501 0 0 0-3.156 1.997l-4.687.002A3.5 3.5 0 0 0 6.5 14a3.5 3.5 0 0 0-3.158 2L3 16.002V5h11v6l1 1h6v3.999zM17.5 19c-.827 0-1.5-.673-1.5-1.5s.673-1.5 1.5-1.5 1.5.673 1.5 1.5-.673 1.5-1.5 1.5zm-11 0c-.827 0-1.5-.673-1.5-1.5S5.673 16 6.5 16s1.5.673 1.5 1.5S7.327 19 6.5 19zm12-12 2.25 3H16V7h2.5zm1-2H16V4l-1-1H2L1 4v13.002l1.001 1 1.039-.001A3.503 3.503 0 0 0 6.5 21a3.502 3.502 0 0 0 3.46-3l4.08-.003A3.503 3.503 0 0 0 17.5 21a3.502 3.502 0 0 0 3.46-3.001H22l1-1V9.665L19.5 5z" fill="#002f34" fill-rule="evenodd"></path></svg> </span>
												@endif
											@endif
											<img class="img-fluid" src="{{ $postImg }}" title="{{ $post->title }}" alt="{{ $post->title }}" style="margin-top: 2px;border-radius: 4px 4px 0px 0px;">
										</span>
										<div style="margin-top:-6px;" class="background-destaque">
										<span class="item-name add-title texto-resumo">{{ \Illuminate\Support\Str::limit($post->title, 50) }}</span>
										<span style="padding-top: 0px!important;padding-bottom: 0px!important;" class="info-row">
							<span style="text-align: left;" class="date">
								{!! $post->created_at_formatted !!}
							</span>
						<span style="text-align: left;" class="item-location">{{ $post->city->name }}
						</span>
					</span>
										<div style="font-weight: 500!important;font-size: 13px;text-align: left;padding-bottom: 7px;" class="price item-price flex-wrap">
											@if (isset($post->category, $post->category->type))
												@if (!in_array($post->category->type, ['not-salable']))
													@if (is_numeric($post->price) && $post->price > 0)
														{!! \App\Helpers\Number::money($post->price) !!}
													@elseif(is_numeric($post->price) && $post->price == 0)
														{!! 'Contacte' !!}
													@else
														{!! 'Contacte' !!}
													@endif
												@endif
											@else
												{{ 'Contacte' }}
											@endif
											<a style="font-size: 15px;color: #a2b1b9;margin-right: 6px!important;" class="make-favorite cobertura" id="{{ $post->id }}" href="javascript:void(0)">
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
										</div>
										</div>
									</a>
								</div>
							@endforeach
						</div>
					</div>
		
				</div>
			</div>
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
@endif

<style>	.photo-count {
    background: #fff!important;
    border: 0 none;
    border-radius: 50%;
    opacity: inherit;
    padding: 3px 4px;
    position: absolute;
    right: 14px;
    top: 15px;
}
.featured-list-slider .item{display:block;margin:0 auto;text-align:center}.featured-list-slider .item .price{color:#888}.featured-list-slider .item>a{display:block;border:none;}.featured-list-slider .item>a:hover{background:none;border:none;}.featured-list-slider .item .item-name{display:block;line-height:normal;color:#002f34;-webkit-transition:none;-moz-transition:none;-o-transition:none;transition:none;}.featured-list-slider .item:hover img{-webkit-transform:none;-o-transform:none;transform:none}.featured-list-slider .item:hover .item-name{-webkit-transform:none;-moz-transform:none;-o-transform:none;transform:none;}.featured-list-slider .item a img{width:100%;-webkit-transition:none;-moz-transition:none;-o-transition:none;transition:none;}
</style>

@section('after_style')
	@parent
@endsection

@section('before_scripts')
	@parent
	<script>
		/* Carousel Parameters */
		var carouselItems = {{ (isset($featured) and isset($featured->posts)) ? collect($featured->posts)->count() : 0 }};
		var carouselAutoplay = {{ (isset($featuredOptions) && isset($featuredOptions['autoplay'])) ? $featuredOptions['autoplay'] : 'false' }};
		var carouselAutoplayTimeout = {{ (isset($featuredOptions) && isset($featuredOptions['autoplay_timeout'])) ? $featuredOptions['autoplay_timeout'] : 1500000 }};
		var carouselLang = {
			'navText': {
				'prev': "{{ t('prev') }}",
				'next': "{{ t('next') }}"
			}
		};
	</script>
@endsection