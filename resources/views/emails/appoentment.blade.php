<!DOCTYPE html>
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
        <h4>hi {{$detiles['agentname']}} </h4>
        <h4>You have an appointment today with {{ $detiles['leadsname'] }}</h4>
        <h4>appointment is {{ $detiles['comment'] }}</h4>
    </div>

</body>
