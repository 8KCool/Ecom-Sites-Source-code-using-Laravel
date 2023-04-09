<div class="reg-sidebar-inner text-center">
	
	@if (request()->segment(1) == 'create' or request()->segment(2) == 'create')
		{{-- Create Form --}}
		
	@else
		{{-- Edit Form --}}
		@if (config('settings.single.publication_form_type') == '2')
			{{-- Single Step Form --}}
			@if (auth()->check())
				@if (auth()->user()->id == $post->user_id)
					<div class="card sidebar-card panel-contact-seller">
						<div style="padding-bottom: 0px!important;text-align: left;" class="card-header">{{ t('author_actions') }}</div>
						<div class="card-content user-info">
							<div class="card-body text-center">
								<a href="{{ \App\Helpers\UrlGen::post($post) }}" class="btn btn-default btn-block">
								 {{ t('Return to the Ad') }}
								</a>
							</div>
						</div>
					</div>
				@endif
			@endif
			
		@else
			{{-- Multi Steps Form --}}
			@if (auth()->check())
				@if (auth()->user()->id == $post->user_id)
					<div class="card sidebar-card panel-contact-seller">
						<div style="padding-bottom: 0px!important;text-align: left;" class="card-header">{{ t('author_actions') }}</div>
						<div class="card-content user-info">
							<div class="card-body text-center">
								<a href="{{ \App\Helpers\UrlGen::post($post) }}" class="btn btn-default btn-block">
									{{ t('Return to the Ad') }}
								</a>
								<a href="{{ url('posts/' . $post->id . '/photos') }}" class="btn btn-default btn-block">
									{{ t('Update Photos') }}
								</a>
								@if (isset($countPackages) and isset($countPaymentMethods) and $countPackages > 0 and $countPaymentMethods > 0)
									<a href="{{ url('posts/' . $post->id . '/payment') }}" class="btn btn-default btn-block">
										 {{ t('Make It Premium') }}
									</a>
								@endif
							</div>
						</div>
					</div>
				@endif
			@endif
			
		@endif
	@endif
	
	<div class="card sidebar-card border-color-primary">
		<div class="card-content">
		    <div class="card-header text-left">Passos para publicar anúncio</div>
			<div style="padding-top: 0px;" class="card-body text-left">
				<ul class="lista-dicas">
				    <li> 1. Selecione uma categoria. </li>
					<li> 2. Mencione o tipo de anúncio. </li>
					<li> 3. Descreva o titulo do anúncio.</li>
					<li> 4. Narre uma descrição.</li>
					<li> 5. Adicione o preço.</li>
					<li> 6. Marque a província.</li>
					<li> 7. Adicione o número de telefone.</li>
					<li> 8. Adicione imagens ao anúncio.</li>
				</ul>
			</div>
		</div>
	</div>
	
	<div class="card sidebar-card border-color-primary">
		<div class="card-content">
		    <div class="card-header text-left">Dicas para vender rápido</div>
			<div style="padding-top: 0px;" class="card-body text-left">
				<ul class="lista-dicas">
					<li> 1. {{ t('sell_quickly_advice_1') }}</li>
					<li> 2. {{ t('sell_quickly_advice_2') }}</li>
					<li> 3. {{ t('sell_quickly_advice_3') }}</li>
					<li> 4. {{ t('sell_quickly_advice_4') }}</li>
					<li> 5. Evite repetir detalhes.</li>
					<li> 6. {{ t('sell_quickly_advice_5') }}</li>
					<li> 7. Destaque o anúncio.</li>
				</ul>
			</div>
		</div>
	</div>
	
</div>

<style>
	.lista-dicas {margin-bottom: 3px;line-height: 1.5;position: relative;}
	</style>