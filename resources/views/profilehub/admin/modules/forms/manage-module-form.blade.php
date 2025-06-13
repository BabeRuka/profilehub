<form class="needs-validation" action="{{ route('profilehub.admin.modules.update') }}" method="POST" novalidate>
    <input type="hidden" name="function" value="update-module" />
    @csrf
    @method('POST')
    <input type="hidden" name="group_id" value="{{ ($request->input('group_id') ? $request->input('group_id') : 0) }}" />
    <input type="hidden" name="module_id" id="module_id" value="0" />
    <div class="row">
        <div class="col-12">
            <label for="module_name">Module Name</label>
            <div class="form-group">
                <div class="form-line">
                    <input disabled readonly type="text" id="module_name" name="module_name" value="" class="form-control" placeholder="Enter the module name..." required>
                    <div class="invalid-feedback">
                        Module name is required.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <label for="module_icon">Module Icon</label>
            <div class="form-group">
                <div class="form-line">
                    <input type="text" id="module_icon" name="module_icon" value="" class="form-control" placeholder="Enter the module icon..." required>
                    <div class="invalid-feedback">
                        Module icon is required.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <label for="module_desc">Module Description</label>
            <div class="form-group">
                <div class="form-line">
                    <textarea id="module_desc" name="module_desc" class="form-control" placeholder="Describe this module..."></textarea>
                </div>
            </div>
        </div>

        <div class="col-12">
            <label for="module_active">Status</label>
            <div class="form-group">
                <div class="form-line">
                    <select class="form-control" id="module_active" name="module_active" required>
                        <option value="" selected="selected">Select module Status</option>
                        <option value="0">Deleted</option>
                        <option value="1">Inactive</option>
                        <option value="2">Active</option>
                     </select>

                    <div class="invalid-feedback">
                        Status is required.
                    </div>

                </div>
            </div>
        </div>


        <div class="col-12">
            
        </div>
    </div>
</form>