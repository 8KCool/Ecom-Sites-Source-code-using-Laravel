
@extends('layouts.master')

@section('search')
	@parent
    @includeFirst([config('larapen.core.customizedViewPath') . 'pages.inc.page-intro', 'pages.inc.page-intro'])
@endsection

@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
	<div class="main-container inner-page">
		<div class="container">
			<div class="section-content">
				<div class="row">
                    
					<div class="col-md-12 page-content">
						<div style="background: #f2f4f5!important;" class="inner-box relative">
						    
						    @if (empty($page->picture))
                        <h2 class="title-2">{{ $page->name }}</h2>
                    @endif
						    
							<div class="row">
								<div class="col-sm-12 page-content">
									<div class="text-content text-left from-wysiwyg">
										{!! $page->content !!}
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>
	
	<style>.imagem1 {
    background-image: url(/images/fundonovo.png)!important;
    color: #fff;
    min-height: 186px;
    justify-content: center;
    flex-direction: column;
    background-repeat: no-repeat;
    background-position: 100% 0;}
.home-search {display:none!important;}
</style>
@endsection

@section('info')
@endsection
