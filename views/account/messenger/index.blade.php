
@extends('layouts.master')

@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
    <div class="main-container">
        <div class="container">
            <div class="row">
                
                <div class="col-md-12 page-content">

                    @if (session()->has('flash_notification'))
                            <div class="row">
                                <div class="col-xl-12">
                                    @include('flash::message')
                                </div>
                            </div>
                        @endif      <div id="successMsg" class="alert alert-success hide" role="alert"></div>
                        <div id="errorMsg" class="alert alert-danger hide" role="alert"></div> </div>

                <div class="col-md-12 page-content ocultar-phone1">
                   <h2 class="title-5"> {{ t('inbox') }} </h2>
                 <div style="background: white;border-bottom: 45px solid #f2f4f5;margin-top: -25px;padding-bottom: 0px;" class="ocultar-phone1 inner-box">
					@includeFirst([config('larapen.core.customizedViewPath') . 'account.inc.sidebar', 'account.inc.sidebar'])
				</div></div>
                
                    <div style="padding-bottom: 150px!important;" class="col-md-12 page-content">
                        <h2 class="title-2 ocultar-pc2">
                             {{ t('inbox') }}
                        </h2>

                        <div class="inbox-wrapper">
                            {!! csrf_field() !!}
                            
                            <div class="row">
                                 <div class="col-md-12 page-content">
                                    <div class="message-list">
                                        <div id="listThreads">
                                            @include('account.messenger.threads.threads')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/. inbox-wrapper-->
                    </div>
                
                <!--/.page-content-->
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </div>
    <!-- /.main-container -->
    
    <style>.message-list .list-group-item {border: 7px solid #f2f4f5;
} .list-inline {margin-bottom: -1px!important;} .user-panel-sidebar {background: #fff!important;} .row-featured-category {background: #ffffff!important;padding-left: 10px;} .user-panel-sidebar ul li a {background: #fff!important;}  @media screen and (min-width: 768px){.default-inner-box {padding: 27px!important;}} .card-header {
    padding: 0px;
    margin-bottom: 20px;
    padding-bottom: 10px!important;} .page-content .inner-box .title-2 {
    margin: 5px 0 -3px!important;
}</style>
    
@endsection

@section('after_styles')
    <style>
        {{-- Center image related to the parent element --}}
        .loading-img {
            position: absolute;
            width: 32px;
            height: 32px;
            left: 50%;
            top: 50%;
            margin-left: -16px;
            margin-right: -16px;
            z-index: 100000;
        }
    </style>
@endsection

@section('after_scripts')
	<script>
        var loadingImage = '{{ url('images/loading.gif') }}';
        var loadingErrorMessage = '';
        var confirmMessage = '{{ t('confirm_this_action') }}';
        var actionText = '{{ t('action') }}';
        var actionErrorMessage = '{{ t('This action could not be done') }}';
        var title = {
            'seen': '{{ t('Mark as read') }}',
            'notSeen': '{{ t('Mark as unread') }}',
            'important': '{{ t('Mark as important') }}',
            'notImportant': '{{ t('Mark as not important') }}',
        };
	</script>
    <script src="{{ url('assets/js/app/messenger.js') }}" type="text/javascript"></script>
@endsection