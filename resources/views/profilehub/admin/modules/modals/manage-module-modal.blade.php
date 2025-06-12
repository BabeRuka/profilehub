<!-- Show Modal -->
<div class="col-lg-4 col-md-6">
    <div class="mt-4">
        <div class="modal fade" id="manageModuleModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog modal-fullscreen modal-halfpage" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-uppercase fw-bold">
                            <span id="manageModuleModalIcon"><i class="ri-book-open-fill text-primary text-secondary"></i></span> 
                            <span id="manageModuleModalTitle">Manage Module</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <hr>
                    <div class="modal-body">
                        <div class="row">
                            <h3 class="text-primary fs-6 fw-bold" id="manageModuleModalHeading"></h3>
                            <div class="col 12">
                                <div id="manageModuleModalContent">

                                    @include('profilehub::admin.modules.forms.manage-module-form')
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>


                        <button class="btn btn-primary float-right active ml-3" type="submit">Save</button> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end Show Modal -->