<label>Widgets</label>
<div class="row mb-3" id="sortable-grid">
    <div class="col-4 mb-3">
        <div class="row">
            <div class="col-12">
                <div class="card h-100 bg-light">
                    <div class="card-header">
                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                        <span id="default_widget_title">Default</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group input-group-sm">
                                    <?php
                                    $page_module = $all_page_module->where('widget_key', '_DEFAULT');
                                    $page_module = $page_module->firstWhere('widget_value', '2');

                                    $page_col = $all_page_col->firstWhere('widget_key', '_DEFAULT');
                                    $page_row = $all_page_row->firstWhere('widget_key', '_DEFAULT');

                                    $widget_value = '';

                                    ?>
                                    <input class="form-control input-sm" type="text" value="Card #1" disabled readonly />
                                    <select name="page_module[_DEFAULT]" id="page_module_DEFAULT"
                                        class="form-control input-sm">
                                        <option <?php
                                        if ($page_module) {
                                            echo $page_module['widget_value'] == '2' ? 'selected="selected"' : '';
                                        }
                                        ?> value="_DEFAULT">
                                            Enabled</option>
                                        <option <?php
                                        if (!$page_module) {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="">Disabled</option>
                                    </select>

                                    <select name="page_col[_DEFAULT]" id="page_col_DEFAULT"
                                        class="form-control input-sm">
                                        <option <?php
                                        if ($page_col) {
                                            echo $page_col['widget_value'] == 'left_col' ? 'selected="selected"' : '';
                                        }
                                        ?> value="left_col_right_col">Left & Right Columns</option>
                                    </select>


                                    <select name="page_row[_DEFAULT]" id="page_row_DEFAULT"
                                        class="form-control input-sm">
                                        <option value="col-xl-12 col-lg-12" <?php
                                        if ($page_row) {
                                            echo $page_row['widget_value'] == 'col-xl-12 col-lg-12' ? 'selected="selected"' : '';
                                        }
                                        ?>>
                                            One card per row</option>
                                        <option value="col-xl-6 col-lg-6 col-md-6 col-sm-12" <?php
                                        if ($page_row) {
                                            echo $page_row['widget_value'] == 'col-xl-6 col-lg-6 col-md-6 col-sm-12' ? 'selected="selected"' : '';
                                        }
                                        ?>>
                                            Two cards per row</option>
                                        <option value="col-xl-4 col-lg-4 col-md-4 col-sm-4" <?php
                                        if ($page_row) {
                                            echo $page_row['widget_value'] == 'col-xl-4 col-lg-4 col-md-4 col-sm-4' ? 'selected="selected"' : '';
                                        }
                                        ?>>
                                            Three cards per row</option>
                                        <option value="col-xl-3 col-lg-3 col-md-3 col-sm-3" <?php
                                        if ($page_row) {
                                            echo $page_row['widget_value'] == 'col-xl-3 col-lg-3 col-md-3 col-sm-3' ? 'selected="selected"' : '';
                                        }
                                        ?>>
                                            Four cards per row</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $number = 2;
    @endphp
    @foreach ($page_modules as $module)
        <!--third layout start [col-9-left col-3-right]-->
        <?php
        $page_module = $all_page_module->where('widget_key', $module->mudule_slug);
        $page_module = $page_module->firstWhere('widget_value', '2');
        $page_col = $all_page_col->firstWhere('widget_key', $module->mudule_slug);
        $page_row = $all_page_row->firstWhere('widget_key', $module->mudule_slug);
        $widget_value = '';
        ?>
        <div class="col-4 mb-3">
            <div class="row">
                <div class="col-12">
                    <div class="card h-100 bg-light">
                        <div class="card-header">
                            <i class="fa {{ $module->module_icon }}"></i>
                            {{ $module->module_name }}

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">

                                    <div class="form-group input-group-sm">
                                        <input type="hidden" name="sortable[]" value="{{ $module->mudule_slug }}" />

                                        <input class="form-control input-sm" type="text" value="Card #{{ $number }}" disabled readonly />
                                        <select name="page_module[{{ $module->mudule_slug }}]"
                                            id="page_module{{ $module->mudule_slug }}" class="form-control input-sm">
                                            <option <?php
                                            if ($page_module) {
                                                echo $page_module->widget_value == '2' ? 'selected="selected"' : '';
                                            }
                                            ?> value="{{ $module->mudule_slug }}">
                                                <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                                Enabled
                                            </option>
                                            <option value="" <?php if (!$page_module) {
                                                echo 'selected="selected"';
                                            } ?>>
                                                Disabled
                                                <?php echo $widget_value; ?>
                                            </option>
                                        </select>

                                        <select name="page_col[{{ $module->mudule_slug }}]"
                                            id="page_col{{ $module->mudule_slug }}" class="form-control input-sm">
                                            <option <?php
                                            if ($page_col) {
                                                echo $page_col['widget_value'] == 'left_col' ? 'selected="selected"' : '';
                                            }
                                            ?> value="left_col">Left
                                                Column</option>
                                            <option <?php
                                            if ($page_col) {
                                                echo $page_col['widget_value'] == 'right_col' ? 'selected="selected"' : '';
                                            }
                                            ?> value="right_col">Right
                                                Column</option>
                                        </select>

                                        <select name="page_row[{{ $module->mudule_slug }}]"
                                            id="page_row{{ $module->mudule_slug }}" class="form-control input-sm">
                                            <option <?php
                                            if ($page_row) {
                                                echo $page_row['widget_value'] == 'col-xl-12 col-lg-12' ? 'selected="selected"' : '';
                                            }
                                            ?> value="col-xl-12 col-lg-12">
                                                One card per row</option>
                                            <option <?php
                                            if ($page_row) {
                                                echo $page_row['widget_value'] == 'col-xl-6 col-lg-6 col-md-6 col-sm-12' ? 'selected="selected"' : '';
                                            }
                                            ?> value="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                Two cards per row</option>
                                            <option <?php
                                            if ($page_row) {
                                                echo $page_row['widget_value'] == 'col-xl-4 col-lg-4 col-md-4 col-sm-4' ? 'selected="selected"' : '';
                                            }
                                            ?> value="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                                Three cards per row</option>
                                            <option <?php
                                            if ($page_row) {
                                                echo $page_row['widget_value'] == 'col-xl-3 col-lg-3 col-md-3 col-sm-3' ? 'selected="selected"' : '';
                                            }
                                            ?> value="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                                                Four cards per row</option>
                                        </select>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
            $number++;
        @endphp
        <!--third layout end-->
    @endforeach


</div>
