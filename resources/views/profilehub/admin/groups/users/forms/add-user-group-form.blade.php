<div id="addGroupModalContent">


    <div class="row">
        <div class="col-12">
            <div class="">
                <div class="">

                <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control @error('group_name') is-invalid @enderror"
                            name="group_name" id="add_group_name" placeholder="Enter group name..." autocomplete="group name" autofocus required="required">
                        <label for="group_name" class="col-md-4 col-form-label">Group Name </label>
                        @error('group_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="valid-feedback" role="alert">
                            <strong>Looks good!</strong>
                        </span>
                        <span class="invalid-feedback" role="alert">
                            <strong>Please enter the group name...</strong>
                        </span>
                    </div>

                    <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control @error('group_key') is-invalid @enderror"
                            name="group_key" id="add_group_key" placeholder="Enter group key..." value="" readonly autocomplete="group key" autofocus>
                        <label for="group_key" class="col-md-4 col-form-label">Group Key </label>
                        @error('group_key')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="valid-feedback" role="alert">
                            <strong>Looks good!</strong>
                        </span>
                        <span class="invalid-feedback" role="alert">
                            <strong>Please enter the group key...</strong>
                        </span>
                    </div>

                    <div class="form-floating form-floating-outline mb-6">
                        <textarea class="form-control @error('group_description') is-invalid @enderror"
                            name="group_description" id="add_group_description" required></textarea>
                        <label for="group_description" class="col-md-4 col-form-label">Group Description </label>
                        @error('group_description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="valid-feedback" role="alert">
                            <strong>Looks good!</strong>
                        </span>
                        <span class="invalid-feedback" role="alert">
                            <strong>Please enter the group description...</strong>
                        </span>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
