@php
$user_data = $UserAdmin->user_data_summary();
@endphp
<div class="{{ $widget->page_row }}">
    <div class="card">
        <div class="card-header"><i class="fa {{ $widget->module_icon }}"></i> {{ $widget->module_name }}
        </div>
        <div class="card-body">

            <div class="card mb-3">
                <div class="row no-gutters">

                    <div class="col-md-8">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-value-xl"><?php echo count($allusers); ?></div>
                                            <div class="text-uppercase text-muted small">Users</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-value-xl"><?php echo count($active_users); ?></div>
                                            <div class="text-uppercase text-muted small">Active Users</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-value-xl"><?php echo $user_data != null && $user_data->first() ? $user_data->first()->num_suspended : ''; ?></div>
                                            <div class="text-uppercase text-muted small">Suspended</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-value-xl"><?php echo $user_data != null && $user_data->first() ? $user_data->first()->online_users : ''; ?></div>
                                            <div class="text-uppercase text-muted small">Online Users</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-value-xl"><?php echo $user_data != null && $user_data->first() ? $user_data->first()->num_admins : ''; ?></div>
                                            <div class="text-uppercase text-muted small">Administrators</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="text-value-xl"><?php echo $user_data != null && $user_data->first() ? $user_data->first()->num_students : ''; ?></div>
                                            <div class="text-uppercase text-muted small">Active Users</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">

                        <ul class="list-group">
                            <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                                Manage
                            </a>
                            <li class="list-group-item"><i class="fa fa-plus-circle" aria-hidden="true"></i><a
                                    href="/admin/users/create">Add Users</a></li>
                            <li class="list-group-item"><i class="fa fa-user-plus" aria-hidden="true"></i><a
                                    href="/admin/users">Manage Users</a></li>
                            <li class="list-group-item"><i class="fa fa-users" aria-hidden="true"></i><a
                                    href="/admin/groups/users">Manage Groups</a></li>
                            <li class="list-group-item"><i class="fa fa-plus-square-o" aria-hidden="true"></i><a
                                    href="/admin/users/additional%20fields">Manage Additional Fields</a></li>
                        </ul>

                    </div>


                </div>
            </div>


            <div class="card-footer ">

            </div>
        </div>
    </div>
</div>
