<!-- Add Modal -->
<div class="col-lg-4 col-md-6">
    <div class="mt-4">
        <div class="modal fade" id="editGroupModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog modal-fullscreen modal-halfpage" role="document">
                <div class="modal-content">
                    <form class="needs-validation" action="{{ route('profilehub.admin.users.groups.createrecord') }}"
                        method="POST" novalidate>
                        @csrf
                        @method('POST')
                        <input type="hidden" name="function" id="edit_function" value="create-user-group" />
                        <input type="hidden" name="group_id" id="edit_edit_group_id" value="" />
                        <input type="hidden" name="group_type" id="edit_group_type" value="" />
                        <input type="hidden" name="group_admin" id="edit_group_admin" value="{{ $you->id }}" />
                        <div class="modal-header">
                            <h5 class="modal-title text-uppercase fw-bold">
                                <span id="editGroupModalIcon"><i
                                        class="ri-book-open-fill text-primary text-secondary"></i></span>
                                <span id="editGroupModalTitle">Add User Group</span>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div> 
                        <div class="modal-body">
                            @include('profilehub::admin.groups.users.forms.add-user-group-form')
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary active float-right" type="submit">Save </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end Show Modal -->
