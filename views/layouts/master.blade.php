<?php
	$plugins = array_keys((array)config('plugins'));
	$publicDisk = \Storage::disk(config('filesystems.default'));
	
	$currURL= url()->current();
	if(!empty($_SERVER['QUERY_STRING'])){
	    $currURL .="?".$_SERVER['QUERY_STRING'];
	}
	$metaURLDetail = \App\Models\MetaTagsUrl::where('url', $currURL)->get();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.meta-robots', 'common.meta-robots'])
	<meta name="viewport" user-scalable="no" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<meta name="author" content="Paiaki Angola"/>
	<meta name="robots" content="index, follow">
	<meta property="og:site_name" content="Paiaki Angola">
	<meta property="og:type" content="website">
	<meta property="og:url" content="{{ $currURL }}">
	<meta http-equiv="content-language" content="pt">
	<meta property="og:locale" content="pt_PT"/>
	<meta name="geo.region" content="AO" />
    <meta name="geo.position" content="-11.877577;17.569124" />
    <meta name="ICBM" content="-11.877577, 17.569124" />
	<meta name="facebook-domain-verification" content="xz24v3q9xsurb8evujii3plf579tnl"/>
	<meta name="apple-mobile-web-app-title" content="{{ config('settings.app.app_name') }}">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('images/iconpaiaki.png') }}">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('images/iconpaiaki.png') }}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('images/iconpaiaki.png') }}">
	<link rel="apple-touch-icon-precomposed" href="{{ asset('images/iconpaiaki.png') }}">
	<link rel="shortcut icon" href="{{ asset('images/iconpaiaki.png') }}">
	@if (!$metaURLDetail->isEmpty())
	    @foreach ($metaURLDetail as $metaData)
	        <title>{{ $metaData->title }}</title>
	        <meta name="description" content="{{ $metaData->description }}">
	        <meta name="keywords" content="{{ $metaData->keywords }}"> 
	        <meta property="og:site_name" content="Paiaki Angola">
	        <meta property="og:locale" content="pt_PT">
	        <meta property="og:type" content="website">
	        <meta property="og:url" content="{{ $currURL }}">
	        <meta property="og:title" content="{{ $metaData->title }}">
	        <meta property="og:description" content="{{ $metaData->description }}">
	    @endforeach
	@else   
	    	<title>{!! MetaTag::get('title') !!}</title>
	        {!! MetaTag::tag('description') !!} {!! MetaTag::tag('keywords') !!}
	@endif
    
	<link rel="canonical" href="{{ request()->fullUrl() }}"/>
	<link rel="preload" as="font" type="font/woff2" crossorigin="anonymous" href="/public/assets/fonts/Geomanist-Book.woff2">
	<link rel="preload" as="font" type="font/woff2" crossorigin="anonymous" href="/public/assets/fonts/Geomanist-Regular.woff2">
	<link rel="preload" as="font" type="font/woff2" crossorigin="anonymous" href="/public/assets/fonts/Geomanist-Medium.woff2">
	<link rel="preload" as="font" type="font/woff2" crossorigin="anonymous" href="/public/assets/fonts/Geomanist-Bold.woff2">
	@if (isset($post))
		@if (isVerifiedPost($post))
			@if (config('services.facebook.client_id'))
				<meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />
			@endif
			{!! $og->renderTags() !!}
			{!! MetaTag::twitterCard() !!}
		@endif
	@else
		@if (config('services.facebook.client_id'))
			<meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />
		@endif
		{!! $og->renderTags() !!}
		{!! MetaTag::twitterCard() !!}
	@endif
	@include('feed::links')
	{!! seoSiteVerification() !!}
	
	@if (file_exists(public_path('manifest.json')))
		<link rel="manifest" href="/manifest.json">
	@endif
	
	@stack('before_styles_stack')
    @yield('before_styles')
	
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url(mix('css/app.css')) }}" rel="stylesheet">
	@else
		<link href="{{ url(mix('css/app.css')) }}" rel="stylesheet">
	@endif

	@includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.tools.style', 'layouts.inc.tools.style'])
	
	<link href="{{ url()->asset('css/custom.css') . getPictureVersion() }}" rel="stylesheet">
	
	@stack('after_styles_stack')
    @yield('after_styles')
	
	@if (isset($plugins) and !empty($plugins))
		@foreach($plugins as $plugin)
			@yield($plugin . '_styles')
		@endforeach
	@endif
    
    @if (config('settings.style.custom_css'))
		{!! printCss(config('settings.style.custom_css')) . "\n" !!}
    @endif
	
	@if (config('settings.other.js_code'))
		{!! printJs(config('settings.other.js_code')) . "\n" !!}
	@endif
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
	<script src="{{ url()->asset('assets/plugins/modernizr/modernizr-custom.js') }}"></script>

	 <script type="application/ld+json" async>
        {
            "@context": "http://schema.org",
            "@type": "Organization",
            "name": "Paiaki Angola",
            "url": "https://paiaki.com/",
            "logo": "https://paiaki.com/images/logopaiaki.svg",
            "description": "Compre e venda praticamente tudo no Paiaki",
            "sameAs": [
                "https://facebook.com/paiakiangola/",
                "https://instagram.com/paiaki.angola/"
            ]
        }
    </script>
    
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4663353052124843"
     crossorigin="anonymous"></script>
    
</head>

<body class="{{ config('app.skin') }}">
<div id="wrapper">
	
	@section('header')
		@includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.header', 'layouts.inc.header'])
	@show

	@section('search')
	@show
		
	@section('wizard')
	@show
	
	@if (isset($siteCountryInfo))
		<div class="h-spacer"></div>
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<div class="alert alert-warning">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						{!! $siteCountryInfo !!}
					</div>
				</div>
			</div>
		</div>
	@endif

	@yield('content')

	@section('info')
	@show
	
	@includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.advertising.auto', 'layouts.inc.advertising.auto'])
	
	@section('footer')
		@includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.footer', 'layouts.inc.footer'])
	@show

</div>

@section('modal_location')
@show
@section('modal_abuse')
@show
@section('modal_message')
@show

@includeWhen(!auth()->check(), 'layouts.inc.modal.login')
@includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.modal.change-country', 'layouts.inc.modal.change-country'])
@includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.modal.error', 'layouts.inc.modal.error'])
@include('cookieConsent::index')

@if (config('plugins.detectadsblocker.installed'))
	@if (view()->exists('detectadsblocker::modal'))
		@include('detectadsblocker::modal')
	@endif
@endif

<script>
	{{-- Init. Root Vars --}}
	var siteUrl = '{{ url('/') }}';
	var languageCode = '<?php echo config('app.locale'); ?>';
	var countryCode = '<?php echo config('country.code', 0); ?>';
	var timerNewMessagesChecking = <?php echo (int)config('settings.other.timer_new_messages_checking', 0); ?>;
	var isLogged = <?php echo (auth()->check()) ? 'true' : 'false'; ?>;
	var isLoggedAdmin = <?php echo (auth()->check() && auth()->user()->can(\App\Models\Permission::getStaffPermissions())) ? 'true' : 'false'; ?>;
	
	{{-- Init. Translation Vars --}}
	var langLayout = {
		'hideMaxListItems': {
			'moreText': "{{ t('View More') }}",
			'lessText': "{{ t('View Less') }}"
		},
		'select2': {
			errorLoading: function(){
				return "{!! t('The results could not be loaded') !!}"
			},
			inputTooLong: function(e){
				var t = e.input.length - e.maximum, n = {!! t('Please delete X character') !!};
				return t != 1 && (n += 's'),n
			},
			inputTooShort: function(e){
				var t = e.minimum - e.input.length, n = {!! t('Please enter X or more characters') !!};
				return n
			},
			loadingMore: function(){
				return "{!! t('Loading more results') !!}"
			},
			maximumSelected: function(e){
				var t = {!! t('You can only select N item') !!};
				return e.maximum != 1 && (t += 's'),t
			},
			noResults: function(){
				return "{!! t('No results found') !!}"
			},
			searching: function(){
				return "{!! t('Searching') !!}"
			}
		}
	};
	var fakeLocationsResults = "{{ config('settings.listing.fake_locations_results', 0) }}";
	var stateOrRegionKeyword = "{{ t('area') }}";
	var errorText = {
		errorFound: "{{ t('error_found') }}"
	};
</script>

@stack('before_scripts_stack')
@yield('before_scripts')

<script src="{{ url(mix('js/app.js')) }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if (config('settings.optimization.lazy_loading_activation') == 1)
	<script async src="{{ url()->asset('assets/plugins/lazysizes/lazysizes.min.js') }}"></script>
@endif
@if (file_exists(public_path() . '/assets/plugins/select2/js/i18n/'.config('app.locale').'.js'))
	<script src="{{ url()->asset('assets/plugins/select2/js/i18n/'.config('app.locale').'.js') }}"></script>
@endif
<script>
	$(document).ready(function () {
		{{-- Select Boxes --}}
		$('.selecter').select2({
			language: langLayout.select2,
			dropdownAutoWidth: 'true',
			minimumResultsForSearch: Infinity,
			width: '100%'
		});
		
		{{-- Searchable Select Boxes --}}
		$('.sselecter').select2({
			language: langLayout.select2,
			dropdownAutoWidth: 'true',
			width: '100%'
		});
		
		{{-- Social Share --}}
		$('.share').ShareLink({
			title: '{{ addslashes(MetaTag::get('title')) }}',
			text: '{!! addslashes(MetaTag::get('title')) !!}',
			url: '{!! request()->fullUrl() !!}',
			width: 640,
			height: 480
		});
		
		{{-- popper.js --}}
		$('[data-toggle="popover"]').popover();
		
		{{-- Modal Login --}}
		@if (isset($errors) and $errors->any())
			@if ($errors->any() and old('quickLoginForm')=='1')
				$('#quickLogin').modal();
			@endif
		@endif
	});
</script>

@stack('after_scripts_stack')
@yield('after_scripts')
@yield('captcha_footer')

@if (isset($plugins) and !empty($plugins))
	@foreach($plugins as $plugin)
		@yield($plugin . '_scripts')
	@endforeach
@endif

@if (config('settings.footer.tracking_code'))
	{!! printJs(config('settings.footer.tracking_code')) . "\n" !!}
@endif
</body>
</html>