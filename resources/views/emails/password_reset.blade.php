<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>

<body style="background-color: #d9dffa;">
    
    <div style="background: #fff;
    border-radius: 5px;
    padding: 66px;
    width: 600px;
    margin: 29px auto;">
    <div style="overflow: hidden;
    width: 100%;
    display: block;
    clear: both;
    height: 249px;">
        <h3 style="    text-align: left;
        font-size: 43px;
        color: #506bec;">Forgot your password?</h3>
        <p style="
        width: 100%;
        margin-bottom: 19px;
        font-size: 20px;
    ">Hey, we received a request to reset your password.</p>
        <p style="
            width: 100%;
            margin-bottom: 19px;
            font-size: 20px;
        ">Let’s get you a new one!</p>
    </div>
        <a href="https://shifti.mamundevstudios.com/recovery/password/{{ $data['otp'] }}" style="background-color: #506bec;
        color: #ffffff;
        padding: 15px;
        text-decoration: none;
        text-align: center;
        border-radius: 10px;
        margin-left: 29%;
        margin-top: 50px;
        overflow: hidden;"> RESET MY PASSWORD</a>
    </div>

</body>
</html>

