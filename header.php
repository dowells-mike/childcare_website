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
                <?php if(isset($_SESSION['parent_id'])) { ?>
                    <li><a href="parent_dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php } elseif(isset($_SESSION['admin_id'])) { ?>
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php } else { ?>
                    <li><a href="login.php">Parent Login</a></li>
                    <li><a href="login.php">Admin Login</a></li>
                <?php } ?>
            </ul>
            <form class="navbar-form navbar-right" action="search.php" method="get">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search" name="q">
                </div>
                <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
            </form>
            <?php if(isset($_SESSION['parent_id'])) { ?>
                <p class="navbar-text navbar-right">Logged in as Parent</p>
            <?php } elseif(isset($_SESSION['admin_id'])) { ?>
                <p class="navbar-text navbar-right">Logged in as Admin</p>
            <?php } ?>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
