<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Student Dashboard - Online Courses & Education Bootstrap5 Template</title>
    <meta name="robots" content="noindex, follow">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/favicon.png">

    <!-- CSS
	============================================ -->
    <link rel="stylesheet" href="../assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/vendor/slick.css">
    <link rel="stylesheet" href="../assets/css/vendor/slick-theme.css">
    <link rel="stylesheet" href="../assets/css/plugins/sal.css">
    <link rel="stylesheet" href="../assets/css/plugins/feather.css">
    <link rel="stylesheet" href="../assets/css/plugins/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/css/plugins/euclid-circulara.css">
    <link rel="stylesheet" href="../assets/css/plugins/swiper.css">
    <link rel="stylesheet" href="../assets/css/plugins/odometer.css">
    <link rel="stylesheet" href="../assets/css/plugins/animation.css">
    <link rel="stylesheet" href="../assets/css/plugins/bootstrap-select.min.css">
    <link rel="stylesheet" href="../assets/css/plugins/jquery-ui.css">
    <link rel="stylesheet" href="../assets/css/plugins/magnigy-popup.min.css">
    <link rel="stylesheet" href="../assets/css/plugins/plyr.css">
    <link rel="stylesheet" href="../assets/css/plugins/jodit.min.css">

    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
<div class="rbt-page-banner-wrapper">
        <!-- Start Banner BG Image  -->
        <div class="rbt-banner-image"></div>
        <!-- End Banner BG Image  -->
    </div>
    <!-- Start Card Style -->
    <div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Start Dashboard Top  -->
                    <div class="rbt-dashboard-content-wrapper">
                        <div class="tutor-bg-photo bg_image bg_image--23 height-245"></div>
                        <!-- Start Tutor Information  -->
                        <div class="rbt-tutor-information">
                            <div class="rbt-tutor-information-left">
                                <div class="thumbnail rbt-avatars size-lg">
                                    <img src="../assets/images/banner/user.png" alt="Instructor">
                                </div>
                                <div class="tutor-content">
                                    <h5 class="title">{{ $userData['surname'] }} {{ $userData['name'] }}</h5>
                                    <ul class="rbt-meta rbt-meta-white mt--5">
                                        <li><i class="feather-book"></i>2 ta fan tanlangan</li>
                                        <li><i class="feather-list"></i>Tarif: bir oylik</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="rbt-tutor-information-right">
                                <div class="tutor-btn">
                                    <a class="rbt-btn btn-md hover-icon-reverse" href="/user/logout">
                                        <span class="icon-reverse-wrapper">
                        <span class="btn-text">Tizimdan chiqish</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- End Tutor Information  -->
                    </div>
                    <!-- End Dashboard Top  -->

                    <div class="row g-5">
                        <div class="col-lg-3">
                            <!-- Start Dashboard Sidebar  -->
                            <div class="rbt-default-sidebar sticky-top rbt-shadow-box rbt-gradient-border">
                                <div class="inner">
                                    <div class="content-item-content">

                                        <div class="rbt-default-sidebar-wrapper">
                                            <div class="section-title mb--20">
                                                <h6 class="rbt-title-style-2">Shaxsiy kabinet</h6>
                                            </div>
                                            <nav class="mainmenu-nav">
                                                <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                                                    <li><a href="/user/main" class="{{ request()->is('user/main') ? 'active' : '' }}"><i class="feather-home"></i><span>Asosiy</span></a></li>
                                                    <li><a href="/user/data" class="{{ request()->is('user/data') ? 'active' : '' }}"><i class="feather-user"></i><span>Ma’lumotlar</span></a></li>
                                                    <li><a href="/user/results" class="{{ request()->is('user/results') ? 'active' : '' }}"><i class="feather-help-circle"></i><span>Natijalar</span></a></li>
                                                    <li><a href="/user/ranking" class="{{ request()->is('user/ranking') ? 'active' : '' }}"><i class="feather-star"></i><span>Reyting</span></a></li>
                                                    <li><a href="/user/invoice" class="{{ request()->is('user/invoice') ? 'active' : '' }}"><i class="feather-shopping-bag"></i><span>To‘lovlar tarixi</span></a></li>
                                                    <li><a href="/user/setting" class="{{ request()->is('user/setting') ? 'active' : '' }}"><i class="feather-settings"></i><span>Sozlamalar</span></a></li>
                                                    <li><a href="/user/logout"><i class="feather-log-out"></i><span>Chiqish</span></a></li>
                                                </ul>
                                            </nav>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End Dashboard Sidebar  -->
                        </div>
@yield('main')
    <!-- Start Footer aera -->
    <footer class="rbt-footer footer-style-1">
        <div class="footer-top">
            <div class="container">
                <div class="row row--15 mt_dec--30">
                    <div class="col-lg-5 col-md-6 col-sm-6 col-12 mt--30">
                        <div class="footer-widget">
                            <div class="logo logo-dark">
                                <a href="#">
                                    <img src="../assets/images/Logo-Main.png" alt="nTest" width="150px">
                                </a>
                            </div>

                            <p class="description mt--20">Fanlarni bo‘limlar, milliy sertifikat va oliy ta’lim <br>tashkilotlariga kirish uchun bilimlarni sinab ko‘rish <br>imkonini beruvchi onlyn test platformasi!
                            </p>

                        </div>
                    </div>


                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt--30">
                        <div class="footer-widget">
                            <h5 class="ft-title">Menyu</h5>
                            <ul class="ft-link">
                                <li>
                                    <a href="#">Loyiha haqida</a>
                                </li>
                                <li>
                                    <a href="#">Narxlar</a>
                                </li>
                                <li>
                                    <a href="#">Statistika</a>
                                </li>
                                <li>
                                    <a href="#">Yangiliklar</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt--30">
                        <div class="footer-widget">
                            <h5 class="ft-title">Biz bilan bog‘lanish</h5>
                            <ul class="ft-link">
                                <li><span>Telefon:</span> <a href="#">(998) 99-835-41-82</a></li>
                                <li><span>E-mail:</span> <a href="mailto:info@ntest.uz">info@ntest.uz</a></li>
                                <li><span>Web-sayt:</span> www.ntest.uz</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer aera -->
    <div class="rbt-separator-mid">
        <div class="container">
            <hr class="rbt-separator m-0">
        </div>
    </div>
    <!-- Start Copyright Area  -->
    <div class="copyright-area copyright-style-1 ptb--20">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-12">
                    <p class="rbt-link-hover text-center text-lg-start">Copyright © 2025 <a href="https://ntest.uz">nTest.</a> Barcha huquqlar himoyalangan</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Copyright Area  -->
    <div class="rbt-progress-parent">
        <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
@if(session('error'))
    <script>
        alert("{{ session('error') }}");
    </script>
@endif

    <!-- JS
============================================ -->
    <!-- Modernizer JS -->
    <script src="../assets/js/vendor/modernizr.min.js"></script>
    <!-- jQuery JS -->
    <script src="../assets/js/vendor/jquery.js"></script>
    <!-- Bootstrap JS -->
    <script src="../assets/js/vendor/bootstrap.min.js"></script>
    <!-- sal.js -->
    <script src="../assets/js/vendor/sal.js"></script>
    <!-- Dark Mode Switcher -->
    <script src="../assets/js/vendor/js.cookie.js"></script>
    <script src="../assets/js/vendor/jquery.style.switcher.js"></script>
    <script src="../assets/js/vendor/swiper.js"></script>
    <script src="../assets/js/vendor/jquery-appear.js"></script>
    <script src="../assets/js/vendor/odometer.js"></script>
    <script src="../assets/js/vendor/backtotop.js"></script>
    <script src="../assets/js/vendor/isotop.js"></script>
    <script src="../assets/js/vendor/imageloaded.js"></script>

    <script src="../assets/js/vendor/wow.js"></script>
    <script src="../assets/js/vendor/waypoint.min.js"></script>
    <script src="../assets/js/vendor/easypie.js"></script>
    <script src="../assets/js/vendor/text-type.js"></script>
    <script src="../assets/js/vendor/jquery-one-page-nav.js"></script>
    <script src="../assets/js/vendor/bootstrap-select.min.js"></script>
    <script src="../assets/js/vendor/jquery-ui.js"></script>
    <script src="../assets/js/vendor/magnify-popup.min.js"></script>
    <script src="../assets/js/vendor/paralax-scroll.js"></script>
    <script src="../assets/js/vendor/paralax.min.js"></script>
    <script src="../assets/js/vendor/countdown.js"></script>
    <script src="../assets/js/vendor/plyr.js"></script>
    <script src="../assets/js/vendor/jodit.min.js"></script>
    <script src="../assets/js/vendor/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

   @yield('script')
</body>
</html>