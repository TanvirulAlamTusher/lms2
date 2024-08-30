@extends('frontend.dashboard.user_dashboard')
@section('userdashboard')




<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
        <div class="setting-body">
            <h3 class="fs-17 font-weight-semi-bold pb-4">Change Password</h3>
        <form method="post" action="{{ route('user.password.update') }}" enctype="multipart/form-data" class="row pt-40px">
            @csrf


                <div class="input-box col-lg-12">
                    <label class="label-text">Old Password</label>
                    <div class="form-group">
                        <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" />

                        @error('old_password')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-12">
                    <label class="label-text">New Password</label>
                    <div class="form-group">
                        <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" />

                        @error('new_password')
                            <span class="text-danger"> {{ $message }} </span>
                        @enderror
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-12">
                    <label class="label-text">Confirm New Password</label>
                    <div class="form-group">
                        <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" />
                    </div>
                </div><!-- end input-box -->

                <div class="input-box col-lg-12 py-2">
                    <button class="btn theme-btn">Save Changes</button>
                </div><!-- end input-box -->
            </form>
        </div><!-- end setting-body -->
    </div><!-- end tab-pane -->


    <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
        <div class="setting-body">
            <h3 class="fs-17 font-weight-semi-bold pb-4">Change Password</h3>
            <form method="post" class="row">
                <div class="input-box col-lg-4">
                    <label class="label-text">Old Password</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="text" name="text" placeholder="Old Password">
                        <span class="la la-lock input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-4">
                    <label class="label-text">New Password</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="text" name="text" placeholder="New Password">
                        <span class="la la-lock input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-4">
                    <label class="label-text">Confirm New Password</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="text" name="text" placeholder="Confirm New Password">
                        <span class="la la-lock input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-12 py-2">
                    <button class="btn theme-btn">Change Password</button>
                </div><!-- end input-box -->
            </form>
            <form method="post" class="pt-5 mt-5 border-top border-top-gray">
                <h3 class="fs-17 font-weight-semi-bold pb-1">Forgot Password then Recover Password</h3>
                <p class="pb-4">Enter the email of your account to reset password. Then you will receive a link to email
                    to reset the password. If you have any issue about reset password
                    <a href="contact.html" class="text-color">contact us</a></p>
                <div class="input-box">
                    <label class="label-text">Email Address</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="email" name="email" placeholder="Enter email address">
                        <span class="la la-envelope input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box py-2">
                    <button class="btn theme-btn">Recover Password</button>
                </div><!-- end input-box -->
            </form>
        </div><!-- end setting-body -->
    </div><!-- end tab-pane -->
    <div class="tab-pane fade" id="change-email" role="tabpanel" aria-labelledby="change-email-tab">
        <div class="setting-body">
            <h3 class="fs-17 font-weight-semi-bold pb-4">Change Email</h3>
            <form method="post" class="row">
                <div class="input-box col-lg-4">
                    <label class="label-text">Old Email</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="text" name="text" placeholder="Old Email">
                        <span class="la la-envelope input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-4">
                    <label class="label-text">New Email</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="text" name="text" placeholder="New Email">
                        <span class="la la-envelope input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-4">
                    <label class="label-text">Confirm New Email</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="text" name="text" placeholder="Confirm New Email">
                        <span class="la la-envelope input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-12 py-2">
                    <button class="btn theme-btn">Change Email</button>
                </div><!-- end input-box -->
            </form>
        </div><!-- end setting-body -->
    </div><!-- end tab-pane -->
    <div class="tab-pane fade" id="withdraw" role="tabpanel" aria-labelledby="withdraw-tab">
        <div class="setting-body">
            <h3 class="fs-17 font-weight-semi-bold pb-4">Select a Withdraw Method</h3>
            <form method="post" class="row mb-40px">
                <div class="col-lg-2 responsive-column-half">
                    <div class="custom-control custom-radio mb-3 pl-0">
                        <input type="radio" class="custom-control-input" id="bankTransfer" name="radio-stacked" required>
                        <label class="custom-control-label custom--control-label custom--control-label-boxed" for="bankTransfer">
                            <span class="font-weight-semi-bold text-black d-block">Bank Transfer</span>
                            <span class="d-block fs-14 lh-18">Min withdraw $50.00</span>
                        </label>
                    </div>
                </div><!-- end col-lg-2 -->
                <div class="col-lg-2 responsive-column-half">
                    <div class="custom-control custom-radio mb-3 pl-0">
                        <input type="radio" class="custom-control-input" id="eCheck" name="radio-stacked" required>
                        <label class="custom-control-label custom--control-label custom--control-label-boxed" for="eCheck">
                            <span class="font-weight-semi-bold text-black d-block">E-Check</span>
                            <span class="d-block fs-14 lh-18">Min withdraw $50.00</span>
                        </label>
                    </div>
                </div><!-- end col-lg-2 -->
                <div class="col-lg-2 responsive-column-half">
                    <div class="custom-control custom-radio mb-3 pl-0">
                        <input type="radio" class="custom-control-input" id="payoneer" name="radio-stacked" required>
                        <label class="custom-control-label custom--control-label custom--control-label-boxed" for="payoneer">
                            <span class="font-weight-semi-bold text-black d-block">Payoneer</span>
                            <span class="d-block fs-14 lh-18">Min withdraw $50.00</span>
                        </label>
                    </div>
                </div><!-- end col-lg-2 -->
                <div class="col-lg-2 responsive-column-half">
                    <div class="custom-control custom-radio mb-3 pl-0">
                        <input type="radio" class="custom-control-input" id="PayPal" name="radio-stacked" required>
                        <label class="custom-control-label custom--control-label custom--control-label-boxed" for="PayPal">
                            <span class="font-weight-semi-bold text-black d-block">PayPal</span>
                            <span class="d-block fs-14 lh-18">Min withdraw $50.00</span>
                        </label>
                    </div>
                </div><!-- end col-lg-2 -->
                <div class="col-lg-2 responsive-column-half">
                    <div class="custom-control custom-radio mb-3 pl-0">
                        <input type="radio" class="custom-control-input" id="skrill" name="radio-stacked" required>
                        <label class="custom-control-label custom--control-label custom--control-label-boxed" for="skrill">
                            <span class="font-weight-semi-bold text-black d-block">Skrill</span>
                            <span class="d-block fs-14 lh-18">Min withdraw $50.00</span>
                        </label>
                    </div>
                </div><!-- end col-lg-2 -->
                <div class="col-lg-2 responsive-column-half">
                    <div class="custom-control custom-radio mb-3 pl-0">
                        <input type="radio" class="custom-control-input" id="stripe" name="radio-stacked" required>
                        <label class="custom-control-label custom--control-label custom--control-label-boxed" for="stripe">
                            <span class="font-weight-semi-bold text-black d-block">Stripe</span>
                            <span class="d-block fs-14 lh-18">Min withdraw $50.00</span>
                        </label>
                    </div>
                </div><!-- end col-lg-2 -->
            </form>
            <form method="post" class="row">
                <h3 class="fs-17 font-weight-semi-bold pb-4 col-lg-12">Account info</h3>
                <div class="input-box col-lg-4">
                    <label class="label-text">Account Name</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="text" name="text" value="Alex Smith">
                        <span class="la la-user input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-4">
                    <label class="label-text">Account Number</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="text" name="text" value="3275476222500">
                        <span class="la la-pencil input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-4">
                    <label class="label-text">Bank Name</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="text" name="text" value="South State Bank">
                        <span class="la la-bank input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-6">
                    <label class="label-text">IBAN</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="text" name="text" value="3030">
                        <span class="la la-pencil input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-6">
                    <label class="label-text">BIC/SWIFT</label>
                    <div class="form-group">
                        <input class="form-control form--control" type="text" name="text" value="CDDHDBBL">
                        <span class="la la-pencil input-icon"></span>
                    </div>
                </div><!-- end input-box -->
                <div class="input-box col-lg-12 py-2">
                    <button class="btn theme-btn">Save withdraw account</button>
                </div><!-- end input-box -->
            </form>
        </div><!-- end setting-body -->
    </div><!-- end tab-pane -->
    <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
        <div class="setting-body">
            <h3 class="fs-17 font-weight-semi-bold pb-4">My Account</h3>
            <form method="post" class="mb-40px">
                <div class="custom-control-wrap d-flex flex-wrap align-items-center">
                    <div class="custom-control custom-radio pl-0 flex-shrink-0 mr-3 mb-2">
                        <input type="radio" class="custom-control-input" id="deactivateAccount" name="radio-stacked" required>
                        <label class="custom-control-label custom--control-label custom--control-label-boxed" for="deactivateAccount">
                            <span class="font-weight-semi-bold text-black">Deactivate Account</span>
                        </label>
                    </div>
                    <button class="btn theme-btn mb-2">Deactivate</button>
                </div><!-- end custom-control-wrap -->
            </form>
            <div class="section-block"></div>
            <div class="danger-zone pt-40px">
                <h4 class="fs-17 font-weight-semi-bold text-danger">Delete Account Permanently</h4>
                <p class="pt-1 pb-4"><span class="text-warning">Warning: </span>Once you delete your account, there is no going back. Please be certain.</p>
                <button class="btn theme-btn" data-toggle="modal" data-target="#deleteModal">Delete my account</button>
            </div>
        </div><!-- end setting-body -->
    </div><!-- end tab-pane -->
</div><!-- end tab-content -->





@endsection
