<!-- Delete Modal -->
<div class="col-lg-4 col-md-6">
    <div class="mt-4"> 
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-uppercase fw-bold"><i class="ri-close-circle-fill text-danger"></i>
                            <span id="deleteModalTitle"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <hr>
                    <div class="modal-body"> 
                        <div class="row">
                            <div class="col 12">
                                <div class="">
                                    <h3 class="text-danger fs-6 fw-bold" id="deleteModalHeading">Careful! proceed with
                                        caution!</h3>
                                    <p class="text-danger" id="deleteModalMsg">Are you sure you want to delete this?</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <form action="" method="POST" id="deleteForm">
                            @csrf
                            <input type="hidden" name="_method" id="_method" value="DELETE">
                            <input type="hidden" name="deleteId" id="deleteId"> 
                            <input type="hidden" name="delFunction" id="delFunction" value=""> 
                            <input type="hidden" name="back_url" id="back_url"> 
                            <button type="submit" form="deleteForm" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delete Modal -->
 