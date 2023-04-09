<div class="item-slider ads-img-v2">
	<?php $titleSlug = \Illuminate\Support\Str::slug($post->title); ?>
	<div class="img-slider-box">
		@if ($post->pictures->count() > 0)
			<div class="slider-left">
				<ul class="bxslider">
					@foreach($post->pictures as $key => $image)
						<li><img class="lazyload" src="{{ imgUrl($image->filename, 'big') }}" alt="{{ $titleSlug . '-big-' . $key }}"/></li>
					@endforeach
				</ul>
			</div>
			<div id="bx-pager" class="scrollbar">
				@foreach($post->pictures as $key => $image)
					<a class="thumb-item-link" data-slide-index="{{ $key }}" href="">
						<img class="lazyload" src="{{ imgUrl($image->filename, 'small') }}" alt="{{ $titleSlug . '-small-' . $key }}"/>
					</a>
				@endforeach
			</div>
		@else
			<div class="slider-left">
				<ul class="bxslider">
					<li><img class="lazyload" src="{{ imgUrl(config('larapen.core.picture.default'), 'big') }}" alt="img"/></li>
				</ul>
			</div>
			<div id="bx-pager" class="scrollbar">
				<a class="thumb-item-link" data-slide-index="0" href="">
					<img class="lazyload" src="{{ imgUrl(config('larapen.core.picture.default'), 'small') }}" alt="img"/>
				</a>
			</div>
		@endif
	</div>
</div>

@section('after_styles')
	@parent
	<style>
		.bx-wrapper {
			margin-bottom: 20px;
		}
	</style>
@endsection
@section('after_scripts')
	@parent
	<script>
		$('.bxslider').bxSlider({
			touchEnabled: {{ (count($post->pictures) > 1) ? 'true' : 'false' }},
			speed: 1000,
			pagerCustom: '#bx-pager',
			adaptiveHeight: true,
			nextText: '{{ t('bxslider.nextText') }}',
			prevText: '{{ t('bxslider.prevText') }}',
			startText: '{{ t('bxslider.startText') }}',
			stopText: '{{ t('bxslider.stopText') }}'
		});
	</script>
@endsection