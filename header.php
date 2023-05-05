<nav class="navbar navbar-light navbar-expand-md sticky-top shadow py-3" style="background: #ffd870;">
    <div class="container"><a class="navbar-brand d-flex align-items-center rubberBand animated" href="#"><span
                class="bs-icon-md bs-icon-rounded bs-icon-primary border rounded-circle d-flex justify-content-center align-items-center me-2 bs-icon"
                style="background: rgb(26,71,85);border-style: none;"><svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512" width="1em" height="1em" fill="currentColor" style="color: rgb(187,210,217);">
                    <!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. -->
                    <path
                        d="M288 167.2V139.1c-28.25-36.38-47.13-79.29-54.13-125.2C231.7 .4054 214.8-5.02 206.1 5.481C184.1 30.36 168.4 59.7 157.2 92.07C191.4 130.3 237.2 156.7 288 167.2zM400 63.97c-44.25 0-79.1 35.82-79.1 80.08l.0014 59.44c-104.4-6.251-193-70.46-233-161.7C81.48 29.25 63.76 28.58 58.01 40.83C41.38 75.96 32.01 115.2 32.01 156.6c0 70.76 34.11 136.9 85.11 185.9c13.12 12.75 26.13 23.27 38.88 32.77L12.12 411.2c-10.75 2.75-15.5 15.09-9.5 24.47c17.38 26.88 60.42 72.54 153.2 76.29c8 .25 15.99-2.633 22.12-7.883l65.23-56.12l76.84 .0561c88.38 0 160-71.49 160-159.9l.0013-160.2l31.1-63.99L400 63.97zM400 160.1c-8.75 0-16.01-7.259-16.01-16.01c0-8.876 7.261-16.05 16.01-16.05s15.99 7.136 15.99 16.01C416 152.8 408.8 160.1 400 160.1z">
                    </path>
                </svg></span><span class="fs-2 fw-semibold" style="font-family: Aclonica, sans-serif;"><strong><span
                        style="color: rgb(26, 71, 85);">Cozy</span><span
                        style="color: rgb(187, 210, 217);">Cubs</span></strong></span></a><button
            data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span
                class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-1" style="font-family: Aclonica, sans-serif;">
            <ul class="navbar-nav me-auto">
                <li class="nav-item <?php if (basename($_SERVER["PHP_SELF"]) == "index.php") {echo "active";} ?>"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item <?php if (basename($_SERVER["PHP_SELF"]) == "services.php") { echo "active";} ?>"><a class="nav-link" href="services.php">Services</a></li>
                <li class="nav-item <?php if (basename($_SERVER["PHP_SELF"]) == "testimonial.php") { echo "active";} ?>"><a class="nav-link" href="testimonial.php">Testimonials</a></li>
                <li class="nav-item <?php if ( basename($_SERVER["PHP_SELF"]) == "dayDetails.php") {echo "active"; } ?>"><a class="nav-link" href="dayDetails.php">Day Details</a></li>
                <li class="nav-item <?php if (basename($_SERVER["PHP_SELF"]) == "contact_us.php") { echo "active";} ?>"><a class="nav-link" href="contact_us.php">Contact Us</a></li>
            </ul>
            <a class="btn btn-primary" role="button" data-bss-hover-animate="pulse" style="background: #ffb4b4;margin: 10px;border-color: rgba(255,255,255,0);" href="registration.php">Register</a>
            <a class="btn btn-primary" role="button" data-bss-hover-animate="pulse" style="background: rgb(187,210,217);border-style: none;" href="login.php">Log In</a>
        </div>
    </div>
</nav>

<!--Scripts for header-->
<script src="assets_navbar_user/bootstrap/js/bootstrap.min.js"></script>
<script src="assets_navbar_user/js/bs-init.js"></script>