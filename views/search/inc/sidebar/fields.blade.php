@if (isset($customFields) and $customFields->count() > 0)
	<form id="cfForm" role="form" class="form" action="{{ request()->url() }}" method="GET">
		<?php
		$disabledFieldsTypes = ['file', 'video'];
		$clearFilterBtn = '';
		$firstFieldFound = false;
		?>
		@foreach($customFields as $field)
			@continue(in_array($field->type, $disabledFieldsTypes) or $field->use_as_filter != 1)
			<?php
			// Fields parameters
			$fieldId = 'cf.' . $field->id;
			$fieldName = 'cf[' . $field->id . ']';
			$fieldOld = 'cf.' . $field->id;
			
			// Get the default value
			$defaultValue = (request()->filled($fieldOld)) ? request()->input($fieldOld) : $field->default_value;
			
			// Field Query String
			$fieldQueryString = '<input type="hidden" id="cf' . $field->id . 'QueryString" value="' . httpBuildQuery(request()->except(['page', $fieldId])) . '">';
			
			// Clear Filter Button
			$clearFilterBtn = \App\Helpers\UrlGen::getCustomFieldFilterClearLink($fieldOld, $cat ?? null, $city ?? null);
			?>
			
			@if (in_array($field->type, ['text', 'textarea', 'url', 'number']))
				
				<!-- text -->
				<div class="block-title sidebar-header">
					<h5>
						<span class="font-weight-bold">
							{{ $field->name }}
						</span> {!! $clearFilterBtn !!}
					</h5>
				</div>
				<div class="block-content list-filter">
					<div class="filter-content row">
						<div class="form-group col-lg-9 col-md-12 col-sm-12">
							<input id="{{ $fieldId }}"
								   name="{{ $fieldName }}"
								   type="{{ ($field->type == 'number') ? 'number' : 'text' }}"
								   placeholder="{{ $field->name }}"
								   class="form-control input-md"
								   value="{{ strip_tags($defaultValue) }}"{!! ($field->type == 'number') ? ' autocomplete="off"' : '' !!}
							>
						</div>
						<div class="form-group col-lg-3 col-md-12 col-sm-12">
							<button class="btn btn-primary pull-right btn-block-md btn-block-xs" type="submit">Ver</button>
						</div>
					</div>
				</div>
				{!! $fieldQueryString !!}
				<div style="clear:both"></div>
			
			@endif
			@if ($field->type == 'checkbox')
				
				<!-- checkbox -->
				<div class="block-title sidebar-header">
					<h5>
						<span class="font-weight-bold"><a rel="nofollow" href="#">{{ $field->name }}</a></span> {!! $clearFilterBtn !!}
					</h5>
				</div>
				<div class="block-content list-filter">
					<div class="filter-content">
						<div class="form-check">
							<input id="{{ $fieldId }}"
								   name="{{ $fieldName }}"
								   value="1"
								   type="checkbox"
								   class="form-check-input"
									{{ ($defaultValue == '1') ? 'checked="checked"' : '' }}
							>
							<label class="form-check-label" for="{{ $fieldId }}">
								{{ $field->name }}
							</label>
						</div>
					</div>
				</div>
				{!! $fieldQueryString !!}
				<div style="clear:both"></div>
			
			@endif
			@if ($field->type == 'checkbox_multiple')
				
				@if ($field->options->count() > 0)
					<!-- checkbox_multiple -->
					<div class="block-title sidebar-header">
						<h5>
							<span class="font-weight-bold">
								{{ $field->name }}
							</span> {!! $clearFilterBtn !!}
						</h5>
					</div>
					<div class="block-content list-filter">
						<?php $cmFieldStyle = ($field->options->count() > 12) ? ' style="height: 250px; overflow-y: scroll;"' : ''; ?>
						<div class="filter-content"{!! $cmFieldStyle !!}>
							@foreach ($field->options as $option)
								<?php
								// Get the default value
								$defaultValue = (request()->filled($fieldOld . '.' . $option->id))
									? request()->input($fieldOld . '.' . $option->id)
									: (
										(is_array($field->default_value) && isset($field->default_value[$option->id], $field->default_value[$option->id]->value))
											? $field->default_value[$option->id]->value
											: $field->default_value
									);
								
								// Field Query String
								$fieldQueryString = '<input type="hidden" id="cf' . $field->id . $option->id . 'QueryString"
									value="' . httpBuildQuery(request()->except(['page', $fieldId . '.' . $option->id])) . '">';
								?>
								<div class="form-check">
									<input id="{{ $fieldId . '.' . $option->id }}"
										   name="{{ $fieldName . '[' . $option->id . ']' }}"
										   value="{{ $option->id }}"
										   type="checkbox"
										   class="form-check-input"
											{{ ($defaultValue == $option->id) ? 'checked="checked"' : '' }}
									>
									<label class="form-check-label" for="{{ $fieldId . '.' . $option->id }}">
										{{ $option->value }}
									</label>
								</div>
								{!! $fieldQueryString !!}
							@endforeach
						</div>
					</div>
					<div style="clear:both"></div>
				@endif
			
			@endif
			@if ($field->type == 'radio')
				
				@if ($field->options->count() > 0)
					<!-- radio -->
					<div class="block-title sidebar-header">
						<h5>
							<span class="font-weight-bold">
								{{ $field->name }}
							</span> {!! $clearFilterBtn !!}
						</h5>
					</div>
					<div class="block-content list-filter">
						<?php $rFieldStyle = ($field->options->count() > 12) ? ' style="height: 250px; overflow-y: scroll;"' : ''; ?>
						<div class="filter-content"{!! $rFieldStyle !!}>
							@foreach ($field->options as $option)
								<div class="form-check">
									<input id="{{ $fieldId }}"
										   name="{{ $fieldName }}"
										   value="{{ $option->id }}"
										   type="radio"
										   class="form-check-input"
											{{ ($defaultValue == $option->id) ? 'checked="checked"' : '' }}
									>
									<label class="form-check-label" for="{{ $fieldId }}">
										{{ $option->value }}
									</label>
								</div>
							@endforeach
						</div>
					</div>
					{!! $fieldQueryString !!}
					<div style="clear:both"></div>
				@endif
				
			@endif
			@if ($field->type == 'select')
			
				<!-- select -->
				<div class="block-title sidebar-header">
					<h5>
						<span class="font-weight-bold">
							{{ $field->name }}
						</span> {!! $clearFilterBtn !!}
					</h5>
				</div>
				<div class="block-content list-filter">
					<div class="filter-content">
						<?php
							$select2Type = ($field->options->count() <= 10) ? 'selecter' : 'sselecter';
						?>
						<select id="{{ $fieldId }}" name="{{ $fieldName }}" class="form-control {{ $select2Type }}">
							<option value=""
									@if (old($fieldOld) == '' or old($fieldOld) == 0)
										selected="selected"
									@endif
							>
								{{ t('Select') }}
							</option>
							@if ($field->options->count() > 0)
								@foreach ($field->options as $option)
									<option value="{{ $option->id }}"
											@if ($defaultValue == $option->id)
												selected="selected"
											@endif
									>
										{{ $option->value }}
									</option>
								@endforeach
							@endif
						</select>
					</div>
				</div>
				{!! $fieldQueryString !!}
				<div style="clear:both"></div>
			
			@endif
			@if (in_array($field->type, ['date', 'date_time', 'date_range']))
			
				<!-- date -->
				<div class="block-title sidebar-header">
					<h5>
						<span class="font-weight-bold">
							{{ $field->name }}
						</span> {!! $clearFilterBtn !!}
					</h5>
				</div>
				<?php
				$datePickerClass = '';
				if (in_array($field->type, ['date', 'date_time'])) {
					$datePickerClass = ' cf-date';
				}
				if ($field->type == 'date_range') {
					$datePickerClass = ' cf-date_range';
				}
				?>
				<div class="block-content list-filter">
					<div class="filter-content row">
						<div class="form-group col-lg-9 col-md-12 col-sm-12">
							<input id="{{ $fieldId }}"
								   name="{{ $fieldName }}"
								   type="text"
								   placeholder="{{ $field->name }}"
								   class="form-control input-md{{ $datePickerClass }}"
								   value="{{ strip_tags($defaultValue) }}"
								   autocomplete="off"
							>
						</div>
						<div class="form-group col-lg-3 col-md-12 col-sm-12">
							<button class="btn btn-default pull-right btn-block-md btn-block-xs" type="submit">Ir</button>
						</div>
					</div>
				</div>
				{!! $fieldQueryString !!}
				<div style="clear:both"></div>
			
			@endif
			
		@endforeach
	</form>
	<div style="clear:both"></div>
@endif

@section('after_styles')
	<link href="{{ url('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection
@section('after_scripts')
	@parent
	<script src="{{ url('assets/plugins/momentjs/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function ()
		{
			/* Select */
			$('#cfForm').find('select').change(function() {
				/* Get full field's ID */
				var fullFieldId = $(this).attr('id');
				
				/* Get full field's ID without dots */
				var jsFullFieldId = fullFieldId.split('.').join('');
				
				/* Get real field's ID */
				var tmp = fullFieldId.split('.');
				if (typeof tmp[1] !== 'undefined') {
					var fieldId = tmp[1];
				} else {
					return false;
				}
				
				/* Get saved QueryString */
				var fieldQueryString = $('#' + jsFullFieldId + 'QueryString').val();
				
				/* Add the field's value to the QueryString */
				if (fieldQueryString !== '') {
					fieldQueryString = fieldQueryString + '&';
				}
				fieldQueryString = fieldQueryString + 'cf['+fieldId+']=' + $(this).val();
				
				/* Redirect to the new search URL */
				var searchUrl = baseUrl + '?' + fieldQueryString;
				redirect(searchUrl);
			});
			
			/* Radio & Checkbox */
			$('#cfForm').find('input[type=radio], input[type=checkbox]').click(function() {
				/* Get full field's ID */
				var fullFieldId = $(this).attr('id');
				
				/* Get full field's ID without dots */
				var jsFullFieldId = fullFieldId.split('.').join('');
				
				/* Get real field's ID */
				var tmp = fullFieldId.split('.');
				if (typeof tmp[1] !== 'undefined') {
					var fieldId = tmp[1];
					if (typeof tmp[2] !== 'undefined') {
						var fieldOptionId = tmp[2];
					}
				} else {
					return false;
				}
				
				/* Get saved QueryString */
				var fieldQueryString = $('#' + jsFullFieldId + 'QueryString').val();
				
				/* Check if field is checked */
				if ($(this).prop('checked') == true) {
					/* Add the field's value to the QueryString */
					if (fieldQueryString != '') {
						fieldQueryString = fieldQueryString + '&';
					}
					if (typeof fieldOptionId !== 'undefined') {
						fieldQueryString = fieldQueryString + 'cf[' + fieldId + '][' + fieldOptionId + ']=' + rawurlencode($(this).val());
					} else {
						fieldQueryString = fieldQueryString + 'cf[' + fieldId + ']=' + $(this).val();
					}
				}
				
				/* Redirect to the new search URL */
				var searchUrl = baseUrl + '?' + fieldQueryString;
				redirect(searchUrl);
			});
			
			/*
			 * Custom Fields Date Picker
			 * https://www.daterangepicker.com/#options
			 */
			{{-- Single Date --}}
			$('#cfForm .cf-date').daterangepicker({
				autoUpdateInput: false,
				autoApply: true,
				showDropdowns: true,
				minYear: parseInt(moment().format('YYYY')) - 100,
				maxYear: parseInt(moment().format('YYYY')) + 20,
				locale: {
					format: '{{ t('datepicker_format') }}',
					applyLabel: "{{ t('datepicker_applyLabel') }}",
					cancelLabel: "{{ t('datepicker_cancelLabel') }}",
					fromLabel: "{{ t('datepicker_fromLabel') }}",
					toLabel: "{{ t('datepicker_toLabel') }}",
					customRangeLabel: "{{ t('datepicker_customRangeLabel') }}",
					weekLabel: "{{ t('datepicker_weekLabel') }}",
					daysOfWeek: [
						"{{ t('datepicker_sunday') }}",
						"{{ t('datepicker_monday') }}",
						"{{ t('datepicker_tuesday') }}",
						"{{ t('datepicker_wednesday') }}",
						"{{ t('datepicker_thursday') }}",
						"{{ t('datepicker_friday') }}",
						"{{ t('datepicker_saturday') }}"
					],
					monthNames: [
						"{{ t('January') }}",
						"{{ t('February') }}",
						"{{ t('March') }}",
						"{{ t('April') }}",
						"{{ t('May') }}",
						"{{ t('June') }}",
						"{{ t('July') }}",
						"{{ t('August') }}",
						"{{ t('September') }}",
						"{{ t('October') }}",
						"{{ t('November') }}",
						"{{ t('December') }}"
					],
					firstDay: 1
				},
				singleDatePicker: true,
				startDate: moment().format('{{ t('datepicker_format') }}')
			});
			$('#cfForm .cf-date').on('apply.daterangepicker', function(ev, picker) {
				$(this).val(picker.startDate.format('{{ t('datepicker_format') }}'));
			});
			
			{{-- Date Range --}}
			$('#cfForm .cf-date_range').daterangepicker({
				autoUpdateInput: false,
				autoApply: true,
				showDropdowns: false,
				minYear: parseInt(moment().format('YYYY')) - 100,
				maxYear: parseInt(moment().format('YYYY')) + 20,
				locale: {
					format: '{{ t('datepicker_format') }}',
					applyLabel: "{{ t('datepicker_applyLabel') }}",
					cancelLabel: "{{ t('datepicker_cancelLabel') }}",
					fromLabel: "{{ t('datepicker_fromLabel') }}",
					toLabel: "{{ t('datepicker_toLabel') }}",
					customRangeLabel: "{{ t('datepicker_customRangeLabel') }}",
					weekLabel: "{{ t('datepicker_weekLabel') }}",
					daysOfWeek: [
						"{{ t('datepicker_sunday') }}",
						"{{ t('datepicker_monday') }}",
						"{{ t('datepicker_tuesday') }}",
						"{{ t('datepicker_wednesday') }}",
						"{{ t('datepicker_thursday') }}",
						"{{ t('datepicker_friday') }}",
						"{{ t('datepicker_saturday') }}"
					],
					monthNames: [
						"{{ t('January') }}",
						"{{ t('February') }}",
						"{{ t('March') }}",
						"{{ t('April') }}",
						"{{ t('May') }}",
						"{{ t('June') }}",
						"{{ t('July') }}",
						"{{ t('August') }}",
						"{{ t('September') }}",
						"{{ t('October') }}",
						"{{ t('November') }}",
						"{{ t('December') }}"
					],
					firstDay: 1
				},
				startDate: moment().format('{{ t('datepicker_format') }}'),
				endDate: moment().add(1, 'days').format('{{ t('datepicker_format') }}')
			});
			$('#cfForm .cf-date_range').on('apply.daterangepicker', function(ev, picker) {
				$(this).val(picker.startDate.format('{{ t('datepicker_format') }}') + ' - ' + picker.endDate.format('{{ t('datepicker_format') }}'));
			});
		});
	</script>
@endsection