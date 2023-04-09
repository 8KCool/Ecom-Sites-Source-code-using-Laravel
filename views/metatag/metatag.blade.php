@extends('admin::layouts.master')

@section('after_styles')
    <!-- Ladda Buttons (loading buttons) -->
    <link href="{{ asset('vendor/admin/ladda/ladda-themeless.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/admin-theme/plugins/datatables/css/jquery.dataTables.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/admin-theme/plugins/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/admin-theme/plugins/datatables/extensions/Responsive/2.2.5/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('header')
	<div class="row page-titles">
		<div class="col-md-6 col-12 align-self-center">
			<h3 class="mb-0">
				{{ trans('admin.wallet_list') }}
			</h3>
		</div>
		<div class="col-md-6 col-12 align-self-center d-none d-md-block">
			<ol class="breadcrumb mb-0 p-0 bg-transparent float-right">
				<li class="breadcrumb-item"><a href="{{ admin_url() }}">{{ trans('admin.dashboard') }}</a></li>
				<li class="breadcrumb-item active">{{ trans('admin.wallet_list') }}</li>
			</ol>
		</div>
	</div>
@endsection

@section('content')
    <!-- Default box -->
	<div class="row">
		<div class="col-12">
			
			<div class="card rounded">
				<div class="card-header">
					<h3>{{ trans('admin.Wallet_lists') }}</h3>
				</div>
				
				<div class="card-body">
					<table class="table table-hover table-condensed" id="walletLists">
						<thead>
						<tr>
							<th>#</th>
                            <th>{{ trans('admin.user') }}</th>													
							<th>{{ trans('admin.payment method') }}</th>
                            <th>{{ trans('admin.Price') }}</th>	
							<th>{{ trans('admin.file_link') }}</th>
                            <th>{{ trans('admin.date') }}</th>
                            <th>{{ trans('admin.Status') }}</th>
							<th>{{ trans('admin.actions') }}</th>
						</tr>
						</thead>
						<tbody>
					
						</tbody>
					</table>
				</div>
			</div>

        </div>
    </div>

	<!-- /.modal -->

@endsection

@section('after_scripts')
    <!-- Ladda Buttons (loading buttons) -->
    <script src="{{ asset('vendor/admin/ladda/spin.js') }}"></script>
    <script src="{{ asset('vendor/admin/ladda/ladda.js') }}"></script>
    <script src="https://paiaki.com/vendor/admin-theme/plugins/datatables/js/jquery.dataTables.js" type="text/javascript"></script>
	<script src="https://paiaki.com/vendor/admin-theme/plugins/datatables.net-bs4/js/dataTables.bootstrap4.js" type="text/javascript"></script>
	<script src="https://paiaki.com/vendor/admin-theme/plugins/datatables/extensions/Responsive/2.2.5/dataTables.responsive.min.js" type="text/javascript"></script>
	<script src="https://paiaki.com/vendor/admin-theme/plugins/datatables/extensions/Responsive/2.2.5/responsive.bootstrap4.min.js" type="text/javascript"></script>
 <script type="text/javascript">
    $(document).ready(function(){
      // DataTable
      $('#walletLists').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength" : 10,
        "responsive": true,
        "order": [[5, "desc" ]],
        "columnDefs": [ {
            'targets': [0,3,4,7], /* column index */
            'orderable': false, /* true or false */
        }],
        "ajax": {
            "url": "{{ route('admin.ajax_walletlist') }}",
            "type": "POST"
        },
      });

    });

	$(document).on("change",".onchange_status",function(){
		var uploaddocid= $(this).attr("data-attr");
		var userid= $(this).attr('data-userid');
		var status= $('option:selected',this).val();
		var statusthis= $(this);
		if(uploaddocid!=""){
			$.ajax({
			method: "POST",
			url: "{{ route('admin.ajax_wallet_statusupdate') }}",
			data: { id: uploaddocid,status:status,userid:userid }
			})
			.done(function( msg ) {
				if(msg=="success"){
					if(status==1){
						$("#status_id_"+uploaddocid).html('<span class="badge badge-info">Approved</span>');
						statusthis.remove();
					} else if(status==2){
						$("#status_id_"+uploaddocid).html('<span class="badge badge-danger">Reject</span>');
					} else {
						$("#status_id_"+uploaddocid).html('<span class="badge badge-warning">Pending</span>');
					}
				}
			});
		}
	})
    </script>
@endsection
