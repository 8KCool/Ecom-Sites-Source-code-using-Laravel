
@extends('layouts.master')

@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])

	<div class="main-container">
		<div class="container">

			<div class="row">
				@if (session()->has('flash_notification'))
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif
	
				<div class="col-md-12 page-content ocultar-phone1 ">
                    @if ($pagePath=='my-posts')
							<h2 class="title-5">Meus anúncios publicados </h2>
						@elseif ($pagePath=='archived')
							<h2 class="title-5">Meus anúncios arquivados </h2>
						@elseif ($pagePath=='favourite')
							<h2 class="title-5">Meus anúncios favoritos </h2>
						@else
							<h2 class="title-5">Meus anúncios publicados </h2>
						@endif
                 <div style="background: #fff!important;border-bottom: 30px solid #f2f4f5;margin-top: -25px;padding-bottom: 0px;" class="ocultar-phone1 inner-box">
					@includeFirst([config('larapen.core.customizedViewPath') . 'account.inc.sidebar', 'account.inc.sidebar'])
				</div></div>

				<div style="padding-bottom: 120px!important;" class="col-md-12 page-content">

					<div class="page-content">
						@if ($pagePath=='my-posts')
							<h2 class="title-2 ocultar-pc2">Meus anúncios publicados </h2>
						@elseif ($pagePath=='archived')
							<h2 class="title-2 ocultar-pc2">Meus anúncios arquivados </h2>
						@elseif ($pagePath=='favourite')
							<h2 class="title-2 ocultar-pc2">Meus anúncios favoritos </h2>
						@else
							<h2 class="title-2 ocultar-pc2">Meus anúncios publicados </h2>
						@endif
						
						<div class="table-responsive">
							<form name="listForm" method="POST" action="{{ url('account/' . $pagePath . '/delete') }}">
								{!! csrf_field() !!}
								
								<table id="addManageTable"
									   class="table table-striped table-bordered add-manage-table table demo"
									   data-filter="#filter"
									   data-filter-text-only="true">
									<tbody>

									<?php
									if (isset($posts) && $posts->count() > 0):
									foreach($posts as $key => $post):
										// Fixed 1
										if ($pagePath == 'favourite') {
											if (isset($post->post)) {
												if (!empty($post->post)) {
													$post = $post->post;
												} else {
													continue;
												}
											} else {
												continue;
											}
										}

										// Fixed 2
										if (!$countries->has($post->country_code)) continue;

										// Get Post's URL
										$postUrl = \App\Helpers\UrlGen::post($post);
                                    
                                    	// Get Post's Pictures
                                        if ($post->pictures->count() > 0) {
                                            $postImg = imgUrl($post->pictures->get(0)->filename, 'medium');
                                        } else {
                                            $postImg = imgUrl(config('larapen.core.picture.default'), 'medium');
                                        }

									?>
									<tr>
										<td style="width:10%" class="add-img-td">
											<a href="{{ $postUrl }}"><img class="img-thumbnail2 img-fluid add-img-td" src="{{ $postImg }}" alt="img"></a>
										</td>
										<td style="width:100%; display:block;margin-top: 4px;padding-left:0px;" class="items-details-td">
											<div>
												<p>
												    @if (in_array($pagePath, ['my-posts']) and $post->user_id==$user->id and $post->archived==0) @if ($post->featured==1) <span style="font-size: 11px;" class="info-row ocultar-phone1"> <a title="Atualizar plano" href="{{ url('posts/' . $post->id . '/payment') }}" class="date"><i style="font-size: 9px;color: #838383!important;" class="fas fa-globe-africa"></i> Patrocinado </a> </span>
																<span style="font-size: 10px;" class="info-row ocultar-pc2"> <a title="Atualizar plano" href="{{ url('posts/' . $post->id . '/payment') }}" class="date"><i style="font-size: 9px;color: #838383!important;" class="fas fa-globe-africa"></i> Patrocinado </a> </span>
															@endif @endif
                                                <a style="font-size:15px; font-weight: 800;letter-spacing: -0.6px;" class="texto-resumo" href="{{ $postUrl }}" title="{{ $post->title }}">{{ \Illuminate\Support\Str::limit($post->title, 30) }}</a>
                                                </p>
											
												<p style="font-size: 12px;" >
													<strong><i class="icon-eye" title="Visualizações"></i></strong> {{ $post->visits ?? 0 }}
													<strong><i style="font-size: 10px;" class="icon-location-2" title="Localização"></i></strong> {{ !empty($post->city) ? $post->city->name : '-' }}
													<strong><i style="font-size: 10px;" class="icon-clock" title="Data"></i></strong> {!! $post->created_at_formatted !!}
												</p>
											</div>
											<div>
											    
											    @if (in_array($pagePath, ['my-posts']) and $post->user_id==$user->id and $post->archived==0)
											<a style="letter-spacing: -0.6px;margin-bottom: 4px;font-size: 12px;font-weight: 400;margin-right:6px;background: #e2e8eb;border-radius: 4px;padding-left: 5px;padding-right: 5px;padding-top: 1px;padding-bottom: 1px;margin-right:4px;" href="{{ url('posts/' . $post->id . '/payment') }}">Destacar</a>
											@endif
											  
											 
												@if (in_array($pagePath, ['my-posts']) and $post->user_id==$user->id and $post->archived==0)
												 @if ($post->featured==0)
                                                        <a style="letter-spacing: -0.6px;margin-bottom: 4px;font-size: 12px;font-weight: 400;margin-right:6px;background: #e2e8eb;border-radius: 4px;padding-left: 5px;padding-right: 5px;padding-top: 1px;padding-bottom: 1px;margin-right:4px;" href="{{ \App\Helpers\UrlGen::editPost($post) }}">{{ t('Edit') }}</a>
												@endif
												@endif 
												
                                                <a style="letter-spacing: -0.6px;margin-bottom: 4px;font-size: 12px;font-weight: 400;margin-right:6px;background: #e2e8eb;border-radius: 4px;padding-left: 5px;padding-right: 5px;padding-top: 1px;padding-bottom: 1px;" class="delete-action" href="{{ lurl('account/'.$pagePath.'/'.$post->id.'/delete') }}">{{ t('Delete') }}</a>
											
											</div>
										</td>
									</tr>
									</tr>
									<?php endforeach; ?>
                                    <?php endif; ?>
									</tbody>
								</table>
							</form>
							
							<nav style="margin-top: 50px;">
                            {{ (isset($posts)) ? $posts->links() : '' }}
                        </nav>
                        
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	
	<style> .list-inline {margin-bottom: -1px!important;} .user-panel-sidebar {background: #fff!important;} .row-featured-category {background: #ffffff!important;padding-left: 10px;} .user-panel-sidebar ul li a {background: #fff!important;}  @media screen and (min-width: 768px){.default-inner-box {padding: 27px!important;}} .card-header {
    padding: 0px;
    margin-bottom: 20px;
    padding-bottom: 10px!important;}
.page-content .inner-box .title-2 {
    margin: 5px 0 -3px!important;
}
		.action-td p {
			margin-bottom: 5px;}
	p {margin-top: 0;
    margin-bottom: 0rem;}
.img-thumbnail2 {
    padding: 0px;
    border: none;
    border-radius: 0px;
    height: 75px;
    width: 85px;}
.page-link {
    font-size: 12px!important;
    position: relative;
    display: block;
    padding: .5rem .75rem;
    margin-left: -1px;
    line-height: 1.25;
    font-weight: 800!important;
    background-color: #f2f4f5!important;
    border: 1px solid #f2f4f5!important;
    margin-bottom: 30px;}
.pagination>li>a, .pagination>li>span {color: #002f34!important;}
.action-td p {margin-bottom: 5px;}
		
	</style>
@endsection

@section('after_styles')
@endsection

@section('after_scripts')
	<script src="{{ url('assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
	<script src="{{ url('assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$(function () {
			$('#addManageTable').footable().bind('footable_filtering', function (e) {
				var selected = $('.filter-status').find(':selected').text();
				if (selected && selected.length > 0) {
					e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
					e.clear = !e.filter;
				}
			});

			$('.clear-filter').click(function (e) {
				e.preventDefault();
				$('.filter-status').val('');
				$('table.demo').trigger('footable_clear_filter');
			});

			$('.from-check-all').click(function () {
				checkAll(this);
			});
			
			$('a.delete-action, button.delete-action, a.confirm-action').click(function(e)
			{
				e.preventDefault(); /* prevents the submit or reload */
				var confirmation = confirm("{{ t('confirm_this_action') }}");
				
				if (confirmation) {
					if( $(this).is('a') ){
						var url = $(this).attr('href');
						if (url !== 'undefined') {
							redirect(url);
						}
					} else {
						$('form[name=listForm]').submit();
					}
				}
				
				return false;
			});
		});
	</script>
	{{-- include custom script for ads table [select all checkbox]  --}}
	<script>
		function checkAll(bx) {
			if (bx.type !== 'checkbox') {
				bx = document.getElementById('checkAll');
				bx.checked = !bx.checked;
			}
			
			var chkinput = document.getElementsByTagName('input');
			for (var i = 0; i < chkinput.length; i++) {
				if (chkinput[i].type == 'checkbox') {
					chkinput[i].checked = bx.checked;
				}
			}
		}
	</script>
@endsection
