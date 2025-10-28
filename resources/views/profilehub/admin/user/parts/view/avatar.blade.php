<h5 class="mb-2"><i class="fa fa-address-book me-2"></i> <strong>Profile Photo</strong></h5>
<hr />

<div class="row justify-content-center text-center">
    <div class="col-12">
        <img class="img-thumbnail rounded-circle mb-3" src="{{ $profile_pic }}" alt="Profile Image" style="max-width: 120px;">
        <h4 class="card-title">{{ $user->name }}</h4>

        <div class="d-flex justify-content-center gap-4 mt-2">
            <!-- Edit Profile -->
            <a href="{{ route('profilehub.admin.profile.edit', ['id' => $user->id]) }}" title="Edit Profile">
                <i class="ri-edit-circle-fill text-primary fs-4"></i>
            </a>

            <!-- Change Password -->
            <a data-bs-toggle="modal" href="#permModal" data-bs-target="#permModal"
               onclick="addInputToElement('perm_user', '{{ $user_id }}');
                        addInputToElement('user_id_password', '{{ $user_id }}');
                        addTextToElement('permModalTitle', 'Change Password for {{ $user->name }}');"
               title="Change Password">
                <i class="ri-lock-unlock-line text-primary fs-4"></i>
            </a>
        </div>
    </div>
</div>