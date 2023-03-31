<html>
<head>
    <title></title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha256-UzFD2WYH2U1dQpKDjjZK72VtPeWP50NoJjd26rnAdUI=" crossorigin="anonymous" />

    <style>
    </style>

</head>
<body>
<table>
        <tr>
            <th>Name</th>
            <th>{{ $data['name'] ?? NULL }}</th>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $data['email'] ?? NULL }}</td>
        </tr>
        <tr>
            <td>URL</td>
            <td> <a href="https://shifti.mamundevstudios.com/signup"> https://shifti.mamundevstudios.com/signup </a></td>
        </tr>
    </table>
</body>
</html>
