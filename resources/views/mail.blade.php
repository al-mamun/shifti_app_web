<html>
<head>
    <title>ORPONBD | Confirmation</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha256-UzFD2WYH2U1dQpKDjjZK72VtPeWP50NoJjd26rnAdUI=" crossorigin="anonymous" />

    <style>
    </style>

</head>
<body>
<div class="obd-order-template-main" style="max-width: 600px; margin: 0 auto;background-color: #f9f9f9;height: auto;border-radius: 5px;padding-bottom: 25px;">
    <!-- Logo Section -->
    <div class="obd-logo-main-section" style="position: relative;">
        <div class="obd-logo-sect" style="text-align: left; margin-top: 5px; padding-top: 22px">
            <a href="{{env('APP_URL')}}">
                <img src="{{env('API_URL')}}/images/logo.png" alt="" style="width: 162px; margin-left: 25px;">
            </a>
        </div>
        <div class="obd-my-order-ttxt">
            <a href="/" style="font-size: 17px;font-family: 'Titillium Web', sans-serif;font-weight: 600;color: #f97058;right: 26px;top: 29px;position: absolute;text-decoration: none;">
                My Orders
            </a>
        </div>
    </div>
    <!-- Logo Section End -->

    <!-- Content Box -->
    <div class="obd-content-main-box" style="width: 570px;background-color: #fff;border-radius: 6px;margin-left: 15px;margin-top: 20px;padding-bottom: 5px;">
        <div class="obd-cont-head-txt">
            <h3 style="font-size: 22px;font-family: 'Titillium Web', sans-serif;font-weight: 700;color: #484848;margin-left: 18px;padding-top: 12px;">
                Your order has been received!
            </h3>
        </div>
        <div class="obd-cont-paragrp-txt" style="margin-top: -9px">
            <h5 style="font-size: 14px;color: #4f4f4f;font-weight: 600;font-family: 'Titillium Web', sans-serif;margin-top: -6px;letter-spacing: 1px;margin-left: 20px;">
                Hi, {{  $data['name'] }}  Here.
            </h5>
            <p style="font-family: 'Titillium Web', sans-serif;font-size: 15px;color: #878787;margin-left: 20px;">
                We have received your order request for <a href="" style="    margin-left: 6px;font-weight: 600;color: #ff8069;"># </a> <br><br>

                To confirm your order please click on "Pay Invoice" button, choose your desired payment method and complete your payment.
            </p>
        </div>
        <div class="obd-buttonsec-box" style="margin-top: 35px;margin-bottom: 25px;">
            <a href="{{env('APP_URL').'/customer/order-details-page/'}}" style="margin-left: 20px;background-color: #ff6347;color: #fff;border-radius: 6px;font-size: 14px;font-weight: 600;padding: 6px 20px 6px 20px;font-family: 'Titillium Web', sans-serif;text-decoration: none;">
                Pay Invoice
            </a>
        </div>
        <div class="obd-cont-cong-lg">
            <p style="font-family: 'Titillium Web', sans-serif;font-size: 15px;margin-top: 35px;color: #878787;margin-left: 20px;">
                If you have any questions, please let us know!
            </p>
            <h5 style="font-size: 14px;color: #4f4f4f;margin-bottom: 14px;font-weight: 600;font-family: 'Titillium Web', sans-serif;margin-top: -6px;letter-spacing: 1px;margin-left: 20px;">
                Sincerly,
            </h5>
            <img src="https://mamundevstudios.com/shifti_api/public/shifti_logo.png" alt="logo" style="width: 118px;margin-left: 18px;padding-bottom: 20px;">
        </div>
    </div>
    <!-- Content Box -->

    <!-- Order Box -->
    <div class="obd-content-main-box" style="width: 570px;background-color: #fff;border-radius: 6px;margin-left: 15px;margin-top: 20px;padding-bottom: 5px;">
        <div class="obd-cont-ord-txt-lf" style="position: relative;">
            <h4 style="font-size: 16px;font-family: 'Titillium Web', sans-serif;font-weight: 700;color: #484848;margin-left: 18px;padding-top: 12px;">
                Order Details
            </h4>
            <div class="obd-cont-ord-txt-rt">
                <h4 style="font-size: 14px;font-family: 'Titillium Web', sans-serif;font-weight: 400;color: #ec7863;position: absolute;right: 25px;top: -6px;">
                    Order Total : {{ '$'. $data['TotalAmount'] }}  <br>
                   
                </h4>
                <h4 style="font-size: 16px;font-family: 'Titillium Web', sans-serif;font-weight: 700;color: #ff6347;position: absolute;right: 25px;top: -6px;">
                     Total Paid : {{ '$'.$data['TotalAmount'] }} 
                </h4>
            </div>
        </div>

        <!-- Product Box -->
        <div class="obd-product-main-box">
            <table class="table table-bordered" style="width: 100%;border-collapse: collapse;margin-bottom: 43px;">

                <tbody>
           
                </tbody>
            </table>
        </div>
        <!-- Product Box -->
    </div>
    <!-- Order Box -->

    <!-- Footer Start -->
    <div class="obd-em-footer-main" style="margin-top: 25px;position: relative;">
        <div class="obd-footer-logo">
            <a href="{{env('APP_URL')}}">
                <img src="https://mamundevstudios.com/shifti_api/public/shifti_logo.png" alt="logo" style="width: 140px;margin-left: 18px;padding-bottom: 5px;margin-top: 10px;">
            </a>
        </div>
        <div class="obd-footer-rt-cont" style="position: absolute;right: 75px;top: -12px;">
            <p style="font-size: 16px;color: #535353;font-family: 'Titillium Web', sans-serif;margin: 0px;margin-top: 5px;">
                Need more help?
            </p>
            <h5 style="margin: 0px;margin-top: 4px;margin-bottom: 12px;">
                <span style="font-family: 'Titillium Web', sans-serif;font-size: 14px;color: #5f5c5c;margin-right: 3px;font-weight: 500;">Call :</span> <a href="tel:09638-333000" style="font-size: 14px;color: #ef7d69;font-weight: 600;font-family: 'Titillium Web', sans-serif;margin-top: -6px;letter-spacing: 1px;">
                    09638-333000
                </a>
            </h5>
            <a href="{{env('APP_WEB_URL')}}/contact-us" style="background-color: #ff6347;color: #fff;border-radius: 6px;font-size: 11px;font-weight: 600;padding: 4px 16px 4px 16px;font-family: 'Titillium Web', sans-serif;text-decoration: none;">
                Contact Us
            </a>
        </div>
    </div>
    <!-- Footer End -->
 
</div>
</body>
</html>
