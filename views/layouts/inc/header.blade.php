<?php
// Search parameters
use Illuminate\Support\Facades\DB;
$queryString = (request()->getQueryString() ? ('?' . request()->getQueryString()) : '');

// Check if the Multi-Countries selection is enabled
$multiCountriesIsEnabled = false;
$multiCountriesLabel = '';
if (config('settings.geo_location.country_flag_activation')) {
	if (!empty(config('country.code'))) {
		if (isset($countries) && $countries->count() > 1) {
			$multiCountriesIsEnabled = true;
			$multiCountriesLabel = 'title="' . t('Select a Country') . '"';
		}
	}
}

// Logo Label
$logoLabel = '';
if (request()->segment(1) != 'countries') {
	if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled) {
		$logoLabel = config('settings.app.app_name') . ((!empty(config('country.name'))) ? ' ' . config('country.name') : '');
	}
}
?>
<div class="header">
	<nav class="navbar fixed-top navbar-site navbar-light bg-light navbar-expand-md" role="navigation">
		<div class="container">
			
			<div class="navbar-identity">
			    
			    {{-- Logo --}}
				<a href="{{ url('/') }}" class="navbar-brand logo logo-title">
					<img src="/images/logopaiaki.svg"
						 alt="{{ strtolower(config('settings.app.app_name')) }}" class="tooltipHere main-logo" alt="Paiaki Angola" title="Paiaki Angola" data-placement="bottom"/>
				</a>
				
				{{-- Botao Menu (Phone) --}}
				<button title="botao" data-target=".navbar-collapse" data-toggle="collapse" class="botao-recente navbar-toggler pull-right" type="button">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" focusable="false"><path d="M3 12C3 10.8954 3.89543 10 5 10C6.10457 10 7 10.8954 7 12C7 13.1046 6.10457 14 5 14C3.89543 14 3 13.1046 3 12Z" fill="currentColor"/><path d="M10 12C10 10.8954 10.8954 10 12 10C13.1046 10 14 10.8954 14 12C14 13.1046 13.1046 14 12 14C10.8954 14 10 13.1046 10 12Z" fill="currentColor"/><path d="M17 12C17 10.8954 17.8954 10 19 10C20.1046 10 21 10.8954 21 12C21 13.1046 20.1046 14 19 14C17.8954 14 17 13.1046 17 12Z" fill="currentColor"/></svg>
				</button>
				    
                {{-- Botao Vender Phone --}}
                <?php
						$addListingUrl = \App\Helpers\UrlGen::addPost();
						$addListingAttr = '';
						if (!auth()->check()) {
							if (config('settings.single.guests_can_post_ads') != '1') {
								$addListingUrl = '#quickLogin';
								$addListingAttr = ' data-toggle="modal"';
							}
						}
						if (config('settings.single.pricing_page_enabled') == '1') {
							$addListingUrl = \App\Helpers\UrlGen::pricing();
							$addListingAttr = '';
						}
					?>
				<a style="margin-right: 6px;padding-left: 14px;
    padding-right: 14px;" class="botao-recente navbar-toggler pull-right ocultar-pc2" href="{{ $addListingUrl }}"{!! $addListingAttr !!}>Anunciar</a>
    
        {{-- Botao de Pesquisa Phone --}}
    <a class="ocultar-tab navbar-toggler ocultar-iphone5 pull-right ocultar-pc2" style="margin-right: 0px;padding-top: 5px;" href="https://paiaki.com/search"> <img title="Paiaki Angola" alt="Paiaki Angola" class="lazyload" src="/images/pesquisa.svg" width="22px"></a>

		</div>
		
			{{-- Barra de Pesquisa PC --}}
			<div class="home-search ocultar-phone1">
						<form autocomplete="off" id="seach" name="search" action="https://paiaki.com/search" method="GET">
								<div class="search-col relative">
									<a href="https://paiaki.com/search"><img class="lazyload" title="Paiaki Angola" alt="Paiaki Angola" src="/images/pesquisa.svg" width="16px" style="position: absolute;top: 11px;left: 15px;"></a>
									<input style="border: 1px solid #cfd7db!important;background: #fff!important;font-size: 14px;border-radius: 3px;" type="text" name="q" class="form-control has-icon" placeholder="Pesquisar..." value="">
								</div>
								<input type="hidden" name="_token" value="">
						</form>
	        </div>
			
			<div class="navbar-collapse collapse">
			
				<ul class="nav navbar-nav ml-auto navbar-right">
					@if (!auth()->check())
						<li class="nav-item">
							@if (config('settings.security.login_open_in_modal'))
								<a href="#quickLogin" class="nav-link" data-toggle="modal"> {{ t('log_in') }}</a>
							@else
								<a href="{{ \App\Helpers\UrlGen::login() }}" class="nav-link"> {{ t('log_in') }}</a>
							@endif
						</li>
						<li class="nav-item">
							<a href="{{ \App\Helpers\UrlGen::register() }}" class="nav-link"> {{ t('register') }}</a>
						</li>
					@else
						<?php
							$userid= auth()->user()->id;
							$getWalletAmount= DB::table('user_wallets')->where('user_id',$userid)->sum('amount');
						?>
						<li class="nav-item dropdown no-arrow">
							<a href="#" class="ocultar-phone1 dropdown-toggle nav-link" data-toggle="dropdown">
								<i style="font-size: 13px;" class="far fa-user hidden-sm"></i>
								<span id="user_name_wallet">{{ auth()->user()->name }} ({{ $getWalletAmount }} KZ)</span>
								<span class="badge badge-pill badge-important count-threads-with-new-messages hidden-sm">0</span>
								<i class="icon-down-open-big fa"></i>
							</a>
							
							<ul id="userMenuDropdown" class="dropdown-menu user-menu dropdown-menu-right shadow-sm">

								<li class="dropdown-item">
									<a href="{{ url('account') }}">
									 {{ t('Personal Home') }}
									</a>
								</li>
								<li class="dropdown-item"><a href="https://paiaki.com/account/wallet">Carteira</a></li>
								<li class="dropdown-item"><a href="{{ url('account/my-posts') }}"> {{ t('my_ads') }} </a></li>
								<li class="dropdown-item"><a href="{{ url('account/favourite') }}"> {{ t('favourite_ads') }} </a></li>
								<li class="dropdown-item"><a href="{{ url('account/saved-search') }}"> {{ t('Saved searches') }} </a></li>
								<li class="dropdown-item">
									<a href="{{ url('account/messages') }}">
										 {{ t('messenger') }}
										<span class="badge badge-pill badge-important count-threads-with-new-messages">0</span>
									</a>
								</li>
								<li class="dropdown-item"><a href="{{ url('account/transactions') }}"> {{ t('Transactions') }}</a></li>
								<li class="dropdown-divider"></li>
								<li class="dropdown-item">
									@if (app('impersonate')->isImpersonating())
										<a href="{{ route('impersonate.leave') }}"> {{ t('Leave') }}</a>
									@else
										<a href="{{ \App\Helpers\UrlGen::logout() }}"> {{ t('log_out') }}</a>
									@endif
								</li>
							</ul>
							
							<ul id="userMenuDropdown" class="user-menu dropdown-menu-right ocultar-pc2">
							
							<div class="userbox-dd__user-card">
							    <?php
							$userid= auth()->user()->id;
							$getWalletAmount= DB::table('user_wallets')->where('user_id',$userid)->sum('amount');
						?>
                                <div style="font-size:15px!important;" class="userbox-dd__user-name"> {{ auth()->user()->name }} ({{ $getWalletAmount }} KZ)</div>
                                </div>
							    <li class="dropdown-divider"></li>
								<li style="padding-left: 8px;" class="dropdown-item">
									<a href="{{ url('account') }}">
									 {{ t('Personal Home') }}
									</a>
								</li>
								<li style="padding-left: 8px;" class="dropdown-item"><a href="https://paiaki.com/account/wallet">Carteira</a></li>
								<li style="padding-left: 8px;" class="dropdown-item"><a href="{{ url('account/my-posts') }}"> {{ t('my_ads') }} </a></li>
								<li style="padding-left: 8px;" class="dropdown-item"><a href="{{ url('account/favourite') }}"> {{ t('favourite_ads') }} </a></li>
								<li style="padding-left: 8px;" class="dropdown-item"><a href="{{ url('account/saved-search') }}"> {{ t('Saved searches') }} </a></li>
								<li style="padding-left: 8px;" class="dropdown-item">
									<a href="{{ url('account/messages') }}">
										 {{ t('messenger') }}
										<span class="badge badge-pill badge-important count-threads-with-new-messages">0</span>
									</a>
								</li>
								<li style="padding-left: 8px;" class="dropdown-item"><a href="{{ url('account/transactions') }}"> {{ t('Transactions') }}</a></li>
								<li style="padding-left: 8px;" class="dropdown-item">
									@if (app('impersonate')->isImpersonating())
										<a href="{{ route('impersonate.leave') }}"> {{ t('Leave') }}</a>
									@else
										<a href="{{ \App\Helpers\UrlGen::logout() }}"> {{ t('log_out') }}</a>
									@endif
								</li>
		
							</ul>
							
						</li>
					@endif
				
					@if (config('settings.single.pricing_page_enabled') == '2')
						<li class="nav-item pricing">
							<a href="{{ \App\Helpers\UrlGen::pricing() }}" class="nav-link">
								<i class="fas fa-tags"></i> {{ t('pricing_label') }}
							</a>
						</li>
					@endif
					
					<?php
						$addListingUrl = \App\Helpers\UrlGen::addPost();
						$addListingAttr = '';
						if (!auth()->check()) {
							if (config('settings.single.guests_can_post_ads') != '1') {
								$addListingUrl = '#quickLogin';
								$addListingAttr = ' data-toggle="modal"';
							}
						}
						if (config('settings.single.pricing_page_enabled') == '1') {
							$addListingUrl = \App\Helpers\UrlGen::pricing();
							$addListingAttr = '';
						}
					?>
				<li class="nav-item postadd ocultar-phone1">
						<a class="btn btn-block btn-border btn-post btn-add-listing" href="{{ $addListingUrl }}"{!! $addListingAttr !!}>
							 Anunciar e vender
						</a>
					</li>
				</ul>
			</div>
	
		</div>
	</nav>
</div>
