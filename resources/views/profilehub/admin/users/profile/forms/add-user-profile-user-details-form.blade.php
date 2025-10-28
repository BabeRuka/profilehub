<input type="hidden" name="details_id" id="details_id" value="0" />
<div class="row">
    <div class="col-md-12 mb-6 form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" id="username" placeholder="Enter username..."
            value="" required>
        <div class="invalid-feedback">
            Valid username is required.
        </div>
    </div>

    <div class="col-md-12 mb-6 form-group">
        <label for="firstname">Firstname</label>
        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Enter firstname..."
            value="" required>
        <div class="invalid-feedback">
            Valid firstname is required.
        </div>
    </div>

    <div class="col-md-12 mb-6 form-group">
        <label for="lastname">Lastname</label>
        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Enter lastname..."
            value="" required>
        <div class="invalid-feedback">
            Valid lastname is required.
        </div>
    </div>


    <div class="col-md-12 mb-6 form-group">
        <label for="middle_name">Middle name</label>
        <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Enter middle name..."
            value="" required>
        <div class="invalid-feedback">
            Valid middle_name is required.
        </div>
    </div>



    <div class="col-md-12 mb-6 form-group">
        <label for="user_bio">User bio</label>
        <textarea rows="5" class="form-control" name="user_bio" id="user_bio" placeholder="Enter user bio..."
            value="" required></textarea>
        <div class="invalid-feedback">
            Valid user bio is required.
        </div>
    </div>


    <div class="col-md-12 mb-6 form-group">
        <label for="profile_pic">Profile Picture</label>
        <input type="file" class="form-control" name="profile_pic" id="profile_pic" placeholder="Enter profile_pic..."
            value="" data-allowed-file-extensions="jpg png jpeg" class="dropify"  required>
        <div class="invalid-feedback">
            Valid profile_pic is required.
        </div>
    </div>
 

</div>