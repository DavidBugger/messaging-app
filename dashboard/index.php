<?php include_once('templates/base.php'); ?>

<body>

    <!-- SWITCHER -->

    <div class="offcanvas offcanvas-end" tabindex="-1" id="switcher-canvas" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title text-default" id="offcanvasRightLabel">Switcher</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <nav class="border-bottom border-block-end-dashed">
                <div class="nav nav-tabs nav-justified" id="switcher-main-tab" role="tablist">
                    <button class="nav-link active" id="switcher-home-tab" data-bs-toggle="tab" data-bs-target="#switcher-home" type="button" role="tab" aria-controls="switcher-home" aria-selected="true">Theme Styles</button>
                    <button class="nav-link" id="switcher-profile-tab" data-bs-toggle="tab" data-bs-target="#switcher-profile" type="button" role="tab" aria-controls="switcher-profile" aria-selected="false">Theme Colors</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active border-0" id="switcher-home" role="tabpanel" aria-labelledby="switcher-home-tab" tabindex="0">
                    <div class="">
                        <p class="switcher-style-head">Theme Color Mode:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-light-theme">
                                        Light
                                    </label>
                                    <input class="form-check-input" type="radio" name="theme-style" id="switcher-light-theme" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-dark-theme">
                                        Dark
                                    </label>
                                    <input class="form-check-input" type="radio" name="theme-style" id="switcher-dark-theme">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Directions:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-ltr">
                                        LTR
                                    </label>
                                    <input class="form-check-input" type="radio" name="direction" id="switcher-ltr" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-rtl">
                                        RTL
                                    </label>
                                    <input class="form-check-input" type="radio" name="direction" id="switcher-rtl">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Navigation Styles:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-vertical">
                                        Vertical
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-style" id="switcher-vertical" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-horizontal">
                                        Horizontal
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-style" id="switcher-horizontal">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="navigation-menu-styles">
                        <p class="switcher-style-head">Vertical &amp; Horizontal Menu Styles:</p>
                        <div class="row switcher-style gx-0  gy-2">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-menu-click">
                                        Menu Click
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-menu-styles" id="switcher-menu-click">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-menu-hover">
                                        Menu Hover
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-menu-styles" id="switcher-menu-hover">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-icon-click">
                                        Icon Click
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-menu-styles" id="switcher-icon-click">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-icon-hover">
                                        Icon Hover
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-menu-styles" id="switcher-icon-hover">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sidemenu-layout-styles">
                        <p class="switcher-style-head">Sidemenu Layout Styles:</p>
                        <div class="row switcher-style gx-0  gy-2">
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-default-menu">
                                        Default Menu
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles" id="switcher-default-menu" checked>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-closed-menu">
                                        Closed Menu
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles" id="switcher-closed-menu">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-icontext-menu">
                                        Icon Text
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles" id="switcher-icontext-menu">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-icon-overlay">
                                        Icon Overlay
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles" id="switcher-icon-overlay">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-detached">
                                        Detached
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles" id="switcher-detached">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-double-menu">
                                        Double Menu
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles" id="switcher-double-menu">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Page Styles:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-regular">
                                        Regular
                                    </label>
                                    <input class="form-check-input" type="radio" name="page-styles" id="switcher-regular" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-classic">
                                        Classic
                                    </label>
                                    <input class="form-check-input" type="radio" name="page-styles" id="switcher-classic">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Layout Width Styles:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-full-width">
                                        Full Width
                                    </label>
                                    <input class="form-check-input" type="radio" name="layout-width" id="switcher-full-width" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-boxed">
                                        Boxed
                                    </label>
                                    <input class="form-check-input" type="radio" name="layout-width" id="switcher-boxed">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Menu Positions:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-menu-fixed">
                                        Fixed
                                    </label>
                                    <input class="form-check-input" type="radio" name="menu-positions" id="switcher-menu-fixed" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-menu-scroll">
                                        Scrollable
                                    </label>
                                    <input class="form-check-input" type="radio" name="menu-positions" id="switcher-menu-scroll">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Header Positions:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-header-fixed">
                                        Fixed
                                    </label>
                                    <input class="form-check-input" type="radio" name="header-positions" id="switcher-header-fixed" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-header-scroll">
                                        Scrollable
                                    </label>
                                    <input class="form-check-input" type="radio" name="header-positions" id="switcher-header-scroll">
                                </div>
                            </div>
                            <div class="col-4 rounded-header">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-header-rounded">
                                        Rounded
                                    </label>
                                    <input class="form-check-input" type="radio" name="header-positions" id="switcher-header-rounded">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Loader:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-loader-enable">
                                        Enable
                                    </label>
                                    <input class="form-check-input" type="radio" name="page-loader" id="switcher-loader-enable">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-loader-disable">
                                        Disable
                                    </label>
                                    <input class="form-check-input" type="radio" name="page-loader" id="switcher-loader-disable" checked>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade border-0" id="switcher-profile" role="tabpanel" aria-labelledby="switcher-profile-tab" tabindex="0">
                    <div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Menu Colors:</p>
                            <div class="d-flex switcher-style pb-2">
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Light Menu" type="radio" name="menu-colors" id="switcher-menu-light">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Dark Menu" type="radio" name="menu-colors" id="switcher-menu-dark" checked>
                                </div>
                            </div>
                            <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Menu dynamically change from below Theme Primary color picker</div>
                        </div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Header &amp; Bredcrumb Colors:</p>
                            <div class="d-flex switcher-style pb-2">
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Dark Header" type="radio" name="header-colors" id="switcher-header-dark">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Color Header" type="radio" name="header-colors" id="switcher-header-primary">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-gradient" data-bs-toggle="tooltip" data-bs-placement="top" title="Gradient Header" type="radio" name="header-colors" id="switcher-header-gradient">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-transparent" data-bs-toggle="tooltip" data-bs-placement="top" title="Transparent Header" type="radio" name="header-colors" id="switcher-header-transparent">
                                </div>
                            </div>
                            <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Header dynamically change from below Theme Primary color picker</div>
                        </div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Header Colors:</p>
                            <div class="d-flex switcher-style pb-2">
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Default Light Header" type="radio" name="header-colors" id="switcher-default-header-light">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Default Dark Header" type="radio" name="header-colors" id="switcher-default-header-dark">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Default Color Header" type="radio" name="header-colors" id="switcher-default-header-primary">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-gradient" data-bs-toggle="tooltip" data-bs-placement="top" title="Default Gradient Header" type="radio" name="header-colors" id="switcher-default-header-gradient">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-transparent" data-bs-toggle="tooltip" data-bs-placement="top" title="Default Transparent Header" type="radio" name="header-colors" id="switcher-default-header-transparent">
                                </div>
                            </div>
                            <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Header dynamically change from below Theme Primary color picker</div>
                        </div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Theme Primary:</p>
                            <div class="d-flex flex-wrap align-items-center switcher-style">
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-1" type="radio" name="theme-primary" id="switcher-primary">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-2" type="radio" name="theme-primary" id="switcher-primary1">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-3" type="radio" name="theme-primary" id="switcher-primary2">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-4" type="radio" name="theme-primary" id="switcher-primary3">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-5" type="radio" name="theme-primary" id="switcher-primary4">
                                </div>
                                <div class="form-check switch-select ps-0 mt-1 color-primary-light">
                                    <div class="theme-container-primary"></div>
                                    <div class="pickr-container-primary"></div>
                                </div>
                            </div>
                        </div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Theme Background:</p>
                            <div class="d-flex flex-wrap align-items-center switcher-style">
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-1" type="radio" name="theme-background" id="switcher-background">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-2" type="radio" name="theme-background" id="switcher-background1">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-3" type="radio" name="theme-background" id="switcher-background2">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-4" type="radio" name="theme-background" id="switcher-background3">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-5" type="radio" name="theme-background" id="switcher-background4">
                                </div>
                                <div class="form-check switch-select ps-0 mt-1 tooltip-static-demo color-bg-transparent">
                                    <div class="theme-container-background"></div>
                                    <div class="pickr-container-background"></div>
                                </div>
                            </div>
                        </div>
                        <div class="menu-image mb-3">
                            <p class="switcher-style-head">Menu With Background Image:</p>
                            <div class="d-flex flex-wrap align-items-center switcher-style">
                                <div class="form-check switch-select m-2">
                                    <input class="form-check-input bgimage-input bg-img1" type="radio" name="theme-background" id="switcher-bg-img">
                                </div>
                                <div class="form-check switch-select m-2">
                                    <input class="form-check-input bgimage-input bg-img2" type="radio" name="theme-background" id="switcher-bg-img1">
                                </div>
                                <div class="form-check switch-select m-2">
                                    <input class="form-check-input bgimage-input bg-img3" type="radio" name="theme-background" id="switcher-bg-img2">
                                </div>
                                <div class="form-check switch-select m-2">
                                    <input class="form-check-input bgimage-input bg-img4" type="radio" name="theme-background" id="switcher-bg-img3">
                                </div>
                                <div class="form-check switch-select m-2">
                                    <input class="form-check-input bgimage-input bg-img5" type="radio" name="theme-background" id="switcher-bg-img4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between canvas-footer flex-wrap">
                    <a target="_blank" href="https://themeforest.net/user/spruko/portfolio" class="btn btn-primary">Buy Now</a>
                    <a target="_blank" href="https://themeforest.net/user/spruko/portfolio" class="btn btn-secondary">Our Portfolio</a>
                    <a href="javascript:void(0);" id="reset-all" class="btn btn-danger">Reset</a>
                </div>
            </div>
        </div>
    </div>
    <!-- END SWITCHER -->

    <!-- LOADER -->
    <div id="loader">
        <img src="https://php.spruko.com/velvet/velvet/assets/images/media/loader.svg" alt="">
    </div>
    <!-- END LOADER -->

    <!-- PAGE -->
    <div class="page">



        <?php include_once("templates/nav.php"); ?>
        <?php include_once("templates/sidebar.php"); ?>

        <!-- MAIN-CONTENT -->


        <!-- Page Header -->
        <div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
            <h4 class="fw-medium mb-0">Dashboard</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Dashboards</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Sales</li>
            </ol>
        </div>
        <!-- Page Header Close -->

        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Start::row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="row row-cols-xxl-5 row-cols-xl-3 row-cols-md-2">
                            <div class="col card-background flex-fill">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div>
                                                <p class="fw-medium mb-1 text-muted">Total Sales</p>
                                                <h3 class="mb-0">$18,645</h3>
                                            </div>
                                            <div class="avatar avatar-md br-4 bg-primary-transparent ms-auto">
                                                <i class="bi bi-cart-check fs-20"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex mt-2">
                                            <span class="badge bg-primary-transparent rounded-pill">+24% <i class="fe fe-arrow-down"></i></span>
                                            <a href="javascript:void(0);" class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">view more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col card-background flex-fill">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div>
                                                <p class="fw-medium mb-1 text-muted">Total Revenue</p>
                                                <h3 class="mb-0">$34,876</h3>
                                            </div>
                                            <div class="avatar avatar-md br-4 bg-secondary-transparent ms-auto">
                                                <i class="bi bi-archive fs-20"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex mt-2">
                                            <span class="badge bg-success-transparent rounded-pill">+0.26% <i class="fe fe-arrow-down"></i></span>
                                            <a href="javascript:void(0);" class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">view more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col card-background flex-fill">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div>
                                                <p class="fw-medium text-muted mb-1">Total Products</p>
                                                <h3 class="mb-0">26,231</h3>
                                            </div>
                                            <div class="avatar avatar-md br-4 bg-info-transparent ms-auto">
                                                <i class="bi bi-handbag fs-20"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex mt-2">
                                            <span class="badge bg-danger-transparent rounded-pill">+06% <i class="fe fe-arrow-down"></i></span>
                                            <a href="javascript:void(0);" class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">view more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col card-background flex-fill">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div>
                                                <p class="fw-medium mb-1 text-muted">Total Expenses</p>
                                                <h3 class="mb-0">$73,579</h3>
                                            </div>
                                            <div class="avatar avatar-md br-4 bg-warning-transparent ms-auto">
                                                <i class="bi bi-currency-dollar fs-20"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex mt-2">
                                            <span class="badge bg-success-transparent rounded-pill">+10% <i class="fe fe-arrow-up"></i></span>
                                            <a href="javascript:void(0);" class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">view more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col card-background flex-fill">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div>
                                                <p class="fw-medium text-muted mb-1">Active Subscribers</p>
                                                <h3 class="mb-0">1,468</h3>
                                            </div>
                                            <div class="avatar avatar-md br-4 bg-danger-transparent ms-auto">
                                                <i class="bi bi-bell fs-20"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex mt-2">
                                            <span class="badge bg-danger-transparent rounded-pill">+16% <i class="fe fe-arrow-down"></i></span>
                                            <a href="javascript:void(0);" class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">view more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ROW-1 -->
                <div class="row">
                    <div class="col-xxl-3 col-xl-12">
                        <div class="row">
                            <div class="col-xxl-12 col-xl-6 col-lg-6">
                                <div class="card custom-card">
                                    <div class="card-header">
                                        <div class="card-title">Recent Activity</div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="task-list mb-0">
                                            <li class="">
                                                <div class="">
                                                    <i class="task-icon bg-primary"></i>
                                                    <h6 class="fw-semibold mb-0">Task Finished</h6>
                                                    <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                                        <div>
                                                            <span class="fs-12 text-muted">Adam Berry finished task on
                                                                <a href="javascript:void(0)" class="fw-semibold text-primary"> AngularJS Template</a></span>
                                                        </div>
                                                        <div class="min-w-fit-content ms-2 text-end">

                                                            <p class="mb-0 text-muted fs-11">09 July 2021</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="">
                                                <div class="">
                                                    <i class="task-icon bg-info"></i>
                                                    <h6 class="fw-semibold mb-0">Task Overdue</h6>
                                                    <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                                        <div>
                                                            <span class="fs-12 text-muted">Petey Cruiser finished</span>
                                                            <a href="javascript:void(0)" class="fw-semibold text-info"> Integrated management</a>
                                                        </div>
                                                        <div class="min-w-fit-content ms-2 text-end">

                                                            <p class="mb-0 text-muted fs-11">29 June 2021</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="">
                                                <div class="">
                                                    <i class="task-icon bg-warning"></i>
                                                    <h6 class="fw-semibold mb-0">Task Finished</h6>
                                                    <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                                        <div>
                                                            <span class="fs-12 text-muted">Adam Berry finished task on</span>
                                                            <a href="javascript:void(0)" class="fw-semibold text-warning"> AngularJS Template</a>
                                                        </div>
                                                        <div class="min-w-fit-content ms-2 text-end">

                                                            <p class="mb-0 text-muted fs-11">09 July 2021</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="">
                                                <div class="">
                                                    <i class="task-icon bg-success"></i>
                                                    <h6 class="fw-semibold mb-0">Task Finished</h6>
                                                    <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                                        <div>
                                                            <span class="fs-12 text-muted">Adam Berry finished task on</span>
                                                            <a href="javascript:void(0)" class="fw-semibold text-success"> AngularJS Template</a>
                                                        </div>
                                                        <div class="min-w-fit-content ms-2 text-end">

                                                            <p class="mb-0 text-muted fs-11">09 July 2021</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="mb-0">
                                                <div class="">
                                                    <i class="task-icon bg-secondary"></i>
                                                    <h6 class="fw-semibold mb-0">New Comment</h6>
                                                    <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                                        <div>
                                                            <span class="fs-12 text-muted">Adam Berry finished task on</span>
                                                            <a href="javascript:void(0)" class="fw-semibold text-secondary"> Project Management</a>
                                                        </div>
                                                        <div class="min-w-fit-content ms-2 text-end">

                                                            <p class="mb-0 text-muted fs-11">25 Aug 2021</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-12 col-xl-6 col-lg-6">
                                <div class="card custom-card overflow-hidden">
                                    <div class="card-header justify-content-between">
                                        <div class="card-title">
                                            Sales by Country
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-outline-light btn-sm">View All</button>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table text-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="row" class="fw-semibold ps-4">Country</th>
                                                        <th scope="row" class="fw-semibold">Sales</th>
                                                        <th scope="row" class="fw-semibold">Bounce</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="top-selling">
                                                    <tr>
                                                        <td class=" ps-4">
                                                            <div class="d-flex align-items-center">
                                                                <span class="avatar avatar-md p-2 bg-light avatar-rounded">
                                                                    <img src="assets/images/flags/canada_flag.jpg" class="rounded-circle" alt="">
                                                                </span>
                                                                <div class="ms-2">
                                                                    <p class="mb-0 fw-semibold">Canada</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fw-semibold">2500</span>
                                                        </td>
                                                        <td><span class="badge badge-sm bg-success-transparent text-success">24.4%</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class=" ps-4">
                                                            <div class="d-flex align-items-center">
                                                                <span class="avatar avatar-md p-2 bg-light avatar-rounded">
                                                                    <img src="assets/images/flags/germany_flag.jpg" class="rounded-circle" alt="">
                                                                </span>
                                                                <div class="ms-2">
                                                                    <p class="mb-0 fw-semibold">Germany</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fw-semibold">846</span>
                                                        </td>
                                                        <td><span class="badge badge-sm bg-danger-transparent text-danger">22.33%</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class=" ps-4">
                                                            <div class="d-flex align-items-center">
                                                                <span class="avatar avatar-md p-2 bg-light avatar-rounded">
                                                                    <img src="assets/images/flags/mexico_flag.jpg" class="rounded-circle" alt="">
                                                                </span>
                                                                <div class="ms-2">
                                                                    <p class="mb-0 fw-semibold">Mexico</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fw-semibold">1,024</span>
                                                        </td>
                                                        <td><span class="badge badge-sm bg-danger-transparent text-danger">14.8%</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class=" ps-4">
                                                            <div class="d-flex align-items-center">
                                                                <span class="avatar avatar-md p-2 bg-light avatar-rounded">
                                                                    <img src="assets/images/flags/russia_flag.jpg" class="rounded-circle" alt="">
                                                                </span>
                                                                <div class="ms-2">
                                                                    <p class="mb-0 fw-semibold">Russia</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fw-semibold">482</span>
                                                        </td>
                                                        <td><span class="badge badge-sm bg-success-transparent text-success">05.8%</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class=" ps-4 border-bottom-0">
                                                            <div class="d-flex align-items-center">
                                                                <span class="avatar avatar-md p-2 bg-light avatar-rounded">
                                                                    <img src="assets/images/flags/us_flag.jpg" class="rounded-circle" alt="">
                                                                </span>
                                                                <div class="ms-2">
                                                                    <p class="mb-0 fw-semibold">USA</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="border-bottom-0">
                                                            <span class="fw-semibold">1,410</span>
                                                        </td>
                                                        <td class="border-bottom-0"><span class="badge badge-sm bg-danger-transparent text-danger">13.08%</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6  col-xl-12">
                        <div class="row">
                            <div class="col-xxl-12 col-xl-12">
                                <div class="card custom-card">
                                    <div class="card-header  justify-content-between">
                                        <div class="card-title">Sales Statistics</div>
                                        <div class="dropdown d-flex">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary-light btn-wave waves-effect waves-light d-flex align-items-center me-2"><i class="ri-filter-3-line me-1"></i>Filter</a>
                                            <a href="javascript:void(0);" class="btn dropdown-toggle btn-sm btn-wave waves-effect waves-light btn-primary d-flex align-items-center" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-calendar-2-line me-1"></i>This Week</a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="javascript:void(0);">Last Month</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Last Week</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Share Report</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="earnings"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-12 col-xl-12">
                                <div class="card custom-card overflow-hidden">
                                    <div class="card-header justify-content-between">
                                        <div class="card-title">
                                            Top Selling Products
                                        </div>
                                        <div class="dropdown">
                                            <a aria-label="anchor" href="javascript:void(0);" class="btn btn-outline-light btn-icons btn-sm text-muted my-1" data-bs-toggle="dropdown">
                                                <i class="fe fe-more-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu mb-0">
                                                <li class="border-bottom"><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                                                <li class="border-bottom"><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table text-nowrap table-hover rounded-3 overflow-hidden">
                                                        <thead>
                                                            <tr>
                                                                <th scope="row" class="ps-4">Product Name</th>
                                                                <th scope="row">stock</th>
                                                                <th scope="row">Price</th>
                                                                <th scope="row">Sold</th>
                                                                <th scope="row">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class=" ps-4">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar avatar-sm me-2">
                                                                            <img src="assets/images/ecommerce/jpg/6.jpg" alt="avatar" class="rounded-1">
                                                                        </div>
                                                                        <a href="product-details.html">Sports Shoes For Men</a>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="mt-sm-1 d-block">
                                                                        <span class="badge bg-success-transparent text-success">In Stock</span>
                                                                    </div>
                                                                </td>
                                                                <td> $73.800</td>
                                                                <td>1,534</td>
                                                                <td>
                                                                    <div class="g-2">
                                                                        <a aria-label="anchor" class="btn  btn-primary-light btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                            <span class="ri-pencil-line fs-14"></span>
                                                                        </a>
                                                                        <a aria-label="anchor" class="btn btn-danger-light btn-sm ms-2" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                            <span class="ri-delete-bin-7-line fs-14"></span>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class=" ps-4">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar avatar-sm me-2">
                                                                            <img src="assets/images/ecommerce/jpg/5.jpg" alt="avatar" class="rounded-1">
                                                                        </div>
                                                                        <a href="product-details.html">Beautiful flower Frame</a>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="mt-sm-1 d-block">
                                                                        <span class="badge bg-info-transparent text-info">Few-left</span>
                                                                    </div>
                                                                </td>
                                                                <td> $73.800</td>
                                                                <td>4,987</td>
                                                                <td>
                                                                    <div class="g-2">
                                                                        <a aria-label="anchor" class="btn  btn-primary-light btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                            <span class="ri-pencil-line fs-14"></span>
                                                                        </a>
                                                                        <a aria-label="anchor" class="btn btn-danger-light btn-sm ms-2" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                            <span class="ri-delete-bin-7-line fs-14"></span>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class=" ps-4">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar avatar-sm me-2">
                                                                            <img src="assets/images/ecommerce/jpg/3.jpg" alt="avatar" class="rounded-1">
                                                                        </div>
                                                                        <a href="product-details.html">Small alarm Watch</a>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="mt-sm-1 d-block">
                                                                        <span class="badge bg-danger-transparent text-danger">Out Of Stock</span>
                                                                    </div>
                                                                </td>
                                                                <td> $13.800</td>
                                                                <td>87,875</td>
                                                                <td>
                                                                    <div class="g-2">
                                                                        <a aria-label="anchor" class="btn  btn-primary-light btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                            <span class="ri-pencil-line fs-14"></span>
                                                                        </a>
                                                                        <a aria-label="anchor" class="btn btn-danger-light btn-sm ms-2" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                            <span class="ri-delete-bin-7-line fs-14"></span>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class=" ps-4">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar avatar-sm me-2">
                                                                            <img src="assets/images/ecommerce/jpg/4.jpg" alt="avatar" class="rounded-1">
                                                                        </div>
                                                                        <a href="product-details.html">Black colord lens cemara</a>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="mt-sm-1 d-block">
                                                                        <span class="badge bg-success-transparent text-success">In Stock</span>
                                                                    </div>
                                                                </td>
                                                                <td> $14.600</td>
                                                                <td>98,876</td>
                                                                <td>
                                                                    <div class="g-2">
                                                                        <a aria-label="anchor" class="btn  btn-primary-light btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                            <span class="ri-pencil-line fs-14"></span>
                                                                        </a>
                                                                        <a aria-label="anchor" class="btn btn-danger-light btn-sm ms-2" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                            <span class="ri-delete-bin-7-line fs-14"></span>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class=" ps-4">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar avatar-sm me-2">
                                                                            <img src="assets/images/ecommerce/jpg/1.jpg" alt="avatar" class="rounded-1">
                                                                        </div>
                                                                        <a href="product-details.html">Smart Phone</a>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="mt-sm-1 d-block">
                                                                        <span class="badge bg-danger-transparent text-danger">Out Of Stock</span>
                                                                    </div>
                                                                </td>
                                                                <td> $13.800</td>
                                                                <td>87,875</td>
                                                                <td>
                                                                    <div class="g-2">
                                                                        <a aria-label="anchor" class="btn  btn-primary-light btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                            <span class="ri-pencil-line fs-14"></span>
                                                                        </a>
                                                                        <a aria-label="anchor" class="btn btn-danger-light btn-sm ms-2" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                            <span class="ri-delete-bin-7-line fs-14"></span>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class=" ps-4">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar avatar-sm me-2">
                                                                            <img src="assets/images/ecommerce/jpg/2.jpg" alt="avatar" class="rounded-1">
                                                                        </div>
                                                                        <a href="product-details.html"> Black colored Headset</a>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="mt-sm-1 d-block">
                                                                        <span class="badge bg-info-transparent text-info">Few-left</span>
                                                                    </div>
                                                                </td>
                                                                <td> $23.800</td>
                                                                <td>1,987</td>
                                                                <td>
                                                                    <div class="g-2">
                                                                        <a aria-label="anchor" class="btn  btn-primary-light btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                            <span class="ri-pencil-line fs-14"></span>
                                                                        </a>
                                                                        <a aria-label="anchor" class="btn btn-danger-light btn-sm ms-2" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                            <span class="ri-delete-bin-7-line fs-14"></span>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-12">
                        <div class="row">
                            <div class="col-xxl-12 col-xl-6">
                                <div class="card custom-card">
                                    <div class="card-header justify-content-between">
                                        <div class="card-title">
                                            Sales Value
                                        </div>
                                        <div class="dropdown">
                                            <a href="javascript:void(0);" class="btn-outline-light btn btn-sm text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                                View All<i class="ri-arrow-down-s-line align-middle ms-1"></i>
                                            </a>
                                            <ul class="dropdown-menu mb-0" role="menu">
                                                <li class="border-bottom"><a class="dropdown-item" href="javascript:void(0);">Today</a></li>
                                                <li class="border-bottom"><a class="dropdown-item" href="javascript:void(0);">This Week</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Last Week</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="">
                                            <div class=" border-bottom">
                                                <div id="avgsales"></div>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <div class="d-flex p-4 border-end">
                                                    <div class="text-center">
                                                        <p class="mb-1 text-muted"> <i class="bx bxs-circle text-primary fs-13  me-1"></i>Sale Items</p>
                                                        <h5 class="mb-0">186,75.00 </h5>
                                                    </div>
                                                </div>

                                                <div class="d-flex p-4">
                                                    <div class="text-center">
                                                        <p class="mb-1 text-muted"> <i class="bx bxs-circle text-primary text-opacity-25 fs-13  me-1"></i>Sale Revenue</p>
                                                        <h5 class=" mb-0">$122,39 </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-12 col-xl-6">
                                <div class="card custom-card">
                                    <div class="card-header justify-content-between">
                                        <div class="card-title">
                                            Monthly Profits
                                        </div>
                                        <div class="dropdown">
                                            <a href="javascript:void(0);" class="btn-outline-light btn btn-sm text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                                View All<i class="ri-arrow-down-s-line align-middle ms-1"></i>
                                            </a>
                                            <ul class="dropdown-menu mb-0" role="menu">
                                                <li class="border-bottom"><a class="dropdown-item" href="javascript:void(0);">Today</a></li>
                                                <li class="border-bottom"><a class="dropdown-item" href="javascript:void(0);">This Week</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Last Week</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="d-flex flex-wrap px-3 py-4 border-bottom justify-content-between">
                                            <div>
                                                <h4 class="mb-1 text-xl">$78,344</h4>
                                                <p class="text-muted mb-0">Total Profit Growth Of 85%</p>
                                            </div>
                                            <div class="ms-sm-auto">
                                                <div class="mt-2">
                                                    <span id="sparkline8"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-3 ">
                                            <ul class="mb-0 mt-1 monthly-profit">
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3">
                                                            <span class="avatar avatar-md br-5 bg-warning-transparent text-warning"><i class="fe fe-box"></i></span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <div class="d-flex justify-content-between">
                                                                <h6 class="fw-semibold">
                                                                    Fashion
                                                                </h6>
                                                                <div>
                                                                    <p class="mb-0 fs-13 text-muted">
                                                                        <i class="fe fe-arrow-up-right me-1 text-success brround"></i>93.0%
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="progress progress-xs">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" style="width: 90%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3">
                                                            <span class="avatar avatar-md br-5 bg-primary-transparent text-primary"><i class="fe fe-home"></i></span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <div class="d-flex justify-content-between">
                                                                <h6 class="fw-semibold">
                                                                    Home Furniture
                                                                </h6>
                                                                <div>
                                                                    <p class="mb-0 fs-13 text-muted">
                                                                        <i class="fe fe-arrow-up-right me-1 text-success brround"></i>97.0%
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="progress progress-xs">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 80%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3">
                                                            <span class="avatar avatar-md br-5 bg-secondary-transparent text-secondary"><i class="fe fe-tv"></i></span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <div class="d-flex justify-content-between">
                                                                <h6 class="fw-semibold">
                                                                    Electronics
                                                                </h6>
                                                                <div>
                                                                    <p class="mb-0 fs-13 text-muted">
                                                                        <i class="fe fe-arrow-up-right me-1 text-success brround"></i>80.0%
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="progress progress-xs">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" style="width: 80%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3">
                                                            <span class="avatar avatar-md br-5 bg-info-transparent text-info"><i class="fe fe-zap"></i></span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <div class="d-flex justify-content-between">
                                                                <h6 class="fw-semibold">
                                                                    Groceries
                                                                </h6>
                                                                <div>
                                                                    <p class="mb-0 fs-13 text-muted">
                                                                        <i class="fe fe-arrow-up-right me-1 text-success brround"></i>80.0%
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="progress progress-xs">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" style="width: 80%;"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ROW-1 END -->
                <div class="row">
                    <div class="col-xxl-3 col-xl-5">
                        <div class="card custom-card">
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    Transactions History
                                </div>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="btn-outline-light btn btn-sm text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                        View All<i class="ri-arrow-down-s-line align-middle ms-1"></i>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li class="border-bottom"><a class="dropdown-item" href="javascript:void(0);">Today</a></li>
                                        <li class="border-bottom"><a class="dropdown-item" href="javascript:void(0);">This Week</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Last Week</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="mb-0 sales-transaction-history-list">
                                    <li>
                                        <div class="d-flex">
                                            <a aria-label="anchor" href="javascript:void(0);"><span class="avatar avatar-md rounded-circle br-5 bg-success-transparent text-success border-success border-opacity-25 border me-3"><i class="fe fe-credit-card"></i></span></a>
                                            <div class="w-100">
                                                <a href="javascript:void(0);">
                                                    <span class="mb-1 fs-14 fw-semibold text-default me-3">ATM Withdrawl</span>
                                                </a>
                                                <p class="fs-12 text-muted me-3 mb-0">Just now</p>
                                            </div>
                                            <div class=" my-auto">
                                                <h6 class="mb-0 text-success">
                                                    $2,45,000
                                                </h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex">
                                            <a aria-label="anchor" href="javascript:void(0);"><span class="avatar avatar-md rounded-circle br-5 bg-danger-transparent text-danger border-danger border-opacity-25 me-3 border"><i class="fe fe-smartphone"></i></span></a>
                                            <div class="w-100">
                                                <a href="javascript:void(0);">
                                                    <span class="mb-1 fs-14 fw-semibold text-default me-3">Movies Subscription</span>
                                                </a>
                                                <p class="fs-12 text-muted me-3 mb-0">Yesterday</p>
                                            </div>
                                            <div class=" my-auto">
                                                <h6 class="mb-0 text-danger">
                                                    -$100.00
                                                </h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex">
                                            <a aria-label="anchor" href="javascript:void(0);"><span class="avatar avatar-md rounded-circle br-5 bg-success-transparent text-success border-success border-opacity-25 border me-3"><i class="fe fe-arrow-down"></i></span></a>
                                            <div class="w-100">
                                                <a href="javascript:void(0);">
                                                    <span class="mb-1 fs-14 fw-semibold text-default me-3">Recieved from John</span>
                                                </a>
                                                <p class="fs-12 text-muted me-3 mb-0">17-04-2022</p>
                                            </div>
                                            <div class=" my-auto">
                                                <h6 class="mb-0 text-success">
                                                    $1,50,000
                                                </h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex">
                                            <a aria-label="anchor" href="javascript:void(0);"><span class="avatar avatar-md rounded-circle br-5 bg-danger-transparent text-danger border-danger border-opacity-25 me-3 border"><i class="fe fe-credit-card"></i></span></a>
                                            <div class="w-100">
                                                <a href="javascript:void(0);">
                                                    <span class="mb-1 fs-14 fw-semibold text-default me-3">Credit Card</span>
                                                </a>
                                                <p class="fs-12 text-muted me-3 mb-0">25-04-2022</p>
                                            </div>
                                            <div class=" my-auto">
                                                <h6 class="mb-0 text-danger">
                                                    -$3,000
                                                </h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex">
                                            <a aria-label="anchor" href="javascript:void(0);"><span class="avatar avatar-md rounded-circle br-5 bg-success-transparent text-success border-success border-opacity-25 border me-3"><i class="fe fe-repeat"></i></span></a>
                                            <div class="w-100">
                                                <a href="javascript:void(0);">
                                                    <span class="mb-1 fs-14 fw-semibold text-default me-3">Transfer to XYZ Card</span>
                                                </a>
                                                <p class="fs-12 text-muted me-3 mb-0">30-04-2022</p>
                                            </div>
                                            <div class=" my-auto">
                                                <h6 class="mb-0 text-success">
                                                    $15,000
                                                </h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex">
                                            <a aria-label="anchor" href="javascript:void(0);"><span class="avatar avatar-md rounded-circle br-5 bg-danger-transparent text-danger border-danger border-opacity-25 me-3 border"><i class="fe fe-repeat"></i></span></a>
                                            <div class="w-100">
                                                <a href="javascript:void(0);">
                                                    <span class="mb-1 fs-14 fw-semibold text-default me-3">Transfer to XYZ Card</span>
                                                </a>
                                                <p class="fs-12 text-muted me-3 mb-0">30-04-2022</p>
                                            </div>
                                            <div class=" my-auto">
                                                <h6 class="mb-0 text-success">
                                                    $15,000
                                                </h6>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-9 col-xl-7">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div>
                                    <h5 class="card-title mb-0">Recent Orders</h5>
                                </div>
                                <div class="ms-auto">
                                    <a aria-label="anchor" href="javascript:void(0)" class="btn btn-outline-light btn-icons btn-sm text-muted" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-start">
                                        <a class="d-flex dropdown-item border-bottom" href="javascript:void(0)">
                                            <i class="ri-share-forward-line me-2"></i>Share
                                        </a>
                                        <a class="d-flex dropdown-item border-bottom" href="javascript:void(0)">
                                            <i class="ri-download-2-line me-2"></i>Download
                                        </a>
                                        <a class="d-flex dropdown-item" href="javascript:void(0)">
                                            <i class="ri-delete-bin-7-line me-2"></i>Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-nowrap table-hover border table-bordered">
                                        <thead class="border-top">
                                            <tr>
                                                <th scope="row" class="border-bottom-0 text-center">S.NO</th>
                                                <th scope="row" class="border-bottom-0">Customer Name</th>
                                                <th scope="row" class="border-bottom-0">Order ID</th>
                                                <th scope="row" class="border-bottom-0">Order Date</th>
                                                <th scope="row" class="border-bottom-0">Price</th>
                                                <th scope="row" class="border-bottom-0">Status</th>
                                                <th scope="row" class="border-bottom-0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="border-bottom">
                                                <td class="text-center">01</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md me-2 avatar-rounded lh-1">
                                                            <img src="assets/images/faces/1.jpg" alt="avatar">
                                                        </div>
                                                        <div class="lh-1">
                                                            <a href="product-details.html">Patty Furniture</a>
                                                            <p class="text-muted fs-11 mb-0 mt-1">patty@spruko.com</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="text-decoration-underline text-primary">#123SP90</span></td>
                                                <td>01 Apr 2022</td>
                                                <td> $73.800</td>
                                                <td>
                                                    <div class="mt-sm-1 d-block">
                                                        <span class="badge bg-success-transparent text-success">Delivered</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="g-2">
                                                        <a aria-label="anchor" class="btn  btn-primary-light btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                            <span class="ri-pencil-line fs-14"></span>
                                                        </a>
                                                        <a aria-label="anchor" class="btn btn-danger-light btn-sm ms-2" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                            <span class="ri-delete-bin-7-line fs-14"></span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td class="text-center">02</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md me-2 avatar-rounded lh-1">
                                                            <img src="assets/images/faces/2.jpg" alt="avatar">
                                                        </div>
                                                        <div class="lh-1">
                                                            <a href="product-details.html">Allie Grate</a>
                                                            <p class="fs-11 text-muted mb-0 mt-1">allie@spruko.com</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="text-decoration-underline text-primary">#123SP91</span></td>
                                                <td>02 Apr 2022</td>
                                                <td> $73.800</td>
                                                <td>
                                                    <div class="mt-sm-1 d-block">
                                                        <span class="badge bg-success-transparent text-success">Delivered</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="g-2">
                                                        <a aria-label="anchor" class="btn  btn-primary-light btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                            <span class="ri-pencil-line fs-14"></span>
                                                        </a>
                                                        <a aria-label="anchor" class="btn btn-danger-light btn-sm ms-2" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                            <span class="ri-delete-bin-7-line fs-14"></span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td class="text-center">03</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md me-2 avatar-rounded lh-1">
                                                            <img src="assets/images/faces/3.jpg" alt="avatar">
                                                        </div>
                                                        <div class="lh-1">
                                                            <a href="product-details.html">Peg Legge</a>
                                                            <p class="fs-11 text-muted mb-0 mt-1">peg@spruko.com</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="text-decoration-underline text-primary">#123SP92</span></td>
                                                <td>24 Mar 2022</td>
                                                <td> $13.800</td>
                                                <td>
                                                    <div class="mt-sm-1 d-block">
                                                        <span class="badge bg-danger-transparent text-danger">Cancelled</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="g-2">
                                                        <a aria-label="anchor" class="btn  btn-primary-light btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                            <span class="ri-pencil-line fs-14"></span>
                                                        </a>
                                                        <a aria-label="anchor" class="btn btn-danger-light btn-sm ms-2" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                            <span class="ri-delete-bin-7-line fs-14"></span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td class="text-center">04</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md me-2 avatar-rounded lh-1">
                                                            <img src="assets/images/faces/4.jpg" alt="avatar">
                                                        </div>
                                                        <div class="lh-1">
                                                            <a href="product-details.html">Maureen Biologist</a>
                                                            <p class="fs-11 text-muted mb-0 mt-1">maureen@spruko.com</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="text-decoration-underline text-primary">#123SP93</span></td>
                                                <td>22 Mar 2022</td>
                                                <td> $14.600</td>
                                                <td>
                                                    <div class="mt-sm-1 d-block">
                                                        <span class="badge bg-info-transparent text-info">Pending</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="g-2">
                                                        <a aria-label="anchor" class="btn  btn-primary-light btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                            <span class="ri-pencil-line fs-14"></span>
                                                        </a>
                                                        <a aria-label="anchor" class="btn btn-danger-light btn-sm ms-2" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                            <span class="ri-delete-bin-7-line fs-14"></span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td class="text-center">05</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md me-2 avatar-rounded lh-1">
                                                            <img src="assets/images/faces/5.jpg" alt="avatar">
                                                        </div>
                                                        <div class="lh-1">
                                                            <a href="product-details.html">Olive Yew</a>
                                                            <p class="text-muted mb-0 mt-1 fs-11">olive@spruko.com</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="text-decoration-underline text-primary">#123SP94</span></td>
                                                <td>20 Mar 2022</td>
                                                <td> $74.965</td>
                                                <td>
                                                    <div class="mt-sm-1 d-block">
                                                        <span class="badge bg-warning-transparent text-warning">Shipped</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="g-2">
                                                        <a aria-label="anchor" class="btn  btn-primary-light btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                            <span class="ri-pencil-line fs-14"></span>
                                                        </a>
                                                        <a aria-label="anchor" class="btn btn-danger-light btn-sm ms-2" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                            <span class="ri-delete-bin-7-line fs-14"></span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End::row -->

            </div>
        </div>
        <!-- End::app-content -->


        <!-- END MAIN-CONTENT -->

        <!-- SEARCH-MODAL -->

        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <span class="input-group">
                            <input type="search" class="form-control px-2 " placeholder="Search..." aria-label="Username">
                            <a href="javascript:void(0);" class="input-group-text bg-primary text-white" id="Search-Grid"><i class="fe fe-search header-link-icon fs-18"></i></a>
                        </span>
                        <div class="mt-3">
                            <div class="">
                                <p class="fw-semibold text-muted mb-2 fs-13">Recent Searches</p>
                                <div class="ps-2">
                                    <a href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>People<span></span></a>
                                    <a href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>Pages<span></span></a>
                                    <a href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>Articles<span></span></a>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="fw-semibold text-muted mb-2 fs-13">Apps and pages</p>
                                <ul class="ps-2">
                                    <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                        <a href="full-calendar.html"><span><i class='bx bx-calendar me-2 fs-14 bg-primary-transparent p-2 rounded-circle '></i>Calendar</span></a>
                                    </li>
                                    <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                        <a href="mail.html"><span><i class='bx bx-envelope me-2 fs-14 bg-primary-transparent p-2 rounded-circle'></i>Mail</span></a>
                                    </li>
                                    <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                        <a href="buttons.html"><span><i class='bx bx-dice-1 me-2 fs-14 bg-primary-transparent p-2 rounded-circle '></i>Buttons</span></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-3">
                                <p class="fw-semibold text-muted mb-2 fs-13">Links</p>
                                <ul class="ps-2">
                                    <li class="p-1 align-items-center  mb-1 search-app">
                                        <a href="javascript:void(0)" class="text-primary"><u>http://spruko/html/spruko.com</u></a>
                                    </li>
                                    <li class="p-1 align-items-center mb-1 search-app">
                                        <a href="javascript:void(0)" class="text-primary"><u>http://spruko/demo/spruko.com</u></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-block">
                        <div class="text-center">
                            <a href="javascript:void(0)" class="text-primary text-decoration-underline fs-15">View all results</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SEARCH-MODAL -->

        <!-- RIGHT-SIDEBAR -->

        <div class="sidebar offcanvas offcanvas-end" tabindex="-1" id="sidebar-right">
            <div class="offcanvas-body position-relative">
                <ul class="nav nav-tabs tab-style-1 d-sm-flex d-block" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#orders-1" aria-current="page"><i class="bx bx-user-plus me-1 fs-16 align-middle"></i>Team</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#accepted-1"><i class="bx bx-pulse me-1 fs-16 align-middle"></i>Timeline</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#declined-1"><i class="bx bx-message-square-dots me-1 fs-16 align-middle"></i>Chat</button>
                    </li>
                </ul>
                <div class="ms-auto my-auto">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"> <i class="bx bx-x sidebar-btn-close"></i></button>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="orders-1" role="tabpanel">
                        <div class="card-body p-0">
                            <input type="text" class="form-control" id="inlinecalendar" placeholder="Choose date">
                        </div>
                        <div class="d-flex pt-4 mt-3 pb-3 align-items-center">
                            <div>
                                <h6 class="fw-semibold mb-0">Team Members</h6>
                            </div>
                            <div class="ms-auto">
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="btn-outline-light btn btn-sm text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                        View All<i class="ri-arrow-down-s-line align-middle ms-1"></i>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li class="border-bottom"><a class="dropdown-item" href="javascript:void(0);">Today</a>
                                        </li>
                                        <li class="border-bottom"><a class="dropdown-item" href="javascript:void(0);">This
                                                Week</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Last Week</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <ul class="ps-0 vertical-scroll">
                            <li class="item">
                                <div class="rounded-2 p-3 border mb-2">
                                    <div class="d-flex">
                                        <a href="profile.html"><img src="assets/images/faces/16.jpg" alt="img" class="avatar avatar-md rounded-2 me-3"></a>
                                        <div class="me-3">
                                            <a href="profile.html">
                                                <h6 class="mb-0 fw-semibold text-default">Vanessa James</h6>
                                            </a>
                                            <span class="clearfix"></span>
                                            <span class="fs-12 text-muted">Front-end Developer</span>
                                        </div>
                                        <a aria-label="anchor" href="javascript:void(0);" class="ms-auto my-auto"> <i class="ri-arrow-right-s-line text-muted fs-20"></i></a>
                                    </div>
                                </div>
                            </li>
                            <li class="item">
                                <div class="rounded-2 p-3 border mb-2">
                                    <div class="d-flex">
                                        <a href="profile.html"><span class="avatar avatar-md rounded-2 bg-primary-transparent text-primary me-3">KH</span></a>
                                        <div class="me-3">
                                            <a href="profile.html">
                                                <h6 class="mb-0 fw-semibold text-default">Kriti Harris</h6>
                                            </a>
                                            <span class="clearfix"></span>
                                            <span class="fs-12 text-muted">Back-end Developer</span>
                                        </div>
                                        <a aria-label="anchor" href="javascript:void(0);" class="ms-auto my-auto"> <i class="ri-arrow-right-s-line text-muted fs-20"></i></a>
                                    </div>
                                </div>
                            </li>
                            <li class="item">
                                <div class="rounded-2 p-3 border mb-2">
                                    <div class="d-flex">
                                        <a href="profile.html"><img src="assets/images/faces/6.jpg" alt="img" class="avatar avatar-md rounded-2 me-3"></a>
                                        <div class="me-3">
                                            <a href="profile.html">
                                                <h6 class="mb-0 fw-semibold text-default">Mira Henry</h6>
                                            </a>
                                            <span class="clearfix"></span>
                                            <span class="fs-12 text-muted">UI / UX Designer</span>
                                        </div>
                                        <a aria-label="anchor" href="javascript:void(0);" class="ms-auto my-auto"> <i class="ri-arrow-right-s-line text-muted fs-20"></i></a>
                                    </div>
                                </div>
                            </li>
                            <li class="item">
                                <div class="rounded-2 p-3 border mb-2">
                                    <div class="d-flex">
                                        <a href="profile.html"><span class="avatar avatar-md rounded-2 bg-secondary-transparent text-secondary me-3">JK</span></a>
                                        <div class="me-3">
                                            <a href="profile.html">
                                                <h6 class="mb-0 fw-semibold text-default">James Kimberly</h6>
                                            </a>
                                            <span class="clearfix"></span>
                                            <span class="fs-12 text-muted">Angular Developer</span>
                                        </div>
                                        <a aria-label="anchor" href="javascript:void(0);" class="ms-auto my-auto"> <i class="ri-arrow-right-s-line text-muted fs-20"></i></a>
                                    </div>
                                </div>
                            </li>
                            <li class="item">
                                <div class="rounded-2 p-3 border mb-2">
                                    <div class="d-flex">
                                        <a href="profile.html"><img src="assets/images/faces/9.jpg" alt="img" class="avatar avatar-md rounded-2 me-3"></a>
                                        <div class="me-3">
                                            <a href="profile.html">
                                                <h6 class="mb-0 fw-semibold text-default">Marley Paul</h6>
                                            </a>
                                            <span class="clearfix"></span>
                                            <span class="fs-12 text-muted">Front-end Developer</span>
                                        </div>
                                        <a aria-label="anchor" href="javascript:void(0);" class="ms-auto my-auto"> <i class="ri-arrow-right-s-line text-muted fs-20"></i></a>
                                    </div>
                                </div>
                            </li>
                            <li class="item">
                                <div class="rounded-2 p-3 border mb-2">
                                    <div class="d-flex">
                                        <a href="profile.html"><span class="avatar avatar-md rounded-2 bg-success-transparent text-success me-3">MA</span></a>
                                        <div class="me-3">
                                            <a href="profile.html">
                                                <h6 class="mb-0 fw-semibold text-default">Mitrona Anna</h6>
                                            </a>
                                            <span class="clearfix"></span>
                                            <span class="fs-12 text-muted">UI / UX Designer</span>
                                        </div>
                                        <a aria-label="anchor" href="javascript:void(0);" class="ms-auto my-auto"> <i class="ri-arrow-right-s-line text-muted fs-20"></i></a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane" id="accepted-1" role="tabpanel">
                        <ul class="activity-list">
                            <li class="d-flex mt-4">
                                <div>
                                    <i class="activity-icon">
                                        <a href="profile.html"><img src="assets/images/faces/14.jpg" alt="img" class="avatar avatar-xs rounded-2 me-3"></a>
                                    </i>
                                    <a href="profile.html">
                                        <h6 class="text-default">Elmer Barnes
                                            <span class="text-muted fs-11 mx-2 fw-normal">Today 02:41 PM</span>
                                        </h6>
                                    </a>
                                    <p class="text-muted fs-12 mb-0">Added 1 attachment <strong>docfile.doc</strong></p>
                                    <div class="btn-group file-attach mt-3" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-sm btn-primary-light">
                                            <span class="ri-file-line me-2"></span> Image_file.jpg
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary-light" aria-label="Close">
                                            <span class="ri-download-2-line"></span>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mt-4">
                                <div>
                                    <i class="activity-icon">
                                        <span class="avatar avatar-xs brround bg-success">RN</span>
                                    </i>
                                    <a href="profile.html">
                                        <h6 class="text-default">Roxanne Nunez
                                            <span class="text-muted fs-11 mx-2 fw-normal">Today 11:40 AM</span>
                                        </h6>
                                    </a>
                                    <p class="text-muted fs-12 mb-0">Commented on <strong>Task Management</strong></p>
                                    <div class="activity-comment mt-3">
                                        <p>There are many variations of passages of Lorem Ipsum available.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mt-4">
                                <div>
                                    <i class="activity-icon">
                                        <span class="avatar avatar-xs brround bg-primary"><i class="ri-shield-line text-white"></i></span>
                                    </i>
                                    <a href="profile.html">
                                        <h6 class="text-default">Shirley Vega
                                            <span class="text-muted fs-11 mx-2 fw-normal">Today 08:43 AM</span>
                                        </h6>
                                    </a>
                                    <p class="text-muted fs-12 mb-0">Task Closed by <strong> Today</strong></p>
                                </div>
                            </li>
                            <li class="d-flex mt-4">
                                <div>
                                    <i class="activity-icon">
                                        <a href="profile.html"><img src="assets/images/faces/11.jpg" alt="img" class="avatar avatar-xs rounded-2 me-3"></a>
                                    </i>
                                    <a href="profile.html">
                                        <h6 class="text-default">Vivian Herrera
                                            <span class="text-muted fs-11 mx-2 fw-normal">Today 08:00 AM</span>
                                        </h6>
                                    </a>
                                    <p class="text-muted fs-12 mb-0">Assigned a new Task on <strong> UI Design</strong></p>
                                </div>
                            </li>
                            <li class="d-flex mt-4">
                                <div>
                                    <i class="activity-icon">
                                        <span class="avatar avatar-xs brround bg-success">TJ</span>
                                    </i>
                                    <a href="profile.html">
                                        <h6 class="text-default">Tony Jarvis
                                            <span class="text-muted fs-11 mx-2 fw-normal">Yesterday 05:40 PM</span>
                                        </h6>
                                    </a>
                                    <p class="text-muted fs-12 mb-0">Added 3 attachments <strong>Project</strong></p>
                                    <div class="activity-images mt-3">
                                        <a href="gallery.php"><img src="assets/images/media/media-34.jpg" alt="thumb1"></a>
                                        <a href="gallery.php"><img src="assets/images/media/media-35.jpg" alt="thumb1"></a>
                                        <a href="gallery.php"><img src="assets/images/media/media-36.jpg" alt="thumb1"></a>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex mt-4">
                                <div>
                                    <i class="activity-icon">
                                        <a href="profile.html"><img src="assets/images/faces/16.jpg" alt="img" class="avatar avatar-xs rounded-2 me-3"></a>
                                    </i>
                                    <a href="profile.html">
                                        <h6 class="text-default">Russell Kim
                                            <span class="text-muted fs-11 mx-2 fw-normal">17 May 2022</span>
                                        </h6>
                                    </a>
                                    <p class="text-muted fs-12 mb-0">Created a group <strong> Team Unity</strong></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane" id="declined-1" role="tabpanel">
                        <div class="list-group list-group-flush">
                            <div class="pt-3 fw-semibold ps-2 text-muted">Today</div>
                            <div class="list-group-item d-flex align-items-center">
                                <div class="me-2">
                                    <a href="profile.html"><img src="assets/images/faces/16.jpg" alt="img" class="avatar avatar-md rounded-2"></a>
                                </div>
                                <div class="">
                                    <a href="chat.html">
                                        <h6 class="fw-semibold mb-0">Leon Ray</h6>
                                        <p class="mb-0 fs-12 text-muted"> 2 mins ago </p>
                                    </a>
                                </div>
                                <div class="ms-auto">
                                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light  me-1"><i class="ri-phone-line text-success"></i></a>
                                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light"><i class="ri-chat-3-line text-primary"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex align-items-center">
                                <div class="me-2">
                                    <span class="avatar avatar-md rounded-2 bg-danger-transparent text-danger">DT
                                        <span class="avatar-status bg-success"></span>
                                    </span>
                                </div>
                                <div class="">
                                    <a href="chat.html">
                                        <h6 class="fw-semibold mb-0">Dane Tillery</h6>
                                        <p class="mb-0 fs-12 text-muted"> 10 mins ago </p>
                                    </a>
                                </div>
                                <div class="ms-auto">
                                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light  me-1"><i class="ri-phone-line text-success"></i></a>
                                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light"><i class="ri-chat-3-line text-primary"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex align-items-center">
                                <div class="me-2">
                                    <a href="profile.html"><img src="assets/images/faces/16.jpg" alt="img" class="avatar avatar-md rounded-2"></a>
                                </div>
                                <div class="">
                                    <a href="chat.html">
                                        <h6 class="fw-semibold mb-0">Zelda Perkins</h6>
                                        <p class="mb-0 fs-12 text-muted"> 3 hours ago </p>
                                    </a>
                                </div>
                                <div class="ms-auto">
                                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light  me-1"><i class="ri-phone-line text-success"></i></a>
                                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light"><i class="ri-chat-3-line text-primary"></i></a>
                                </div>
                            </div>
                            <div class="py-3 fw-semibold ps-2 text-muted">Yesterday</div>
                            <div class="list-group-item d-flex align-items-center">
                                <div class="me-2">
                                    <span class="avatar avatar-md rounded-2 bg-primary-transparent text-primary">GB
                                        <span class="avatar-status bg-success"></span>
                                    </span>
                                </div>
                                <div class="">
                                    <a href="chat.html">
                                        <h6 class="fw-semibold mb-0">Gaylord Barrett</h6>
                                        <p class="mb-0 fs-12 text-muted"> 12:40 pm </p>
                                    </a>
                                </div>
                                <div class="ms-auto">
                                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light  me-1"><i class="ri-phone-line text-success"></i></a>
                                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light"><i class="ri-chat-3-line text-primary"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex align-items-center">
                                <div class="me-2">
                                    <a href="profile.html"><img src="assets/images/faces/16.jpg" alt="img" class="avatar avatar-md rounded-2"></a>
                                </div>
                                <div class="">
                                    <a href="chat.html">
                                        <h6 class="fw-semibold mb-0">Roger Bradley</h6>
                                        <p class="mb-0 fs-12 text-muted"> 01:00 pm </p>
                                    </a>
                                </div>
                                <div class="ms-auto">
                                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light  me-1"><i class="ri-phone-line text-success"></i></a>
                                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light"><i class="ri-chat-3-line text-primary"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex align-items-center">
                                <div class="me-2">
                                    <a href="profile.html"><img src="assets/images/faces/16.jpg" alt="img" class="avatar avatar-md rounded-2"></a>
                                </div>
                                <div class="">
                                    <a href="chat.html">
                                        <h6 class="fw-semibold mb-0">Magnus Haynes</h6>
                                        <p class="mb-0 fs-12 text-muted"> 03:53 pm </p>
                                    </a>
                                </div>
                                <div class="ms-auto">
                                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light  me-1"><i class="ri-phone-line text-success"></i></a>
                                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light"><i class="ri-chat-3-line text-primary"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex align-items-center">
                                <div class="me-2">
                                    <span class="avatar avatar-md rounded-2 bg-secondary-transparent text-secondary">DC
                                        <span class="avatar-status bg-gray"></span>
                                    </span>
                                </div>
                                <div class="">
                                    <a href="chat.html">
                                        <h6 class="fw-semibold mb-0">Doran Chasey</h6>
                                        <p class="mb-0 fs-12 text-muted"> 06:00 pm </p>
                                    </a>
                                </div>
                                <div class="ms-auto">
                                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light  me-1"><i class="ri-phone-line text-success"></i></a>
                                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light"><i class="ri-chat-3-line text-primary"></i></a>
                                </div>
                            </div>
                            <div class="list-group-item d-flex align-items-center">
                                <div class="me-2">
                                    <span class="avatar avatar-md rounded-2 bg-warning-transparent text-warning">EW
                                        <span class="avatar-status bg-danger"></span>
                                    </span>
                                </div>
                                <div class="">
                                    <a href="chat.html">
                                        <h6 class="fw-semibold mb-0">Ellery Wolfe</h6>
                                        <p class="mb-0 fs-12 text-muted"> 08:46 pm </p>
                                    </a>
                                </div>
                                <div class="ms-auto">
                                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light  me-1"><i class="ri-phone-line text-success"></i></a>
                                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light"><i class="ri-chat-3-line text-primary"></i></a>
                                </div>
                            </div>
                            <div class="text-center">
                                <a href="javascript:void(0)" class="btn btn-sm text-primary text-decoration-underline">View
                                    all</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END RIGHT-SIDEBAR -->

        <?php include_once("templates/base_footer.php"); ?>