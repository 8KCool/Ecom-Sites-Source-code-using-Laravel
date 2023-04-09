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
				{{ trans('admin.metatag_url_list') }}
			</h3>
		</div>
		<div class="col-md-6 col-12 align-self-center d-none d-md-block">
			<ol class="breadcrumb mb-0 p-0 bg-transparent float-right">
				<li class="breadcrumb-item"><a href="{{ admin_url() }}">{{ trans('admin.dashboard') }}</a></li>
				<li class="breadcrumb-item active">{{ trans('admin.metatag_url_list') }}</li>
			</ol>
		</div>
	</div>
@endsection

@section('content')
    <!-- Default box -->
	<div class="row">
		<div class="col-12">
			
			<div class="card rounded">
				<div class="card-header with-border">
					<a href="{{ admin_url('/meta_tag_url/create/') }}" class="btn btn-primary shadow ladda-button" data-style="zoom-in">
                		<span class="ladda-label">
                            <i class="fas fa-plus"></i> Add meta tag (URL)
                        </span>
                    </a>
	  		  		<button id="bulkDeleteBtn" class="btn btn-danger shadow"><i class="fas fa-times"></i> Delete Selected Items</button>
			  		<div id="datatable_button_stack" class="pull-right text-right"></div>
				</div>
				
				<div class="card-body">
					<table class="table table-hover table-condensed" id="walletLists">
						<thead>
						<tr>
							<th>#</th>
                            <th>{{ trans('admin.metatag_page_url') }}</th>
                            <th>{{ trans('admin.metatag_page_title') }}</th>
                            <th>{{ trans('admin.metatag_page_createdat') }}</th>
                            <th>{{ trans('admin.metatag_page_status') }}</th>
                            <th>{{ trans('admin.metatag_page_action') }}</th>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Meta Tag URL</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure want to delete?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="delete_meta_popup">Delete</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <input type="hidden" id="delete_metaid" value=""/>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2">Meta Tag URL</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure want to delete multiple meta tag?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="delete_meta_popup2">Delete</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>
    
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
        function deleteTags(deleteArr)
        {
            $.ajax({
              method: "POST",
              url: "{{ admin_url('/meta_tag_url/deletemetatag/') }}",
              data: { deleteids: deleteArr }
            }).done(function( msg ) {
                if(msg=="success"){
                    $.each(deleteArr, function( index, value ) {
                      $('.deletetag_'+value).parent('td').parent('tr').remove();
                    });
                    $("#exampleModal").modal("hide");
                    $("#exampleModal2").modal("hide");
                }
            });
        }
        
        $(document).ready(function(){
          // DataTable
          $('#walletLists').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength" : 10,
            "responsive": true,
            "order": [[3, "desc" ]],
            "columnDefs": [ {
                'targets': [0,4,5], /* column index */
                'orderable': false, /* true or false */
            }],
            "ajax": {
                "url": "{{ route('admin.ajax_meta_tag_url_list') }}",
                "type": "POST"
            },
          });
          
          $("#delete_meta_popup").click(function(){
                var deleteid= $("#delete_metaid").val();
                var deleteArr=[];
                deleteArr.push(deleteid);
                deleteTags(deleteArr)
          })
          
          $("#bulkDeleteBtn").click(function(){
              var isChecked=false;
              $.each($(".deletetag_chkbox:checked"), function(){
                isChecked=true;
              });
              if(isChecked==true){
                $("#exampleModal2").modal("show");
              }
          })
          
          $("#delete_meta_popup2").click(function(){
              var deleteArr=[];
              $.each($(".deletetag_chkbox:checked"), function(){
                deleteArr.push($(this).val());
              });
              deleteTags(deleteArr);
          })
          
          
          
        });
        
        $(document).on("click",".clckdelete_metatag",function(evt){
            evt.preventDefault();
            var deleteid= $(this).attr("data-delete");
            $("#delete_metaid").val(deleteid);
            $("#exampleModal").modal("show");
        })
    </script>
@endsection
