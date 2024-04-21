<?php
include "dashboard/templates/header.php";
include "dashboard/model/connection.php";
// Instantiate the connection
$connection = new Connection();
// Get the database connection
$conn = $connection->connect();
// Check if connection was successful
if ($conn) {
    // Query to select countries from the database
    $query = "SELECT * FROM countries";
    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    $stmt->execute();
    // Fetch all rows as an associative array
    $countries = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Connection error
    echo '<p>Connection error</p>';
}


?>


<div class="page error-bg" id="particles-js">
    <div class="row justify-content-center ">
        <div class="col-xl-8 col-md-12 col-sm-10 ">
            <div class="card custom-card  rectangle2">
                <div class="card-body p-0 ">
                    <div class="row">
                        <div class="col-xl-6 col-md-6 pe-sm-0 d-flex">
                            <div class="p-5">

                                <p class="h4 fw-semibold mb-2">Sign Up</p>
                                <p class="mb-3 text-muted op-7 fw-normal">Welcome & Join us by creating a free account !</p>
                                <form id="register" action="javascript:void(0)" autocomplete="off">
                                    <input type="hidden" name="type" value="Controller::register">               
                                    <div id="message-container"></div>
                                    <div class="row gy-3 mt-3">
                                        <div class="col-xl-12">
                                            <label for="signup-lastname" class="form-label text-default">Email<span class="text-danger">*</span></label>
                                            <input type="email" class="form-control form-control-lg" name="email" id="signup-email" placeholder="e.g davidifeanyi***@gmail.com">
                                        </div>
                                        <div class="col-xl-12 mt-4">
                                            <label for="signup-firstname" class="form-label text-default">Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control form-control-lg" name="password" id="signup-password" placeholder="e.g dev@!***3">
                                        </div>
                                        <div class="col-xl-12 mt-4">
                                            <label for="signup-firstname" class="form-label text-default">Confirm Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control form-control-lg" id="signup-confirm_password" name="confirm_password" placeholder="e.g dev@!***3">
                                        </div>

                                        <div class="col-xl-12">
                                            <label for="signup-lastname" class="form-label text-default">Select Country</label>

                                            <select class="form-select form-select-lg" name="country_id">
                                                <?php
                                                foreach ($countries as $country) {
                                                    echo '<option value="' . $country['id'] . '">' . $country['name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>


                                        <div class="col-xl-12 d-grid mt-2">
                                            <button class="create-account btn btn-lg btn-primary mt-4 " id="create_account">Register</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="text-center">
                                    <p class="fs-12 text-muted mt-3">Already have an account? <a href="sign-in" class="text-primary">Sign In</a></p>
                                </div>
                                <!-- <div class="text-center my-3 authentication-barrier">
                                    <span>OR</span>
                                </div> -->
                                <!-- <div class="btn-list text-center">
                                    <button class="btn btn-icon btn-light btn-wave waves-effect waves-light">
                                        <i class="ri-facebook-line fw-bold "></i>
                                    </button>
                                    <button class="btn btn-icon btn-light btn-wave waves-effect waves-light">
                                        <i class="ri-google-line fw-bold "></i>
                                    </button>
                                    <button class="btn btn-icon btn-light btn-wave waves-effect waves-light">
                                        <i class="ri-twitter-line fw-bold "></i>
                                    </button>
                                </div> -->
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 ps-0 text-fixed-white rounded-0 d-none d-md-block  ">
                            <div class="card custom-card mb-0 cover-background overflow-hidden rounded-end rounded-0">
                                <div class="card-img-overlay d-flex  align-items-center p-0 rounded-0">
                                    <div class="card-body p-5 rectangle3">
                                        <div>
                                            <!-- <a href=""> <img src="dashboard/assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark"></a> -->
                                            <h4 class="text-white">Say Hello</h4>
                                        </div>
                                        <h6 class="mt-4 fs-15 op-9  text-fixed-white">Sign Up</h6>
                                        <div class="d-flex mt-3  text-fixed-white">
                                            <p class="mb-0 fw-normal fs-14 op-7"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa eligendi expedita aliquam quaerat nulla voluptas facilis.
                                                Porro rem voluptates possimus, ad, autem quae culpa architecto, quam labore blanditiis at ratione.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "dashboard/templates/footer.php"; ?>