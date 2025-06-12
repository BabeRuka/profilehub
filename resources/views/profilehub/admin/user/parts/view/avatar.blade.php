Profile Photo
<hr />
<div class="row">
    <div class="col-12"> <img class="img-fluid rounded-circle" src="<?php echo $profile_pic; ?>" alt="card image"></p>
        <h4 class="card-title">{{ $user->name }}</h4>
        <div class="container">
            <div class="row">
                <div class="col">
                    <a href="{{ route('profilehub::profile.edit', ['id' => $user->id]) }}" class="">
                        <i class="ri-edit-circle-fill text-primary"></i>
                    </a>
                </div>
                <div class="col"> 
                    <a data-bs-toggle="modal" href="#permModal" data-bs-target="#permModal" onclick="addInputToElement('perm_user', '{{$user_id}}'),addInputToElement('user_id_password', '{{$user_id}}'),addTextToElement('permModalTitle', 'Change Password for {{ $user->name }}') "  class="" data-placement="top"
                        title="Permissions">
                        <i class="ri-lock-unlock-line text-primary"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
