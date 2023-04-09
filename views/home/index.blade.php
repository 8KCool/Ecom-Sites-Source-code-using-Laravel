
@extends('layouts.master')

@section('search')
	@parent
@endsection

@section('content')
	<div class="main-container" id="homepage">
	    <h1 style="display:none!important;">Paiaki Angola - Anúncios Classificados</h1>
	    <h5 style="display:none!important;">Classificados em Angola</h5>
	    <h6 style="display:none!important;">Maior site de compra e venda em Angola</h6>
	    
	    <div style="display:none!important;" class="main-container" id="homepage">
	    <p>Paiaki é o maior site moderno de anúncios classificados online em Angola para utilizadores particulares e profissionais, que conecta as pessoas para comprar, vender, leiloar ou trocar produtos e serviços de maneira rápida, simples e segura. Startup fundada por Vicente Brás Zau em 11 de fevereiro de 2019 e lançada oficialmente em 11 de Julho de 2019, marca registada pela empresa KUMBUNET LDA, NIF: 5000151238.</p>

<p>Com o Paiaki, as pessoas podem vender produtos que já não querem ou comprar outros que pretendem. À disposição dos usuários, tem várias categorias e pode-se também filtrar a pesquisa por localização, marcas, preço e entre outros.</p>

<p>A plataforma proporciona-lhe uma forma simples, rápida e fácil de vender, em qualquer dia da semana, a qualquer hora, esteja onde estiver sem precisar de intermediários singulares. Nunca antes foi tão fácil comprar ou vender casas, carros, telemóveis, computadores, animais ou qualquer outra coisa em Angola. E porque é fácil vender, encontrará certamente boas oportunidades para comprar tudo o que precisa. No Paiaki encontra também ofertas de emprego ou serviços.</p>

<p>O Paiaki é um marketplace C2C. Mas o que isso significa? Basta imaginar que seria como um shopping center online, um local onde diferentes vendedores disponibilizam diversos produtos para serem vendidos. Porém, com transações feitas de consumidor para consumidor, o tal “C2C”.</p>	</div>
			
		@if (isset($sections) and $sections->count() > 0)
			@foreach($sections as $section)
				@if (view()->exists($section->view))
					@includeFirst([config('larapen.core.customizedViewPath') . $section->view, $section->view], ['firstSection' => $loop->first])
				@endif
			@endforeach
		@endif
		
	</div>
@endsection

@section('after_scripts')
	<script>
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
