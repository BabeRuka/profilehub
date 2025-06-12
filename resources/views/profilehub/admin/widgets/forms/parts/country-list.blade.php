<select class="form-control" id="{{ $dropdown_id }}" name="{{ $dropdown_name }}" data-live-search="true" {{ $required_settings }} >
	<option value="">Please select a country... </option>
	@foreach($all_countries as $country)
		<option value="{{ $country->country_id }}" {{ ($selected_option==$country->country_id ? 'selected="selected"' : '') }}>{{ $country->country_name }}</option>
	@endforeach
</select>
