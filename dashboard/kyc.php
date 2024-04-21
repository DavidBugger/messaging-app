<?php
@session_start();
include_once('templates/base.php');
include_once("templates/nav.php");
include_once("templates/sidebar.php");
include_once("controller/controller.php");
$antiCSRF = new \HCI\SecurityService\securityService();
$csrf_token = $antiCSRF->insertHiddenToken();
$controller = new Controller();
$countries = json_decode($controller->getCountries(), true);
$states = json_decode($controller->getState(), true);



?>





<!-- MAIN-CONTENT -->
<!-- PAGE HEADER -->
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">KYC</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>
                <li class="breadcrumb-item active" aria-current="page">KYC</li>
            </ol>
        </nav>
    </div>
</div>
<!-- END PAGE HEADER -->

<!-- APP CONTENT -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body d-sm-flex align-items-top p-4   main-profile-cover">
                        <p class="avatar avatar-xxl avatar-rounded online me-3 my-auto">
                            <img src="assets/images/faces/5.jpg" alt="">
                        </p>
                        <div class="flex-fill main-profile-info my-auto">
                            <h5 class="fw-semibold mb-1 "><?= $_SESSION['messaging_username']; ?></h5>
                            <div>
                                <p class="mb-1 text-muted"><?= $_SESSION['messaging_role_name']; ?></p>
                                <div class="fs-12 op-7 mb-0 d-flex">
                                    <p class="me-3 mb-0"><i class="ri-building-line me-1 align-middle d-inline-flex"></i>Abuja</p>
                                    <p class="mb-0"><i class="ri-map-pin-line me-1 align-middle d-inline-flex"></i>Nigeria</p>
                                </div>
                            </div>
                        </div>
                        <div class="main-profile-info ms-auto">
                            <div class="">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex mb-0 ms-auto">
                                        <div class="me-4">
                                            <p class="fw-bold fs-20  text-shadow mb-0">113</p>
                                            <p class="mb-0 fs-12 text-muted ">SMS sent</p>
                                        </div>
                                        <div class="me-4">
                                            <p class="fw-bold fs-20  text-shadow mb-0">12.2k</p>
                                            <p class="mb-0 fs-12 text-muted ">Unit</p>
                                        </div>
                                        <div class="">
                                            <p class="fw-bold fs-20  text-shadow mb-0">128</p>
                                            <p class="mb-0 fs-12 text-muted ">remaining Bal</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-12 col-xl-12">
                <div class="col-xxl-12 col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title text-primary">
                                Complete your KYC
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="message-container"></div>
                            <form id="onboarding" action="javascript:void(0)" autocomplete="off" enctype="multipart/form-data">
                                <input type="hidden" name="type" value="Users::Onboarding">
                                <input type="hidden" id="hci-csrf-token-label" name="csrf_token" value="<?= $csrf_token ?>">
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">First Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="e.g David" name="firstname" aria-label="First name">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Last Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="e.g Akanang" name="lastname" aria-label="Last name">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Address<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="address" placeholder="e.g 69 Adamu Shuaibu Crescent Abuja, Nigeria" aria-label="Street">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone Number<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="mobile_phone" placeholder="e.g 081****33" aria-label="mobile_phone">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" placeholder="e.g david**@gmail.com" aria-label="email">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">D.O.B</label>
                                        <input type="date" class="form-control text-start"  name="dob" aria-label="dateofbirth">
                                    </div>
                                    <div class="row-xl-12">
                                        <label for="gender" class="tex-muted mt-2">Gender<span class="text-danger">*</span></label>
                                        <select name="sex" class="form-select" id="sex">
                                            <option value="male" class="value">Male</option>
                                            <option value="female" class="value">Female</option>
                                        </select>

                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="occupation" class="text-muted mt-2">Select Country<span class="text-danger">*</span></label>
                                        <select name="state" class="form-select">
                                            <option value="" selected>Select Your Country</option>

                                            <?php if ($countries['response_code'] == 0) {
                                                if (is_array($countries['data']) && count($countries['data']) > 0) {
                                                    foreach ($countries['data'] as $country) {
                                                        // echo '<option value="'.$country['id'].'">'.$country['name'].'</option>';
                                                        echo '<option value="' . $country['id'] . '" data-code="' . $country['code'] . '">' . $country['name'] . '</option>';
                                                    }
                                                }
                                            } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="occupation" class="text-muted mt-2">State<span class="text-danger">*</span></label>
                                        <select name="state" class="form-select">
                                            <option value="" selected>Select Your State</option>

                                            <?php if ($states['response_code'] == 0) {
                                                if (is_array($states['data']) && count($states['data']) > 0) {
                                                    foreach ($states['data'] as $state) {
                                                        // echo '<option value="'.$country['id'].'">'.$country['name'].'</option>';
                                                        echo '<option value="' . $state['id'] . '" data-code="' . $state['code'] . '">' . $state['name'] . '</option>';
                                                    }
                                                }
                                            } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="occupation" class="text-muted">Occupation<span class="text-danger">*</span></label>
                                        <input type="text" name="occupation" class="form-control" placeholder="e.g Artisan" aria-label="Occupation">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="occupation" class="text-muted">City<span class="text-danger">*</span></label>

                                        <input type="text" class="form-control" name="city" placeholder="City" aria-label="City">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">ID Card Number <span class="text-danger">*</span></label>

                                        <input type="text" name="kyc_id" class="form-control" placeholder="e.g NIN or BVN" aria-label="Phone number">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Card Issuance Date <span class="text-danger">*</span></label>
                                        <input type="date" name="card_issued_date" class="form-control text-start" aria-label="dateofbirth">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Card Expiry Date <span class="text-danger">*</span></label>
                                        <input type="date" name="card_expiry_date" class="form-control text-start" aria-label="dateofbirth">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Card Issuer <span class="text-danger">*</span></label>
                                        <input type="text" name="card_issuer" class="form-control text-start" aria-label="card_issuer">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="file">File Upload</label>
                                    <input type="file" class="form-control" name="file" />
                                </div>
                                <div class="col-md-12 mb-3 mt-2 ml-4">
                                    <button class="btn btn-primary" id="kyc_button">submit</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modaldemo8">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title text-primary">Hello <?= $_SESSION['messaging_username']; ?></h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-start">
                    <h6></h6>
                    <p class="text-muted mb-0">Welcome to messaging app, kindly complete your KYC, to have full access to our amazing features.</p>
                </div>
                <div class="modal-footer">
                    <!-- <button class="btn btn-outline-primary">Save changes</button> -->
                    <!-- <button class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
</div>
<!--End::row-1 -->

</div>
</div>


<!-- END APP CONTENT -->
<?php include_once("templates/base_footer.php"); ?>

<!-- END MAIN-CONTENT -->