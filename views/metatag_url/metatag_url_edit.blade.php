@extends('admin::layouts.master')

@section('header')
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h2 class="mb-0">
                <span class="text-capitalize">Meta Tags URL</span>
                <small> Edit meta tag url</small>
            </h2>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <ol class="breadcrumb mb-0 p-0 bg-transparent float-right">
                <li class="breadcrumb-item"><a href="{{ admin_url() }}">{{ trans('admin.dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ admin_url('/meta_tag_url/') }}" class="text-capitalize">Meta tag url</a></li>
                <li class="breadcrumb-item active">{{ trans('admin.add') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="flex-row d-flex justify-content-center">
        <?php
        $colMd = config('settings.style.admin_boxed_layout') == '1' ? ' col-md-12' : ' col-md-9';
        ?>
        <div class="col-sm-12{{ $colMd }}">
            
            <!-- Default box -->
            <a href="{{ admin_url('/meta_tag_url/') }}" class="btn btn-primary shadow">
                <i class="fa fa-angle-double-left"></i> {{ trans('admin.back_to_all') }}
            </a>
            <br><br>
            

            <form method="POST" action="{{ admin_url('/meta_tag_url/update/') }}" accept-charset="UTF-8">
               @csrf
            <div class="card border-top border-primary">
            
            <div class="card-header">
            <h3 class="mb-0">Edit meta tag (URL)</h3>
            </div>
            @if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			@if ($message = Session::get('success_message'))
				<div class="alert alert-success">
					<span>Meta tag (URL) salva com sucesso</span>
				</div>
			@endif
			@if ($metaDataDetails)
            <div class="card-body">
            <!-- load the view from the application if it exists, otherwise load the one in the package -->
            <div class="card mb-0">
                @foreach ($metaDataDetails as $metaData)
                    <div class="row">
            <!-- select2 from array -->
            <div class="form-group col-md-12">
            <label>URL</label>
            <input type="text" name="url" value="{{ $metaData->url }}" placeholder="URL" class="form-control">
            </div>
            <!-- text input -->
            <div class="form-group col-md-12">
            <label>Title</label>
            <i class="fas fa-flag-checkered pull-right" title="This field is translatable."></i>
            
            <input type="text" name="title" value="{{ $metaData->title }}" placeholder="Title" class="form-control">
            
            
            <small class="form-control-feedback">You can use dynamic variables such as <strong>{app_name}</strong> and <strong>{country}</strong> - e.g. {app_name} will be replaced with the name of your website and {country} by the selected country.</small>
            </div>
            
            <!-- textarea -->
            <div class="form-group col-md-12">
            <label>Description</label>
            <i class="fas fa-flag-checkered pull-right" title="This field is translatable."></i>
            <textarea name="description" placeholder="Description" class="form-control">{{ $metaData->description }}</textarea>
            
            
            <small class="form-control-feedback">You can use dynamic variables such as <strong>{app_name}</strong> and <strong>{country}</strong> - e.g. {app_name} will be replaced with the name of your website and {country} by the selected country.</small>
            </div>							<!-- text input -->
            <div class="form-group col-md-12">
            <label>Keywords</label>
            <i class="fas fa-flag-checkered pull-right" title="This field is translatable."></i>
            
            <input type="text" name="keywords" value="{{ $metaData->keywords }}" placeholder="Keywords" class="form-control">
            
            
            <small class="form-control-feedback">You can use dynamic variables such as <strong>{app_name}</strong> and <strong>{country}</strong> - e.g. {app_name} will be replaced with the name of your website and {country} by the selected country.</small>
            </div>
            <!-- checkbox field -->
            <div class="form-group col-md-12">
            <div class="checkbox">
            <label>
            <input type="hidden" name="active" value="0">
            <input type="checkbox" value="1" name="active" @if ($metaData->active==1) checked @endif> Active
            </label>
            
            
            </div>
            </div>
            </div>
                @endforeach
            </div>
            
            </div>
            @endif
            <div class="card-footer">
            <div id="saveActions" class="form-group">
            
            <input type="hidden" name="save_action" value="save_and_back">
            <input type="hidden" name="editid" value="{{ $metaData->id }}">
            
            <div class="btn-group">
            
            <button type="submit" class="btn btn-primary shadow">Save</button>
            
            </div>
            
            <a href="{{ admin_url('/meta_tag_url/') }}" class="btn btn-secondary shadow"><span class="fa fa-ban"></span> &nbsp;Cancel</a>
            </div>                </div>
            
            </div>
            </form>


        </div>
    </div>

@endsection
