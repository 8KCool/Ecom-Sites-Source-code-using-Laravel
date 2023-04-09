<div style="margin-bottom: -20px;" class="posts-image">
	<?php $titleSlug = \Illuminate\Support\Str::slug($post->title); ?>
	@if ($post->pictures->count() > 0)
		<ul style="display:inline-block!important;" class="bxslider">
			@foreach($post->pictures as $key => $image)
				<li style="display:inline-block!important;"> <img  class="lazyload" src="{{ imgUrl($image->filename, 'big') }}" title="{{ $post->title }}" alt="{{ $post->title }}"></li>
			@endforeach
		</ul>
		<div style="position: absolute;bottom: 10px;left: 0;right: 0;text-align: center;" id="bx-pager">
				@foreach($post->pictures as $key => $image)
				<li style="display:inline-block!important;">
					<a class="thumb-item-link" data-slide-index="{{ $key }}" href="">
						<img style="display:none!important;" src="{{ imgUrl($image->filename, 'small') }}" title="{{ $post->title }}" alt="{{ $post->title }}"/>
					</a>
					</li>
				@endforeach
			</div>
	@else
		<ul class="bxslider">
			<li><img class="lazyload" src="{{ imgUrl(config('larapen.core.picture.default'), 'big') }}" title="img" alt="img"></li>
		</ul>
	@endif
</div>

<style> @media (max-width: 640px){
.thumb-item-link {
    width: 9px!important;
    height: 9px!important;
    border: 2px solid #d3d3d3!important;
}} @media (max-width: 640px){
.thumb-item-link.active {
    width: 9px!important;
    height: 9px!important;
    border: 3px solid #fff!important;
}} .thumb-item-link.active {
    width: 16px;
    height: 16px;
    border: 5px solid #fff;
    border-radius: 50%;
} .thumb-item-link {
    width: 16px;
    height: 16px;
    border: 3px solid #d3d3d3;
    border-radius: 50%;
}</style>

@section('after_scripts')
	@parent
	<script>
		$(document).ready(function () {
			
			/* bxSlider - Main Images */
			$('.bxslider').bxSlider({
				touchEnabled: {{ ($post->pictures->count() > 1) ? 'true' : 'false' }},
				speed: 1000,
				pagerCustom: '#bx-pager',
				adaptiveHeight: true,
				nextText: '{{ t('bxslider.nextText') }}',
				prevText: '{{ t('bxslider.prevText') }}',
				startText: '{{ t('bxslider.startText') }}',
				stopText: '{{ t('bxslider.stopText') }}',
				onSlideAfter: function ($slideElement, oldIndex, newIndex) {
					@if (!userBrowser('Chrome'))
						$('#bx-pager li:not(.bx-clone)').eq(newIndex).find('a.thumb-item-link').addClass('active');
					@endif
				}
			});
			
			/* bxSlider - Thumbnails */
			@if (userBrowser('Chrome'))
				$('#bx-pager').addClass('m-3');
				$('#bx-pager .thumb-item-link').unwrap();
			@else
				var thumbSlider = $('.product-view-thumb').bxSlider(bxSliderSettings());
				$(window).on('resize', function() {
					thumbSlider.reloadSlider(bxSliderSettings());
				});
			@endif
		});
		
		/* bxSlider - Initiates Responsive Carousel */
		function bxSliderSettings()
		{
			var smSettings = {
				slideWidth: 65,
				minSlides: 1,
				maxSlides: 4,
				slideMargin: 5,
				adaptiveHeight: true,
				pager: false
			};
			var mdSettings = {
				slideWidth: 100,
				minSlides: 1,
				maxSlides: 4,
				slideMargin: 5,
				adaptiveHeight: true,
				pager: false
			};
			var lgSettings = {
				slideWidth: 100,
				minSlides: 3,
				maxSlides: 6,
				pager: false,
				slideMargin: 10,
				adaptiveHeight: true
			};
			
			if ($(window).width() <= 640) {
				return smSettings;
			} else if ($(window).width() > 640 && $(window).width() < 768) {
				return mdSettings;
			} else {
				return lgSettings;
			}
		}
	</script>
@endsection