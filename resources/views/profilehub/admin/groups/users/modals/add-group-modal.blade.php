<!-- Add Modal -->
<div class="col-lg-4 col-md-6">
    <div class="mt-4">
        <div class="modal fade" id="addGroupModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog modal-fullscreen modal-halfpage" role="document">
                <div class="modal-content">
                    <form class="needs-validation" action="{{ route('profilehub::admin.groups.createrecord') }}"
                        method="POST" novalidate>
                        @csrf
                        @method('POST')
                        <input type="hidden" name="function" id="add_function" value="create-user-group" />
                        <input type="hidden" name="group_id" id="add_add_group_id" value="0" />
                        <input type="hidden" name="group_type" id="add_group_type"
                            value="{{ $group_type[0]->type_key }}" />
                        <input type="hidden" name="group_admin" id="add_group_admin" value="{{ $you->id }}" />
                        <div class="modal-header">
                            <h5 class="modal-title text-uppercase fw-bold">
                                <span id="addGroupModalIcon"><i
                                        class="ri-book-open-fill text-primary text-secondary"></i></span>
                                <span id="addGroupModalTitle">Add User Group</span>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <hr>
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
