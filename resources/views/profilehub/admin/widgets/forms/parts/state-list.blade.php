<select class="form-control" id="{{ $dropdown_id }}" name="{{ $dropdown_name }}" data-live-search="true" {{ $required_settings }}  >
	<option value="">Please select a state / province / region... </option>
	@foreach($all_states as $state)
		<option value="{{ $state->state_id }}" {{ ($selected_option==$state->state_id ? 'selected="selected"' : '') }}>{{ $state->state_name }}</option>
	@endforeach
</select>
