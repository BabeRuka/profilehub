<!-- Add Modal -->
<div class="col-lg-4 col-md-6">
    <div class="mt-4">
        <div class="modal fade" id="addUserDetails" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog modal-fullscreen modal-halfpage" role="document" style="overflow: scroll;">
                <div class="modal-content">
                    <form method="POST" action="{{ route('profilehub.admin.users.groups.userdetails.createrecord') }}"
                        id="createGroupForm" enctype="multipart/form-data" class="needs-validation" accesskey="" novalidate>
                        <input type="hidden" name="function" value="manage-user-detail" />
                        <input type="hidden" name="user_id" id="user_id_details_id" value="0" />
                        @csrf
                        @method('POST')
                        <div class="modal-header">
                            <h5 class="modal-title text-uppercase fw-bold">
                                <span id="addUserDetailsIcon"><i class="ri-book-open-fill text-primary text-secondary"></i></span>
                                <span id="addUserDetailsTitle"></span>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <hr>
                        <div class="modal-body">
                            <div class="row">
                                <h3 class="text-primary fs-6 fw-bold" id="addUserDetailsHeading"></h3>
                                <div class="col 12">
                                    @include('profilehub::admin.users.profile.forms.add-user-profile-user-details-form')
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="addUserDetailsBtnSubmit" class="btn btn-primary d-grid w-30">
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
