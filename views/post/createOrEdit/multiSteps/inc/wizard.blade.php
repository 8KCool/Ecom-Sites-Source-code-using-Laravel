@if (isset($wizardMenu) && !empty($wizardMenu))

@endif

@section('after_styles')
    @parent
	@if (config('lang.direction') == 'rtl')
    	<link href="{{ url('assets/css/rtl/wizard.css') }}" rel="stylesheet">
	@else
		<link href="{{ url('assets/css/wizard.css') }}" rel="stylesheet">
	@endif
@endsection
@section('after_scripts')
    @parent
@endsection