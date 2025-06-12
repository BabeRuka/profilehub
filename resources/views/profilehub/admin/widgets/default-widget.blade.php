<div class="{{ $widget->page_row ? $widget->page_row : '12' }}">
    <div class="card">
        <div class="card-header"><i class="fa fa-link"></i> Quick Administration
        </div>
        <div class="card-body">
            <div class="row">

                <!--/.col-->
                <div class="col-6 col-lg-3 col-xl-3 col-xxl-3 col-md-3">
                    <div class="cards">
                        <div class="card-body p-0 clearfix">
                            <i class="fa fa-user-circle-o p-4 font-5xl mr-3 float-left"></i>
                            <div class="h5 font-weight-bold mb-0 pt-4">Users</div>
                            <div class="text-muted text-uppercase font-weight-bold font-xs"><a href="/admin/users/create" class="text-muted">Add User</a></div>
                        </div>
                    </div>
                </div>
                <!--/.col-->

                <!--/.col-->
                <div class="col-6 col-lg-3 col-xl-3 col-xxl-3 col-md-3">
                    <div class="cards">
                        <div class="card-body p-0 clearfix">
                            <i class="fa fa-plus-square-o p-4 font-5xl mr-3 float-left"></i>
                            <div class="h5 font-weight-bold mb-0 pt-4">Additional Fields</div>
                            <div class="text-muted text-uppercase font-weight-bold font-xs"><a href="/admin/users/additional%20fields" class="text-muted">Add Field</a></div>
                        </div>
                    </div>
                </div>
                <!--/.col-->
 

            </div>
        </div>
    </div>
</div>
