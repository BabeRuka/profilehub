<!-- Add Modal -->
<div class="col-lg-4 col-md-6">
    <div class="mt-4">
        <div class="modal fade" id="permModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog modal-fullscreen modal-halfpage" role="document">
                <div class="modal-content">
                    <form class="needs-validation" action="{{ route('profilehub::admin.users.createrecord') }}" id="permForm" mult method="POST" enctype="multipart/form-data" novalidate>
                        <input type="hidden" name="function" id="function" value="create-group-name" />
                        <input type="hidden" name="user_id" id="user_id_password" value="0" />
                        @csrf
                        @method('POST')
                        <div class="modal-header">
                            <h5 class="modal-title text-uppercase fw-bold">
                                <span id="permModalIcon"><i
                                        class="ri-book-open-fill text-primary text-secondary"></i></span>
                                <span id="permModalTitle"></span>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <hr>
                        <div class="modal-body">
                            <div class="row">
                                <h3 class="text-primary fs-6 fw-bold" id="permModalHeading"></h3>
                                <div class="col 12">
                                    @include('profilehub::admin.users.forms.edit-password-form')
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
