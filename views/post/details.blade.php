@extends('layouts.master')

@section('content')
	{!! csrf_field() !!}
	<input type="hidden" id="postId" name="post_id" value="{{ $post->id }}">
	
	@if (session()->has('flash_notification'))
		@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
		<?php $paddingTopExists = true; ?>
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					@include('flash::message')
				</div>
			</div>
		</div>
		<?php session()->forget('flash_notification.message'); ?>
	@endif
	
	<div class="main-container">
	    
	    <?php if (isset($topAdvertising) and !empty($topAdvertising)): ?>
			@includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.top', 'layouts.inc.advertising.top'], ['paddingTopExists' => $paddingTopExists ?? false])
		<?php
			$paddingTopExists = false;
		endif;
		?>

		<div class="container">
		    
		    @if (auth()->check())
				@if (auth()->user()->id == $post->user_id)
			      @if ($post->featured==0)
				<div class="alert alert-warning"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Destaque este anúncio para aumentar a visibilidade e vender mais rápido: <a style="text-decoration: underline;font-weight:800!important;" href="{{ url('posts/' . $post->id . '/payment') }}">Destacar</a></div>
			     @endif 
		    @endif
		   @endif
	   
		<div class="ocultar-phone" style="margin-bottom:30px!important;"></div>
		  
			<div class="row ocultar-phone1">
				<div class="col-md-12">
					
					<nav aria-label="breadcrumb" role="navigation" class="pull-left">
						<ol class="breadcrumb">
						    <a style="margin-right:25px;" href="{{ rawurldecode(url()->previous()) }}"><i class="fas fa-chevron-left"></i> Voltar</a>
							@if (isset($catBreadcrumb) && is_array($catBreadcrumb) && count($catBreadcrumb) > 0)
								@foreach($catBreadcrumb as $key => $value)
									<li class="breadcrumb-item">
										<a href="{{ $value->get('url') }}">
											{!! $value->get('name') !!}
										</a>
									</li>
								@endforeach
							@endif
							<li class="breadcrumb-item active" aria-current="page">{{ \Illuminate\Support\Str::limit($post->title, 60) }}</li>
						</ol>
					</nav>
				
				</div>
			</div>
		</div>
		
		<div class="container">
			<div class="row">
				<div class="col-lg-9 page-content col-thin-right">
  
				    @if ($post->featured == 1)
				<div style="position: absolute;left: 38px;top: 22px;" class="cornerRibbons orange">
					<a target="_blank" href="https://paiaki.com/page/destaque">Destaque</a>
				</div>
		@endif
      
      <?php $picturesSlider = 'post.inc.pictures-slider.' . config('settings.single.pictures_slider', 'horizontal-thumb'); ?>
						@if (view()->exists($picturesSlider))
							@includeFirst([config('larapen.core.customizedViewPath') . $picturesSlider, $picturesSlider])
						@endif
						
					<div class="inner inner-box items-details-wrapper pb-0">
                    
						<div class="items-details">
							<div class="tab-content p-3 mb-3" id="itemsDetailsTabsContent">
							    <h1 style="padding-right: 76px; font-size: 20px;" class="enable-long-words col-xl-12">
								{{ \Illuminate\Support\Str::limit($post->title, 65) }}
							      <div style="padding-right: 0px;margin-top: -20px;display: block;" class="sell-your-item">
							          <p>
											<a style="font-size: 20px;" class="make-favorite cobertura" id="{{ $post->id }}" href="javascript:void(0)">
															@if (auth()->check())
																@if (\App\Models\SavedPost::where('user_id', auth()->user()->id)->where('post_id', $post->id)->count() > 0)
																	<i class="fa fa-heart tooltipHere"  title="Remover dos favoritos"></i>
																@else
																	<i class="far fa-heart" class="tooltipHere" title="Guardar anúncio"></i>
																@endif
															@else
																<i class="far fa-heart" class="tooltipHere" title="Guardar anúncio"></i>
															@endif
											</a>
									    </a>
									  </p>
                                  </div>
							    </h1>
							    
								<div class="tab-pane show active" id="item-details" role="tabpanel" aria-labelledby="item-details-tab">
									<div class="row">
										<div class="items-details-info col-md-12 col-sm-12 col-xs-12 enable-long-words from-wysiwyg">
											
											<div class="row">
				
											    @if (!in_array($post->category->type, ['not-salable']))
													<!-- Price / Salary -->
													<div class="detail-line-lite col-md-6 col-sm-6 col-xs-6">
														<div>
																<span style="font-size: 24px;font-weight: 500!important;">
																@if ($post->price > 0)
																	{!! \App\Helpers\Number::money($post->price) !!} 
																@else
																	{!! ('Contacte') !!}
																@endif
																@if ($post->negotiable == 1)
																	<small style="font-size: 13px; font-weight: 400!important;" class="label badge-success">{{ t('negotiable') }}</small>
																@endif
															</span>
														</div>
													</div>
												@endif
											 </div> 
												
					                    	<!-- Entrega ao domicilio -->
											@if (!empty($post->tags))
												<?php $tags = array_map('trim', explode(',', $post->tags)); ?>
												@if (!empty($tags))
													<span title="Disponível para entrega ao domicílio" class="entregas"> <svg width="1em" height="1em" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="css-1eqb88w"><path d="M21 15.999h-.343A3.501 3.501 0 0 0 17.5 14a3.501 3.501 0 0 0-3.156 1.997l-4.687.002A3.5 3.5 0 0 0 6.5 14a3.5 3.5 0 0 0-3.158 2L3 16.002V5h11v6l1 1h6v3.999zM17.5 19c-.827 0-1.5-.673-1.5-1.5s.673-1.5 1.5-1.5 1.5.673 1.5 1.5-.673 1.5-1.5 1.5zm-11 0c-.827 0-1.5-.673-1.5-1.5S5.673 16 6.5 16s1.5.673 1.5 1.5S7.327 19 6.5 19zm12-12 2.25 3H16V7h2.5zm1-2H16V4l-1-1H2L1 4v13.002l1.001 1 1.039-.001A3.503 3.503 0 0 0 6.5 21a3.502 3.502 0 0 0 3.46-3l4.08-.003A3.503 3.503 0 0 0 17.5 21a3.502 3.502 0 0 0 3.46-3.001H22l1-1V9.665L19.5 5z" fill="#002f34" fill-rule="evenodd"></path></svg> &nbsp;&nbsp;Entregas ao domicílio</span>
												@endif
											@endif
											
											<!-- Compra segura -->
											@if ($post->featured == 1)
													<span title="Vendedor de confiança" class="entregas"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1em" height="1em" color="currentColor"><path fill="#002f34" fill-rule="evenodd" d="M4 2.25h16A2.75 2.75 0 0122.75 5v6c0 5.937-4.813 10.75-10.75 10.75A10.75 10.75 0 011.25 11V5A2.75 2.75 0 014 2.25zm0 1.5c-.69 0-1.25.56-1.25 1.25v6a9.25 9.25 0 0018.5 0V5c0-.69-.56-1.25-1.25-1.25H4zm4.53 5.72L12 12.94l3.47-3.47a.75.75 0 011.06 1.06l-4 4a.75.75 0 01-1.06 0l-4-4a.75.75 0 011.06-1.06z"></path></svg> &nbsp;&nbsp;Compra segura</span>
											@endif
											
											<hr>
											<!-- Description -->
											<div class="row">
											<div class="col-xl-12">
				                                  <h4 style="font-weight: 800!important;margin-bottom: 15px;" >Descrição: </h4>
		                                    </div>
												<div class="col-12 detail-line-content">{!! transformDescription($post->description) !!}</br></br>
												</div>
											</div>
											
												<span style="display:none!important;"> 
Nota: Paiaki é o maior site moderno de anúncios classificados online em Angola para utilizadores particulares e profissionais, que conecta as pessoas para comprar, vender, leiloar ou trocar produtos e serviços de maneira rápida, simples e segura. Startup fundada por Vicente Brás Zau em 11 de fevereiro de 2019 e lançada oficialmente em 11 de Julho de 2019, marca registada pela empresa KUMBUNET LDA, NIF: 5000151238.

Com o Paiaki, as pessoas podem vender produtos que já não querem ou comprar outros que pretendem. À disposição dos usuários, tem várias categorias e pode-se também filtrar a pesquisa por localização, marcas, preço e entre outros.

O Paiaki tem como missão criar ligações perfeitas entre compradores e vendedores, num espaço de confiança e seguro e é com essa missão em mente que a nossa equipa trabalha todos os dias. 

A plataforma proporciona-lhe uma forma simples, rápida e fácil de vender, em qualquer dia da semana, a qualquer hora, esteja onde estiver sem precisar de intermediários singulares. Nunca antes foi tão fácil comprar ou vender casas, carros, telemóveis, computadores, animais ou qualquer outra coisa em Angola. E porque é fácil vender, encontrará certamente boas oportunidades para comprar tudo o que precisa. No Paiaki encontra também ofertas de emprego ou serviços.

O Paiaki é também um espaço virtual de encontro de vendedores e compradores, sem qualquer interferência no processo de negociação entre ambas as partes, porém a negociação é realizada diretamente entre o comprador e o vendedor sem comissões à plataforma.

  O Paiaki é um marketplace C2C. Mas o que isso significa? Basta imaginar que seria como um shopping center online, um local onde diferentes vendedores disponibilizam diversos produtos para serem vendidos. Porém, com transações feitas de consumidor para consumidor, o tal “C2C”. Para quem procura comprar, a vantagem é a grande variedade de ofertas no mesmo destino; para quem busca vender, é poder conectar-se a diferentes pessoas interessadas no que você pode oferecer. Paiaki é o maior site moderno de anúncios classificados online em Angola para utilizadores particulares e profissionais, que conecta as pessoas para comprar, vender, leiloar ou trocar produtos e serviços de maneira rápida, simples e segura. Startup fundada por Vicente Brás Zau em 11 de fevereiro de 2019 e lançada oficialmente em 11 de Julho de 2019, marca registada pela empresa KUMBUNET LDA, NIF: 5000151238. 
  
  O Paiaki tem como missão criar ligações perfeitas entre compradores e vendedores, num espaço de confiança e seguro e é com essa missão em mente que a nossa equipa trabalha todos os dias. No Paiaki, podes comprar e vender uma grande variedade de coisas.

O Paiaki proporciona-lhe uma forma simples, rápida e fácil de vender, em qualquer dia da semana, a qualquer hora, esteja onde estiver sem precisar de intermediários singulares. Nunca antes foi tão fácil comprar ou vender casas, carros, telemóveis, computadores, animais ou qualquer outra coisa em Angola. E porque é fácil vender, encontrará certamente boas oportunidades para comprar tudo o que precisa. No Paiaki encontra também ofertas de emprego ou serviços.</span>
												
		<!-- Custom Fields -->
											@includeFirst([config('larapen.core.customizedViewPath') . 'post.inc.fields-values', 'post.inc.fields-values'])
										</div>
										<br>&nbsp;<br>
									</div>
								</div>
								
								@if (isset($customFields) and $customFields->count() > 0)
	                                <div class="ocultar-phone1 text-center" id="cfContainer">
				                    @foreach($customFields as $field)
					            	@if (!is_array($field->default_value) and $field->type != 'video')
						           	@if ($field->type == 'url')
											<a style=" padding-left: 40px; padding-right: 40px; " class="btn btn-default" href="{{ addHttp($field->default_value) }}" target="_blank" rel="nofollow">Candidatar</a>
							        @endif
						            @endif
			                    	@endforeach
	                                </div>
                                    @endif
								
	            			</div>
	            			
	            			
							
							<span class="info-row">
							@if (!config('settings.single.hide_dates'))
							<span class="date">
								<i class="icon-clock"></i> {!! $post->created_at_formatted !!}
							</span>&nbsp;
							@endif
							<span style="margin-right: 3px;" class="category"> 
							<i class="icon-eye" title="Visualizações"></i> {{ $post->visits ?? 0 }} <span title="Visualizações" class="ocultar-phone">Cliques</span></span>
							<span class="category ocultar-phone">
								<i class="far fa-folder"></i> &nbsp;{{ (!empty($post->category->parent)) ? $post->category->parent->name : $post->category->name }}
							</span>&nbsp;
							<span  class="category"> 
								<i class="fas fa-share-alt"></i>&nbsp;<a class="share s_facebook"> Partilhar</a>
							</span>&nbsp;
							<span  class="category"> 
								<i class="far fa-flag"></i>&nbsp;<a href="{{ lurl('posts/' . $post->id . '/report') }}"> Denunciar</a>
							</span>
						</span>
						</div>
					</div>
				</div>
			
				<div class="col-lg-3 page-sidebar-right">
					<aside>
						<div class="card card-user-info sidebar-card">
						    
							@if (auth()->check() && auth()->id() == $post->user_id)
								<div style="text-align: left;padding-bottom: 0px;" class="card-header">{{ t('Manage Ad') }}</div>
							@else
							
								<div class="card-header">Anunciante</div>
								<div style="padding-top: 0px;padding-bottom: 0px;" class="block-cell user">
									<div class="cell-media">
										<a href="{{ \App\Helpers\UrlGen::user($user) }}"><img title="{{ $post->contact_name }}" alt="{{ $post->contact_name }}" class="lazyload" style="max-width: none;" src="{{ $post->user_photo_url }}"></a>
									</div>
									<div class="cell-content">
							<span class="name">
											@if (isset($user) and !empty($user))
												<a href="{{ \App\Helpers\UrlGen::user($user) }}">
												{{ $post->contact_name }} @if(!$user->isOnline())<i style="color: #d9d9d9!important;font-size: 8px;position: absolute;margin-top: 7px;margin-left: 4px;" title="Offline" class="ocultar-phone1 fa fa-circle online"></i>@endif @if($user->isOnline())<i style="color: #2ecc71!important;font-size: 8px;position: absolute;margin-top: 7px;margin-left: 4px;" title="Online" class="ocultar-phone1 fa fa-circle online"></i>@endif
												
												@if(!$user->isOnline())<i style="color: #d9d9d9!important;font-size: 8px;" title="Offline" class="ocultar-pc2 fa fa-circle online"></i>@endif @if($user->isOnline())<i style="color: #2ecc71!important;font-size: 8px;" title="Online" class="ocultar-pc2 fa fa-circle online"></i>@endif
												</a>
											@else
												{{ $post->contact_name }}
											@endif
										</span>
										<div style="margin-bottom: -2px!important;"><span style="color: #013035!important; font-size:13px;">Registado {!! $user->created_at_formatted !!}</span></div>
										<a href="{{ \App\Helpers\UrlGen::user($user) }}">
										<span style="font-size: 13px; color: #406367!important;">Ver todos anúncios <img title="Paiaki Angola" alt="Paiaki Angola" style="height: 13px!important;" src="/images/seta.svg"></span></a>
									</div>
								</div>
								
							@endif
							
							<div class="card-content">
								<?php $evActionStyle = 'style="border-top: 0;"'; ?>
								
								<div class="ev-action" {!! $evActionStyle !!}>
									@if (auth()->check())
										@if (auth()->user()->id == $post->user_id)
	
			                        @if ($post->featured==0)
				<a href="{{ \App\Helpers\UrlGen::editPost($post) }}" class="btn btn-default btn-block">
												 {{ t('Update the Details') }}
											</a>
			                                @endif 
									
                               		@if (config('settings.single.publication_form_type') == '1')
												<a href="{{ url('posts/' . $post->id . '/photos') }}" class="btn btn-default btn-block">
													 {{ t('Update Photos') }}
												</a>
												@if (isset($countPackages) && isset($countPaymentMethods) && $countPackages > 0 && $countPaymentMethods > 0)
													<a href="{{ url('posts/' . $post->id . '/payment') }}" class="btn btn-default btn-block">
														 {{ t('Make It Premium') }}
													</a>
												@endif
											@endif
										@else
											{!! genPhoneNumberBtn($post, true) !!}
											{!! genEmailContactBtn($post, true) !!}
										@endif
										<?php
										try {
											if (auth()->user()->can(\App\Models\Permission::getStaffPermissions())) {
												$btnUrl = admin_url('blacklists/add') . '?email=' . $post->email;
												
												if (!isDemoDomain($btnUrl)) {
													$cMsg = trans('admin.confirm_this_action');
													$cLink = "window.location.replace('" . $btnUrl . "'); window.location.href = '" . $btnUrl . "';";
													$cHref = "javascript: if (confirm('" . addcslashes($cMsg, "'") . "')) { " . $cLink . " } else { void('') }; void('')";
													
													$btnText = trans('admin.ban_the_user');
													$btnHint = trans('admin.ban_the_user_email', ['email' => $post->email]);
													$tooltip = ' data-toggle="tooltip" data-placement="bottom" title="' . $btnHint . '"';
													
													$btnOut = '';
													$btnOut .= '<a href="'. $cHref .'" class="btn btn-danger btn-block"'. $tooltip .'>';
													$btnOut .= 'Banir usuário';
													$btnOut .= '</a>';
													
													echo $btnOut;
												}
											}
										} catch (\Exception $e) {}
										?>
									@else
										{!! genPhoneNumberBtn($post, true) !!}
										{!! genEmailContactBtn($post, true) !!}
									@endif
									
									@if (isset($customFields) and $customFields->count() > 0)
	                                <div id="cfContainer">
				                    @foreach($customFields as $field)
					            	@if (!is_array($field->default_value) and $field->type != 'video')
						           	@if ($field->type == 'url')
											<a class="btn btn-default btn-block" href="{{ addHttp($field->default_value) }}" target="_blank" rel="nofollow">Candidatar</a>
							        @endif
						            @endif
			                    	@endforeach
	                                </div>
                                    @endif

								</div>
							</div>
						</div>

						<div class="card sidebar-card">
							<div class="card-header">Dicas de segurança</div>
							<div class="card-content">
								<div style="padding-top: 0px;" class="card-body text-left">
									<ul class="lista-dicas">
									    <li> 1. Negocie apenas pessoalmente. </li>
										<li> 2. Encontre o vendedor em um lugar público. </li>
										<li> 3. Nunca transfira dinheiro à distância. </li>
										<li> 4. Denuncie anúncios suspeitos. </li>
									</ul>
                                    <?php $tipsLinkAttributes = getUrlPageByType('tips'); ?>
									<p>
										<a style="font-size: 13px; color: #406367!important; margin-bottom: 20px;margin-top: 15px;" class="pull-left" target="_blank" href="https://paiaki.com/page/seguranca">
                                            Ver todas as dicas <img title="Paiaki Angola" alt="Paiaki Angola" style="height: 14px!important;" src="/images/seta.svg">
                                        </a> 
                                    </p>
								</div>
							</div>
						</div>
						
						<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4663353052124843"
     crossorigin="anonymous"></script>
<!-- PAIAKI QUADRADO -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-4663353052124843"
     data-ad-slot="2794759771"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
						<div class="espaco"></div> 
					</aside>
				</div>
			</div>
		</div>
		
		<div class="espacoweb"></div>
		@if (config('settings.single.similar_posts') == '1' || config('settings.single.similar_posts') == '2')
			@includeFirst([config('larapen.core.customizedViewPath') . 'home.inc.featured', 'home.inc.featured'], ['firstSection' => false])
		@endif
		@includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.bottom', 'layouts.inc.advertising.bottom'], ['firstSection' => false])
	</div>
	
	<style> @media (max-width: 992px){
.ocultar-phone10 {
    display: none;
}} .entregas {
    z-index: 2;
    background: #fff3e5;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 800;
    font-style: normal;
    line-height: 1.25;
    border: none;
    padding: 0 12px;
    height: 29px;
    border-radius: 4px;
    margin-top: 7px;
    margin-right: 3px;
}
	.estilo-bom {display: flex;flex-wrap: nowrap;position: absolute;padding-top: 8px;padding-bottom: 8px;padding-left: 15px;padding-right: 15px;background: #fff;margin-top: 20px;margin-left: 20px;border-radius: 4px;}
	.p-3 {padding: 7px!important;}
	 .icon-phone-1 {display: none;} .fab fa-whatsapp {display: none!important;} .far fa-envelope-open {display: none!important;} .espacoweb  {padding-top: 35px;}
    .banana {margin-top: 5px;}
	.botao-destacar {margin-top: 20px;margin-bottom: 14px;}
	.btn10 {display: inline-block;font-weight: 400;line-height: 1.5;text-align: center;white-space: nowrap;vertical-align: middle;user-select: none;border: 1px solid transparent;padding: 5px 13px;font-size: .85rem;border-radius: .2rem;margin-right: 6px;}
	.lista-dicas {margin-bottom: 3px;line-height: 1.5;position: relative;}
	.cobertura {margin: 3px!important;}
	.from-wysiwyg ul {list-style-type: none;}
	.coluna-partilha {padding: 0;margin: 10px 0px 20px;flex-wrap: wrap;}
    .btn-success {color: #002f34;background-color: #ffffff;border-color: #002f34;}
    .btn-success:hover {color: #fff!important;;background-color: #25a25a;border-color: #239a55;}
    .btn-default:hover {background: #002f34!important;color: #fff!important;}
    .btn-warning:hover {background: #002f34!important;color: #fff!important;}
    .from-wysiwyg ol, .from-wysiwyg ul {margin: 0;}
    .detail-line div span:last-child {float: left;}
    .espaco-aqui {margin-bottom: 15px;}
    .naoaqui {display:none!important;}
    .p-2 {padding: 0px!important;}
	</style>
	
@endsection
<?php
if (!session()->has('emailVerificationSent') && !session()->has('phoneVerificationSent')) {
	if (session()->has('message')) {
		session()->forget('message');}}?>

@section('modal_message')
	@if (config('settings.single.show_security_tips') == '1')
		@includeFirst([config('larapen.core.customizedViewPath') . 'post.inc.security-tips', 'post.inc.security-tips'])
	@endif
	@if (auth()->check() || config('settings.single.guests_can_contact_ads_authors')=='1')
		@includeFirst([config('larapen.core.customizedViewPath') . 'account.messenger.modal.create', 'account.messenger.modal.create'])
	@endif
@endsection

@section('after_styles')
	<!-- bxSlider CSS file -->
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url('assets/plugins/bxslider/jquery.bxslider.rtl.css') }}" rel="stylesheet"/>
	@else
		<link href="{{ url('assets/plugins/bxslider/jquery.bxslider.css') }}" rel="stylesheet"/>
	@endif
@endsection

@section('before_scripts')
	<script>
		var showSecurityTips = '{{ config('settings.single.show_security_tips', '0') }}';
	</script>
@endsection

@section('after_scripts')
   
	<!-- bxSlider Javascript file -->
	<script src="{{ url('assets/plugins/bxslider/jquery.bxslider.min.js') }}"></script>
    
	<script>
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
		
		$(document).ready(function () {
			$('[rel="tooltip"]').tooltip({trigger: "hover"});
			
			/* Keep the current tab active with Twitter Bootstrap after a page reload */
            /* For bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line */
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                /* save the latest tab; use cookies if you like 'em better: */
                localStorage.setItem('lastTab', $(this).attr('href'));
            });
            /* Go to the latest tab, if it exists: */
            var lastTab = localStorage.getItem('lastTab');
            if (lastTab) {
                $('[href="' + lastTab + '"]').tab('show');
            }
		});
	</script>
@endsection