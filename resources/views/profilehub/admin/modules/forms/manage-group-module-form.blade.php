<form class="needs-validation" action="{{ route('profilehub::admin.modules.createrecord') }}" id="pubSettingsForm" method="POST"
    novalidate>
    @csrf
    @method('POST')
    <input type="hidden" name="function" value="create-module-group" />
    <input type="hidden" name="group_id" id="group_id" value="0" />
    <input type="hidden" name="module_id" id="module_id_up" value="0" />
    <div class="row">
        <div class="col-12">
            <label for="group_name">Module Group Name</label>
            <div class="form-group">
                <div class="form-line">
                    <input type="text" id="group_name" name="group_name" value="" class="form-control"
                        placeholder="Enter the module name..." required>
                    <div class="invalid-feedback">
                        Module name is required.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <label for="group_icon">Module Group Icon</label>
            <div class="form-group">
                <div class="form-line">
                    <input type="text" id="group_icon" name="group_icon" value="" class="form-control"
                        placeholder="Enter the module icon..." required>
                    <div class="invalid-feedback">
                        Module icon is required.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <label for="group_desc">Module Group Description</label>
            <div class="form-group">
                <div class="form-line">
                    <textarea id="group_desc" name="group_desc" class="form-control" placeholder="Describe this module group..."></textarea>
                </div>
            </div>
        </div>

        <div class="col-12">
            <label for="group_active">Module Group Status</label>
            <div class="form-group">
                <div class="form-line">
                    <select class="form-control" id="group_active" name="group_active" required>
                        <option value="" selected="selected">Select group status
                        </option>
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
