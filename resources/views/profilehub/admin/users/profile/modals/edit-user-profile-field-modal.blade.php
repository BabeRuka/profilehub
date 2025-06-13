<!-- Add Modal -->
<div class="col-lg-4 col-md-6"> 
    <div class="mt-4">
        <div class="modal fade" id="editUserField" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog modal-fullscreen modal-halfpage" role="document">
                <div class="modal-content"> 
                    <form method="POST" action="{{ route('profilehub.admin.users.groups.userdetails.createrecord') }}"
                        id="createGroupForm" class="needs-validation" accesskey="" novalidate>
                        <input type="hidden" name="function" value="create-group-name" />
                        <input type="hidden" name="group_id" value="0" />
                        @csrf
                        @method('POST')
                        <div class="modal-header">
                            <h5 class="modal-title text-uppercase fw-bold">
                                <span id="editUserFieldIcon"><i
                                        class="ri-book-open-fill text-primary text-secondary"></i></span>
                                <span id="editUserFieldTitle">Edit User Profile Field</span>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <hr>
                        <div class="modal-body">
                            <div class="row">
                                <h3 class="text-primary fs-6 fw-bold" id="editUserFieldHeading"></h3>
                                <div class="col 12">
                                    @include('profilehub::admin.users.profile.forms.edit-profile-field-form')
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="addGroupBtnSubmit" class="btn btn-primary d-grid w-30">
                                {{ __('Save') }}
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end Show Modal -->
