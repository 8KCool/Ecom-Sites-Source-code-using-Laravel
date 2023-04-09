<?php
if (
	config('settings.other.ios_app_url') ||
	config('settings.other.android_app_url') ||
	config('settings.social_link.facebook_page_url') ||
	config('settings.social_link.twitter_url') ||
	config('settings.social_link.google_plus_url') ||
	config('settings.social_link.linkedin_url') ||
	config('settings.social_link.pinterest_url') ||
	config('settings.social_link.instagram_url')
) {
	$colClass1 = 'col-lg-3 col-md-3 col-sm-3 col-xs-6';
	$colClass2 = 'col-lg-3 col-md-3 col-sm-3 col-xs-6';
	$colClass3 = 'col-lg-2 col-md-2 col-sm-2 col-xs-12';
	$colClass4 = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
} else {
	$colClass1 = 'col-lg-4 col-md-4 col-sm-4 col-xs-6';
	$colClass2 = 'col-lg-4 col-md-4 col-sm-4 col-xs-6';
	$colClass3 = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
	$colClass4 = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
}
?>
<footer class="main-footer">
	<div class="footer-content">
		<div class="container">
			<div class="row">
				
				@if (!config('settings.footer.hide_links'))
					<div class="{{ $colClass1 }}">
						<div class="footer-col">
							<h4 class="footer-title">Empresa</h4>
							<ul class="list-unstyled footer-nav">
							    <li><a rel="nofollow" title="Sobre o Paiaki" href="https://paiaki.com/page/sobre">Sobre o Paiaki</a></li>
							    	
							    	<li><a rel="nofollow" title="Anunciar e vender no Paiaki" href="https://paiaki.com/posts/create" target="_blank">Vender no Paiaki</a></li>
							    	
							    	<li><a rel="nofollow" title="Paiaki Ads" href="https://paiaki.com/contact" target="_blank">Publicitar no Paiaki</a></li>
							    	
							    	<li><a rel="nofollow" title="Blog Paiaki | Dicas para uma vida melhor" href="http://blog.paiaki.com" target="_blank">Blog do Paiaki</a></li>
							    	
								@if (isset($pages) and $pages->count() > 0)
									<li> <a rel="nofollow" href="https://paiaki.com/page/precos">Pacotes de Anúncios </a> </li>
									<li> <a rel="nofollow" href="https://paiaki.com/page/destaque">Pacotes de Destaques </a> </li>
									<li><a rel="nofollow" href="https://paiaki.com/page/marca">A marca Paiaki</a></li>
									<li><a rel="nofollow" href="https://paiaki.com/page/carreiras">Carreiras no Paiaki</a></li>
										<li><a rel="nofollow" href="https://paiaki.com/contact">Reportar erro</a></li>
								@endif 
								
							</ul>
						</div>
					</div>
					
					<div class="{{ $colClass2 }}">
						<div class="footer-col">
							<h4 class="footer-title">Informações</h4>
						<ul class="list-unstyled footer-nav">
						        <li> <a rel="nofollow" href="https://paiaki.com/page/funciona"> Como Funciona </a> </li>
							    <li><a rel="nofollow" href="https://paiaki.com/page/regulamento">Regulamentos</a></li>
							    <li><a rel="nofollow" href="https://paiaki.com/page/seguranca">Dicas de Segurança</a></li>
								<li><a href="{{ \App\Helpers\UrlGen::sitemap() }}"> Mapa do site </a></li>
								<li> <a rel="nofollow" rel="nofollow" href="https://paiaki.com/page/privicidade"> Política de Privacidade </a> </li>
								<li> <a rel="nofollow" href="https://paiaki.com/page/termos"> Termos e Condições </a> </li>
								<li><a rel="nofollow" class="ocultar-phone" href="/sitemap#locais"> Anúncios por localidade </a></li>
								<li><a rel="nofollow" href="{{ lurl(trans('contact')) }}">Contacto</a></li>
							</ul>
						</div>
					</div>
					
				<div class="{{ $colClass2 }} hidden-sm">
						<div class="footer-col">
							<h4 class="footer-title">Parceiros</h4>
											<ul class="list-unstyled ocultar-phone1 list-inline footer-nav footer-nav-inline">
												<li>
													<img alt="Policia Nacional de Angola" title="Policia Nacional de Angola" src="/images/pna.png" width="55" height="55">
												</li>
												<li>
													<img alt="Protecção Civil E Bombeiros Angola" title="Protecção Civil E Bombeiros Angola" src="/images/bombeiros22.png" width="50" height="50">
												</li>
											</ul>
						</div>
					</div>
					
					@if (
						config('settings.other.ios_app_url') or
						config('settings.other.android_app_url') or
						config('settings.social_link.facebook_page_url') or
						config('settings.social_link.twitter_url') or
						config('settings.social_link.google_plus_url') or
						config('settings.social_link.linkedin_url') or
						config('settings.social_link.pinterest_url') or
						config('settings.social_link.instagram_url')
						)
						<div class="{{ $colClass2 }}">
							<div class="footer-col row">
							    
								<?php
									$footerSocialClass = '';
									$footerSocialTitleClass = '';
								?>
								{{-- @todo: API Plugin --}}
								@if (config('settings.other.ios_app_url') or config('settings.other.android_app_url'))
									<div class="col-sm-12 col-xs-6 col-xxs-12 no-padding-lg">
										<div class="mobile-app-content">
											<h4 class="footer-title">{{ t('Mobile Apps') }}</h4>
											<div class="row ">
												@if (config('settings.other.ios_app_url'))
												<div class="col-xs-12 col-sm-6">
													<a rel="nofollow" class="app-icon" target="_blank" href="{{ config('settings.other.ios_app_url') }}">
														<span class="hide-visually">{{ t('iOS app') }}</span>
														<img src="{{ url('images/site/app-store-badge.svg') }}" alt="{{ t('Available on the App Store') }}">
													</a>
												</div>
												@endif
												@if (config('settings.other.android_app_url'))
												<div class="col-xs-12 col-sm-6">
													<a rel="nofollow" class="app-icon" target="_blank" href="{{ config('settings.other.android_app_url') }}">
														<span class="hide-visually">{{ t('Android App') }}</span>
														<img src="{{ url('images/site/google-play-badge.svg') }}" alt="{{ t('Available on Google Play') }}">
													</a>
												</div>
												@endif
											</div>
										</div>
									</div>
									<?php
										$footerSocialClass = 'hero-subscribe';
										$footerSocialTitleClass = 'no-margin';
									?>
								@endif
								
								@if (
									config('settings.social_link.facebook_page_url') or
									config('settings.social_link.twitter_url') or
									config('settings.social_link.google_plus_url') or
									config('settings.social_link.linkedin_url') or
									config('settings.social_link.pinterest_url') or
									config('settings.social_link.instagram_url')
									)
									<div class="col-sm-12 col-xs-6 col-xxs-12 no-padding-lg">
										<div class="{!! $footerSocialClass !!}">
											<h4 class="footer-title {!! $footerSocialTitleClass !!}">Siga-nos</h4>
											<ul style="margin-bottom:40px!important;">
												<li>
													<a style="margin-right: 10px;" rel="nofollow" target="_blank" href="https://facebook.com/paiakiangola" title="Facebook">
														<img alt="Facebook" title="Facebook" src="/images/Facebook.svg" width="24" height="24">
													</a>
													<a style="margin-right: 10px;" rel="nofollow" target="_blank" href="https://instagram.com/paiaki.angola" title="Instagram">
															<img alt="Instagram" title="Instagram" src="/images/Instgram.svg" width="24" height="24">
														</a>
														
															<a rel="nofollow" target="_blank" href="https://www.youtube.com/@paiakiangola3389" title="Instagram">
															<img alt="Instagram" title="Instagram" src="/images/youtube-svgrepo-com.svg" width="34" height="34">
														</a>
												</li>
											</ul>
										</div>
									</div>
								@endif
							</div>
						</div>
					@endif
					
					<div style="clear: both"></div>
				@endif
				
				<div class="col-xl-12">
				
						@if (!config('settings.footer.hide_links'))
							<hr>
						@endif
					
					<div class="copy-info text-center">
						© 2019 - {{ date('Y') }} Paiaki Angola - {{ t('all_rights_reserved') }}. </br>
						ANGOVITECH Platforms (SU) Lda. Luanda, Angola NIF: 5001277014
					</div>
					
					<div class="text-center" style="margin-top:10px;"><a target="_blank" href="https://www.angovitech.com/"><img alt="Powered by ANGOVITECH Platforms (SU) Lda." title="Powered by ANGOVITECH Platforms (SU) Lda." src="/images/angovitechlogo.svg" width="85"></a></div>
				</div>
			
			</div>
		</div>
	</div>
	
</footer>

<style>
.list-inline {
    margin-left: -11px;
}

.icone-footer {
    color: #f2f4f5!important;
    padding: 12px 15px!important;
    border-radius: 50%;
    background: #002f34!important;
}

@media (max-width: 980px){
.col-sm-3 {
    -ms-flex: 0 0 25%;
    flex: 0 0 100%;
    max-width: 100%;
}}
</style>
