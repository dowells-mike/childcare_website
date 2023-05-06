<?php
session_start();
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services and Facilities</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="service.css">
    <script>
        $(document).ready(function() {
            $('.thumbnail').hover(function() {
                $(this).animate({
                    height: '+=10px'
                }, 'fast');
            }, function() {
                $(this).animate({
                    height: '-=10px'
                }, 'fast');
            });
        });
    </script>
</head>

<body>
    <div class="container">
        <h2>Services and Facilities</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="thumbnail">
                    <img src="path/to/photo1.jpg" alt="Service 1">
                    <div class="caption">
                        <h3>Service 1</h3>
                        <p>Summary of Service 1.</p>
                        <p><a href="service1.html" class="btn btn-primary" role="button">Learn More</a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="thumbnail">
                    <img src="path/to/photo2.jpg" alt="Service 2">
                    <div class="caption">
                        <h3>Service 2</h3>
                        <p>Summary of Service 2.</p>
                        <p><a href="service2.html" class="btn btn-primary" role="button">Learn More</a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="thumbnail">
                    <img src="path/to/photo3.jpg" alt="Service 3">
                    <div class="caption">
                        <h3>Service 3</h3>
                        <p>Summary of Service 3.</p>
                        <p><a href="service3.html" class="btn btn-primary" role="button">Learn More</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>