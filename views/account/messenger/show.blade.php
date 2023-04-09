
@extends('layouts.master')

@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
    <div class="main-container">
        <div class="container">
            <div class="row">
                
                <div class="col-md-12 page-content">
                    <div class="alert alert-warning"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i style="font-size: 12px;" class="far fa-question-circle"></i> Se estiver a negociar, nunca transfira dinheiro à distância. Negocie pessoalmente: <a style="text-decoration: underline;font-weight: 800;" href="https://paiaki.com/page/seguranca" target="_blank">Saiba mais</a></div>
                  </div>
                
                <div class="col-md-12 page-content">
                    <div class="inner-box">
                        <h2 class="title-2">
                            <a style="margin-right: 7px;" href="{{ url('account/messages') }}">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a> <a href="{{ \App\Helpers\UrlGen::post($thread->post) }}">{{ $thread->post->title }}</a>
                        </h2>
    
                        @if (session()->has('flash_notification'))
                            <div class="row">
                                <div class="col-xl-12">
                                    @include('flash::message')
                                </div>
                            </div>
                        @endif
                        
                        @if (isset($errors) and $errors->any())
                            <div class="alert alert-danger">
                                <ul class="list list-check">
                                    @foreach($errors->all() as $error)
                                        <li class="mb-0">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
    
                        <div id="successMsg" class="alert alert-success hide" role="alert"></div>
                        <div id="errorMsg" class="alert alert-danger hide" role="alert"></div>
                        
                        <div class="inbox-wrapper">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="user-bar-top">
                                        <div class="user-top">
                                            <p>
                                                @if (auth()->id() != $thread->creator()->id)
                                                    <a href="#user">
                                                        <a style="font-size: 15px; font-weight:800!important;">
                                                            <a style="font-size: 15px; font-weight:800!important;" href="{{ \App\Helpers\UrlGen::user($thread->creator()) }}">
                                                                {{ $thread->creator()->name }}
                                                            </a>
                                                        </a>
                                                        
                                                        @if (isUserOnline($thread->creator()))
                                                            <i style="font-size: 9px;" class="fa fa-circle color-success"></i>&nbsp;
                                                        @endif
                                                        
                                                    </a>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="row">
                                <div class="col-md-12 chat-row">
                                    <div class="message-chat p-2 rounded">
                                        <div id="messageChatHistory" class="message-chat-history">
                                            <div id="linksMessages" class="text-center">
                                                {!! $linksRender !!}
                                            </div>
                                            
                                            @include('account.messenger.messages.messages')
                                            
                                        </div>

                                        <div class="type-message">
                                            <div class="type-form">
                                                <?php $updateUrl = url('account/messages/' . $thread->id); ?>
                                                <form id="chatForm" role="form" method="POST" action="{{ $updateUrl }}" enctype="multipart/form-data">
                                                    {!! csrf_field() !!}
                                                    <input name="_method" type="hidden" value="PUT">
                                                    <textarea id="body"
                                                          name="body"
                                                          maxlength="500"
                                                          rows="3"
                                                          class="input-write form-control"
                                                          placeholder="{{ t('Type a message') }}"
                                                          style="{{ (config('lang.direction')=='rtl') ? 'padding-left' : 'padding-right' }}: 75px;"
                                                    ></textarea>
                                                    <div class="button-wrap lazyload">
                                                        <input id="addFile" name="filename" type="file">
                                                        <button id="sendChat" class="lazyload btn btn-primary" type="submit">
                                                            <i class="fas fa-paper-plane" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/. inbox-wrapper-->
                    </div>
                </div>
                <!--/.page-content-->
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </div>
    <!-- /.main-container -->
@endsection

@section('after_styles')
    @parent
    <link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
    @if (config('lang.direction') == 'rtl')
        <link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
    @endif
    <style>
        .file-input {
            display: inline-block;
        }
    </style>
@endsection

@section('after_scripts')
    @parent

    <script>
        var loadingImage = '{{ url('images/loading.gif') }}';
        var loadingErrorMessage = 'Não esqueça de terminar a conversa';
        var confirmMessage = '{{ t('confirm_this_action') }}';
        var actionErrorMessage = '{{ t('This action could not be done') }}';
        var title = {
            'seen': '{{ t('Mark as read') }}',
            'notSeen': '{{ t('Mark as unread') }}',
            'important': '{{ t('Mark as important') }}',
            'notImportant': '{{ t('Mark as not important') }}',
        };
    </script>
    <script src="{{ url('assets/js/app/messenger.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/js/app/messenger-chat.js') }}" type="text/javascript"></script>
    
    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/plugins/bootstrap-fileinput/themes/fas/theme.js') }}" type="text/javascript"></script>
    <script src="{{ url('js/fileinput/locales/' . config('app.locale') . '.js') }}" type="text/javascript"></script>
    
    <script>
        /* Initialize with defaults (filename) */
        $('#addFile').fileinput(
        {
            theme: 'fas',
            language: '{{ config('app.locale') }}',
            @if (config('lang.direction') == 'rtl')
                rtl: true,
            @endif
            allowedFileExtensions: {!! getUploadFileTypes('file', true) !!},
            maxFileSize: {{ (int)config('settings.upload.max_file_size', 1000) }},
            browseClass: 'btn btn-primary',
            browseIcon: '<i class="fas fa-camera" aria-hidden="true"></i>',
            layoutTemplates: {
                main1: '{browse}',
                main2: '{browse}',
                btnBrowse: '<div tabindex="500" class="{css}"{status}>{icon}</div>',
            }
        });
    </script>
@endsection