<!-- This code generates the base URL for the website by combining the protocol, domain name, and directory path -->
<!-- This code generates the base URL for the website by combining the protocol, domain name, and directory path -->

<!-- This code is useful for internal styles  -->
<!-- This code is useful for internal styles  -->

<!-- This code is useful for content -->
<!-- This code is useful for content -->

<!-- This code is useful for internal scripts  -->
<!-- This code is useful for internal scripts  -->

<!-- This code use for render base file -->
<!DOCTYPE html> 
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="gradient" data-menu-styles="dark">

    
<!-- Mirrored from php.spruko.com/velvet/velvet/pages/widgets.php by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 21 Mar 2024 11:40:04 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>

        <!-- Meta Data -->
		<meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Description" content="Velvet - PHP Bootstrap5 Admin & Dashboard Template">
        <meta name="Author" content="Spruko Technologies Private Limited">
        <meta name="keywords" content="bootstrap admin dashboard, admin template, bootstrap admin panel, php admin, admin, php, php admin dashboard, php admin panel, php framework, admin template bootstrap 5, php dashboard, dashboard, bootstrap dashboard, dashboard bootstrap 5, php my admin">
        
        <!-- TITLE -->
		<title> Velvet - PHP Bootstrap5 Admin &amp; Dashboard Template </title>

        <!-- FAVICON -->
        <link rel="icon" href="https://php.spruko.com/velvet/velvet/assets/images/brand-logos/fav.ico" type="image/x-icon">

        <!-- BOOTSTRAP CSS -->
        <link  id="style" href="assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- ICONS CSS -->
        <link href="assets/css/icons.css" rel="stylesheet">

        <!-- STYLES CSS -->
        <link href="assets/css/styles.css" rel="stylesheet">

        <!-- MAIN JS -->
        <script src="assets/js/main.js"></script>

        
        <!-- NODE WAVES CSS -->
        <link href="assets/libs/node-waves/waves.min.css" rel="stylesheet"> 

        <!-- SIMPLEBAR CSS -->
        <link rel="stylesheet" href="assets/libs/simplebar/simplebar.min.css">

        <!-- COLOR PICKER CSS -->
        <link rel="stylesheet" href="assets/libs/flatpickr/flatpickr.min.css">
        <link rel="stylesheet" href="assets/libs/%40simonwep/pickr/themes/nano.min.css">

        <!-- CHOICES CSS -->
        <link rel="stylesheet" href="assets/libs/choices.js/public/assets/styles/choices.min.css">

        <!-- CHOICES JS -->
        <script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
        


	</head>

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
                        <button class="nav-link active" id="switcher-home-tab" data-bs-toggle="tab" data-bs-target="#switcher-home"
                            type="button" role="tab" aria-controls="switcher-home" aria-selected="true">Theme Styles</button>
                        <button class="nav-link" id="switcher-profile-tab" data-bs-toggle="tab" data-bs-target="#switcher-profile"
                            type="button" role="tab" aria-controls="switcher-profile" aria-selected="false">Theme Colors</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active border-0" id="switcher-home" role="tabpanel" aria-labelledby="switcher-home-tab"
                        tabindex="0">
                        <div class="">
                            <p class="switcher-style-head">Theme Color Mode:</p>
                            <div class="row switcher-style gx-0">
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-light-theme">
                                            Light
                                        </label>
                                        <input class="form-check-input" type="radio" name="theme-style" id="switcher-light-theme"
                                            checked>
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
                                        <input class="form-check-input" type="radio" name="navigation-style" id="switcher-vertical"
                                            checked>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-horizontal">
                                            Horizontal
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-style"
                                            id="switcher-horizontal">
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
                                        <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                            id="switcher-menu-click">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-menu-hover">
                                            Menu Hover
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                            id="switcher-menu-hover">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-icon-click">
                                            Icon Click
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                            id="switcher-icon-click">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-icon-hover">
                                            Icon Hover
                                        </label>
                                        <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                            id="switcher-icon-hover">
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
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-default-menu" checked>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-closed-menu">
                                            Closed Menu
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-closed-menu">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-icontext-menu">
                                            Icon Text
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-icontext-menu">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-icon-overlay">
                                            Icon Overlay
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-icon-overlay">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-detached">
                                            Detached
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-detached">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-double-menu">
                                            Double Menu
                                        </label>
                                        <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                            id="switcher-double-menu">
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
                                        <input class="form-check-input" type="radio" name="page-styles" id="switcher-regular"
                                            checked>
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
                                        <input class="form-check-input" type="radio" name="layout-width" id="switcher-full-width"
                                            checked>
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
                                        <input class="form-check-input" type="radio" name="menu-positions" id="switcher-menu-fixed"
                                            checked>
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
                                        <input class="form-check-input" type="radio" name="header-positions"
                                            id="switcher-header-fixed" checked>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-header-scroll">
                                            Scrollable
                                        </label>
                                        <input class="form-check-input" type="radio" name="header-positions"
                                            id="switcher-header-scroll" >
                                    </div>
                                </div>
                                <div class="col-4 rounded-header">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-header-rounded">
                                            Rounded
                                        </label>
                                        <input class="form-check-input" type="radio" name="header-positions"
                                            id="switcher-header-rounded">
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
                                        <input class="form-check-input" type="radio" name="page-loader"
                                            id="switcher-loader-enable">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check switch-select">
                                        <label class="form-check-label" for="switcher-loader-disable">
                                            Disable
                                        </label>
                                        <input class="form-check-input" type="radio" name="page-loader"
                                            id="switcher-loader-disable" checked>
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
                                        <input class="form-check-input color-input color-white" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Light Menu" type="radio" name="menu-colors"
                                            id="switcher-menu-light">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Dark Menu" type="radio" name="menu-colors"
                                            id="switcher-menu-dark" checked>
                                    </div>
                                </div>
                                <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Menu dynamically change from below Theme Primary color picker</div>
                            </div>
                            <div class="theme-colors">
                                <p class="switcher-style-head">Header &amp; Bredcrumb Colors:</p>
                                <div class="d-flex switcher-style pb-2">
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Dark Header" type="radio" name="header-colors"
                                            id="switcher-header-dark">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Color Header" type="radio" name="header-colors"
                                            id="switcher-header-primary">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-gradient" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Gradient Header" type="radio" name="header-colors"
                                            id="switcher-header-gradient">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-transparent" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Transparent Header" type="radio" name="header-colors"
                                            id="switcher-header-transparent">
                                    </div>
                                </div>
                                <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Header dynamically change from below Theme Primary color picker</div>
                            </div>
                            <div class="theme-colors">
                                <p class="switcher-style-head">Header Colors:</p>
                                <div class="d-flex switcher-style pb-2">
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-white" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Default Light Header" type="radio" name="header-colors"
                                            id="switcher-default-header-light">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Default Dark Header" type="radio" name="header-colors"
                                            id="switcher-default-header-dark">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Default Color Header" type="radio" name="header-colors"
                                            id="switcher-default-header-primary">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-gradient" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Default Gradient Header" type="radio" name="header-colors"
                                            id="switcher-default-header-gradient">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-transparent" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Default Transparent Header" type="radio" name="header-colors"
                                            id="switcher-default-header-transparent">
                                    </div>
                                </div>
                                <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Header dynamically change from below Theme Primary color picker</div>
                            </div>
                            <div class="theme-colors">
                                <p class="switcher-style-head">Theme Primary:</p>
                                <div class="d-flex flex-wrap align-items-center switcher-style">
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-1" type="radio"
                                            name="theme-primary" id="switcher-primary">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-2" type="radio"
                                            name="theme-primary" id="switcher-primary1">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-3" type="radio" name="theme-primary"
                                            id="switcher-primary2">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-4" type="radio" name="theme-primary"
                                            id="switcher-primary3">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-primary-5" type="radio" name="theme-primary"
                                            id="switcher-primary4">
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
                                        <input class="form-check-input color-input color-bg-1" type="radio"
                                            name="theme-background" id="switcher-background">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-2" type="radio"
                                            name="theme-background" id="switcher-background1">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-3" type="radio" name="theme-background"
                                            id="switcher-background2">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-4" type="radio"
                                            name="theme-background" id="switcher-background3">
                                    </div>
                                    <div class="form-check switch-select me-3">
                                        <input class="form-check-input color-input color-bg-5" type="radio"
                                            name="theme-background" id="switcher-background4">
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
                                        <input class="form-check-input bgimage-input bg-img1" type="radio"
                                            name="theme-background" id="switcher-bg-img">
                                    </div>
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img2" type="radio"
                                            name="theme-background" id="switcher-bg-img1">
                                    </div>
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img3" type="radio" name="theme-background"
                                            id="switcher-bg-img2">
                                    </div>
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img4" type="radio"
                                            name="theme-background" id="switcher-bg-img3">
                                    </div>
                                    <div class="form-check switch-select m-2">
                                        <input class="form-check-input bgimage-input bg-img5" type="radio"
                                            name="theme-background" id="switcher-bg-img4">
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

            <!-- HEADER -->
            
            <header class="app-header">

                <!-- Start::main-header-container -->
                <div class="main-header-container container-fluid">

                    <!-- Start::header-content-left -->
                    <div class="header-content-left">

                        <!-- Start::header-element -->
                        <div class="header-element">
                            <div class="horizontal-logo">
                                <a href="index.html" class="header-logo">
                                    <img src="assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
                                    <img src="assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
                                    <img src="assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark">
                                    <img src="assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
                                </a>
                            </div>
                        </div>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <div class="header-element">
                            <!-- Start::header-link -->
                            <a aria-label="anchor" href="javascript:void(0);" class="sidemenu-toggle header-link" data-bs-toggle="sidebar">
                                <span class="open-toggle me-2">
                                    <i class="bx bx-menu header-link-icon"></i>
                                </span>
                            </a>
                            <div class="main-header-center  d-none d-lg-block  header-link">
                                <input type="text" class="form-control form-control-lg" id="typehead" placeholder="Search for results..."
                                    autocomplete="off">
                                <button type="button"  aria-label="button" class="btn pe-1"><i class="fe fe-search" aria-hidden="true"></i></button>
                                <div id="headersearch" class="header-search">
                                    <div class="p-3">
                                        <div class="">
                                            <p class="fw-semibold text-muted mb-2 fs-13">Recent Searches</p>
                                            <div class="ps-2">
                                                <a  href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>People<span></span></a>
                                                <a  href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>Pages<span></span></a>
                                                <a  href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>Articles<span></span></a>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <p class="fw-semibold text-muted mb-2 fs-13">Apps and pages</p>
                                            <ul class="ps-2">
                                                <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                                    <a href="full-calendar.html"><span><i class="bx bx-calendar me-2 fs-14 bg-primary-transparent p-2 rounded-circle"></i>Calendar</span></a>
                                                </li>
                                                <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                                    <a href="mail.html"><span><i class="bx bx-envelope me-2 fs-14 bg-primary-transparent p-2 rounded-circle"></i>Mail</span></a>
                                                </li>
                                                <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                                    <a href="buttons.html"><span><i class="bx bx-dice-1 me-2 fs-14 bg-primary-transparent p-2 rounded-circle"></i>Buttons</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="mt-3">
                                        <p class="fw-semibold text-muted mb-2 fs-13">Links</p>
                                        <ul class="ps-2">
                                                <li class="p-1 align-items-center text-muted mb-1 search-app">
                                                        <a href="javascript:void(0)" class="text-primary"><u>http://spruko/spruko.com</u></a>
                                                </li>
                                                <li class="p-1 align-items-center text-muted mb-1 search-app">
                                                        <a href="javascript:void(0)" class="text-primary"><u>http://spruko/spruko.com</u></a>
                                                </li>
                                            </ul>
                                    </div>
                                    </div>
                                    <div class="py-3 border-top px-0">
                                        <div class="text-center">
                                            <a href="javascript:void(0)" class="text-primary text-decoration-underline fs-15">View all</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- End::header-link -->
                        </div>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <div class="header-element header-search d-lg-none d-block ">
                            <!-- Start::header-link -->
                            <a aria-label="anchor" href="javascript:void(0);" class="header-link" data-bs-toggle="modal" data-bs-target="#searchModal">
                                <i class="bx bx-search-alt-2 header-link-icon"></i>
                            </a>
                            <!-- End::header-link -->
                        </div>
                        <!-- End::header-element -->

                    </div>
                    <!-- End::header-content-left -->

                    <!-- Start::header-content-right -->
                    <div class="header-content-right">

                        <!-- Start::header-element -->
                        <div class="header-element country-selector">
                            <!-- Start::header-link|dropdown-toggle -->
                            <a aria-label="anchor" href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                    <i class="bx bx-globe header-link-icon"></i>
                            </a>
                            <!-- End::header-link|dropdown-toggle -->
                            <ul class="main-header-dropdown dropdown-menu border-0" data-popper-placement="none">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                        <span class="avatar avatar-xs lh-1 me-2">
                                            <img src="assets/images/flags/us_flag.jpg" alt="img">
                                        </span>
                                        English
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                        <span class="avatar avatar-xs lh-1 me-2">
                                            <img src="assets/images/flags/spain_flag.jpg" alt="img" >
                                        </span>
                                        Spanish
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                        <span class="avatar avatar-xs lh-1 me-2">
                                            <img src="assets/images/flags/french_flag.jpg" alt="img" >
                                        </span>
                                        French
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                        <span class="avatar avatar-xs lh-1 me-2">
                                            <img src="assets/images/flags/germany_flag.jpg" alt="img" >
                                        </span>
                                        German
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                        <span class="avatar avatar-xs lh-1 me-2">
                                            <img src="assets/images/flags/italy_flag.jpg" alt="img" >
                                        </span>
                                        Italian
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                        <span class="avatar avatar-xs lh-1 me-2">
                                            <img src="assets/images/flags/russia_flag.jpg" alt="img" >
                                        </span>
                                        Russian
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <div class="header-element header-theme-mode">
                            <!-- Start::header-link|layout-setting -->
                            <a aria-label="anchor" href="javascript:void(0);" class="header-link layout-setting">
                                    <!-- Start::header-link-icon -->
                                        <i class="bx bx-sun bx-flip-horizontal header-link-icon ionicon  dark-layout"></i>
                                    <!-- End::header-link-icon -->
                                    <!--  Start::header-link-icon -->
                                        <i class="bx bx-moon bx-flip-horizontal header-link-icon ionicon light-layout"></i>
                                    <!-- End::header-link-icon -->
                            </a>
                            <!-- End::header-link|layout-setting -->
                        </div>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <div class="header-element cart-dropdown">
                            <!-- Start::header-link|dropdown-toggle -->
                            <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                    <i class="bx bx-cart header-link-icon ionicon"></i>
                                <span class="badge bg-danger rounded-pill header-icon-badge" id="cart-icon-badge">5</span>
                            </a>
                            <!-- End::header-link|dropdown-toggle -->
                            <!-- Start::main-header-dropdown -->
                            <div class="main-header-dropdown dropdown-menu  border-0 dropdown-menu-end" data-popper-placement="none">
                                <div class="p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <p class="mb-0 fs-17 fw-semibold">Cart Items</p>
                                        <span class="badge bg-success-transparent" id="cart-data">5 Items</span>
                                    </div>
                                </div>
                                <div><hr class="dropdown-divider"></div>
                                <ul class="list-unstyled mb-0" id="header-cart-items-scroll">
                                    <li class="dropdown-item border-bottom">
                                        <div class="d-flex align-items-start cart-dropdown-item">
                                            <span class="avatar avatar-xl bd-gray-200 p-1">
                                                <img src="assets/images/ecommerce/png/1.png" alt="">
                                            </span>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="d-flex align-items-start justify-content-between mb-0">
                                                    <div class=" fs-13 fw-semibold">
                                                        <a href="cart.html">Cactus mini plant</a>
                                                    </div>
                                                    <div>
                                                        <a aria-label="anchor" href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="min-w-fit-content align-items-start">
                                                    <div class=" fw-normal fs-12 text-muted">Quantity:02</div>
                                                    <div class="d-flex  align-items-center">
                                                        <span class=" fw-semibold fs-16">$1,229</span>
                                                        <p class="text-muted text-decoration-line-through ms-1 op-6 fs-12 mb-0">$1,799</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-item border-bottom">
                                        <div class="d-flex align-items-start cart-dropdown-item">
                                            <span class="avatar avatar-xl bd-gray-200 p-1">
                                                <img src="assets/images/ecommerce/png/15.png" alt="">
                                            </span>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="d-flex align-items-start justify-content-between mb-0">
                                                    <div class=" fs-13 fw-semibold">
                                                        <a href="cart.html">Sports shoes for men</a>
                                                    </div>
                                                    <div>
                                                        <a aria-label="anchor" href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="min-w-fit-content align-items-start">
                                                    <div class=" fw-normal fs-12 text-muted">Quantity:01</div>
                                                    <div class="d-flex  align-items-center">
                                                        <span class=" fw-semibold fs-16">$10,229</span>
                                                        <p class="text-muted text-decoration-line-through ms-1 op-6 fs-12 mb-0">$799</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-item border-bottom">
                                        <div class="d-flex align-items-start cart-dropdown-item">
                                            <span class="avatar avatar-xl bd-gray-200 p-1">
                                                <img src="assets/images/ecommerce/png/40.png" alt="">
                                            </span>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="d-flex align-items-start justify-content-between mb-0">
                                                    <div class=" fs-13 fw-semibold">
                                                        <a href="cart.html">Pink color smart watch </a>
                                                    </div>
                                                    <div>
                                                        <a aria-label="anchor" href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="min-w-fit-content align-items-start">
                                                    <div class=" fw-normal fs-12 text-muted">Quantity:03</div>
                                                    <div class="d-flex  align-items-center">
                                                        <span class=" fw-semibold fs-16">$5,500</span>
                                                        <p class="text-muted text-decoration-line-through ms-1 op-6 fs-12 mb-0">$599</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-item border-bottom">
                                        <div class="d-flex align-items-start cart-dropdown-item">
                                            <span class="avatar avatar-xl bd-gray-200 p-1">
                                                <img src="assets/images/ecommerce/png/8.png" alt="">
                                            </span>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="d-flex align-items-start justify-content-between mb-0">
                                                    <div class=" fs-13 fw-semibold">
                                                        <a href="cart.html">Red Leafs plant </a>
                                                    </div>
                                                    <div>
                                                        <a aria-label="anchor" href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="min-w-fit-content align-items-start">
                                                    <div class=" fw-normal fs-12 text-muted">Quantity:01</div>
                                                    <div class="d-flex  align-items-center">
                                                        <span class=" fw-semibold fs-16">$15,300</span>
                                                        <p class="text-muted text-decoration-line-through ms-1 op-6 fs-12 mb-0">$799</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-start cart-dropdown-item">
                                            <span class="avatar avatar-xl bd-gray-200 p-1">
                                                <img src="assets/images/ecommerce/png/11.png" alt="">
                                            </span>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="d-flex align-items-start justify-content-between mb-0">
                                                    <div class=" fs-13 fw-semibold">
                                                        <a href="cart.html">Good luck mini plant</a>
                                                    </div>
                                                    <div>
                                                        <a aria-label="anchor" href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="min-w-fit-content align-items-start">
                                                    <div class=" fw-normal fs-12 text-muted">Quantity:02</div>
                                                    <div class="d-flex  align-items-center">
                                                        <span class=" fw-semibold fs-16">$600</span>
                                                        <p class="text-muted text-decoration-line-through ms-1 op-6 fs-12 mb-0">$99</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="p-3 empty-header-item border-top">
                                    <div class="d-grid">
                                        <a href="checkout.html" class="btn btn-primary">Checkout</a>
                                    </div>
                                </div>
                                <div class="p-5 empty-item d-none">
                                    <div class="text-center">
                                        <span class="avatar avatar-xxl avatar-rounded bg-warning-transparent">
                                            <i class="bx bx-cart bx-tada fs-2"></i>
                                        </span>
                                        <h6 class="fw-bold mb-2 mt-3">Your Cart is Empty</h6>
                                        <a href="products.html" class="btn btn-primary btn-wave btn-sm m-1" data-abc="true">continue shopping <i class="bi bi-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                            <!-- End::main-header-dropdown -->
                        </div>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <div class="header-element notifications-dropdown ">
                            <!-- Start::header-link|dropdown-toggle -->
                            <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="messageDropdown" aria-expanded="false">
                                <i class="bx bx-bell bx-flip-horizontal header-link-icon ionicon"></i>
                            <span class="badge bg-info rounded-pill header-icon-badge pulse pulse-secondary" id="notification-icon-badge">5</span>
                            </a>
                            <!-- End::header-link|dropdown-toggle -->
                            <!-- Start::main-header-dropdown -->
                            <div class="main-header-dropdown dropdown-menu  border-0 dropdown-menu-end" data-popper-placement="none">
                                <div class="p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <p class="mb-0 fs-17 fw-semibold">Notifications</p>
                                        <span class="badge bg-secondary-transparent" id="notifiation-data">5 Unread</span>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <ul class="list-unstyled mb-0" id="header-notification-scroll">
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-start">
                                            <div class="pe-2">
                                                <span class="avatar avatar-md bg-secondary-transparent rounded-2">
                                                    <img src="assets/images/faces/2.jpg" alt="">
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 d-flex  justify-content-between">
                                                <div>
                                                    <p class="mb-0 fw-semibold"><a href="notifications.html">Olivia James</a></p>
                                                    <span class="fs-12 text-muted fw-normal">Congratulate for New template start</span>
                                                </div>
                                                <div class="min-w-fit-content ms-2 text-end">
                                                    <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-14"></i></a>
                                                    <p class="mb-0 text-muted fs-11">2 min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-start">
                                            <div class="pe-2">
                                                <span class="avatar avatar-md bg-warning-transparent rounded-2"><i class="bx bx-pyramid fs-18"></i></span>
                                            </div>
                                            <div class="flex-grow-1 d-flex  justify-content-between">
                                                <div>
                                                    <p class="mb-0 fw-semibold"><a href="notifications.html">Order Placed <span class="text-warning">ID: #1116773</span></a></p>
                                                    <span class="fs-12 text-muted fw-normal header-notification-text">Order Placed Successfully</span>
                                                </div>
                                                <div class="min-w-fit-content ms-2 text-end">
                                                    <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-14"></i></a>
                                                    <p class="mb-0 text-muted fs-11">5 min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-start">
                                            <div class="pe-2">
                                                <span class="avatar avatar-md bg-secondary-transparent rounded-2">
                                                    <img src="assets/images/faces/8.jpg" alt="">
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 d-flex  justify-content-between">
                                                <div>
                                                    <p class="mb-0 fw-semibold"><a href="notifications.html">Elizabeth Lewis</a></p>
                                                    <span class="fs-12 text-muted fw-normal">added new schedule realease date</span>
                                                </div>
                                                <div class="min-w-fit-content ms-2 text-end">
                                                    <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-14"></i></a>
                                                    <p class="mb-0 text-muted fs-11">10 min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-start">
                                            <div class="pe-2">
                                                <span class="avatar avatar-md bg-primary-transparent rounded-2"><i class="bx bx-pulse fs-18"></i></span>
                                            </div>
                                            <div class="flex-grow-1 d-flex  justify-content-between">
                                                <div>
                                                    <p class="mb-0 fw-semibold"><a href="notifications.html">Your Order Has Been Shipped</a></p>
                                                    <span class="fs-12 text-muted fw-normal header-notification-text">Order No: 123456 Has Shipped To Your Delivery Address</span>
                                                </div>
                                                <div class="min-w-fit-content ms-2 text-end">
                                                    <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-14"></i></a>
                                                    <p class="mb-0 text-muted fs-11">12 min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-start">
                                            <div class="pe-2">
                                                <span class="avatar avatar-md bg-pink-transparent rounded-2"><i class="bx bx-badge-check"></i></span>
                                            </div>
                                            <div class="flex-grow-1 d-flex  justify-content-between">
                                                <div>
                                                    <p class="mb-0 fw-semibold"><a href="notifications.html">Account Has Been Verified</a></p>
                                                    <span class="fs-12 text-muted fw-normal  header-notification-text">Your Account Has Been Verified Sucessfully</span>
                                                </div>
                                                <div class="min-w-fit-content ms-2 text-end">
                                                    <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit-content text-muted me-1 dropdown-item-close1"><i class="ti ti-x fs-14"></i></a>
                                                    <p class="mb-0 text-muted fs-11">20 min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="p-3 empty-header-item1 border-top">
                                    <div class="d-grid">
                                        <a href="notifications.html" class="btn btn-primary">View All</a>
                                    </div>
                                </div>
                                <div class="p-5 empty-item1 d-none">
                                    <div class="text-center">
                                        <span class="avatar avatar-xl avatar-rounded bg-secondary-transparent">
                                            <i class="bx bx-bell-off bx-tada fs-2"></i>
                                        </span>
                                        <h6 class="fw-semibold mt-3">No New Notifications</h6>
                                    </div>
                                </div>
                            </div>
                            <!-- End::main-header-dropdown -->
                        </div>
                        <!-- End::header-element -->
                        <div class="d-flex header-settings header-shortcuts-dropdown">
                            <a aria-label="anchor" href="javascript:void(0);" class=" header-link nav-link icon" data-bs-toggle="offcanvas" data-bs-target="#apps" aria-controls="apps">
                            <i class="bx bx-category  header-link-icon"></i>
                            </a>
                        </div>

                        <div class="offcanvas offcanvas-end wd-330" tabindex="-1" id="apps" aria-labelledby="appsLabel">
                        <div class="offcanvas-header border-bottom">
                            <h5 id="appsLabel" class="mb-0 fs-18">Related Apps</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"> <i class="bx bx-x   apps-btn-close"></i></button>
                        </div>
                        <div class="p-3">
                            <div class="row g-3">
                                <div class="col-6">
                                        <a href="full-calendar.html">
                                            <div class="text-center p-3 related-app border">
                                                <span class="avatar fs-23 bg-success-transparent p-2 mb-2">
                                                    <i class="bx bx-calendar text-success"></i>
                                                </span>
                                                <span class="d-block fs-13 text-muted fw-semibold">Calendar</span>
                                            </div>
                                        </a>
                                </div>
                                <div class="col-6">
                                        <a href="mail.html">
                                            <div class="text-center p-3 related-app border">
                                                <span class="avatar  fs-23 bg-info-transparent p-2 mb-2">
                                                    <i class="bx bx-envelope  text-info"></i>
                                                </span>
                                                <span class="d-block fs-13 text-muted fw-semibold">Mail</span>
                                            </div>
                                        </a>
                                </div>
                                <div class="col-6">
                                    <a href="profile.html">
                                            <div class="text-center p-3 related-app border">
                                                <span class="avatar bg-warning-transparent fs-23 bg p-2 mb-2">
                                                    <i class="bx bx-user  text-warning"></i>
                                                </span>
                                                <span class="d-block fs-13 text-muted fw-semibold">Profile</span>
                                            </div>
                                        </a>
                                </div>
                                <div class="col-6">
                                    <a href="chat.html">
                                            <div class="text-center p-3 related-app border">
                                                <span class="avatar    bg-pink-transparent fs-23 bg p-2 mb-2">
                                                    <i class="bx bx-chat text-pink"></i>
                                                </span>
                                                <span class="d-block fs-13 text-muted fw-semibold">Chat</span>
                                            </div>
                                        </a>
                                </div>
                                <div class="col-6">
                                    <a href="contacts.html">
                                            <div class="text-center p-3 related-app border">
                                                <span class="avatar    bg-secondary-transparent fs-23 bg p-2 mb-2">
                                                    <i class="bx bx-phone text-secondary"></i>
                                                </span>
                                                <span class="d-block fs-13 text-muted fw-semibold">Contacts</span>
                                            </div>
                                        </a>
                                </div>
                                <div class="col-6">
                                    <a href="mail-settings.html">
                                            <div class="text-center p-3 related-app border">
                                                <span class="avatar    bg-teal-transparent fs-23 bg p-2 mb-2">
                                                    <i class="bx bx-cog text-teal"></i>
                                                </span>
                                                <span class="d-block fs-13 text-muted fw-semibold">Settings</span>
                                            </div>
                                        </a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!-- Start::header-element -->

                        <!-- Start::header-element -->
                        <div class="header-element header-fullscreen">
                            <!-- Start::header-link -->
                            <a aria-label="anchor" onclick="openFullscreen();" href="javascript:void(0);" class="header-link">
                                    <i class="bx bx-fullscreen header-link-icon  full-screen-open"></i>
                                    <i class="bx bx-exit-fullscreen header-link-icon  full-screen-close  d-none"></i>
                            </a>
                            <!-- End::header-link -->
                        </div>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <div class="d-flex header-settings">
                            <a aria-label="anchor"  href="javascript:void(0);" class=" header-link nav-link icon me-1" data-bs-toggle="offcanvas" data-bs-target="#sidebar-right" aria-controls="sidebar-right">
                            <i class="bx bx-slider header-link-icon"></i>
                            </a>
                        </div>
                    <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <div class="header-element mainuserProfile">
                            <!-- Start::header-link|dropdown-toggle -->
                            <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="d-sm-flex wd-100p">
                                        <div class="avatar avatar-sm"><img alt="avatar" class="rounded-circle" src="assets/images/faces/1.jpg"></div>
                                        <div class="ms-2 my-auto d-none d-xl-flex">
                                            <h6 class=" font-weight-semibold mb-0 fs-13 user-name d-sm-block d-none">Harry Jones</h6>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <!-- End::header-link|dropdown-toggle -->
                            <ul class="dropdown-menu  border-0 main-header-dropdown  overflow-hidden header-profile-dropdown" aria-labelledby="mainHeaderProfile">
                                <li><a class="dropdown-item border-bottom" href="profile.html"><i class="fs-13 me-2 bx bx-user"></i>Profile</a></li>
                                <li><a class="dropdown-item border-bottom" href="mail.html"><i class="fs-13 me-2 bx bx-comment"></i>Message</a></li>
                                <li><a class="dropdown-item border-bottom" href="mail-settings.html"><i class="fs-13 me-2 bx bx-cog"></i>Settings</a></li>
                                <li><a class="dropdown-item border-bottom" href="faqs.html"><i class="fs-13 me-2 bx bx-help-circle"></i>Help</a></li>
                                <li><a class="dropdown-item" href="signin-cover.html"><i class="fs-13 me-2 bx bx-arrow-to-right"></i>Log Out</a></li>
                            </ul>
                        </div>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <div class="header-element">
                            <!-- Start::header-link|switcher-icon -->
                            <a aria-label="anchor" href="javascript:void(0);" class="header-link switcher-icon ms-1" data-bs-toggle="offcanvas" data-bs-target="#switcher-canvas">
                                <i class="bx bx-cog bx-spin header-link-icon"></i>
                            </a>
                            <!-- End::header-link|switcher-icon -->
                        </div>
                        <!-- End::header-element -->

                    </div>
                    <!-- End::header-content-right -->

                </div>
                <!-- End::main-header-container -->

            </header>
            <!-- END HEADER -->

            <!-- SIDEBAR -->
            
            <aside class="app-sidebar" id="sidebar">

                <!-- Start::main-sidebar-header -->
                <div class="main-sidebar-header">
                    <a href="index.html" class="header-logo">
                        <img src="assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
                        <img src="assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
                        <img src="assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark">
                        <img src="assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
                    </a>
                </div>
                <!-- End::main-sidebar-header -->

                <!-- Start::main-sidebar -->
                <div class="main-sidebar" id="sidebar-scroll">

                    <!-- Start::nav -->
                    <nav class="main-menu-container nav nav-pills flex-column sub-open">
                        <div class="slide-left" id="slide-left">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
                        </div>
                        <ul class="main-menu">
                            <!-- Start::slide__category -->
                            <li class="slide__category"><span class="category-name">Main</span></li>
                            <!-- End::slide__category -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <span class=" side-menu__icon">
                                        <i class='bx bx-desktop'></i>
                                    </span>
                                    <span class="side-menu__label">Dashboards<span class="badge bg-warning-transparent ms-2">12</span></span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Dashboards</a>
                                    </li>
                                    <li class="slide">
                                        <a href="index.html" class="side-menu__item">Sales</a>
                                    </li>
                                    <li class="slide">
                                        <a href="index2.html" class="side-menu__item">Crypto</a>
                                    </li>
                                    <li class="slide">
                                        <a href="index3.html" class="side-menu__item">Jobs</a>
                                    </li>
                                    <li class="slide">
                                        <a href="index4.html" class="side-menu__item">CRM</a>
                                    </li>
                                    <li class="slide">
                                        <a href="index5.html" class="side-menu__item">Ecommerce</a>
                                    </li>
                                    <li class="slide">
                                        <a href="index6.html" class="side-menu__item">Analytics</a>
                                    </li>
                                    <li class="slide">
                                        <a href="index7.html" class="side-menu__item">Projects</a>
                                    </li>
                                    <li class="slide">
                                        <a href="index8.html" class="side-menu__item">NFT</a>
                                    </li>
                                    <li class="slide">
                                        <a href="index9.html" class="side-menu__item">HRM</a>
                                    </li>
                                    <li class="slide">
                                        <a href="index10.html" class="side-menu__item">Personal</a>
                                    </li>
                                    <li class="slide">
                                        <a href="index11.html" class="side-menu__item">Stocks</a>
                                    </li>
                                    <li class="slide">
                                        <a href="index12.html" class="side-menu__item">Course</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- End::slide -->

                            <!-- Start::slide__category -->
                            <li class="slide__category"><span class="category-name">General</span></li>
                            <!-- End::slide__category -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <span class=" side-menu__icon">
                                        <i class='bx bx-cube'></i>
                                    </span>
                                    <span class="side-menu__label">Advanced Ui</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Advanced Ui</a>
                                    </li>
                                    <li class="slide">
                                        <a href="accordions-collpase.html" class="side-menu__item">Accordions & Collapse</a>
                                    </li>
                                    <li class="slide">
                                        <a href="carousel.html" class="side-menu__item">Carousel</a>
                                    </li>
                                    <li class="slide">
                                        <a href="draggable-cards.html" class="side-menu__item">Draggable Cards</a>
                                    </li>
                                    <li class="slide">
                                        <a href="modals-closes.html" class="side-menu__item">Modals & Closes</a>
                                    </li>
                                    <li class="slide">
                                        <a href="navbars.html" class="side-menu__item">Navbars</a>
                                    </li>
                                    <li class="slide">
                                        <a href="offcanvas.html" class="side-menu__item">Offcanvas</a>
                                    </li>
                                    <li class="slide">
                                        <a href="placeholders.html" class="side-menu__item">Placeholders</a>
                                    </li>
                                    <li class="slide">
                                        <a href="ratings.html" class="side-menu__item">Ratings</a>
                                    </li>
                                    <li class="slide">
                                        <a href="scrollspy.html" class="side-menu__item">Scrollspy</a>
                                    </li>
                                    <li class="slide">
                                        <a href="swiperjs.html" class="side-menu__item">Swiper JS</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide__category -->
                            <li class="slide__category"><span class="category-name">Pages</span></li>
                            <!-- End::slide__category -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <span class=" side-menu__icon">
                                        <i class='bx bx-food-menu' ></i>
                                    </span> 
                                    <span class="side-menu__label">Pages</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Pages</a>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Blog
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="blog.html" class="side-menu__item">Blog</a>
                                            </li>
                                            <li class="slide">
                                                <a href="blog-details.html" class="side-menu__item">Blog Details</a>
                                            </li>
                                            <li class="slide">
                                                <a href="blog-create.html" class="side-menu__item">Create Blog</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="slide">
                                        <a href="chat.html" class="side-menu__item">Chat</a>
                                    </li>
                                    <li class="slide">
                                        <a href="contacts.html" class="side-menu__item">Contacts</a>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Ecommerce
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="add-products.html" class="side-menu__item">Add Products</a>
                                            </li>
                                            <li class="slide">
                                                <a href="cart.html" class="side-menu__item">Cart</a>
                                            </li>
                                            <li class="slide">
                                                <a href="checkout.html" class="side-menu__item">Checkout</a>
                                            </li>
                                            <li class="slide">
                                                <a href="edit-products.html" class="side-menu__item">Edit Products</a>
                                            </li>
                                            <li class="slide">
                                                <a href="orders.html" class="side-menu__item">Orders</a>
                                            </li>
                                            <li class="slide">
                                                <a href="order-details.html" class="side-menu__item">Order Details</a>
                                            </li>
                                            <li class="slide">
                                                <a href="products.html" class="side-menu__item">Products</a>
                                            </li>
                                            <li class="slide">
                                                <a href="product-details.html" class="side-menu__item">Product Details</a>
                                            </li>
                                            <li class="slide">
                                                <a href="products-list.html" class="side-menu__item">Products List</a>
                                            </li>
                                            <li class="slide">
                                                <a href="wishlist.html" class="side-menu__item">Wishlist</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Email
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="mail.html" class="side-menu__item">Mail App</a>
                                            </li>
                                            <li class="slide">
                                                <a href="mail-chat.html" class="side-menu__item">Mail Chat</a>
                                            </li>
                                            <li class="slide">
                                                <a href="mail-settings.html" class="side-menu__item">Mail Settings</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="slide">
                                        <a href="empty-page.html" class="side-menu__item">Empty</a>
                                    </li>
                                    <li class="slide">
                                        <a href="faqs.html" class="side-menu__item">FAQ's</a>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">File Manager
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="file-manager.html" class="side-menu__item">File Manager</a>
                                            </li>
                                            <li class="slide">
                                                <a href="file-details.html" class="side-menu__item">File Details</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Invoice
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="invoice-create.html" class="side-menu__item">Create Invoice</a>
                                            </li>
                                            <li class="slide">
                                                <a href="invoice-details.html" class="side-menu__item">Invoice Details</a>
                                            </li>
                                            <li class="slide">
                                                <a href="invoice-list.html" class="side-menu__item">Invoice List</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Timeline
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="timeline.html" class="side-menu__item">Timeline 1</a>
                                            </li>
                                            <li class="slide">
                                                <a href="timeline2.html" class="side-menu__item">Timeline 2</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="slide">
                                        <a href="landing.html" class="side-menu__item">Landing</a>
                                    </li>
                                    <li class="slide">
                                        <a href="notifications.html" class="side-menu__item">Notifications</a>
                                    </li>
                                    <li class="slide">
                                        <a href="pricing.html" class="side-menu__item">Pricing</a>
                                    </li>
                                    <li class="slide">
                                        <a href="profile.html" class="side-menu__item">Profile</a>
                                    </li>
                                    <li class="slide">
                                        <a href="reviews.html" class="side-menu__item">Reviews</a>
                                    </li>
                                    <li class="slide">
                                        <a href="teams.html" class="side-menu__item">Teams</a>
                                    </li>
                                    <li class="slide">
                                        <a href="terms-conditions.html" class="side-menu__item">Terms & Conditions</a>
                                    </li>
                                    <li class="slide">
                                        <a href="todo-list.php" class="side-menu__item">To Do List</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <span class=" side-menu__icon">
                                        <i class='bx bx-magnet' ></i>
                                    </span> 
                                <span class="side-menu__label">Utilities</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Utilities</a>
                                    </li>
                                    <li class="slide">
                                        <a href="avatars.php" class="side-menu__item">Avatars</a>
                                    </li>
                                    <li class="slide">
                                        <a href="borders.php" class="side-menu__item">Borders</a>
                                    </li>
                                    <li class="slide">
                                        <a href="breakpoints.php" class="side-menu__item">Breakpoints</a>
                                    </li>
                                    <li class="slide">
                                        <a href="colors.php" class="side-menu__item">Colors</a>
                                    </li>
                                    <li class="slide">
                                        <a href="columns.php" class="side-menu__item">Columns</a>
                                    </li>
                                    <li class="slide">
                                        <a href="flex.php" class="side-menu__item">Flex</a>
                                    </li>
                                    <li class="slide">
                                        <a href="gutters.php" class="side-menu__item">Gutters</a>
                                    </li>
                                    <li class="slide">
                                        <a href="helpers.php" class="side-menu__item">Helpers</a>
                                    </li>
                                    <li class="slide">
                                        <a href="positions.php" class="side-menu__item">Positions</a>
                                    </li>
                                    <li class="slide">
                                        <a href="more.php" class="side-menu__item">Additional Content</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <span class=" side-menu__icon">
                                        <i class='bx bx-lock-alt' ></i>
                                    </span> 
                                    <span class="side-menu__label">Authentication</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Authentication</a>
                                    </li>
                                    <li class="slide">
                                        <a href="coming-soon.php" class="side-menu__item">Coming Soon</a>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Create Password
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="create-password-basic.php" class="side-menu__item">Basic</a>
                                            </li>
                                            <li class="slide">
                                                <a href="create-password-cover.php" class="side-menu__item">Cover</a>
                                            </li>
                                            <li class="slide">
                                                <a href="create-password-cover2.php" class="side-menu__item">Cover2</a>
                                            </li>
                                        </ul>
                                    </li>      
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Lock Screen
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="lockscreen-basic.php" class="side-menu__item">Basic</a>
                                            </li>
                                            <li class="slide">
                                                <a href="lockscreen-cover.php" class="side-menu__item">Cover</a>
                                            </li>
                                            <li class="slide">
                                                <a href="lockscreen-cover2.php" class="side-menu__item">Cover2</a>
                                            </li>
                                        </ul>
                                    </li>     
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Reset Password
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="reset-password-basic.php" class="side-menu__item">Basic</a>
                                            </li>
                                            <li class="slide">
                                                <a href="reset-password-cover.php" class="side-menu__item">Cover</a>
                                            </li>
                                            <li class="slide">
                                                <a href="reset-password-cover2.php" class="side-menu__item">Cover2</a>
                                            </li>
                                        </ul>
                                    </li>     
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Sign Up
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="signup-basic.php" class="side-menu__item">Basic</a>
                                            </li>
                                            <li class="slide">
                                                <a href="signup-cover.php" class="side-menu__item">Cover</a>
                                            </li>
                                            <li class="slide">
                                                <a href="signup-cover2.php" class="side-menu__item">Cover2</a>
                                            </li>
                                        </ul>
                                    </li>  
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Sign In
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="signin-basic.php" class="side-menu__item">Basic</a>
                                            </li>
                                            <li class="slide">
                                                <a href="signin-cover.html" class="side-menu__item">Cover</a>
                                            </li>
                                            <li class="slide">
                                                <a href="signin-cover2.php" class="side-menu__item">Cover2</a>
                                            </li>
                                        </ul>
                                    </li> 
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Two Step Verification
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="twostep-verification-basic.php" class="side-menu__item">Basic</a>
                                            </li>
                                            <li class="slide">
                                                <a href="twostep-verification-cover.php" class="side-menu__item">Cover</a>
                                            </li>
                                            <li class="slide">
                                                <a href="twostep-verification-cover2.php" class="side-menu__item">Cover2</a>
                                            </li>
                                        </ul>
                                    </li> 
                                    <li class="slide">
                                        <a href="under-maintenance.php" class="side-menu__item">Under Maintenance</a>
                                    </li>
                                    <li class="slide">
                                        <a href="no-internet.php" class="side-menu__item">no-internet</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <span class=" side-menu__icon">
                                        <i class='bx bx-error-alt' ></i>
                                    </span> 
                                    <span class="side-menu__label">Error</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Error</a>
                                    </li>
                                    <li class="slide">
                                        <a href="error401.php" class="side-menu__item">401 - Error</a>
                                    </li>
                                    <li class="slide">
                                        <a href="error404.php" class="side-menu__item">404 - Error</a>
                                    </li>
                                    <li class="slide">
                                        <a href="error500.php" class="side-menu__item">500 - Error</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->
                    

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <span class=" side-menu__icon">
                                        <i class='bx bx-carousel' ></i>
                                    </span>
                                    <span class="side-menu__label">Apps</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Apps</a>
                                    </li>
                                    <li class="slide">
                                        <a href="full-calendar.html" class="side-menu__item">Full Calendar</a>
                                    </li>
                                    <li class="slide">
                                        <a href="gallery.php" class="side-menu__item">Gallery</a>
                                    </li>
                                    <li class="slide">
                                        <a href="sweet-alerts.php" class="side-menu__item">Sweet Alerts</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->
                    
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="icons.php" class="side-menu__item">
                                    <span class=" side-menu__icon">
                                        <i class='bx bx-smile' ></i>
                                    </span> 
                                    <span class="side-menu__label">Icons</span>
                                </a>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="widgets.php" class="side-menu__item">
                                    <span class=" side-menu__icon">
                                        <i class='bx bx-layout' ></i>
                                    </span> 
                                    <span class="side-menu__label">Widgets<span class="badge bg-danger-transparent ms-2">Hot</span></span>
                                </a>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide__category -->
                            <li class="slide__category"><span class="category-name">Web Apps</span></li>
                            <!-- End::slide__category -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <span class=" side-menu__icon">
                                        <i class='bx bx-underline' ></i>
                                    </span> 
                                    <span class="side-menu__label">Ui Elements</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1 mega-menu">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Ui Elements</a>
                                    </li>
                                    <li class="slide">
                                        <a href="alerts.php" class="side-menu__item">Alerts</a>
                                    </li>
                                    <li class="slide">
                                        <a href="badges.php" class="side-menu__item">Badges</a>
                                    </li>
                                    <li class="slide">
                                        <a href="breadcrumbs.php" class="side-menu__item">Breadcrumbs</a>
                                    </li>
                                    <li class="slide">
                                        <a href="buttons.html" class="side-menu__item">Buttons</a>
                                    </li>
                                    <li class="slide">
                                        <a href="buttongroups.php" class="side-menu__item">Button Groups</a>
                                    </li>
                                    <li class="slide">
                                        <a href="cards.php" class="side-menu__item">Cards</a>
                                    </li>
                                    <li class="slide">
                                        <a href="dropdowns.php" class="side-menu__item">Dropdowns</a>
                                    </li>
                                    <li class="slide">
                                        <a href="images-figures.php" class="side-menu__item">Images & Figures</a>
                                    </li>
                                    <li class="slide">
                                        <a href="listgroups.php" class="side-menu__item">List Groups</a>
                                    </li>
                                    <li class="slide">
                                        <a href="navs-tabs.php" class="side-menu__item">Navs & Tabs</a>
                                    </li>
                                    <li class="slide">
                                        <a href="object-fit.php" class="side-menu__item">Object Fit</a>
                                    </li>
                                    <li class="slide">
                                        <a href="paginations.php" class="side-menu__item">Paginations</a>
                                    </li>
                                    <li class="slide">
                                        <a href="popovers.php" class="side-menu__item">Popovers</a>
                                    </li>
                                    <li class="slide">
                                        <a href="progress.php" class="side-menu__item">Progress</a>
                                    </li>
                                    <li class="slide">
                                        <a href="spinners.php" class="side-menu__item">Spinners</a>
                                    </li>
                                    <li class="slide">
                                        <a href="toasts.php" class="side-menu__item">Toasts</a>
                                    </li>
                                    <li class="slide">
                                        <a href="tooltips.php" class="side-menu__item">Tooltips</a>
                                    </li>
                                    <li class="slide">
                                        <a href="typography.php" class="side-menu__item">Typography</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <span class=" side-menu__icon">
                                        <i class='bx bx-menu' ></i>
                                    </span> 
                                    <span class="side-menu__label">Nested Menu</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Nested Menu</a>
                                    </li>
                                    <li class="slide">
                                        <a href="javascript:void(0);" class="side-menu__item">Nested-1</a>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Nested-2
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="javascript:void(0);" class="side-menu__item">Nested-2-1</a>
                                            </li>
                                            <li class="slide has-sub">
                                                <a href="javascript:void(0);" class="side-menu__item">Nested-2-2
                                                    <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                                <ul class="slide-menu child3">
                                                    <li class="slide">
                                                        <a href="javascript:void(0);" class="side-menu__item">Nested-2-2-1</a>
                                                    </li>
                                                    <li class="slide">
                                                        <a href="javascript:void(0);" class="side-menu__item">Nested-2-2-2</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide__category -->
                            <li class="slide__category"><span class="category-name">Maps & Charts</span></li>
                            <!-- End::slide__category -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <span class=" side-menu__icon">
                                        <i class='bx bx-map-pin' ></i>
                                    </span> 
                                    <span class="side-menu__label">Maps</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Maps</a>
                                    </li>
                                    <li class="slide">
                                        <a href="google-maps.php" class="side-menu__item">Google Maps</a>
                                    </li>
                                    <li class="slide">
                                        <a href="leaflet-maps.php" class="side-menu__item">Leaflet Maps</a>
                                    </li>
                                    <li class="slide">
                                        <a href="vector-maps.php" class="side-menu__item">Vector Maps</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <span class=" side-menu__icon">
                                        <i class='bx bx-scatter-chart' ></i>
                                    </span> 
                                    <span class="side-menu__label">Charts</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Charts</a>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Apex Charts
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="apex-line-charts.php" class="side-menu__item">Line Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apex-area-charts.php" class="side-menu__item">Area Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apex-column-charts.php" class="side-menu__item">Column Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apex-bar-charts.php" class="side-menu__item">Bar Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apex-mixed-charts.php" class="side-menu__item">Mixed Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apex-rangearea-charts.php" class="side-menu__item">Range Area Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apex-timeline-charts.html" class="side-menu__item">Timeline Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apex-candlestick-charts.html" class="side-menu__item">CandleStick
                                                    Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apex-boxplot-charts.html" class="side-menu__item">Boxplot Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apex-bubble-charts.html" class="side-menu__item">Bubble Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apex-scatter-charts.html" class="side-menu__item">Scatter Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apex-heatmap-charts.html" class="side-menu__item">Heatmap Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apex-treemap-charts.html" class="side-menu__item">Treemap Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apex-pie-charts.html" class="side-menu__item">Pie Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apex-radialbar-charts.html" class="side-menu__item">Radialbar Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apex-radar-charts.html" class="side-menu__item">Radar Charts</a>
                                            </li>
                                            <li class="slide">
                                                <a href="apex-polararea-charts.html" class="side-menu__item">Polararea Charts</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="slide">
                                        <a href="chartjs-charts.html" class="side-menu__item">Chartjs Charts</a>
                                    </li>
                                    <li class="slide">
                                        <a href="echarts.html" class="side-menu__item">Echart Charts</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide__category -->
                            <li class="slide__category"><span class="category-name">Forms & Tables </span></li>
                            <!-- End::slide__category -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <span class=" side-menu__icon">
                                        <i class='bx bx-file' ></i>
                                    </span> 
                                    <span class="side-menu__label">Forms</span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Forms</a>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Form Elements
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="form-inputs.html" class="side-menu__item">Inputs</a>
                                            </li>
                                            <li class="slide">
                                                <a href="form-check-radios.html" class="side-menu__item">Checks & Radios</a>
                                            </li>
                                            <li class="slide">
                                                <a href="form-input-group.html" class="side-menu__item">Input Group</a>
                                            </li>
                                            <li class="slide">
                                                <a href="form-select.html" class="side-menu__item">Form Select</a>
                                            </li>
                                            <li class="slide">
                                                <a href="form-range.html" class="side-menu__item">Range Slider</a>
                                            </li>
                                            <li class="slide">
                                                <a href="form-input-masks.html" class="side-menu__item">Input Masks</a>
                                            </li>
                                            <li class="slide">
                                                <a href="form-file-uploads.html" class="side-menu__item">File Uploads</a>
                                            </li>
                                            <li class="slide">
                                                <a href="form-datetime-pickers.html" class="side-menu__item">Date & Time Pickers</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="slide">
                                        <a href="floating-labels.html" class="side-menu__item">Floating Labels</a>
                                    </li>
                                    <li class="slide">
                                        <a href="form-layouts.html" class="side-menu__item">Form Layouts</a>
                                    </li>
                                    <li class="slide has-sub">
                                        <a href="javascript:void(0);" class="side-menu__item">Form Editors
                                            <i class="fe fe-chevron-right side-menu__angle"></i></a>
                                        <ul class="slide-menu child2">
                                            <li class="slide">
                                                <a href="quill-editor.html" class="side-menu__item">Quill Editor</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="slide">
                                        <a href="form-validations.html" class="side-menu__item">Validations</a>
                                    </li>
                                    <li class="slide">
                                        <a href="form-select2.html" class="side-menu__item">Select2</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->

                            <!-- Start::slide -->
                            <li class="slide has-sub">
                                <a href="javascript:void(0);" class="side-menu__item">
                                    <span class=" side-menu__icon">
                                        <i class='bx bx-table' ></i>
                                    </span> 
                                    <span class="side-menu__label">Tables<span class="badge bg-success-transparent ms-2">3</span></span>
                                    <i class="fe fe-chevron-right side-menu__angle"></i>
                                </a>
                                <ul class="slide-menu child1">
                                    <li class="slide side-menu__label1">
                                        <a href="javascript:void(0)">Tables</a>
                                    </li>
                                    <li class="slide">
                                        <a href="tables.html" class="side-menu__item">Tables</a>
                                    </li>
                                    <li class="slide">
                                        <a href="grid-tables.html" class="side-menu__item">Grid JS Tables</a>
                                    </li>
                                    <li class="slide">
                                        <a href="data-tables.html" class="side-menu__item">Data Tables</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- End::slide -->
                        </ul>
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
                    </nav>
                    <!-- End::nav -->

                </div>
                <!-- End::main-sidebar -->

            </aside>
            <!-- END SIDEBAR -->

            <!-- MAIN-CONTENT -->

                
                    <!-- PAGE HEADER -->
                    <div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                        <h4 class="fw-medium mb-0">Widgets</h4>
                        <div class="ms-sm-1 ms-0">
                            <nav>
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Widgets</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Widgets</li>
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
                                <div class="col-xxl-12">
                                    <div class="card custom-card">
                                        <div class="card-body p-0">
                                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                <div class="d-flex flex-1 p-4 tx-white pos-relative">
                                                    <a aria-label="anchor" href="javascript:void(0);" class="masked-link"></a>
                                                    <div class="me-3 mt-1">
                                                        <div class="avatar avatar-lg bg-secondary-transparent radius-5"><i class="ti ti-package fs-20"></i></div>
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="mb-0 text-muted">Total Products</p>
                                                        <span class="text-xl fw-semibold">45,280</span>
                                                        <span class="ms-4 fs-13  text-secondary"><i class="fe fe-arrow-up-right fs-12"></i>1.31%</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-1 p-4 tx-white pos-relative">
                                                    <a aria-label="anchor" href="javascript:void(0);" class="masked-link"></a>
                                                    <div class="me-3 mt-1">
                                                        <div class="avatar avatar-lg bg-pink-transparent radius-5"><i class="ti ti-packge-import fs-20"></i></div>
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="mb-0 text-muted">Total Orders</p>
                                                        <span class="text-xl fw-semibold">12,088</span>
                                                        <span class="ms-4 fs-13  text-pink"><i class="fe fe-arrow-up-right fs-12"></i>12.05%</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-1 p-4 tx-white pos-relative">
                                                    <a aria-label="anchor" href="javascript:void(0);" class="masked-link"></a>
                                                    <div class="me-3 mt-1">
                                                        <div class="avatar avatar-lg bg-info-transparent radius-5"><i class="ti ti-rocket fs-20"></i></div>
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="mb-0 text-muted">Total Sales</p>
                                                        <span class="text-xl fw-semibold">10,500</span>
                                                        <span class="ms-4 fs-13  text-info"><i class="fe fe-arrow-down-right fs-12"></i>1.14%</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-1 p-4 tx-white pos-relative">
                                                    <a aria-label="anchor" href="javascript:void(0);" class="masked-link"></a>
                                                    <div class="me-3 mt-1">
                                                        <div class="avatar avatar-lg bg-orange-transparent radius-5"><i class="ti ti-wallet fs-20"></i></div>
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="mb-0 text-muted">Income</p>
                                                        <span class="text-xl fw-semibold">$69,270</span>
                                                        <span class="ms-4 fs-13 text-orange"><i class="fe fe-arrow-up-right fs-12 "></i>2.58%</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-1 p-4 tx-white pos-relative">
                                                    <a aria-label="anchor" href="javascript:void(0);" class="masked-link"></a>
                                                    <div class="me-3 mt-1">
                                                        <div class="avatar avatar-lg bg-success-transparent radius-5"><i class="ti ti-coin fs-20"></i></div>
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="mb-0 text-muted">Expenses</p>
                                                        <span class="text-xl fw-semibold">$21,520</span>
                                                        <span class="ms-4 fs-13  text-success"><i class="fe fe-arrow-down-right fs-12"></i>14.69%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-sm-6">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="flex-1 border-bottom-dashed">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span class="mb-0 flex-1 text-muted fw-semibold">Total Projects</span>
                                                    <div class="ms-2">
                                                        <span class="avatar bg-info-transparent text-info"><i class="bx bxs-briefcase fs-20"></i></span>
                                                    </div>
                                                </div>
                                                <h4 class="mb-0">676,90</h4>
                                                <div class="flex-between">
                                                    <span class="text-muted fs-12">6 min ago</span>
                                                    <span class="text-info fw-semibold"><i class="bi bi-arrow-down-right me-1 fs-13"></i>105.05%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-sm-6">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="flex-1 border-bottom-dashed">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span class="mb-0 flex-1 text-muted fw-semibold">Pending Projects</span>
                                                    <div class="ms-2">
                                                        <span class="avatar bg-pink-transparent text-pink"><i class="bx bxs-book-open fs-20"></i></span>
                                                    </div>
                                                </div>
                                                <h4 class="mb-0">406,90</h4>
                                                <div class="flex-between">
                                                    <span class="text-muted fs-12">30 min ago</span>
                                                    <span class="text-pink fw-semibold"><i class="bi bi-arrow-up-right me-1 fs-13"></i>095.05%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-sm-6">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="flex-1 border-bottom-dashed">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span class="mb-0 flex-1 text-muted fw-semibold">New Projects</span>
                                                    <div class="ms-2">
                                                        <span class="avatar bg-warning-transparent text-warning"><i class="bx bxs-folder-plus fs-20"></i></span>
                                                    </div>
                                                </div>
                                                <h4 class="mb-0">716,80</h4>
                                                <div class="flex-between">
                                                    <span class="text-muted fs-12">1 hr ago</span>
                                                    <span class="text-warning fw-semibold"><i class="bi bi-arrow-up-right me-1 fs-13"></i>006.43%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-sm-6">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="flex-1 border-bottom-dashed">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span class="mb-0 flex-1 text-muted fw-semibold">Completed Projects</span>
                                                    <div class="ms-2">
                                                        <span class="avatar bg-teal-transparent text-teal"><i class="bx bxs-compass fs-20"></i></span>
                                                    </div>
                                                </div>
                                                <h4 class="mb-0">536,80</h4>
                                                <div class="flex-between">
                                                    <span class="text-muted fs-12">30 min ago</span>
                                                    <span class="text-teal fw-semibold"><i class="bi bi-arrow-down-right me-1 fs-13"></i>396.03%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End::row-1 -->

                            <!-- Start::row-2 -->

                            <div class="row row-cols-12">
                                <div class="col-xxl-2 col-xl-4 col-md-4 col-sm-6">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="flex-between mb-3">
                                                <span class="text-muted">Total Applicants</span>
                                                <a aria-label="anchor" href="javascript:void(0);" class="btn btn-outline-light btn-icons btn-sm text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Action</a></li>
                                                    <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Another Action</a></li>
                                                    <li><a href="javascript:void(0);" class="dropdown-item">Something Else Here</a></li>
                                                </ul>
                                            </div>
                                            <div class="d-flex align-items-end">
                                                <div class="flex-1">
                                                    <h3 class="mb-2">1,123</h3>
                                                    <span class="badge bg-primary-transparent rounded-1">+1.26%</span>
                                                </div>
                                                <span class="ms-2 avatar bg-primary-transparent">
                                                    <i class="bi bi-people fs-18"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-xl-4 col-md-4 col-sm-6">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="flex-between mb-3">
                                                <span class="text-muted">Total Shortlisted</span>
                                                <a aria-label="anchor" href="javascript:void(0);" class="btn btn-outline-light btn-icons btn-sm text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Action</a></li>
                                                    <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Another Action</a></li>
                                                    <li><a href="javascript:void(0);" class="dropdown-item">Something Else Here</a></li>
                                                </ul>
                                            </div>
                                            <div class="d-flex align-items-end">
                                                <div class="flex-1">
                                                    <h3 class="mb-2">7,123</h3>
                                                    <span class="badge bg-pink-transparent rounded-1">+4.26%</span>
                                                </div>
                                                <span class="ms-2 avatar bg-pink-transparent">
                                                    <i class="bi bi-person-dash fs-18"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-xl-4 col-md-4 col-sm-6">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="flex-between mb-3">
                                                <span class="text-muted">Hired Candidates</span>
                                                <a aria-label="anchor" href="javascript:void(0);" class="btn btn-outline-light btn-icons btn-sm text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Action</a></li>
                                                    <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Another Action</a></li>
                                                    <li><a href="javascript:void(0);" class="dropdown-item">Something Else Here</a></li>
                                                </ul>
                                            </div>
                                            <div class="d-flex align-items-end">
                                                <div class="flex-1">
                                                    <h3 class="mb-2">8,123</h3>
                                                    <span class="badge bg-info-transparent rounded-1">+6.26%</span>
                                                </div>
                                                <span class="ms-2 avatar bg-info-transparent">
                                                    <i class="bi bi-person-check fs-18"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-xl-4 col-md-4 col-sm-6">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="flex-between mb-3">
                                                <span class="text-muted">Rejected Applicants</span>
                                                <a aria-label="anchor" href="javascript:void(0);" class="btn btn-outline-light btn-icons btn-sm text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Action</a></li>
                                                    <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Another Action</a></li>
                                                    <li><a href="javascript:void(0);" class="dropdown-item">Something Else Here</a></li>
                                                </ul>
                                            </div>
                                            <div class="d-flex align-items-end">
                                                <div class="flex-1">
                                                    <h3 class="mb-2">8,123</h3>
                                                    <span class="badge bg-danger-transparent rounded-1">9.26%</span>
                                                </div>
                                                <span class="ms-2 avatar bg-danger-transparent">
                                                    <i class="bi bi-person-x fs-18"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-xl-4 col-md-4 col-sm-6">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="flex-between mb-3">
                                                <span class="text-muted">Total Locations</span>
                                                <a aria-label="anchor" href="javascript:void(0);" class="btn btn-outline-light btn-icons btn-sm text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Action</a></li>
                                                    <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Another Action</a></li>
                                                    <li><a href="javascript:void(0);" class="dropdown-item">Something Else Here</a></li>
                                                </ul>
                                            </div>
                                            <div class="d-flex align-items-end">
                                                <div class="flex-1">
                                                    <h3 class="mb-2">5,123</h3>
                                                    <span class="badge bg-warning-transparent rounded-1">886</span>
                                                </div>
                                                <span class="ms-2 avatar bg-warning-transparent">
                                                    <i class="bi bi-globe fs-18"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-xl-4 col-md-4 col-sm-6">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="flex-between mb-3">
                                                <span class="text-muted">Ressume Upload</span>
                                                <a aria-label="anchor" href="javascript:void(0);" class="btn btn-outline-light btn-icons btn-sm text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Action</a></li>
                                                    <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Another Action</a></li>
                                                    <li><a href="javascript:void(0);" class="dropdown-item">Something Else Here</a></li>
                                                </ul>
                                            </div>
                                            <div class="d-flex align-items-end">
                                                <div class="flex-1">
                                                    <h3 class="mb-2">5,123</h3>
                                                    <span class="badge bg-teal-transparent rounded-1">9,686</span>
                                                </div>
                                                <span class="ms-2 avatar bg-teal-transparent">
                                                    <i class="bi bi-receipt fs-18"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End::row-2 -->

                            <!-- Start::row-3 -->
                            <div class="row">
                                <div class="col-xxl-3 col-sm-6">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-top justify-content-between mb-4">
                                                <div class="flex-fill d-flex align-items-top">
                                                    <div class="me-2">
                                                        <span class="avatar avatar-md text-primary border bg-light"><i class="ti ti-users fs-18"></i></span>
                                                    </div>
                                                    <div class="flex-fill">
                                                        <p class="fw-semibold fs-14 mb-0">Total Candidates</p>
                                                        <p class="mb-0 text-muted fs-12 op-7">Magna sit elitr kasd consetetur.</p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a aria-label="anchor" href="javascript:void(0);" data-bs-toggle="dropdown" class="btn btn-icon btn-sm btn-light"><i class="ti ti-dots"></i></a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Action</a></li>
                                                        <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Another Action</a></li>
                                                        <li><a href="javascript:void(0);" class="dropdown-item">Something Else Here</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-0">
                                                <p class="mb-0 fs-20 fw-semibold">2,460</p>
                                                <span class="text-muted ms-2"><i class="ti ti-trending-up align-middle text-success me-1 d-inline-flex"></i>2.5%</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-fill">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 14%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="ms-3">
                                                    <span class="fs-12 text-muted">14% Target</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-sm-6">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-top justify-content-between mb-4">
                                                <div class="flex-fill d-flex align-items-top">
                                                    <div class="me-2">
                                                        <span class="avatar avatar-md text-secondary border bg-light"><i class="ti ti-user-circle fs-18"></i></span>
                                                    </div>
                                                    <div class="flex-fill">
                                                        <p class="fw-semibold fs-14 mb-0">Recruiters</p>
                                                        <p class="mb-0 text-muted fs-12 op-7">Elitr at gubergren sit sed.</p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a aria-label="anchor" href="javascript:void(0);" data-bs-toggle="dropdown" class="btn btn-icon btn-sm btn-light"><i class="ti ti-dots"></i></a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Action</a></li>
                                                        <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Another Action</a></li>
                                                        <li><a href="javascript:void(0);" class="dropdown-item">Something Else Here</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-0">
                                                <p class="mb-0 fs-20 fw-semibold">7,539</p>
                                                <span class="text-muted ms-2"><i class="ti ti-trending-up align-middle text-success me-1 d-inline-flex"></i>3.1%</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-fill">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="ms-3">
                                                    <span class="fs-12 text-muted">55% Target</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-sm-6">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-top justify-content-between mb-4">
                                                <div class="flex-fill d-flex align-items-top">
                                                    <div class="me-2">
                                                        <span class="avatar avatar-md text-success border bg-light"><i class="ti ti-view-360 fs-18"></i></span>
                                                    </div>
                                                    <div class="flex-fill">
                                                        <p class="fw-semibold fs-14 mb-0">Page Views</p>
                                                        <p class="mb-0 text-muted fs-12 op-7">Sed duo ut sanctus gubergren.</p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a aria-label="anchor" href="javascript:void(0);" data-bs-toggle="dropdown" class="btn btn-icon btn-sm btn-light"><i class="ti ti-dots"></i></a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Action</a></li>
                                                        <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Another Action</a></li>
                                                        <li><a href="javascript:void(0);" class="dropdown-item">Something Else Here</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-0">
                                                <p class="mb-0 fs-20 fw-semibold">13,693</p>
                                                <span class="text-muted ms-2"><i class="ti ti-trending-up align-middle text-success me-1 d-inline-flex"></i>5.4%</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-fill">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 24%" aria-valuenow="24" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="ms-3">
                                                    <span class="fs-12 text-muted">24% Target</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-sm-6">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-top justify-content-between mb-4">
                                                <div class="flex-fill d-flex align-items-top">
                                                    <div class="me-2">
                                                        <span class="avatar avatar-md text-indigo border bg-light"><i class="ti ti-view-360 fs-18"></i></span>
                                                    </div>
                                                    <div class="flex-fill">
                                                        <p class="fw-semibold fs-14 mb-0">Total Subscriptions</p>
                                                        <p class="mb-0 text-muted fs-12 op-7">Invidunt magna voluptua.</p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a aria-label="anchor" href="javascript:void(0);" data-bs-toggle="dropdown" class="btn btn-icon btn-sm btn-light"><i class="ti ti-dots"></i></a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Action</a></li>
                                                        <li><a href="javascript:void(0);" class="dropdown-item border-bottom">Another Action</a></li>
                                                        <li><a href="javascript:void(0);" class="dropdown-item">Something Else Here</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-0">
                                                <p class="mb-0 fs-20 fw-semibold">1,116</p>
                                                <span class="text-muted ms-2"><i class="ti ti-trending-down align-middle text-danger me-1"></i>3.2%</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-fill">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-indigo" role="progressbar" style="width: 67%" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="ms-3">
                                                    <span class="fs-12 text-muted">67% Target</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End::row-3 -->

                            <!-- Start::row-4 -->
                            <div class="row">
                                <div class="col-xl-9">
                                    <div class="card custom-card">
                                        <div class="card-body p-0">
                                            <div class="row">
                                                <div class="col-xl-3 border-end border-inline-end-dashed">
                                                    <div class="d-flex flex-wrap align-items-top p-4">
                                                        <div class="me-3 lh-1">
                                                            <span class="avatar avatar-md avatar-rounded bg-primary shadow-sm">
                                                                <i class="ti ti-package fs-18"></i>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <h5 class="fw-semibold mb-1">45,280</h5>
                                                            <p class="text-muted mb-0 fs-12">Total Products</p>
                                                        </div>
                                                        <div>
                                                            <span class="badge bg-success-transparent"><i class="ri-arrow-up-s-line align-middle me-1"></i>1.31%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 border-end border-inline-end-dashed">
                                                    <div class="d-flex flex-wrap align-items-top p-4">
                                                        <div class="me-3 lh-1">
                                                            <span class="avatar avatar-md avatar-rounded bg-secondary shadow-sm">
                                                                <i class="ti ti-rocket fs-18"></i>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <h5 class="fw-semibold mb-1">10,500</h5>
                                                            <p class="text-muted mb-0 fs-12">Total Sales</p>
                                                        </div>
                                                        <div>
                                                            <span class="badge bg-danger-transparent"><i class="ri-arrow-down-s-line align-middle me-1"></i>1.14%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 border-end border-inline-end-dashed">
                                                    <div class="d-flex flex-wrap align-items-top p-4">
                                                        <div class="me-3 lh-1">
                                                            <span class="avatar avatar-md avatar-rounded bg-success shadow-sm">
                                                                <i class="ti ti-wallet fs-18"></i>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <h5 class="fw-semibold mb-1">$69,270</h5>
                                                            <p class="text-muted mb-0 fs-12">Income</p>
                                                        </div>
                                                        <div>
                                                            <span class="badge bg-success-transparent"><i class="ri-arrow-up-s-line align-middle me-1"></i>2.58%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="d-flex flex-wrap align-items-top p-4">
                                                        <div class="me-3 lh-1">
                                                            <span class="avatar avatar-md avatar-rounded bg-warning shadow-sm">
                                                                <i class="ti ti-packge-import fs-18"></i>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <h5 class="fw-semibold mb-1">12,088</h5>
                                                            <p class="text-muted mb-0 fs-12">Total Orders</p>
                                                        </div>
                                                        <div>
                                                            <span class="badge bg-success-transparent"><i class="ri-arrow-up-s-line align-middle me-1"></i>12.05%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="card custom-card card-bg-primary text-fixed-white">
                                        <div class="card-body p-0">
                                            <div class="d-flex align-items-top p-4 flex-wrap">
                                                <div class="me-3 lh-1">
                                                    <span class="avatar avatar-md avatar-rounded bg-white text-primary shadow-sm">
                                                        <i class="ti ti-coin fs-18"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-fill">
                                                    <h5 class="fw-semibold mb-1">$21,520</h5>
                                                    <p class="op-7 mb-0 fs-12">Expenses</p>
                                                </div>
                                                <div>
                                                    <span class="badge bg-success"><i class="ri-arrow-up-s-line align-middle me-1"></i>14.69%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End::row-4 -->

                            <!-- Start::row-5 -->

                            <div class="row">
                                <div class="col-xxl-6 col-xl-6 col-lg-12">
                                    <div class="row">
                                        <div class="col">
                                            <div class="card custom-card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-top">
                                                        <div class="me-3">
                                                            <span class="avatar avatar-md p-2 bg-primary-transparent">
                                                                <svg class="svg-primary" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
                                                                    <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                                    <path d="M12 5.9c1.16 0 2.1.94 2.1 2.1s-.94 2.1-2.1 2.1S9.9 9.16 9.9 8s.94-2.1 2.1-2.1m0 9c2.97 0 6.1 1.46 6.1 2.1v1.1H5.9V17c0-.64 3.13-2.1 6.1-2.1M12 4C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 9c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z"></path>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <div class="d-flex mb-1 align-items-top justify-content-between">
                                                                <h5 class="fw-semibold mb-0 lh-1">256</h5>
                                                                <div class="text-danger fw-semibold"><i class="ri-arrow-down-s-fill me-1 align-middle"></i>-1.05%</div>
                                                            </div>
                                                            <p class="mb-0 fs-10 op-7 text-muted fw-semibold">TOTAL EMPLOYERS</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card custom-card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-top">
                                                        <div class="me-3">
                                                            <span class="avatar avatar-md p-2 bg-secondary-transparent">
                                                                <svg class="svg-secondary" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
                                                                    <rect fill="none" height="24" width="24"></rect>
                                                                    <g>
                                                                        <path d="M4,13c1.1,0,2-0.9,2-2c0-1.1-0.9-2-2-2s-2,0.9-2,2C2,12.1,2.9,13,4,13z M5.13,14.1C4.76,14.04,4.39,14,4,14 c-0.99,0-1.93,0.21-2.78,0.58C0.48,14.9,0,15.62,0,16.43V18l4.5,0v-1.61C4.5,15.56,4.73,14.78,5.13,14.1z M20,13c1.1,0,2-0.9,2-2 c0-1.1-0.9-2-2-2s-2,0.9-2,2C18,12.1,18.9,13,20,13z M24,16.43c0-0.81-0.48-1.53-1.22-1.85C21.93,14.21,20.99,14,20,14 c-0.39,0-0.76,0.04-1.13,0.1c0.4,0.68,0.63,1.46,0.63,2.29V18l4.5,0V16.43z M16.24,13.65c-1.17-0.52-2.61-0.9-4.24-0.9 c-1.63,0-3.07,0.39-4.24,0.9C6.68,14.13,6,15.21,6,16.39V18h12v-1.61C18,15.21,17.32,14.13,16.24,13.65z M8.07,16 c0.09-0.23,0.13-0.39,0.91-0.69c0.97-0.38,1.99-0.56,3.02-0.56s2.05,0.18,3.02,0.56c0.77,0.3,0.81,0.46,0.91,0.69H8.07z M12,8 c0.55,0,1,0.45,1,1s-0.45,1-1,1s-1-0.45-1-1S11.45,8,12,8 M12,6c-1.66,0-3,1.34-3,3c0,1.66,1.34,3,3,3s3-1.34,3-3 C15,7.34,13.66,6,12,6L12,6z"></path>
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <div class="d-flex mb-1 align-items-top justify-content-between">
                                                                <h5 class="fw-semibold mb-0 lh-1">4,026</h5>
                                                                <div class="text-success fw-semibold"><i class="ri-arrow-up-s-fill me-1 align-middle"></i>+0.40%</div>
                                                            </div>
                                                            <p class="mb-0 fs-10 op-7 text-muted fw-semibold">TOTAL CANDIDATES</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card custom-card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-top">
                                                        <div class="me-3">
                                                            <span class="avatar avatar-md p-2 bg-info-transparent">
                                                                <svg class="svg-info" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
                                                                    <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM4 12c0-.61.08-1.21.21-1.78L8.99 15v1c0 1.1.9 2 2 2v1.93C7.06 19.43 4 16.07 4 12zm13.89 5.4c-.26-.81-1-1.4-1.9-1.4h-1v-3c0-.55-.45-1-1-1h-6v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41C17.92 5.77 20 8.65 20 12c0 2.08-.81 3.98-2.11 5.4z"></path>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <div class="d-flex mb-1 align-items-top justify-content-between">
                                                                <h5 class="fw-semibold mb-0 lh-1">48</h5>
                                                                <div class="text-success fw-semibold"><i class="ri-arrow-up-s-fill me-1 align-middle"></i>+0.82%</div>
                                                            </div>
                                                            <p class="mb-0 fs-10 op-7 text-muted fw-semibold">TOTAL LOCATIONS</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card custom-card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-top">
                                                        <div class="me-3">
                                                            <span class="avatar avatar-md p-2 bg-success-transparent">
                                                                <svg class="svg-success" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
                                                                    <g>
                                                                        <rect fill="none" height="24" width="24"></rect>
                                                                    </g>
                                                                    <g>
                                                                        <g>
                                                                            <path d="M9,14c1.65,0,3-1.35,3-3s-1.35-3-3-3s-3,1.35-3,3S7.35,14,9,14z M9,10c0.54,0,1,0.46,1,1s-0.46,1-1,1s-1-0.46-1-1 S8.46,10,9,10z"></path>
                                                                            <path d="M22,3H2C0.9,3,0,3.9,0,5v14c0,1.1,0.9,2,2,2h20c1.1,0,1.99-0.9,1.99-2L24,5C24,3.9,23.1,3,22,3z M4.54,19 c1.1-1.22,2.69-2,4.46-2s3.36,0.78,4.46,2H4.54z M22,19h-6.08c-1.38-2.39-3.96-4-6.92-4s-5.54,1.61-6.92,4H2V5h20V19z"></path>
                                                                            <polygon points="15.78,11.15 17.25,10.3 17.25,12 18.75,12 18.75,10.3 20.22,11.15 20.97,9.85 19.5,9 20.97,8.15 20.22,6.85 18.75,7.7 18.75,6 17.25,6 17.25,7.7 15.78,6.85 15.03,8.15 16.5,9 15.03,9.85"></polygon>
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <div class="d-flex mb-1 align-items-top justify-content-between">
                                                                <h5 class="fw-semibold mb-0 lh-1">1,116</h5>
                                                                <div class="text-success fw-semibold"><i class="ri-arrow-up-s-fill me-1 align-middle"></i>+0.21%</div>
                                                            </div>
                                                            <p class="mb-0 fs-10 op-7 text-muted fw-semibold">TOTAL RECRUITERS</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card custom-card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-top">
                                                        <div class="me-3">
                                                            <span class="avatar avatar-md p-2 bg-pink-transparent">
                                                                <svg class="svg-pink" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
                                                                    <path d="M0 0h24v24H0V0z" fill="none"></path>
                                                                    <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2zm-2 1H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6z"></path>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <div class="d-flex mb-1 align-items-top justify-content-between">
                                                                <h5 class="fw-semibold mb-0 lh-1">1,468</h5>
                                                                <div class="text-danger fw-semibold"><i class="ri-arrow-down-s-fill me-1 align-middle"></i>-0.153%</div>
                                                            </div>
                                                            <p class="mb-0 fs-10 op-7 text-muted fw-semibold">TOTAL SUBSCRIPTIONS</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card custom-card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-top">
                                                        <div class="me-3">
                                                            <span class="avatar avatar-md p-2 bg-teal-transparent">
                                                                <svg class="svg-teal" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
                                                                    <g>
                                                                        <rect fill="none" height="24" width="24"></rect>
                                                                        <g>
                                                                            <path d="M19,5v14H5V5H19 M19,3H5C3.9,3,3,3.9,3,5v14c0,1.1,0.9,2,2,2h14c1.1,0,2-0.9,2-2V5C21,3.9,20.1,3,19,3L19,3z"></path>
                                                                        </g>
                                                                        <path d="M14,17H7v-2h7V17z M17,13H7v-2h10V13z M17,9H7V7h10V9z"></path>
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <div class="d-flex mb-1 align-items-top justify-content-between">
                                                                <h5 class="fw-semibold mb-0 lh-1">34%</h5>
                                                                <div class="text-success fw-semibold"><i class="ri-arrow-up-s-fill me-1 align-middle"></i>+0.165%</div>
                                                            </div>
                                                            <p class="mb-0 fs-10 op-7 text-muted fw-semibold">RESSUME UPLOAD RATIO</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-5">
                                    <div class="row">
                                        <div class="col-xxl-6">
                                            <div class="card custom-card card-bg-primary">
                                                <div class="card-header justify-content-between border-bottom-0">
                                                    <div class="card-title text-fixed-white">
                                                        Premium Recruiters
                                                    </div>
                                                    <div>
                                                        <button type="button" aria-label="button" class="btn btn-sm btn-icon text-bg-primary"><i class="ti ti-chevron-right"></i></button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex flex-wrap align-items-top">
                                                        <div class="flex-fill overflow-hidden">
                                                            <p class="mb-2 lh-1 fs-5 fw-semibold">9,231</p>
                                                            <p class="mb-0 fs-12 text-fixed-white op-7">
                                                                <span><i class="bi bi-caret-up-fill"></i> 2.3%</span>
                                                                <span class="op-7 ms-1">From Last Month</span>
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <span class="avatar avatar-sm bg-success avatar-rounded"><i class="bi bi-people-fill"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6">
                                            <div class="card custom-card">
                                                <div class="card-body p-0">
                                                    <div class="p-3">
                                                        <div class="d-flex flex-wrap mb-1">
                                                            <a aria-label="anchor" href="javascript:void(0);" class="pe-2">
                                                                <span class="avatar border text-muted text-primary"><i class="ri-bit-coin-fill fs-18"></i></span>
                                                            </a>
                                                            <div class="flex-fill">
                                                                <div class="d-flex flex-wrap align-items-center justify-content-between mb-1">
                                                                    <span class="fw-semibold">Bitcoin</span>
                                                                    <span class="text-success text-end"><i class="ti ti-trending-up fs-11 me-1"></i>2.14%</span>
                                                                </div>
                                                                <div class="d-flex flex-wrap align-items-center justify-content-between fs-12 mb-3">
                                                                    <span class="text-muted">$58,151.02</span>
                                                                    <span class="text-success text-end">+$5,745.62</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <a href="javascript:void(0);" class="flex-fill btn btn-sm btn-light me-2">Short</a>
                                                            <a href="javascript:void(0);" class="flex-fill btn btn-sm btn-primary-light">Buy</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-xl-7 col-lg-7">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card custom-card">
                                                <div class="card-header">
                                                    <div class="card-title">Team Performance</div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row m-1">
                                                        <div class="col-xl-4 text-center p-2 team-performance1">
                                                            <a href="javascript:void(0);" class="mb-2">
                                                                <img src="assets/images/faces/10.jpg" alt="img" width="40" height="40" class="rounded-circle">
                                                            </a>
                                                            <p class=" fs-16 mt-2 mb-0">Aliaroon</p>
                                                            <p class="  fs-12 text-muted fs-semibold mb-0">customer1</p>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6  col-6 p-0 text-center  border border-end-0 p-2 border-start team-performance2">
                                                            <div class="mt-1">
                                                                <div class="me-2 mb-2 mb-sm-0">
                                                                    <span class="avatar avatar-sm br-5 bg-primary-transparent text-primary primary-shadow">
                                                                        <i class="ti ti-briefcase fs-20"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="flex-grow-1 mt-2">
                                                                    <span class="fs-16 mb-1">71,234 </span>
                                                                    <p class="mb-0 fs-12 text-muted">Total Targets</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-sm-6 col-6 text-center  border p-2 team-performance3">
                                                            <div class="mt-1">
                                                                <div class="me-2 mb-2 mb-sm-0">
                                                                    <span class="avatar avatar-sm br-5 bg-secondary-transparent text-seconday success-shadow">
                                                                        <i class="ti ti-cash-banknote fs-20"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="flex-grow-1 mt-2">
                                                                    <span class="fs-16 mb-1"> 66,450</span>
                                                                    <p class="mb-0 fs-12 text-muted">Total sales</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="border bg-light text-primary p-2 border-top-0">
                                                            <span class=" fs-14 mt-2 text-end">See All Team Performance</span>
                                                            <a href="javascript:void(0);" class="float-end fs-15 text-primary fs-semibold">
                                                            <div class="list-group-item list-group-item-action border-0 header-link switcher-icon p-0">
                                                                <span class="badge bg-primary br-3">click me<i class="ms-1 ti ti-arrow-bar-to-right d-inline-flex"></i></span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-xl-5">
                                    <div class="card  custom-card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Sales By Category
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-sm-flex mb-3">
                                                <div class="me-sm-2 mb-2 mb-sm-0">
                                                    <div class="avatar bg-primary-transparent text-primary br-5 fs-22"><i class="bx bx-category"></i></div>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex-between mb-1">
                                                        <p class="mb-0 fs-14">Total Sales</p>
                                                    </div>
                                                    <h5 class="mb-0">55,283 <span class="tx-muted tx-13"> / 120K</span></h5>
                                                </div>
                                            </div>
                                            <div class="progress progress-xl my-4">
                                                <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 45%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">40%</div>
                                            </div>
                                            <span class="fs-14 mt-2 d-block d-sm-inline-block"><i class="bx bxs-circle text-primary tx-8 me-2"></i>Electronics</span>
                                            <span class="ms-3 fs-14 mt-2 d-block d-sm-inline-block"><i class="bx bxs-circle text-secondary tx-8 me-2"></i>Home Appliances</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End::row-5 -->

                            <!-- Start::row-6 -->
                            <div class="row">
                                <div class="col-xxl-4 col-xl-12 col-md-12">
                                    <div class="card custom-card overflow-hidden justify-content-between">
                                        <div class="card-header justify-content-between">
                                            <div class="card-title">
                                                Top Referrers
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
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="ps-4">Browser</th>
                                                            <th scope="col">Page Views</th>
                                                            <th scope="col">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="ps-4">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-2 lh-1">
                                                                        <span class="avatar avatar-sm avatar-rounded bg-primary">
                                                                            <i class="ri-chrome-line"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="fw-semibold">
                                                                            Chrome
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>37,098<i class="bi bi-caret-up-fill ms-2 fs-11 text-success"></i></td>
                                                            <td class="border-top-0">
                                                                <div class="progress progress-sm mb-3" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                                    <div class="progress-bar bg-primary" style="width: 65%">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ps-4">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-2 lh-1">
                                                                        <span class="avatar avatar-sm avatar-rounded bg-secondary">
                                                                            <i class="ri-safari-line"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="fw-semibold">
                                                                            safari
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>37,098<i class="bi bi-caret-up-fill ms-2 fs-11 text-success"></i></td>
                                                            <td class="border-top-0">
                                                                <div class="progress progress-sm mb-3" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                                    <div class="progress-bar bg-primary" style="width: 60%">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ps-4">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-2 lh-1">
                                                                        <span class="avatar avatar-sm avatar-rounded bg-info">
                                                                            <i class="ri-firefox-line"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="fw-semibold">
                                                                            Firefox
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>54,085<i class="bi bi-caret-down-fill ms-2 fs-11 text-danger"></i></td>
                                                            <td class="border-top-0">
                                                                <div class="progress progress-sm mb-3" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                                    <div class="progress-bar bg-primary" style="width: 40%">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ps-4">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-2 lh-1">
                                                                        <span class="avatar avatar-sm avatar-rounded bg-warning">
                                                                            <i class="ri-opera-line"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="fw-semibold">
                                                                            Opera
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>74,085<i class="bi bi-caret-up-fill ms-2 fs-11 text-success"></i></td>
                                                            <td class="border-top-0">
                                                                <div class="progress progress-sm mb-3" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                                    <div class="progress-bar bg-primary" style="width: 50%">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="ps-4">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-2 lh-1">
                                                                        <span class="avatar avatar-sm avatar-rounded bg-success">
                                                                            <i class="ri-edge-line"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="fw-semibold">
                                                                            Edge
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>54,085<i class="bi bi-caret-down-fill ms-2 fs-11 text-danger"></i></td>
                                                            <td class="border-top-0">
                                                                <div class="progress progress-sm mb-3" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                                    <div class="progress-bar bg-primary" style="width: 45%">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-5 col-xl-6">
                                    <div class="card custom-card">
                                        <div class="card-header d-sm-flex d-block">
                                            <div class="card-title">Task List</div>
                                            <div class="tab-menu-heading border-0 p-0 ms-auto mt-sm-0 mt-2">
                                                <div class="tabs-menu-task me-3">
                                                    <ul class="nav nav-tabs panel-tabs-task border-0" role="tablist">
                                                        <li><a href="javascript:void(0);" class="me-1 active" data-bs-toggle="tab" data-bs-target="#Active" role="tab" aria-selected="true">Active Tasks</a></li>
                                                        <li><a href="javascript:void(0);" data-bs-toggle="tab" data-bs-target="#Complete" role="tab" aria-selected="false" tabindex="-1">Completed Tasks</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="mt-sm-0 mt-2">
                                                <button type="button" class="btn btn-sm btn-light"><i class="ti ti-plus me-1 fw-semibold align-middle d-inline-flex"></i>Add Task</button>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="tab-content p-0">
                                                <div class="tab-pane active p-0 border-0" id="Active" role="tabpanel">
                                                    <div class="table-responsive">
                                                        <table class="table text-nowrap table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" class="text-center">
                                                                        <span>
                                                                            <input class="form-check-input" type="checkbox" id="checkAll" value="" aria-label="...">
                                                                        </span>
                                                                    </th>
                                                                    <th scope="col">Task details</th>
                                                                    <th scope="col">Assigned date</th>
                                                                    <th scope="col">Target</th>
                                                                    <th scope="col">Assigned to</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <span>
                                                                            <input class="form-check-input" type="checkbox" id="check1" value="" aria-label="...">
                                                                        </span>
                                                                    </td>
                                                                    <td>Design task page for new template</td>
                                                                    <td class="text-muted">12.43pm</td>
                                                                    <td><span class="badge bg-primary">Today</span></td>
                                                                    <td>
                                                                        <div class="avatar-list-stacked mb-0">
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/2.jpg" alt="user-img">
                                                                            </span>
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/8.jpg" alt="user-img">
                                                                            </span>
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/2.jpg" alt="user-img">
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <span>
                                                                            <input class="form-check-input" type="checkbox" id="check2" value="" aria-label="..." checked>
                                                                        </span>
                                                                    </td>
                                                                    <td>Solve UI issues in new template</td>
                                                                    <td class="text-muted">11.25am</td>
                                                                    <td><span class="badge bg-secondary">Tomorrow</span></td>
                                                                    <td>
                                                                        <div class="avatar-list-stacked mb-0">
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/6.jpg" alt="user-img">
                                                                            </span>
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/9.jpg" alt="user-img">
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <span>
                                                                            <input class="form-check-input" type="checkbox" id="check3" value="" aria-label="...">
                                                                        </span>
                                                                    </td>
                                                                    <td>prepare pre requisites</td>
                                                                    <td class="text-muted">9.56am</td>
                                                                    <td><span class="badge bg-primary">Today</span></td>
                                                                    <td>
                                                                        <div class="avatar-list-stacked mb-0">
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/3.jpg" alt="user-img">
                                                                            </span>
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/5.jpg" alt="user-img">
                                                                            </span>
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/10.jpg" alt="user-img">
                                                                            </span>
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/15.jpg" alt="user-img">
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <span>
                                                                            <input class="form-check-input" type="checkbox" id="check4" value="" aria-label="...">
                                                                        </span>
                                                                    </td>
                                                                    <td>Change total styles od that dashboard</td>
                                                                    <td class="text-muted">8.15am</td>
                                                                    <td><span class="badge bg-primary">Today</span></td>
                                                                    <td>
                                                                        <div class="avatar-list-stacked mb-0">
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/11.jpg" alt="user-img">
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <span>
                                                                            <input class="form-check-input" type="checkbox" id="check5" value="" aria-label="...">
                                                                        </span>
                                                                    </td>
                                                                    <td>Update color theme</td>
                                                                    <td class="text-muted">4.20pm</td>
                                                                    <td><span class="badge bg-secondary">Tomorrow</span></td>
                                                                    <td>
                                                                        <div class="avatar-list-stacked mb-0">
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/13.jpg" alt="user-img">
                                                                            </span>
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/16.jpg" alt="user-img">
                                                                            </span>
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/8.jpg" alt="user-img">
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <span>
                                                                            <input class="form-check-input" type="checkbox" id="check11" value="" aria-label="...">
                                                                        </span>
                                                                    </td>
                                                                    <td>New dashboard design update</td>
                                                                    <td class="text-muted">8.29am</td>
                                                                    <td><span class="badge bg-primary">Today</span></td>
                                                                    <td>
                                                                        <div class="avatar-list-stacked mb-0">
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/10.jpg" alt="user-img">
                                                                            </span>
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/5.jpg" alt="user-img">
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane p-0 border-0" id="Complete" role="tabpanel">
                                                    <div class="table-responsive">
                                                        <table class="table text-nowrap table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" class="text-center">
                                                                        <span>
                                                                            <input class="form-check-input" type="checkbox" id="checkAll1" value="" aria-label="...">
                                                                        </span>
                                                                    </th>
                                                                    <th scope="col">Task details</th>
                                                                    <th scope="col">Assigned date</th>
                                                                    <th scope="col">Completed</th>
                                                                    <th scope="col">Assigned to</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <span>
                                                                            <input class="form-check-input" type="checkbox" id="check6" value="" aria-label="...">
                                                                        </span>
                                                                    </td>
                                                                    <td>New landing page ui update</td>
                                                                    <td class="text-muted">24 Nov 2022</td>
                                                                    <td><span class="badge bg-success">4 hrs ago</span></td>
                                                                    <td>
                                                                        <div class="avatar-list-stacked mb-0">
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/5.jpg" alt="user-img">
                                                                            </span>
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/9.jpg" alt="user-img">
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <span>
                                                                            <input class="form-check-input" type="checkbox" id="check7" value="" aria-label="...">
                                                                        </span>
                                                                    </td>
                                                                    <td>Job portal dashboard redesign</td>
                                                                    <td class="text-muted">30 Nov 2022</td>
                                                                    <td><span class="badge bg-success">Today</span></td>
                                                                    <td>
                                                                        <div class="avatar-list-stacked mb-0">
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/11.jpg" alt="user-img">
                                                                            </span>
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/12.jpg" alt="user-img">
                                                                            </span>
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/13.jpg" alt="user-img">
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <span>
                                                                            <input class="form-check-input" type="checkbox" id="check8" value="" aria-label="...">
                                                                        </span>
                                                                    </td>
                                                                    <td>New template layout update</td>
                                                                    <td class="text-muted">11 Dec 2022</td>
                                                                    <td><span class="badge bg-success">Yesterday</span></td>
                                                                    <td>
                                                                        <div class="avatar-list-stacked mb-0">
                                                                            <span class="avatar avatar-xs">
                                                                                <img src="assets/images/faces/4.jpg" alt="user-img">
                                                                            </span>
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
                                <div class="col-xxl-3 col-xl-6">
                                    <div class="card custom-card recent-transactions-card overflow-hidden">
                                        <div class="card-header justify-content-between">
                                            <div class="card-title">Recent Transactions</div>
                                            <div class="dropdown">
                                                <a aria-label="anchor" href="javascript:void(0);" class="btn btn-icon btn-sm btn-light" data-bs-toggle="dropdown">
                                                    <i class="fe fe-more-vertical"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li class="border-bottom"><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                                                    <li class="border-bottom"><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="list-group">
                                                <a href="javascript:void(0);" class="border-0">
                                                    <div class="list-group-item border-0">
                                                        <div class="d-flex align-items-start">
                                                            <span class="tansaction-icon bg-primary-transparent">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-primary" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"></rect><path d="M18,6h-2c0-2.21-1.79-4-4-4S8,3.79,8,6H6C4.9,6,4,6.9,4,8v12c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2V8C20,6.9,19.1,6,18,6z M12,4c1.1,0,2,0.9,2,2h-4C10,4.9,10.9,4,12,4z M18,20H6V8h2v2c0,0.55,0.45,1,1,1s1-0.45,1-1V8h4v2c0,0.55,0.45,1,1,1s1-0.45,1-1V8 h2V20z"></path></g></svg>
                                                            </span>
                                                            <div class="w-100">
                                                                <div class="d-flex align-items-top justify-content-between">
                                                                    <div class="mt-0">
                                                                        <p class="mb-0 fw-semibold"><span class="me-3">Shopping</span></p>
                                                                        <span class="mb-0 fs-12 text-muted">card</span>
                                                                    </div>
                                                                    <div class="text-muted fs-12 text-center"></div>
                                                                    <span class="ms-auto">
                                                                        <span class="text-end text-danger d-block">
                                                                            -$256.99
                                                                        </span>
                                                                        <span class="text-end text-muted d-block fs-12">Mar 12,2022</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0);" class="border-0">
                                                    <div class="list-group-item border-0">
                                                        <div class="d-flex align-items-start">
                                                            <span class="tansaction-icon bg-info-transparent">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-info" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"></rect></g><g><g><path d="M20,2H4C3,2,2,2.9,2,4v3.01C2,7.73,2.43,8.35,3,8.7V20c0,1.1,1.1,2,2,2h14c0.9,0,2-0.9,2-2V8.7c0.57-0.35,1-0.97,1-1.69V4 C22,2.9,21,2,20,2z M19,20H5V9h14V20z M20,7H4V4h16V7z"></path><rect height="2" width="6" x="9" y="12"></rect></g></g></svg>
                                                            </span>
                                                            <div class="w-100">
                                                                <div class="d-flex align-items-top justify-content-between">
                                                                    <div class="mt-0">
                                                                        <p class="mb-0 fw-semibold"><span class="me-3">Stock Market</span></p>
                                                                        <span class="mb-0 fs-12 text-muted">Transfer</span>
                                                                    </div>
                                                                    <div class="text-muted fs-12 text-center"></div>
                                                                    <span class="ms-auto">
                                                                        <span class="text-end text-success d-block">
                                                                            +$18,567.00
                                                                        </span>
                                                                        <span class="text-end text-muted d-block fs-12">Mar 10,2022</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0);" class="border-0">
                                                    <div class="list-group-item border-0">
                                                        <div class="d-flex align-items-start">
                                                            <span class="tansaction-icon bg-warning-transparent">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-warning" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2zm-1.45-5c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.37-.66-.11-1.48-.87-1.48H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6z"></path></svg>
                                                            </span>
                                                            <div class="w-100">
                                                                <div class="d-flex align-items-top justify-content-between">
                                                                    <div class="mt-0">
                                                                        <p class="mb-0 fw-semibold"><span class="me-3">Grocery</span></p>
                                                                        <span class="mb-0 fs-12 text-muted">card</span>
                                                                    </div>
                                                                    <div class="text-muted fs-12 text-center"></div>
                                                                    <span class="ms-auto">
                                                                        <span class="text-end text-danger d-block">
                                                                            -$256.99
                                                                        </span>
                                                                        <span class="text-end text-muted d-block fs-12">Apr 23,2022</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0);" class="border-0">
                                                    <div class="list-group-item border-0">
                                                        <div class="d-flex align-items-start">
                                                            <span class="tansaction-icon bg-success-transparent">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-success" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H8V4h12v12zM10 9h8v2h-8zm0 3h4v2h-4zm0-6h8v2h-8z"></path></svg>
                                                            </span>
                                                            <div class="w-100">
                                                                <div class="d-flex align-items-top justify-content-between">
                                                                    <div class="mt-0">
                                                                        <p class="mb-0 fw-semibold"><span class="me-3">Books</span></p>
                                                                        <span class="mb-0 fs-12 text-muted">card</span>
                                                                    </div>
                                                                    <div class="text-muted fs-12 text-center"></div>
                                                                    <span class="ms-auto">
                                                                        <span class="text-end text-danger d-block">
                                                                            -$256.99
                                                                        </span>
                                                                        <span class="text-end text-muted d-block fs-12">May 18,2022</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0);" class="border-0">
                                                    <div class="list-group-item border-0">
                                                        <div class="d-flex align-items-start">
                                                            <span class="tansaction-icon bg-danger-transparent">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-danger" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"></rect></g><g><g></g><g><path d="M21.9,8.89l-1.05-4.37c-0.22-0.9-1-1.52-1.91-1.52H5.05C4.15,3,3.36,3.63,3.15,4.52L2.1,8.89 c-0.24,1.02-0.02,2.06,0.62,2.88C2.8,11.88,2.91,11.96,3,12.06V19c0,1.1,0.9,2,2,2h14c1.1,0,2-0.9,2-2v-6.94 c0.09-0.09,0.2-0.18,0.28-0.28C21.92,10.96,22.15,9.91,21.9,8.89z M18.91,4.99l1.05,4.37c0.1,0.42,0.01,0.84-0.25,1.17 C19.57,10.71,19.27,11,18.77,11c-0.61,0-1.14-0.49-1.21-1.14L16.98,5L18.91,4.99z M13,5h1.96l0.54,4.52 c0.05,0.39-0.07,0.78-0.33,1.07C14.95,10.85,14.63,11,14.22,11C13.55,11,13,10.41,13,9.69V5z M8.49,9.52L9.04,5H11v4.69 C11,10.41,10.45,11,9.71,11c-0.34,0-0.65-0.15-0.89-0.41C8.57,10.3,8.45,9.91,8.49,9.52z M4.04,9.36L5.05,5h1.97L6.44,9.86 C6.36,10.51,5.84,11,5.23,11c-0.49,0-0.8-0.29-0.93-0.47C4.03,10.21,3.94,9.78,4.04,9.36z M5,19v-6.03C5.08,12.98,5.15,13,5.23,13 c0.87,0,1.66-0.36,2.24-0.95c0.6,0.6,1.4,0.95,2.31,0.95c0.87,0,1.65-0.36,2.23-0.93c0.59,0.57,1.39,0.93,2.29,0.93 c0.84,0,1.64-0.35,2.24-0.95c0.58,0.59,1.37,0.95,2.24,0.95c0.08,0,0.15-0.02,0.23-0.03V19H5z"></path></g></g></svg>
                                                            </span>
                                                            <div class="w-100">
                                                                <div class="d-flex align-items-top justify-content-between">
                                                                    <div class="mt-0">
                                                                        <p class="mb-0 fw-semibold"><span class="me-3">Business</span></p>
                                                                        <span class="mb-0 fs-12 text-muted">transfer</span>
                                                                    </div>
                                                                    <div class="text-muted fs-12 text-center"></div>
                                                                    <span class="ms-auto">
                                                                        <span class="text-end text-success d-block">
                                                                            +$256.99
                                                                        </span>
                                                                        <span class="text-end text-muted d-block fs-12">May 4,2022</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End::row-6 -->

                            <!-- Start:: row-7 -->
                            <div class="row">
                                <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12">
                                    <div class="card custom-card overflow-hidden">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="card-title">Tasks Status</div>
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle btn-sm btn-wave waves-effect waves-light btn-primary d-flex align-items-center" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-calendar-2-line me-1"></i>Weekly</button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item" href="javascript:void(0);">Monthly</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0);">More</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table text-nowrap table-hover">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w-12 ps-4">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar avatar-md me-2 bg-primary-transparent">
                                                                        <i class="ri-file-chart-2-line fs-16"></i>
                                                                    </div>
                                                                    <div>
                                                                        <p class="mb-0 fw-semibold">Robert anii</p>
                                                                        <span class="fs-10 fw-semibold text-muted">New website designs</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="mb-1">
                                                                    <span class="fs-12 fw-semibold">Completed</span>
                                                                    <span class="fs-10 mb-0 float-end">90%<i class="ri-arrow-up-line text-primary"></i></span>
                                                                </div>
                                                                <div class="progress progress-xs">
                                                                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="avatar-list-stacked my-auto">
                                                                    <span class="avatar avatar-rounded avatar-sm">
                                                                        <img src="assets/images/faces/15.jpg" alt="user-img">
                                                                    </span>
                                                                    <span class="avatar avatar-rounded avatar-sm">
                                                                        <img src="assets/images/faces/13.jpg" alt="user-img">
                                                                    </span>
                                                                    <span class="avatar avatar-rounded avatar-sm">
                                                                        <img src="assets/images/faces/8.jpg" alt="user-img">
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td class="w-2 pe-3 text-end">
                                                                <button type="button" class="btn btn-sm btn-wave btn-primary-light d-inline-flex align-items-center waves-effect waves-light"><i class="ri-timer-flash-line me-1 fs-13"></i>Reminder</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-12 ps-4">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar avatar-md me-2 bg-secondary-transparent">
                                                                        <i class="ri-file-chart-2-line fs-16"></i>
                                                                    </div>
                                                                    <div>
                                                                        <p class="mb-0 fw-semibold">Renaissance</p>
                                                                        <span class="fs-10 fw-semibold text-muted">Ad Design for new Project</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="mb-1">
                                                                    <span class="fs-12 fw-semibold">Completed</span>
                                                                    <span class="fs-10 mb-0 float-end">60%<i class="ri-arrow-up-line text-secondary"></i></span>
                                                                </div>
                                                                <div class="progress progress-xs">
                                                                    <div class="progress-bar bg-secondary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="avatar-list-stacked my-auto">
                                                                    <span class="avatar avatar-rounded avatar-sm">
                                                                        <img src="assets/images/faces/15.jpg" alt="user-img">
                                                                    </span>
                                                                    <span class="avatar avatar-rounded avatar-sm">
                                                                        <img src="assets/images/faces/13.jpg" alt="user-img">
                                                                    </span>
                                                                    <span class="avatar avatar-rounded avatar-sm">
                                                                        <img src="assets/images/faces/8.jpg" alt="user-img">
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td class="w-2 pe-3 text-end">
                                                                <button type="button" class="btn btn-sm btn-wave btn-primary-light d-inline-flex align-items-center waves-effect waves-light"><i class="ri-timer-flash-line me-1 fs-13"></i>Reminder</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-12 ps-4">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar avatar-md me-2 bg-success-transparent">
                                                                        <i class="ri-file-chart-2-line fs-16"></i>
                                                                    </div>
                                                                    <div>
                                                                        <p class="mb-0 fw-semibold">Bonorum</p>
                                                                        <span class="fs-10 fw-semibold text-muted">New website designs</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="mb-1">
                                                                    <span class="fs-12 fw-semibold">Completed</span>
                                                                    <span class="fs-10 mb-0 float-end">45%<i class="ri-arrow-up-line text-success"></i></span>
                                                                </div>
                                                                <div class="progress progress-xs">
                                                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="avatar-list-stacked my-auto">
                                                                    <span class="avatar avatar-rounded avatar-sm">
                                                                        <img src="assets/images/faces/15.jpg" alt="user-img">
                                                                    </span>
                                                                    <span class="avatar avatar-rounded avatar-sm">
                                                                        <img src="assets/images/faces/13.jpg" alt="user-img">
                                                                    </span>
                                                                    <span class="avatar avatar-rounded avatar-sm">
                                                                        <img src="assets/images/faces/8.jpg" alt="user-img">
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td class="w-2 pe-3 text-end">
                                                                <button type="button" class="btn btn-sm btn-wave btn-primary-light d-inline-flex align-items-center waves-effect waves-light"><i class="ri-timer-flash-line me-1 fs-13"></i>Reminder</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-12 ps-4">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar avatar-md me-2 bg-info-transparent">
                                                                        <i class="ri-file-chart-2-line fs-16"></i>
                                                                    </div>
                                                                    <div>
                                                                        <p class="mb-0 fw-semibold">Malorum</p>
                                                                        <span class="fs-10 fw-semibold text-muted">Ad Design for new Project</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="mb-1">
                                                                    <span class="fs-12 fw-semibold">Completed</span>
                                                                    <span class="fs-10 mb-0 float-end">75%<i class="ri-arrow-up-line text-info"></i></span>
                                                                </div>
                                                                <div class="progress progress-xs">
                                                                    <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="avatar-list-stacked my-auto">
                                                                    <span class="avatar avatar-rounded avatar-sm">
                                                                        <img src="assets/images/faces/15.jpg" alt="user-img">
                                                                    </span>
                                                                    <span class="avatar avatar-rounded avatar-sm">
                                                                        <img src="assets/images/faces/13.jpg" alt="user-img">
                                                                    </span>
                                                                    <span class="avatar avatar-rounded avatar-sm">
                                                                        <img src="assets/images/faces/8.jpg" alt="user-img">
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td class="w-2 pe-3 text-end">
                                                                <button type="button" class="btn btn-sm btn-wave btn-primary-light d-inline-flex align-items-center waves-effect waves-light"><i class="ri-timer-flash-line me-1 fs-13"></i>Reminder</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-12 ps-4">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar avatar-md me-2 bg-warning-transparent">
                                                                        <i class="ri-file-chart-2-line fs-16"></i>
                                                                    </div>
                                                                    <div>
                                                                        <p class="mb-0 fw-semibold">Rackham</p>
                                                                        <span class="fs-10 fw-semibold text-muted">New website designs</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="mb-1">
                                                                    <span class="fs-12 fw-semibold">Completed</span>
                                                                    <span class="fs-10 mb-0 float-end">55%<i class="ri-arrow-up-line text-warning"></i></span>
                                                                </div>
                                                                <div class="progress progress-xs">
                                                                    <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="avatar-list-stacked my-auto">
                                                                    <span class="avatar avatar-rounded avatar-sm">
                                                                        <img src="assets/images/faces/15.jpg" alt="user-img">
                                                                    </span>
                                                                    <span class="avatar avatar-rounded avatar-sm">
                                                                        <img src="assets/images/faces/13.jpg" alt="user-img">
                                                                    </span>
                                                                    <span class="avatar avatar-rounded avatar-sm">
                                                                        <img src="assets/images/faces/8.jpg" alt="user-img">
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td class="w-2 pe-3 text-end">
                                                                <button type="button" class="btn btn-sm btn-wave btn-primary-light d-inline-flex align-items-center waves-effect waves-light"><i class="ri-timer-flash-line me-1 fs-13"></i>Reminder</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <div class="card custom-card overflow-hidden">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="card-title">Team Members</div>
                                            <button type="button" class="btn btn-sm btn-wave btn-primary-light waves-effect waves-light">View all <i class="ri-arrow-right-line align-middle"></i></button>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group online-agents">
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-sm avatar-rounded online me-2">
                                                                <img src="assets/images/faces/4.jpg" alt="user-img">
                                                            </div>
                                                            <div class="lh-1">
                                                                <a href="javascript:void(0);" class="mb-1 fw-semibold fs-13 d-block">Madrick</a>
                                                                <span class="fs-11 text-muted fw-semibold">Hey hi.!</span>
                                                            </div>
                                                        </div>
                                                        <div class="badge bg-light px-2 rounded-pill text-dark">
                                                            <span class="fs-11 ms-auto fw-semibold d-inline-flex"><i class="ri-map-pin-line fs-10 me-1 text-success"></i>London</span>
                                                        </div>
                                                        <div class="btn-list d-flex">
                                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-secondary-light btn-wave waves-effect waves-light" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" aria-label="Chat">
                                                                <i class="bi bi-chat-dots"></i>
                                                            </a>
                                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-primary-light btn-wave waves-effect waves-light" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" aria-label="View">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-sm avatar-rounded me-2">
                                                                <img src="assets/images/faces/6.jpg" alt="user-img">
                                                            </div>
                                                        <div class="lh-1">
                                                                <a href="javascript:void(0);" class="mb-1 fw-semibold fs-13 d-block">Daiveed</a>
                                                                <span class="fs-11 text-muted fw-semibold">Hey hi.!</span>
                                                        </div>
                                                        </div>
                                                        <div class="badge bg-light px-2 rounded-pill text-dark">
                                                            <span class="fs-11 ms-auto fw-semibold d-inline-flex"><i class="ri-map-pin-line fs-10 me-1 text-success"></i>Mexico</span>
                                                        </div>
                                                        <div class="btn-list d-flex">
                                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-secondary-light btn-wave waves-effect waves-light" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" aria-label="Chat">
                                                                <i class="bi bi-chat-dots"></i>
                                                            </a>
                                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-primary-light btn-wave waves-effect waves-light" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" aria-label="View">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-sm avatar-rounded online me-2">
                                                                <img src="assets/images/faces/2.jpg" alt="user-img">
                                                            </div>
                                                            <div class="lh-1">
                                                                <a href="javascript:void(0);" class="mb-1 fw-semibold fs-13 d-block">Majeshe</a>
                                                                <span class="fs-11 text-muted fw-semibold">Hey hi.!</span>
                                                            </div>
                                                        </div>
                                                        <div class="badge bg-light px-2 rounded-pill text-dark">
                                                            <span class="fs-11 ms-auto fw-semibold d-inline-flex"><i class="ri-map-pin-line fs-10 me-1 text-success"></i>Canada</span>
                                                        </div>
                                                        <div class="btn-list d-flex">
                                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-secondary-light btn-wave waves-effect waves-light" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" aria-label="Chat">
                                                                <i class="bi bi-chat-dots"></i>
                                                            </a>
                                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-primary-light btn-wave waves-effect waves-light" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" aria-label="View">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-sm avatar-rounded online me-2">
                                                                <img src="assets/images/faces/4.jpg" alt="user-img">
                                                            </div>
                                                            <div class="lh-1">
                                                                <a href="javascript:void(0);" class="mb-1 fw-semibold fs-13 d-block">Travegh</a>
                                                                <span class="fs-11 text-muted fw-semibold">Hey hi.!</span>
                                                            </div>
                                                        </div>
                                                        <div class="badge bg-light px-2 rounded-pill text-dark">
                                                            <span class="fs-11 ms-auto fw-semibold d-inline-flex"><i class="ri-map-pin-line fs-10 me-1 text-success"></i>London</span>
                                                        </div>
                                                        <div class="btn-list d-flex">
                                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-secondary-light btn-wave waves-effect waves-light" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" aria-label="Chat">
                                                                <i class="bi bi-chat-dots"></i>
                                                            </a>
                                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-primary-light btn-wave waves-effect waves-light" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" aria-label="View">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-sm avatar-rounded me-2">
                                                                <img src="assets/images/faces/7.jpg" alt="user-img">
                                                            </div>
                                                            <div class="lh-1">
                                                                <a href="javascript:void(0);" class="mb-1 fw-semibold fs-13 d-block">Ropesg</a>
                                                                <span class="fs-11 text-muted fw-semibold">Hey hi.!</span>
                                                            </div>
                                                        </div>
                                                        <div class="badge bg-light px-2 rounded-pill text-dark">
                                                            <span class="fs-11 ms-auto fw-semibold d-inline-flex"><i class="ri-map-pin-line fs-10 me-1 text-success"></i>America</span>
                                                        </div>
                                                        <div class="btn-list d-flex">
                                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-secondary-light btn-wave waves-effect waves-light" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-secondary" aria-label="Chat">
                                                                <i class="bi bi-chat-dots"></i>
                                                            </a>
                                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-primary-light btn-wave waves-effect waves-light" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" aria-label="View">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                    <div class="card custom-card overflow-hidden">
                                        <div class="card-header d-flex justify-content-between">
                                            <div class="card-title">New Applicants</div>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-wave btn-primary-light waves-effect waves-light">Today</a>
                                        </div>
                                        <div class="card-body p-2">
                                            <div class="table-responsive">
                                                <table class="table text-nowrap table-hover">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w-50 border-bottom-0">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar avatar-sm me-2">
                                                                        <img src="assets/images/faces/15.jpg" alt="user-img">
                                                                    </div>
                                                                    <div class="lh-1">
                                                                        <p class="mb-1 fw-semibold">Mackeil Jepf</p>
                                                                        <span class="fs-11 text-muted">Applied for a <span class="fw-semibold">Full-stack Developer</span></span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="w-30 border-bottom-0 text-end">
                                                                <a href="javascript:void(0);" class="badge bg-info-transparent">View</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-50 border-bottom-0">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar avatar-sm me-2">
                                                                        <img src="assets/images/faces/8.jpg" alt="user-img">
                                                                    </div>
                                                                    <div class="lh-1">
                                                                        <p class="mb-1 fw-semibold">Rosen Begh</p>
                                                                        <span class="fs-11 text-muted">Applied for a <span class="fw-semibold">UI Designer</span></span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="w-30 border-bottom-0 text-end">
                                                                <a href="javascript:void(0);" class="badge bg-info-transparent br-5">View</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-50 border-bottom-0">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar avatar-sm me-2">
                                                                        <img src="assets/images/faces/13.jpg" alt="user-img">
                                                                    </div>
                                                                    <div class="lh-1">
                                                                        <p class="mb-1 fw-semibold">Joseph George</p>
                                                                        <span class="fs-11 text-muted">Applied for a <span class="fw-semibold">Team Lead</span></span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="w-30 border-bottom-0 text-end">
                                                                <a href="javascript:void(0);" class="badge bg-info-transparent br-5">View</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-50 border-bottom-0">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar avatar-sm me-2">
                                                                        <img src="assets/images/faces/5.jpg" alt="user-img">
                                                                    </div>
                                                                    <div class="lh-1">
                                                                        <p class="mb-1 fw-semibold">RoJesh Marfph</p>
                                                                        <span class="fs-11 text-muted">Applied for a <span> Product Manger</span></span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="w-30 border-bottom-0 text-end">
                                                                <a href="javascript:void(0);" class="badge bg-info-transparent br-5">View</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-50 border-bottom-0">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar avatar-sm me-2">
                                                                        <img src="assets/images/faces/16.jpg" alt="user-img">
                                                                    </div>
                                                                    <div class="lh-1">
                                                                        <p class="mb-1 fw-semibold">Daniel Jackson</p>
                                                                        <span class="fs-11 text-muted">Applied for a <span>Web Developer</span></span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="w-30 border-bottom-0 text-end">
                                                                <a href="javascript:void(0);" class="badge bg-info-transparent br-5">View</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w-50 border-bottom-0">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar avatar-sm me-2">
                                                                        <img src="assets/images/faces/1.jpg" alt="user-img">
                                                                    </div>
                                                                    <div class="lh-1">
                                                                        <p class="mb-1 fw-semibold"> Jackson</p>
                                                                        <span class="fs-11 text-muted">Applied for a <span>Web Developer</span></span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="w-30 border-bottom-0 text-end">
                                                                <a href="javascript:void(0);" class="badge bg-info-transparent br-5">View</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End:: row-7 -->

                            <!-- Start::row-8 -->
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="card custom-card">
                                        <div class="card-header d-flex align-items-start justify-content-between">
                                            <div class="flex-1">
                                                <div class="card-title">Quick Transfer</div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row d-lg-flex d-none mb-2 g-0">
                                                <div class="col">
                                                    <a href="chat.html" class="avatar-sm avatar-status rounded-circle">
                                                        <img src="assets/images/faces/2.jpg" alt="img" class="avatar avatar-md rounded-circle">
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <a href="chat.html" class="avatar-sm avatar-status rounded-circle">
                                                        <img src="assets/images/faces/3.jpg" alt="img" class="avatar avatar-md rounded-circle">
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <a href="chat.html" class="avatar-sm avatar-status offline rounded-circle">
                                                        <img src="assets/images/faces/13.jpg" alt="img" class="avatar avatar-md rounded-circle">
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <a href="chat.html" class="avatar-sm avatar-status rounded-circle">
                                                        <img src="assets/images/faces/6.jpg" alt="img" class="avatar avatar-md rounded-circle">
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <a href="chat.html" class="avatar-sm avatar-status offline rounded-circle">
                                                        <img src="assets/images/faces/9.jpg" alt="img" class="avatar avatar-md rounded-circle">
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <a href="chat.html" class="avatar-sm avatar-status offline rounded-circle">
                                                        <img src="assets/images/faces/1.jpg" alt="img" class="avatar avatar-md rounded-circle">
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <a aria-label="anchor" href="contacts.html" class="avatar avatar-md rounded-circle btn btn-light text-primary">
                                                        <i class="fe fe-chevron-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <p class="mb-3 text-muted">Send / Receive</p>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-text">Send To</span>
                                                    <input type="text" class="form-control" placeholder="Account Number" value="11167731611">
                                                    <a href="javascript:void(0);" class="input-group-text btn btn-primary-light btn-sm lh-lg">Check</a>
                                                </div>
                                                <label class="form-label mt-1 mb-3 fs-12 text-success">Sayi Hii...</label>
                                            </div>
                                            <div class="form-group mb-4">
                                                <div class="input-group">
                                                    <span class="input-group-text">Amount</span>
                                                    <input type="text" class="form-control" placeholder="Amount" value="2000">
                                                </div>
                                            </div>
                                            <div class="btn-list d-flex">
                                                <a aria-label="anchor" href="javascript:void(0);" class="btn btn-primary-light"><i class="bi bi-arrow-down-up ms-2"></i></a>
                                                <a href="javascript:void(0);" class="btn btn-primary flex-1"><i class="bi bi-send me-3 fs-14"></i>Proceed To Pay</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="card custom-card">
                                        <div class="card-header">
                                            <div class="card-title">Recent Applicants</div>
                                        </div>
                                        <div class="card-body">
                                            <div id="views"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="card custom-card contactus-form overflow-hidden">
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="mb-4">
                                                        <h5 class="card-title mb-1">Contact Information</h5>
                                                        <p class="text-muted mb-0">Fill up the Form our team will be get back to you</p>
                                                    </div>
                                                    <div>
                                                        <div class="d-flex align-items-top mt-2">
                                                            <div class="me-3">
                                                                <span class="avatar avatar-md p-2 bg-info-transparent">
                                                                    <i class="bx bxs-phone"></i>
                                                                </span>
                                                            </div>
                                                            <div class="flex-fill">
                                                                <div class=" mb-1 align-items-top">
                                                                    <h6 class="fw-semibold mb-1 lh-1">Phone number</h6>
                                                                    <span class="text-muted">+ 01 234 567 88</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-top mt-4">
                                                            <div class="me-3">
                                                                <span class="avatar avatar-md p-2 bg-pink-transparent">
                                                                    <i class="bx bxs-envelope" ></i>
                                                                </span>
                                                            </div>
                                                            <div class="flex-fill">
                                                                <div class=" mb-1 align-items-top">
                                                                    <h6 class="fw-semibold mb-1 lh-1">Email Address</h6>
                                                                    <span class="text-muted">Alizver873@example.com</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-top mt-4">
                                                            <div class="me-3">
                                                                <span class="avatar avatar-md p-2 bg-teal-transparent">
                                                                    <i class="bx bxs-time" ></i>
                                                                </span>
                                                            </div>
                                                            <div class="flex-fill">
                                                                <div class=" mb-1 align-items-top">
                                                                    <h6 class="fw-semibold mb-1 lh-1">Timings</h6>
                                                                    <span class="text-muted">Mon-Fri 09:00 to 06:00</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-top mt-4">
                                                            <div class="me-3">
                                                                <span class="avatar avatar-md p-2 bg-warning-transparent">
                                                                    <i class="bx bxs-location-plus" ></i>
                                                                </span>
                                                            </div>
                                                            <div class="flex-fill">
                                                                <div class=" mb-1 align-items-top">
                                                                    <h6 class="fw-semibold mb-1 lh-1">Address</h6>
                                                                    <span class="text-muted">New York, NY 10012, US-52014</span>
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
                            <!-- End::row-8 -->

                        </div>
                    </div>
                    <!-- END APP CONTENT -->


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
                                        <a  href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>People<span></span></a>
                                        <a  href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>Pages<span></span></a>
                                        <a  href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>Articles<span></span></a>
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
                                                <a href="javascript:void(0)"  class="text-primary"><u>http://spruko/demo/spruko.com</u></a>
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
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#orders-1" aria-current="page" ><i class="bx bx-user-plus me-1 fs-16 align-middle"></i>Team</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#accepted-1"><i
                                    class="bx bx-pulse me-1 fs-16 align-middle"></i>Timeline</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#declined-1"><i
                            class="bx bx-message-square-dots me-1 fs-16 align-middle"></i>Chat</button>
                        </li>
                    </ul>
                    <div class="ms-auto my-auto">
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"> <i
                                class="bx bx-x sidebar-btn-close"></i></button>
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
                                        <a href="javascript:void(0);" class="btn-outline-light btn btn-sm text-muted"
                                            data-bs-toggle="dropdown" aria-expanded="false">
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
                                            <a href="profile.html"><img src="assets/images/faces/16.jpg" alt="img"
                                                    class="avatar avatar-md rounded-2 me-3"></a>
                                            <div class="me-3">
                                                <a href="profile.html">
                                                    <h6 class="mb-0 fw-semibold text-default">Vanessa James</h6>
                                                </a>
                                                <span class="clearfix"></span>
                                                <span class="fs-12 text-muted">Front-end Developer</span>
                                            </div>
                                            <a aria-label="anchor" href="javascript:void(0);" class="ms-auto my-auto"> <i
                                                    class="ri-arrow-right-s-line text-muted fs-20"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="rounded-2 p-3 border mb-2">
                                        <div class="d-flex">
                                            <a href="profile.html"><span
                                                    class="avatar avatar-md rounded-2 bg-primary-transparent text-primary me-3">KH</span></a>
                                            <div class="me-3">
                                                <a href="profile.html">
                                                    <h6 class="mb-0 fw-semibold text-default">Kriti Harris</h6>
                                                </a>
                                                <span class="clearfix"></span>
                                                <span class="fs-12 text-muted">Back-end Developer</span>
                                            </div>
                                            <a aria-label="anchor" href="javascript:void(0);" class="ms-auto my-auto"> <i
                                                    class="ri-arrow-right-s-line text-muted fs-20"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="rounded-2 p-3 border mb-2">
                                        <div class="d-flex">
                                            <a href="profile.html"><img src="assets/images/faces/6.jpg" alt="img"
                                                    class="avatar avatar-md rounded-2 me-3"></a>
                                            <div class="me-3">
                                                <a href="profile.html">
                                                    <h6 class="mb-0 fw-semibold text-default">Mira Henry</h6>
                                                </a>
                                                <span class="clearfix"></span>
                                                <span class="fs-12 text-muted">UI / UX Designer</span>
                                            </div>
                                            <a aria-label="anchor" href="javascript:void(0);" class="ms-auto my-auto"> <i
                                                    class="ri-arrow-right-s-line text-muted fs-20"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="rounded-2 p-3 border mb-2">
                                        <div class="d-flex">
                                            <a href="profile.html"><span
                                                    class="avatar avatar-md rounded-2 bg-secondary-transparent text-secondary me-3">JK</span></a>
                                            <div class="me-3">
                                                <a href="profile.html">
                                                    <h6 class="mb-0 fw-semibold text-default">James Kimberly</h6>
                                                </a>
                                                <span class="clearfix"></span>
                                                <span class="fs-12 text-muted">Angular Developer</span>
                                            </div>
                                            <a aria-label="anchor" href="javascript:void(0);" class="ms-auto my-auto"> <i
                                                    class="ri-arrow-right-s-line text-muted fs-20"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="rounded-2 p-3 border mb-2">
                                        <div class="d-flex">
                                            <a href="profile.html"><img src="assets/images/faces/9.jpg" alt="img"
                                                    class="avatar avatar-md rounded-2 me-3"></a>
                                            <div class="me-3">
                                                <a href="profile.html">
                                                    <h6 class="mb-0 fw-semibold text-default">Marley Paul</h6>
                                                </a>
                                                <span class="clearfix"></span>
                                                <span class="fs-12 text-muted">Front-end Developer</span>
                                            </div>
                                            <a aria-label="anchor" href="javascript:void(0);" class="ms-auto my-auto"> <i
                                                    class="ri-arrow-right-s-line text-muted fs-20"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="rounded-2 p-3 border mb-2">
                                        <div class="d-flex">
                                            <a href="profile.html"><span
                                                    class="avatar avatar-md rounded-2 bg-success-transparent text-success me-3">MA</span></a>
                                            <div class="me-3">
                                                <a href="profile.html">
                                                    <h6 class="mb-0 fw-semibold text-default">Mitrona Anna</h6>
                                                </a>
                                                <span class="clearfix"></span>
                                                <span class="fs-12 text-muted">UI / UX Designer</span>
                                            </div>
                                            <a aria-label="anchor" href="javascript:void(0);" class="ms-auto my-auto"> <i
                                                    class="ri-arrow-right-s-line text-muted fs-20"></i></a>
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
                                            <a href="profile.html"><img src="assets/images/faces/14.jpg" alt="img"
                                                    class="avatar avatar-xs rounded-2 me-3"></a>
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
                                            <span class="avatar avatar-xs brround bg-primary"><i
                                                    class="ri-shield-line text-white"></i></span>
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
                                            <a href="profile.html"><img src="assets/images/faces/11.jpg" alt="img"
                                                    class="avatar avatar-xs rounded-2 me-3"></a>
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
                                            <a href="profile.html"><img src="assets/images/faces/16.jpg" alt="img"
                                                    class="avatar avatar-xs rounded-2 me-3"></a>
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
                                        <a href="profile.html"><img src="assets/images/faces/16.jpg" alt="img"
                                                class="avatar avatar-md rounded-2"></a>
                                    </div>
                                    <div class="">
                                        <a href="chat.html">
                                            <h6 class="fw-semibold mb-0">Leon Ray</h6>
                                            <p class="mb-0 fs-12 text-muted"> 2 mins ago </p>
                                        </a>
                                    </div>
                                    <div class="ms-auto">
                                        <a aria-label="anchor" href="javascript:void(0);"
                                            class="btn btn-sm btn-outline-light  me-1"><i
                                                class="ri-phone-line text-success"></i></a>
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light"><i
                                                class="ri-chat-3-line text-primary"></i></a>
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
                                        <a aria-label="anchor" href="javascript:void(0);"
                                            class="btn btn-sm btn-outline-light  me-1"><i
                                                class="ri-phone-line text-success"></i></a>
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light"><i
                                                class="ri-chat-3-line text-primary"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex align-items-center">
                                    <div class="me-2">
                                        <a href="profile.html"><img src="assets/images/faces/16.jpg" alt="img"
                                                class="avatar avatar-md rounded-2"></a>
                                    </div>
                                    <div class="">
                                        <a href="chat.html">
                                            <h6 class="fw-semibold mb-0">Zelda Perkins</h6>
                                            <p class="mb-0 fs-12 text-muted"> 3 hours ago </p>
                                        </a>
                                    </div>
                                    <div class="ms-auto">
                                        <a aria-label="anchor" href="javascript:void(0);"
                                            class="btn btn-sm btn-outline-light  me-1"><i
                                                class="ri-phone-line text-success"></i></a>
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light"><i
                                                class="ri-chat-3-line text-primary"></i></a>
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
                                        <a aria-label="anchor" href="javascript:void(0);"
                                            class="btn btn-sm btn-outline-light  me-1"><i
                                                class="ri-phone-line text-success"></i></a>
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light"><i
                                                class="ri-chat-3-line text-primary"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex align-items-center">
                                    <div class="me-2">
                                        <a href="profile.html"><img src="assets/images/faces/16.jpg" alt="img"
                                                class="avatar avatar-md rounded-2"></a>
                                    </div>
                                    <div class="">
                                        <a href="chat.html">
                                            <h6 class="fw-semibold mb-0">Roger Bradley</h6>
                                            <p class="mb-0 fs-12 text-muted"> 01:00 pm </p>
                                        </a>
                                    </div>
                                    <div class="ms-auto">
                                        <a aria-label="anchor" href="javascript:void(0);"
                                            class="btn btn-sm btn-outline-light  me-1"><i
                                                class="ri-phone-line text-success"></i></a>
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light"><i
                                                class="ri-chat-3-line text-primary"></i></a>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex align-items-center">
                                    <div class="me-2">
                                        <a href="profile.html"><img src="assets/images/faces/16.jpg" alt="img"
                                                class="avatar avatar-md rounded-2"></a>
                                    </div>
                                    <div class="">
                                        <a href="chat.html">
                                            <h6 class="fw-semibold mb-0">Magnus Haynes</h6>
                                            <p class="mb-0 fs-12 text-muted"> 03:53 pm </p>
                                        </a>
                                    </div>
                                    <div class="ms-auto">
                                        <a aria-label="anchor" href="javascript:void(0);"
                                            class="btn btn-sm btn-outline-light  me-1"><i
                                                class="ri-phone-line text-success"></i></a>
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light"><i
                                                class="ri-chat-3-line text-primary"></i></a>
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
                                        <a aria-label="anchor" href="javascript:void(0);"
                                            class="btn btn-sm btn-outline-light  me-1"><i
                                                class="ri-phone-line text-success"></i></a>
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light"><i
                                                class="ri-chat-3-line text-primary"></i></a>
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
                                        <a aria-label="anchor" href="javascript:void(0);"
                                            class="btn btn-sm btn-outline-light  me-1"><i
                                                class="ri-phone-line text-success"></i></a>
                                        <a aria-label="anchor" href="javascript:void(0);" class="btn btn-sm btn-outline-light"><i
                                                class="ri-chat-3-line text-primary"></i></a>
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

            <!-- FOOTER -->
            
            <footer class="footer mt-auto py-3 bg-white text-center">
                <div class="container">
                    <span class="text-muted"> Copyright © <span id="year"></span> <a
                            href="javascript:void(0);" class="text-dark fw-semibold">Velvet</a>.
                        Designed with <span class="bi bi-heart-fill text-danger"></span> by <a href="javascript:void(0);">
                            <span class="fw-semibold text-primary text-decoration-underline">Spruko</span>
                        </a> All
                        rights
                        reserved
                    </span>
                </div>
            </footer>
            <!-- END FOOTER -->

		</div>
        <!-- END PAGE-->

        <!-- SCRIPTS -->

        
        <!-- SCROLL-TO-TOP -->
        <div class="scrollToTop">
                <span class="arrow"><i class="ri-arrow-up-circle-fill fs-20"></i></span>
        </div>
        <div id="responsive-overlay"></div>

        <!-- POPPER JS -->
        <script src="assets/libs/%40popperjs/core/umd/popper.min.js"></script>

        <!-- BOOTSTRAP JS -->
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- DATE & TIME PICKER JS -->
        <script src="assets/libs/flatpickr/flatpickr.min.js"></script>
        <script src="assets/js/date%26time_pickers.js"></script>

        <!-- NODE WAVES JS -->
        <script src="assets/libs/node-waves/waves.min.js"></script>

        <!-- SIMPLEBAR JS -->
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/js/simplebar.js"></script>

        <!-- COLOR PICKER JS -->
        <script src="assets/libs/%40simonwep/pickr/pickr.es5.min.js"></script>

        <!-- DEFAULTMENU JS -->
        <script src="assets/js/defaultmenu.js"></script>
        
        <!-- APEX CHARTS JS -->
        <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
        
        <!-- WIDGETS JS -->
        <script src="assets/js/widgets.js"></script>


        <!-- STICKY JS -->
		<script src="assets/js/sticky.js"></script>

        <!-- CUSTOM JS -->
        <script src="assets/js/custom.js"></script>

        <!-- CUSTOM-SWITCHER JS -->
        <script src="assets/js/custom-switcher.js"></script>

        <!-- END SCRIPTS -->

	</body>

<!-- Mirrored from php.spruko.com/velvet/velvet/pages/widgets.php by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 21 Mar 2024 11:40:06 GMT -->
</html>
<!-- This code use for render base file -->