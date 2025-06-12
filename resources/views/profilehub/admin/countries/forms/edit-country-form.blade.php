<div id="ditGroupModalContent">


    <div class="row">
        <div class="col-12">
            <div class="">
                <div class="">

                    @csrf

                    <div class="form-floating form-floating-outline mb-6">


                        <input type="hidden" name="country_id" id="country_id" value="" />
                        <input type="hidden" name="function" value="edit-country" />
                        <input type="hidden" name="post_type" id="post_type" value="" />
                        <input id="country_name" type="text"
                            class="form-control @error('country_name') is-invalid @enderror" name="country_name"
                            required="required" autocomplete="name" autofocus>
                        <label for="country_name" class="col-md-4  col-form-label">{{ __('Country Name') }}</label>
                        @error('country_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="valid-feedback" role="alert">
                            <strong>Looks good!</strong>
                        </span>
                        <span class="invalid-feedback" role="alert">
                            <strong>Please enter a country name...</strong>
                        </span>
                    </div>
                    <div class="form-floating form-floating-outline mb-6">

 
                        <input id="country_code" type="text"
                            class="form-control @error('country_code') is-invalid @enderror" name="country_code"
                            required="required" autocomplete="name" autofocus>
                        <label for="country_code" class="col-md-4  col-form-label">{{ __('Country Code') }}</label>
                        @error('country_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="valid-feedback" role="alert">
                            <strong>Looks good!</strong>
                        </span>
                        <span class="invalid-feedback" role="alert">
                            <strong>Please enter a country code...</strong>
                        </span>
                    </div>

                    <div class="form-floating form-floating-outline mb-6">
 
                        <input id="dialing_code" type="text"
                            class="form-control @error('dialing_code') is-invalid @enderror" name="dialing_code"
                            required="required" autocomplete="name" autofocus>
                        <label for="dialing_code" class="col-md-4  col-form-label">{{ __('Dialing Code') }}</label>
                        @error('dialing_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="valid-feedback" role="alert">
                            <strong>Looks good!</strong>
                        </span>
                        <span class="invalid-feedback" role="alert">
                            <strong>Please enter a dialing code...</strong>
                        </span>
                    </div>


                    <div class="form-floating form-floating-outline mb-6">


                        <textarea id="country_desc" type="text"
                            class="form-control h-px-100 @error('country_desc') is-invalid @enderror" name="country_desc"
                            required="required" autocomplete="name" rows="6" autofocus></textarea>
                        <label for="country_desc"
                            class="col-md-4  col-form-label">{{ __('Country description') }}</label>
                        @error('country_desc')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="valid-feedback" role="alert">
                            <strong>Looks good!</strong>
                        </span>
                        <span class="invalid-feedback" role="alert">
                            <strong>Please enter a country description...</strong>
                        </span>
                    </div>


                </div>
            </div>

        </div>

    </div>
    <div class="row mb-0">
        <div class="col-12">

        </div>
    </div>

</div>