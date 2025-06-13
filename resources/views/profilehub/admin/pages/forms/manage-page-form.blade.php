<form class="needs-validation" action="{{ route('profilehub.admin.layout.createrecord') }}" method="POST" id="addRoleForm" novalidate>
    <input type="hidden" name="function" value="add-page">
    @csrf

    <div class="row">
        <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12 col-md-8">
            <div class="overflow-autos">

                <div class="row mb-3">
                    <div class="col">
                        <label for="page_type">Type</label>
                        <select class="form-control" name="page_type" id="page_type" required="required">
                            <option value="">Please select a page type...</option>
                            @foreach ($widget_types as $key => $widget)
                                <option value="{{ $key }}">{{ $widget }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>



                <div class="row mb-3">
                    <div class="col-12">
                        <label>Name</label>
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="{{ __('Enter page name...') }}"
                                name="page_name" id="page_name" required="required">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


</form>
