
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>appoentment Information</title>
    <style>
        .body{
            width: 80%;
            margin: auto
        }
    </style>
</head>
<body>
    <div class="body">
        <h4>hi {{ $detiles['username'] }}</h4>
        <h4>You have an appointment today</h4>
        <h4>event title: {{ $detiles['title'] }}</h4>
        <h4>event location: {{ $detiles['location'] }}</h4>
        <h4>event description: {{ $detiles['description'] }}</h4>
    </div>

</body>
