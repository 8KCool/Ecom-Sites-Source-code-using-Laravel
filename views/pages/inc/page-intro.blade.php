@if (!empty($page->picture))
<div class="intro-inner">
	<div class="about-intro" style="background:url({{ imgUrl($page->picture, 'bgHeader') }}) no-repeat center;background-size:cover;">
		<div class="dtable hw100">
			<div class="dtable-cell hw100">
				<div class="container text-center">
					<h1 class="intro-title" style="color: {!! $page->name_color !!};"> {{ $page->name }} </h1>
                    <h3 class="text-center title-1"><strong>{{ $page->title }}</strong></h3>
				</div>
			</div>
		</div>
	</div>
</div>
@endif

