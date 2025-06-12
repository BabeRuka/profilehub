@php
$group_layout = $page_data->first() ? $page_data->where('page_key', 'group_layout') : null;
$glayout = $group_layout != null && $group_layout->first() ? $group_layout->first()->page_data : '';
@endphp
 <i class="fa fa-address-book" aria-hidden="true"></i> <strong>Additional Fields</strong>
 <hr />
 <div class="{{ $glayout == 'cards' ? 'card' : '' }}">
     <div class="">
         
             <div class="row">
                 @foreach ($userdetails->user_field_groups() as $rowid => $group)
                     @php
                         $gs = $page_data->where('page_module', $group->group_id);
                         $group_enabled = $gs->first() ? $gs->where('page_key', 'group_enabled') : null;
                         $genabled =
                             $group_enabled != null && $group_enabled->first()
                                 ? ($group_enabled->first()->page_data > 0
                                     ? 1
                                     : 0)
                                 : 0;

                         $group_settings = $page_data->where('page_module', 'input_layout');
                         $group_layout = $group_settings->first()
                             ? $group_settings->where('page_key', 'group_layout')
                             : null;
                         $glayout =
                             $group_layout != null && $group_layout->first() ? $group_layout->first()->page_data : '';

                         $group_settings = $page_data->where('page_module', 'cols');
                         $group_input = $group_settings->first()
                             ? $group_settings->where('page_key', 'group_layout')
                             : null;
                         $ginput =
                             $group_input != null && $group_input->first() ? $group_input->first()->page_data : null;

                         $group_input = $gs->first() ? $gs->where('page_key', 'group_input') : null;
                         $group_input =
                             $group_input != null && $group_input->first() ? $group_input->first()->page_data : null;

                     @endphp
                     @if ($genabled > 0)
                         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                             <div class="card-header">
                                 @if ($rowid == 0)
                                 @endif

                                 <i class="fa {{ $group->group_icon }}" aria-hidden="true"></i> {{ $group->group_name }}
                             </div>
                             <div class="{{ $glayout == 'cards' ? 'card-body' : 'row card-body' }}">
                                 @php
                                     if ($glayout == 'cards') {
                                         echo '<div class="row">';
                                     }
                                 @endphp
                                 @foreach ($userdetails->user_field(0, $group->group_id) as $field)
                                     @php
                                         $page_settings = $page_data->where('page_module', $field->field_id);
                                         $input_enabled = $page_settings->first()
                                             ? $page_settings->where('page_key', 'page_input')
                                             : null;
                                         $input_enabled = $input_enabled->first()
                                             ? ($input_enabled->first()->page_data > 0
                                                 ? 1
                                                 : 0)
                                             : 0;

                                         $input_required = $page_settings->first()
                                             ? $page_settings->where('page_key', 'page_input_required')
                                             : null;
                                         $input_required = $input_required->first()
                                             ? ($input_required->first()->page_data > 0
                                                 ? 'required'
                                                 : '')
                                             : '';
                                         $input_required = 'required';
                                         $input_settings = $page_settings->first()
                                             ? $page_settings->where('page_key', 'page_input_settings')
                                             : null;
                                         $input_settings =
                                             $input_settings->first() && $input_settings->first()->page_data
                                                 ? json_decode($input_settings->first()->page_data)
                                                 : null;
                                         $input_type = $input_settings != null ? $input_settings->input : 'text';
                                     @endphp
                                     @php
                                         if ($glayout == 'cards') {
                                             echo '<div class="' . $group_input . '">';
                                         }
                                     @endphp
                                     @if ($input_enabled > 0)
                                         @php
                                             echo $glayout == 'form-group' ? '<div class="' . $group_input . '">' : '';
                                         @endphp
                                         @if ($field->type_field == 'dropdown')
                                             <label class="label label-default"
                                                 for="user_entry_{{ $field->field_id }}">{{ strtoupper($field->translation) }}
                                             </label>
                                             <div class="form-group">
                                                 <div class="form-line">
                                                     <select class="form-control p-2"
                                                         id="user_entry_{{ $field->field_id }}"
                                                         name="user_entry[{{ $field->field_id }}]" required>
                                                         <option value="">Select an option...</option>
                                                         @foreach ($userdetails->user_field_son($field->field_id) as $son)
                                                             <option value="{{ $son->son_id }}"
                                                                 {{ $son->translation == $userdetails->one_user_field_details($field->field_id, $user->id) ? 'selected="selected"' : '' }}>
                                                                 {{ strtoupper($son->translation) }}</option>
                                                         @endforeach
                                                     </select>
                                                 </div>
                                             </div>
                                         @elseif ($field->type_field == 'date')
                                             <label class="label label-default"
                                                 for="user_entry_{{ $field->field_id }}">{{ $field->translation }}</label>
                                             <div class="form-group">
                                                 <div class="form-line">
                                                     <input type="text" id="user_entry_{{ $field->field_id }}"
                                                         name="user_entry[{{ $field->field_id }}]"
                                                         value="{{ $userdetails->one_user_field_details($field->field_id, $user->id) }}"
                                                         class="form-control"
                                                         placeholder="Enter {{ $field->translation }}" required>
                                                 </div>
                                             </div>
                                         @elseif ($field->type_field == 'country')
                                             <label class="label label-default"
                                                 for="user_entry_{{ $field->field_id }}">{{ $field->translation }}</label>
                                             <div class="form-group">
                                                 <div class="form-line">
                                                     <select class="form-control p-2"
                                                         id="user_entry_{{ $field->field_id }}"
                                                         name="user_entry[{{ $field->field_id }}]" required>
                                                         <option value="">Select an option...</option>
                                                         @foreach ($all_countries as $country)
                                                             <option value="{{ $country->country_code }}"
                                                                 {{ $country->country_code == $userdetails->one_user_field_details($field->field_id, $user->id) ? 'selected="selected"' : '' }}>
                                                                 {{ strtoupper($country->country_name) }}</option>
                                                         @endforeach
                                                         <option value="ZA"
                                                             {{ 'ZA' == $userdetails->one_user_field_details($field->field_id, $user->id) ? 'selected="selected"' : '' }}>
                                                             South Africa</option>
                                                     </select>
                                                 </div>
                                             </div>
                                         @else
                                             <label class="label label-default"
                                                 for="user_entry_{{ $field->field_id }}">{{ $field->translation }}</label>
                                             <div class="form-group">
                                                 <div class="form-line">
                                                     @if (in_array($field->type_field, $html_inputs))
                                                         @if ($input_type == 'textarea')
                                                             <textarea type="text" id="{{ $default }}" name="{{ $default }}" class="form-control"
                                                                 placeholder="Enter your {{ $default }}..." {{ $input_required }}>@php echo $user->$default  @endphp</textarea>
                                                         @else
                                                             <input type="{{ $input_type }}"
                                                                 id="user_entry_{{ $field->field_id }}"
                                                                 name="user_entry[{{ $field->field_id }}]"
                                                                 value="{{ $userdetails->one_user_field_details($field->field_id, $user->id) }}"
                                                                 class="form-control"
                                                                 placeholder="Enter {{ $field->translation }}"
                                                                 required>
                                                         @endif
                                                     @else
                                                         <input type="text" id="user_entry_{{ $field->field_id }}"
                                                             name="user_entry[{{ $field->field_id }}]"
                                                             value="{{ $userdetails->one_user_field_details($field->field_id, $user->id) }}"
                                                             class="form-control"
                                                             placeholder="Enter {{ $field->translation }}" required>
                                                     @endif
                                                 </div>
                                             </div>
                                         @endif
                                         @php echo $glayout == 'form-group' ? '</div>' : '' @endphp
                                     @endif
                                     @php
                                         if ($glayout == 'cards' && $field->type_field != 'table') {
                                             echo '</div>';
                                         }
                                     @endphp
                                 @endforeach
                                 @php
                                     if ($glayout == 'cards') {
                                         echo '</div>';
                                     }
                                 @endphp
                             </div>

                         </div>
                     @endif
                 @endforeach
             </div>
         </div>
     </div>
 
