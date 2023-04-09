<?php
// Search parameters
$queryString = (request()->getQueryString() ? ('?' . request()->getQueryString()) : '');

// Check if the Multi-Countries selection is enabled
$multiCountriesIsEnabled = false;
$multiCountriesLabel = '';

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
					<img src="/images/logopaiaki.svg" class="tooltipHere main-logo" />
				</a>
			
			{{-- Vender --}}
				<a style="margin-right: 10px;padding-left: 14px;
    padding-right: 14px;" class="botao-recente navbar-toggler pull-right ocultar-pc2" href="https://paiaki.com/posts/create">Anunciar</a>

			
				{{-- Country Flag (Mobile) --}}
				@if (request()->segment(1) != 'countries')
					@if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
						@if (!empty(config('country.icode')))
							@if (file_exists(public_path() . '/images/flags/24/' . config('country.icode') . '.png'))
								<button class="flag-menu country-flag d-block d-md-none btn btn-secondary hidden pull-right" href="#selectCountry" data-toggle="modal">
									<img src="{{ url('images/flags/24/'.config('country.icode').'.png') . getPictureVersion() }}"
										 alt="{{ config('country.name') }}"
										 style="float: left;"
									>
									<span class="caret hidden-xs"></span>
								</button>
							@endif
						@endif
					@endif
				@endif
            </div>
	
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-left">
					{{-- Country Flag --}}
					@if (request()->segment(1) != 'countries')
						@if (config('settings.geo_location.country_flag_activation'))
							@if (!empty(config('country.icode')))
								@if (file_exists(public_path() . '/images/flags/32/' . config('country.icode') . '.png'))
									<li class="flag-menu country-flag tooltipHere hidden-xs nav-item" data-toggle="tooltip" data-placement="{{ (config('lang.direction') == 'rtl') ? 'bottom' : 'right' }}">
										@if (isset($multiCountriesIsEnabled) and $multiCountriesIsEnabled)
											<a href="#selectCountry" data-toggle="modal" class="nav-link">
												<img class="flag-icon"
													 src="{{ url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion() }}"
													 alt="{{ config('country.name') }}"
												>
												<span class="caret hidden-sm"></span>
											</a>
										@else
											<a style="cursor: default;">
												<img class="flag-icon no-caret"
													 src="{{ url('images/flags/32/' . config('country.icode') . '.png') . getPictureVersion() }}"
													 alt="{{ config('country.name') }}"
												>
											</a>
										@endif
									</li>
								@endif
							@endif
						@endif
					@endif
				</ul>
				
				<ul class="nav navbar-nav ml-auto navbar-right">
                    @if (auth()->check())
                        
					<li class="nav-item postadd">
							@if (config('settings.single.guests_can_post_ads') != '1')
								<a style="font-size:13px!important;" class="btn btn-block btn-border btn-post btn-add-listing" href="https://paiaki.com/posts/create">
									Anunciar e vender
								</a>
							@else
								<a style="font-size:13px!important;" class="btn btn-block btn-border btn-post btn-add-listing" href="https://paiaki.com/posts/create">
									Anunciar e vender
								</a>
							@endif
						@else
							<a style="font-size:13px!important;" class="btn btn-block btn-border btn-post btn-add-listing" href="https://paiaki.com/posts/create">
							Anunciar e vender
							</a>
						@endif
					</li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<style>
    @media (max-width: 767px){
.navbar-site.navbar .navbar-identity .btn, .navbar-site.navbar .navbar-identity .navbar-toggler {
    margin-top: 16px!important;
    padding: 0 10px;
    height: 35px!important;
}}

@media (max-width: 479px) {
.navbar-site.navbar .navbar-identity {
    height: 70px!important;
}}

.botao-recente {
    text-align: center;
    vertical-align: baseline;
    white-space: nowrap;
    user-select: none;
    cursor: pointer;
    color: #002f34!important;
    font-weight: 400;
    font-size: 14px;
    line-height: 5px;
    min-height: 28px;
    width: auto;
    display: inline-flex;
    -webkit-box-flex: 0;
    flex-grow: 0;
    -webkit-box-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    align-items: center;
    appearance: button;
    margin: 0px;
    overflow: visible;
    text-decoration: none;
    border-width: initial;
    border-style: none;
    border-image: initial;
    background: #e2e8eb;
    border-radius: 2em;
    padding: 4px 8px;
}

</style>
