@if (is_array(getSupportedLanguages()) && count(getSupportedLanguages()) > 1)
	<!-- Language Selector -->
	<li class="dropdown lang-menu nav-item">
		<button style="margin-right: 10px;padding-left: 14px;
    padding-right: 14px;" type="button" class="botao-recente dropdown-toggle" data-toggle="dropdown">
			<span class="lang-title">{{ strtoupper(config('app.locale')) }}</span>
		</button>
		
			<div class="navbar-collapse collapse">
		<ul id="langMenuDropdown" class="nav navbar-nav ml-auto navbar-rightdropdown-menu dropdown-menu-right user-menu shadow-sm" role="menu">
			@foreach(getSupportedLanguages() as $langCode => $lang)
				@continue(strtolower($langCode) == strtolower(config('app.locale')))
				<li class="dropdown-item">
					<a href="{{ url('lang/' . $langCode) }}" tabindex="-1" rel="alternate" hreflang="{{ $langCode }}">
						<span class="lang-name">{!! $lang['native'] !!}</span>
					</a>
				</li>
			@endforeach
		</ul>
		</div>
	</li>
@endif
