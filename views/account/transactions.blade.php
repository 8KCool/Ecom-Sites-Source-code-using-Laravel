
@extends('layouts.master')

@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
	<div class="main-container">
		<div class="container">
			<div class="row">
			     <div class="col-md-12 page-content ocultar-phone1">
                   <h2 class="title-5"> Meus pagamentos </h2>
                 <div style="background: white;border-bottom: 45px solid #f2f4f5;margin-top: -25px;padding-bottom: 0px;" class="ocultar-phone1 inner-box">
					@includeFirst([config('larapen.core.customizedViewPath') . 'account.inc.sidebar', 'account.inc.sidebar'])
				</div></div>
					<div style="padding-bottom: 150px!important;" class="col-md-12">
						<h2 class="title-2 ocultar-pc2"> Meus pagamentos </h2>
						<div style="clear:both"></div>
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
								<tr>
									<th>Anúncio</th>
									<th>Montante</th>
									<th>Data</th>
									<th>{{ t('Status') }}</th>
								</tr>
								</thead>
								<tbody>
								<?php
								if (isset($transactions) && $transactions->count() > 0):
									foreach($transactions as $key => $transaction):
										
										// Fixed 2
										if (empty($transaction->post)) continue;
										if (!$countries->has($transaction->post->country_code)) continue;
										
										if (empty($transaction->package)) continue;
								?>
								<tr>
									<td>
										<a href="{{ \App\Helpers\UrlGen::post($transaction->post) }}">{{ $transaction->post->title }}</a>
									</td>
									<td>{!! $transaction->package->price !!} KZ</td>
									<td>{!! $transaction->created_at_formatted !!}</td>
									<td>
										@if ($transaction->active == 1)
											<span>Pago</span>
										@else
											<span>Não pago</span>
										@endif
									</td>
								</tr>
								<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
							</table>
						</div>

						<div style="clear:both"></div>
					</div>
			</div>
			<!--/.row-->
		</div>
		<!--/.container-->
	</div>
	<!-- /.main-container -->

<style> .list-inline {margin-bottom: -1px!important;} .user-panel-sidebar {background: #fff!important;} .row-featured-category {background: #ffffff!important;padding-left: 10px;} .user-panel-sidebar ul li a {background: #fff!important;}  @media screen and (min-width: 768px){.default-inner-box {padding: 27px!important;}} .card-header {
    padding: 0px;
    margin-bottom: 20px;
    padding-bottom: 10px!important;}
    .page-content .inner-box .title-2 {
    margin: 5px 0 -3px!important;
}
</style>	
	
@endsection

@section('after_scripts')
@endsection