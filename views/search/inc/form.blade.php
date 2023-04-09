<?php
// Keywords
$keywords = rawurldecode(request()->get('q'));

// Category
$qCategory = (isset($cat) and !empty($cat)) ? $cat->id : request()->get('c');

// Location
if (isset($city) and !empty($city)) {
	$qLocationId = (isset($city->id)) ? $city->id : 0;
	$qLocation = $city->name;
	$qAdmin = request()->get('r');
} else {
	$qLocationId = request()->get('l');
	$qLocation = (request()->filled('r')) ? t('area') . rawurldecode(request()->get('r')) : request()->get('location');
    $qAdmin = request()->get('r');
}
?>
<div class="container hidden-sm">
	<div class="search-row-wrapper rounded">
		<div class="container">
			<form autocomplete="off" id="seach" name="search" action="{{ \App\Helpers\UrlGen::search() }}" method="GET">
				<div class="row m-0">

					<div class="col-xl-7 col-sm-7 col-xs-14">
					    <img title="Paiaki Angola" alt="Paiaki Angola" class="lazyload" src="/images/pesquisa.svg" width="18px" style="position: absolute;top: 21px;left: 18px;">
						<input style="border: 1px solid #fff!important;" name="q" class="has-icon form-control keyword" type="text" placeholder="O que procuras?" value="{{ $keywords }}">
					</div>
					
					<div class="col-xl-3 col-md-3 col-sm-12 col-xs-12 search-col locationicon">
					    <i style="color:#002f34!important;font-size: 16px;margin-top: 2px;" class="icon-location-2 icon-append"></i>
						<input type="text" id="locSearch" name="location" class="form-control has-icon locinput input-rel searchtag-input tooltipHere"
							   placeholder="Província" value="{{ $qLocation }}" title="" data-placement="bottom">
					</div>
	
					<input type="hidden" id="lSearch" name="l" value="{{ $qLocationId }}">
					<input type="hidden" id="rSearch" name="r" value="{{ $qAdmin }}">
	
					<div class="col-xl-2 col-md-2 col-sm-12 col-xs-12">
						<button style="border-radius: 0px" class="btn btn-block btn-search">{{ t('find') }}
						</button>
					</div>
					
				</div>
			</form>
		</div>
	</div>
</div>

<style>
#wrapper {padding-top: 80px!important;}
.home-search  {display:none;!important;}
.search-row-wrapper .has-icon {padding-left: 44px;}
.search-row-wrapper .icon-location-2.icon-append {margin-top: 2px;margin-left: 11px;}
.btn-search {background-color: #ffffff! important;border-color: #ffffff!important;color: #002f34!important;} 
.btn-search:hover {background-color: #002f34! important;border-color: #002f34!important;color: white!important;}
.search-row .search-col .form-control, .search-row button.btn-search, .search-row-wrapper .form-control, .search-row-wrapper button.btn {
    height: 60px!important;font-size: 15px;}
		.select2-container--default .select2-selection--single, .select2-dropdown {background-color: #fff;border: 1px solid #fff!important;}
		.form-control {border: 1px solid #fff!important;}
		.form-control:focus {border-color: #fff!important; box-shadow: none;}
		@media (max-width: 767px){
.locinput {border-right: none!important;border-bottom: none!important;}}
@media (max-width: 767px){
.search-col .form-control {border-radius: 0px!important;}}
	</style>

@section('after_scripts')
	@parent
	<script>
		$(document).ready(function () {
			$('#locSearch').on('change', function () {
				if ($(this).val() == '') {
					$('#lSearch').val('');
					$('#rSearch').val('');
				}
			});
		});
	</script>
@endsection
