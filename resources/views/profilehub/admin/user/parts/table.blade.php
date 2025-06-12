<div class="table-responsive">
    <table class="table table-responsive table-striped table-hover table-active">
        <thead>
            <tr>
                @foreach ($son_fields as $table)
                    <th scope="col"><strong>{{ $table->translation }}</strong></th>
                @endforeach
            </tr>
        </thead>
        @php
            $sequence = 1;
        @endphp
        @for ($td = 0; $td < $detailsdata_rows; $td++)
            <tbody>
                @foreach ($son_fields as $table)
                    <td class="text-center">
                        @php
                            $user_entry = $userdetails->one_userfield_details_data($table->field_id, $table->son_id, $sequence, $user->id);
                        @endphp
                        @if ($table->field_type == 'dropdown' || $table->field_type == 'json' || $table->field_type == 'array')
                            @php
                                $has_son_data = $son_data->where('son_id', $table->son_id);
                                $has_son_data = $son_data->where('data_id', $user_entry);
                            @endphp
                            {{ $has_son_data->first() ? $has_son_data->first()->data_value : '' }}
                        @elseif($table->field_type == 'date')
                            {{ $user_entry }}
                        @else
                            {{ $user_entry }}
                        @endif

                    </td>
                @endforeach
            </tbody>
            @php
                $sequence++;
            @endphp
        @endfor
    </table>
</div>