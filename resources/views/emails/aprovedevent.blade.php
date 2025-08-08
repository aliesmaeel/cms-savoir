<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>event Information</title>
    <style>
        .body {
            width: 80%;
            margin: auto
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/add-to-calendar-button@1/assets/css/atcb.min.css">
</head>

<body>
    <div class="body">

        <h4>The Event Has Been Approved </h4>
        <h4>Event Name: {{ $event['name'] }}</h4>
        <h4>Event Date: {{ $event['date'] }}</h4>
        <h4>Event Address :{{ $event['address'] }}</h4>
        <h4>Event Description :{{ $event['description'] }} </h4>
        <div class="atcb" style="display:none;">
            {
            "name":"{{ $event['name'] }}",
            "description":"{{ $event['description'] }}:<br>→
            [url]https://github.com/add2cal/add-to-calendar-button[/url]",
            "startDate":"{{ $event['date_format'] }}",
            "endDate":"{{ $event['date_format'] }}",
            "startTime":"10:15",
            "endTime":"23:30",
            "location":"{{ $event['address'] }}",
            "options":[
            "Apple",
            "Google",
            "iCal",
            "Microsoft365",
            "MicrosoftTeams",
            "Outlook.com",
            "Yahoo"
            ],
            "timeZone":"Asia/Dubai",
            "iCalFileName":"Reminder-Event"
            }
        </div>
        <script src="https://cdn.jsdelivr.net/npm/add-to-calendar-button@1" async defer></script>
        <script>
            import * as addToCalendarButton from "https://cdn.jsdelivr.net/npm/add-to-calendar-button@1.14";
            addToCalendarButton.atcb_init;
        </script>

    </div>

</body>
