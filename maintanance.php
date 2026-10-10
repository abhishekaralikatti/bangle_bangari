<?php
header('HTTP/1.1 503 Service Temporarily Unavailable');
header('Status: 503 Service Temporarily Unavailable');
header('Retry-After: 3600');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Under Maintenance</title>
    <style>
        body{
            margin:0 auto;
            text-align: center;
        }
        .error-box .error-title {
            font-size:  100px;
            font-weight: 900;
            text-shadow: 4px 4px 0 #fff, 6px 6px 0 #343a40;
            line-height: 210px;
        }
        .text-danger {
            color: #da542e!important;
        }
        .text-uppercase {
            text-transform: uppercase!important;
        }
        .h3, h3 {
            font-size: 24px;
        }
        .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
            margin-bottom: 0.5rem;
            font-family: inherit;
            font-weight: 700;
            line-height: 1.2;
            color: inherit;
        }
    </style>
</head>
<body>
	<div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="error-box">
            <div class="error-body text-center">
                <h1 class="error-title text-danger">Under Maintenance</h1>
                <h3 class="text-uppercase error-subtitle">We will be back soon</h3>
        	</div>
    	</div>
    </div>
</body>
</html>
