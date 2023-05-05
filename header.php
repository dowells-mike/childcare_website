<?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "member") { ?>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Childcare Premises</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="dayDetails.php">Day details</a></li>
                    <li><a href="testimonial_add.php">Testimonial add</a></li>
                    <li><a href="contact_us.php">Contact Us</a></li>
                    <li><a href="registration.php">Register child</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php">Logged-in User: <?php echo $_SESSION["username"]; ?></a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php } elseif (
                isset($_SESSION["role"]) &&
                $_SESSION["role"] === "admin"
            ) { ?>
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="index.php">Childcare Premises</a>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                                <style>
                                    .dropdown:hover .dropdown-menu {
                                        display: block;
                                    }
                                </style>

                                <ul class="nav navbar-nav">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Home <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="index.php">View</a></li>
                                            <li><a href="index_edit.php">Edit</a></li>
                                            <li><a href="services.php">Services</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Day Details <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="dayDetails.php">View</a></li>
                                            <li><a href="day_details_edit.php">Edit</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Testimonials <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="testimonial.php">View</a></li>
                                            <li><a href="testimonial_add.php">insert</a></li>
                                            <li><a href="testimonial_manage.php">Manage</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Register Child <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="registration.php">View</a></li>
                                            <li><a href="registration_edit.php">Manage</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="contact_us.php">Contact Us</a></li>
                                </ul>


                                <ul class="nav navbar-nav navbar-right">
                                    <li><a href="index.php">Logged-in Admin <?php echo $_SESSION["username"]; ?></a></li>
                                    <li><a href="logout.php">Logout</a></li>
                                <?php } else { ?>
                                    <nav class="navbar navbar-default">
                                        <div class="container-fluid">
                                            <!-- Brand and toggle get grouped for better mobile display -->
                                            <div class="navbar-header">
                                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                                                    <span class="sr-only">Toggle navigation</span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                </button>
                                                <a class="navbar-brand" href="index.php">Childcare Premises</a>
                                            </div>

                                            <!-- Collect the nav links, forms, and other content for toggling -->
                                            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                                                <ul class="nav navbar-nav">
                                                    <li><a href="index.php">Home</a></li>
                                                    <li><a href="services.php">Services</a></li>
                                                    <li><a href="testimonial.php">Testimonials</a></li>
                                                    <li><a href="contact_us.php">Contact Us</a></li>
                                                </ul>
                                                <ul class="nav navbar-nav navbar-right">
                                                    <li><a href="login.php">Login</a></li>
                                                <?php } ?>
                                                </ul>


                                            </div><!-- /.navbar-collapse -->
                                        </div><!-- /.container-fluid -->
                                    </nav>