<?php
$answer = "";

include_once("../assets/php/functions.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DarkPan - Bootstrap 5 Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="assets/css/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="assets/css/style.old.css" rel="stylesheet">

    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
<div class="container-fluid position-relative d-flex p-0">
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Sidebar Start -->
    <?php include_once("assets/components/sidebar.php") ?>
    <!-- Sidebar End -->


    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <?php include_once("assets/components/navbar.php"); ?>
        <!-- Navbar End -->


        <!-- Sale & Revenue Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                        <svg class="fill1" width="48" height="48" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path class="fill1" d="M4.5 20.25C4.30189 20.2474 4.11263 20.1676 3.97253 20.0275C3.83244 19.8874 3.75259 19.6981 3.75 19.5V4.5C3.75 4.30109 3.82902 4.11032 3.96967 3.96967C4.11032 3.82902 4.30109 3.75 4.5 3.75C4.69891 3.75 4.88968 3.82902 5.03033 3.96967C5.17098 4.11032 5.25 4.30109 5.25 4.5V19.5C5.24741 19.6981 5.16756 19.8874 5.02747 20.0275C4.88737 20.1676 4.69811 20.2474 4.5 20.25Z" fill="#000000"></path>
                            <path class="fill1" d="M19.5 20.25H4.5C4.30109 20.25 4.11032 20.171 3.96967 20.0303C3.82902 19.8897 3.75 19.6989 3.75 19.5C3.75 19.3011 3.82902 19.1103 3.96967 18.9697C4.11032 18.829 4.30109 18.75 4.5 18.75H19.5C19.6989 18.75 19.8897 18.829 20.0303 18.9697C20.171 19.1103 20.25 19.3011 20.25 19.5C20.25 19.6989 20.171 19.8897 20.0303 20.0303C19.8897 20.171 19.6989 20.25 19.5 20.25Z" fill="#000000"></path>
                            <path class="fill1" d="M14 14.75C13.9015 14.7504 13.8038 14.7312 13.7128 14.6934C13.6218 14.6557 13.5392 14.6001 13.47 14.53L11 12.06L8.53 14.53C8.38782 14.6624 8.19978 14.7346 8.00548 14.7311C7.81118 14.7277 7.62579 14.649 7.48838 14.5116C7.35096 14.3742 7.27225 14.1888 7.26882 13.9945C7.2654 13.8002 7.33752 13.6121 7.47 13.47L10.47 10.47C10.6106 10.3295 10.8012 10.2506 11 10.2506C11.1987 10.2506 11.3894 10.3295 11.53 10.47L14 12.94L17.47 9.46997C17.6122 9.33749 17.8002 9.26537 17.9945 9.26879C18.1888 9.27222 18.3742 9.35093 18.5116 9.48835C18.649 9.62576 18.7277 9.81115 18.7312 10.0054C18.7346 10.1997 18.6625 10.3878 18.53 10.53L14.53 14.53C14.4608 14.6001 14.3782 14.6557 14.2872 14.6934C14.1962 14.7312 14.0985 14.7504 14 14.75Z" fill="#000000"></path>
                            <path class="fill1" d="M18.5 13.84C18.3019 13.8374 18.1126 13.7576 17.9725 13.6175C17.8324 13.4774 17.7526 13.2881 17.75 13.09V10.25H15C14.8011 10.25 14.6103 10.171 14.4697 10.0303C14.329 9.88968 14.25 9.69891 14.25 9.5C14.25 9.30109 14.329 9.11032 14.4697 8.96967C14.6103 8.82902 14.8011 8.75 15 8.75H18.5C18.6981 8.75259 18.8874 8.83244 19.0275 8.97253C19.1676 9.11263 19.2474 9.30189 19.25 9.5V13.09C19.2474 13.2881 19.1676 13.4774 19.0275 13.6175C18.8874 13.7576 18.6981 13.8374 18.5 13.84Z" fill="#000000"></path>
                        </svg>
                        <div class="ms-3">
                            <p class="mb-2">Today Sale</p>
                            <h6 class="mb-0">$1234</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                        <svg class="fill1" width="48" height="48" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 2H4V18H20V20H2V2M6 16V8H10V16H6M11 16V4H15V16H11M16 16V11H20V16H16Z"></path>
                        </svg>
                        <div class="ms-3">
                            <p class="mb-2">Total Sale</p>
                            <h6 class="mb-0">$1234</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                        <svg class="fill1" width="48" height="48" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M7.90625 1.96875C7.863281 1.976563 7.820313 1.988281 7.78125 2C7.316406 2.105469 6.988281 2.523438 7 3L7 12L16 12C16.359375 12.003906 16.695313 11.816406 16.878906 11.503906C17.058594 11.191406 17.058594 10.808594 16.878906 10.496094C16.695313 10.183594 16.359375 9.996094 16 10L10.3125 10C14.101563 6.292969 19.277344 4 25 4C36.609375 4 46 13.390625 46 25C46 36.609375 36.609375 46 25 46C13.390625 46 4 36.609375 4 25C4 21.527344 4.855469 18.257813 6.34375 15.375L4.5625 14.46875C2.929688 17.625 2 21.207031 2 25C2 37.691406 12.308594 48 25 48C37.691406 48 48 37.691406 48 25C48 12.308594 37.691406 2 25 2C18.773438 2 13.140625 4.503906 9 8.53125L9 3C9.011719 2.710938 8.894531 2.433594 8.6875 2.238281C8.476563 2.039063 8.191406 1.941406 7.90625 1.96875 Z M 25 5C24.449219 5 24 5.449219 24 6C24 6.550781 24.449219 7 25 7C25.550781 7 26 6.550781 26 6C26 5.449219 25.550781 5 25 5 Z M 34.5 7.53125C33.949219 7.53125 33.5 7.980469 33.5 8.53125C33.5 9.082031 33.949219 9.53125 34.5 9.53125C35.050781 9.53125 35.5 9.082031 35.5 8.53125C35.5 7.980469 35.050781 7.53125 34.5 7.53125 Z M 41.46875 14.5C40.917969 14.5 40.46875 14.949219 40.46875 15.5C40.46875 16.050781 40.917969 16.5 41.46875 16.5C42.019531 16.5 42.46875 16.050781 42.46875 15.5C42.46875 14.949219 42.019531 14.5 41.46875 14.5 Z M 18.375 16.90625C15.601563 16.90625 13.625 18.714844 13.625 21.3125L13.625 21.34375L15.6875 21.34375L15.6875 21.3125C15.6875 19.808594 16.726563 18.8125 18.28125 18.8125C19.734375 18.8125 20.84375 19.773438 20.84375 21.0625C20.84375 22.097656 20.386719 22.847656 18.5 24.8125L13.75 29.75L13.75 31.34375L23.25 31.34375L23.25 29.375L16.78125 29.375L16.78125 29.21875L19.9375 26.03125C22.300781 23.640625 23 22.429688 23 20.9375C23 18.613281 21.050781 16.90625 18.375 16.90625 Z M 31.59375 17.25C29.082031 21.011719 26.980469 24.289063 25.71875 26.59375L25.71875 28.625L32.59375 28.625L32.59375 31.34375L34.6875 31.34375L34.6875 28.625L36.65625 28.625L36.65625 26.65625L34.6875 26.65625L34.6875 17.25 Z M 32.5 19.1875L32.625 19.1875L32.625 26.71875L27.8125 26.71875L27.8125 26.5625C29.472656 23.679688 31.105469 21.207031 32.5 19.1875 Z M 6 24C5.449219 24 5 24.449219 5 25C5 25.550781 5.449219 26 6 26C6.550781 26 7 25.550781 7 25C7 24.449219 6.550781 24 6 24 Z M 44 24C43.449219 24 43 24.449219 43 25C43 25.550781 43.449219 26 44 26C44.550781 26 45 25.550781 45 25C45 24.449219 44.550781 24 44 24 Z M 8.53125 33.5C7.980469 33.5 7.53125 33.949219 7.53125 34.5C7.53125 35.050781 7.980469 35.5 8.53125 35.5C9.082031 35.5 9.53125 35.050781 9.53125 34.5C9.53125 33.949219 9.082031 33.5 8.53125 33.5 Z M 41.46875 33.5C40.917969 33.5 40.46875 33.949219 40.46875 34.5C40.46875 35.050781 40.917969 35.5 41.46875 35.5C42.019531 35.5 42.46875 35.050781 42.46875 34.5C42.46875 33.949219 42.019531 33.5 41.46875 33.5 Z M 15.5 40.46875C14.949219 40.46875 14.5 40.917969 14.5 41.46875C14.5 42.019531 14.949219 42.46875 15.5 42.46875C16.050781 42.46875 16.5 42.019531 16.5 41.46875C16.5 40.917969 16.050781 40.46875 15.5 40.46875 Z M 34.5 40.46875C33.949219 40.46875 33.5 40.917969 33.5 41.46875C33.5 42.019531 33.949219 42.46875 34.5 42.46875C35.050781 42.46875 35.5 42.019531 35.5 41.46875C35.5 40.917969 35.050781 40.46875 34.5 40.46875 Z M 25 43C24.449219 43 24 43.449219 24 44C24 44.550781 24.449219 45 25 45C25.550781 45 26 44.550781 26 44C26 43.449219 25.550781 43 25 43Z"></path>
                        </svg>
                        <div class="ms-3">
                            <p class="mb-2">Today Revenue</p>
                            <h6 class="mb-0">$1234</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                        <svg width="48" height="48" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.15" d="M19 20V9H5V20H19Z"></path>
                            <path class="fill1" d="M10 13H14M19 9V20H5V9M19 9H5M19 9C19.5523 9 20 8.55228 20 8V5C20 4.44772 19.5523 4 19 4H5C4.44772 4 4 4.44772 4 5V8C4 8.55228 4.44772 9 5 9" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <div class="ms-3">
                            <p class="mb-2">Total Revenue</p>
                            <h6 class="mb-0">$1234</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sale & Revenue End -->


        <!-- Sales Chart Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-12 col-xl-6">
                    <div class="bg-secondary text-center rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">Worldwide Sales</h6>
                            <a href="">Show All</a>
                        </div>
                        <canvas id="worldwide-sales"></canvas>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-6">
                    <div class="bg-secondary text-center rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">Salse & Revenue</h6>
                            <a href="">Show All</a>
                        </div>
                        <canvas id="salse-revenue"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sales Chart End -->


        <!-- Recent Sales Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Recent Salse</h6>
                    <a href="">Show All</a>
                </div>
                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                        <tr class="text-white">
                            <th scope="col"><input class="form-check-input" type="checkbox"></th>
                            <th scope="col">Date</th>
                            <th scope="col">Invoice</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>01 Jan 2045</td>
                            <td>INV-0123</td>
                            <td>Jhon Doe</td>
                            <td>$123</td>
                            <td>Paid</td>
                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>01 Jan 2045</td>
                            <td>INV-0123</td>
                            <td>Jhon Doe</td>
                            <td>$123</td>
                            <td>Paid</td>
                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>01 Jan 2045</td>
                            <td>INV-0123</td>
                            <td>Jhon Doe</td>
                            <td>$123</td>
                            <td>Paid</td>
                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>01 Jan 2045</td>
                            <td>INV-0123</td>
                            <td>Jhon Doe</td>
                            <td>$123</td>
                            <td>Paid</td>
                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>01 Jan 2045</td>
                            <td>INV-0123</td>
                            <td>Jhon Doe</td>
                            <td>$123</td>
                            <td>Paid</td>
                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Recent Sales End -->


        <!-- Widgets Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-12 col-md-6 col-xl-4">
                    <div class="h-100 bg-secondary rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="mb-0">Messages</h6>
                            <a href="">Show All</a>
                        </div>
                        <div class="d-flex align-items-center border-bottom py-3">
                            <img class="rounded-circle flex-shrink-0" src="assets/img/user.jpg" alt="">
                            <div class="w-100 ms-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-0">Jhon Doe</h6>
                                    <small>15 minutes ago</small>
                                </div>
                                <span>Short message goes here...</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center border-bottom py-3">
                            <img class="rounded-circle flex-shrink-0" src="assets/img/user.jpg" alt="">
                            <div class="w-100 ms-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-0">Jhon Doe</h6>
                                    <small>15 minutes ago</small>
                                </div>
                                <span>Short message goes here...</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center border-bottom py-3">
                            <img class="rounded-circle flex-shrink-0" src="assets/img/user.jpg" alt="">
                            <div class="w-100 ms-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-0">Jhon Doe</h6>
                                    <small>15 minutes ago</small>
                                </div>
                                <span>Short message goes here...</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center pt-3">
                            <img class="rounded-circle flex-shrink-0" src="assets/img/user.jpg" alt="">
                            <div class="w-100 ms-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-0">Jhon Doe</h6>
                                    <small>15 minutes ago</small>
                                </div>
                                <span>Short message goes here...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-4">
                    <div class="h-100 bg-secondary rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">Calender</h6>
                            <a href="">Show All</a>
                        </div>
                        <div id="calender"></div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-4">
                    <div class="h-100 bg-secondary rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">To Do List</h6>
                            <a href="">Show All</a>
                        </div>
                        <div class="d-flex mb-2">
                            <input class="form-control bg-dark border-0" type="text" placeholder="Enter task">
                            <button type="button" class="btn btn-primary ms-2">Add</button>
                        </div>
                        <div class="d-flex align-items-center border-bottom py-2">
                            <input class="form-check-input m-0" type="checkbox">
                            <div class="w-100 ms-3">
                                <div class="d-flex w-100 align-items-center justify-content-between">
                                    <span>Short task goes here...</span>
                                    <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center border-bottom py-2">
                            <input class="form-check-input m-0" type="checkbox">
                            <div class="w-100 ms-3">
                                <div class="d-flex w-100 align-items-center justify-content-between">
                                    <span>Short task goes here...</span>
                                    <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center border-bottom py-2">
                            <input class="form-check-input m-0" type="checkbox" checked>
                            <div class="w-100 ms-3">
                                <div class="d-flex w-100 align-items-center justify-content-between">
                                    <span><del>Short task goes here...</del></span>
                                    <button class="btn btn-sm text-primary"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center border-bottom py-2">
                            <input class="form-check-input m-0" type="checkbox">
                            <div class="w-100 ms-3">
                                <div class="d-flex w-100 align-items-center justify-content-between">
                                    <span>Short task goes here...</span>
                                    <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center pt-2">
                            <input class="form-check-input m-0" type="checkbox">
                            <div class="w-100 ms-3">
                                <div class="d-flex w-100 align-items-center justify-content-between">
                                    <span>Short task goes here...</span>
                                    <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Widgets End -->


        <!-- Footer Start -->
        <?php include_once("assets/components/footer.php"); ?>
        <!-- Footer End -->
    </div>
    <!-- Content End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>

<!-- JavaScript Libraries -->
<script src="assets/js/jquery-3.4.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/chart/chart.min.js"></script>
<script src="assets/js/easing/easing.min.js"></script>
<script src="assets/js/waypoints/waypoints.min.js"></script>
<script src="assets/js/owlcarousel/owl.carousel.min.js"></script>
<script src="assets/js/tempusdominus/js/moment.min.js"></script>
<script src="assets/js/tempusdominus/js/moment-timezone.min.js"></script>
<script src="assets/js/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Template Javascript -->
<script src="assets/js/main.js"></script>
</body>

</html>