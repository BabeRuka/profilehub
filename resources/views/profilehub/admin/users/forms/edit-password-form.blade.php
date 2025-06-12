 <input type="hidden" name="function" id="perm_function" value="update-password" />
 <input type="hidden" name="user" id="perm_user" value="0" />
 <div class="row">
     <div class="col-md-12 mb-6">
         <label for="pwdId">Password</label>
         <div class="form-group">
             <div class="form-line">
                 <input class="form-control" type="password" id="pwdId" name="user_password" value=""
                     placeholder="enter password" minlength="6" required>
             </div>
             <div class="valid-feedback">Valid</div>
             <div class="invalid-feedback">a to z only (more than 6 letters)</div>
         </div>
     </div>
     <div class="col-md-12 mb-6">
         <label for="cPwdId">Repeat Password</label>
         <div class="form-group">
             <div class="form-line">
                 <input class="form-control" type="password" id="cPwdId" name="user_password_repeat" value=""
                     placeholder="repeat password here..." minlength="6" autocomplete="autocomplete_off_hack_xfr4!k"
                     onfocus="this.removeAttribute('readonly');" required>
             </div>
             <div id="cPwdValid" class="valid-feedback">confirm password must match with password.</div>
             <div id="cPwdInvalid" class="invalid-feedback">a to z only (more than 6 letters)</div>
         </div>
     </div>
 </div>
