<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Information</title>
    <style>
        @import "https://cdn.jsdelivr.net/npm/add-to-calendar-button/assets/css/atcb.min.css";

        .body {
            width: 80%;
            margin: auto
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            padding: 12px 16px;
            z-index: 1;

        }

        .dropdown:hover .dropdown-content {
            display: block;

        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/add-to-calendar-button@1/assets/css/atcb.min.css">
</head>

<body>
    <div class="body" style="text-align: center; margin-top: 10%">
        <h2>Meeting Details </h2>
        <h4>Meeting Title: {{ $meeting->title }}</h4>
        <h4>Meeting Date: {{ $meeting->date }}</h4>
        <h4>Meeting Description :{{ $meeting->description }} </h4>
        <div class="atcb" style="display:none;">
            {
            "title":"{{ $meeting->title }}",
            "description":"{{ $meeting->description }}",
            "startDate":"{{ $meeting->date }}",
            "endDate":"{{ $meeting->date }}",
            "startTime":"10:15",
            "endTime":"23:30",
            "location":"",
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
