<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>event Information</title>
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
        @if ($type == 1)
            <h2>Event Details </h2>
            <h4>Event Name: {{ $event->name }}</h4>
            <h4>Event Date: {{ $event->date }}</h4>
            <h4>Event Address :{{ $event->address }}</h4>
            <h4>Event Description :{{ $event->description }} </h4>
            <div class="atcb" style="display:none;">
                {
                "name":"{{ $event->name }}",
                "description":"{{ $event->description }}",
                "startDate":"{{ $event->date }}",
                "endDate":"{{ $event->date }}",
                "startTime":"10:15",
                "endTime":"23:30",
                "location":"{{ $event->address }}",
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
        @elseif($type == 2)
            <h2>Appointment Details </h2>
            <h4>Date:{{ $event->date }}</h4>
            <h4>Time:{{ $event->time }}</h4>
            <h4>Photographer Name:{{ $photographer_name }}</h4>
            <h4>location:{{ $event->location }}</h4>

            <div class="atcb" style="display:none;">
                {
                "name":"Appointment with photoghrapher",
                "description":"{{ $event->description }}",
                "startDate":"{{ $event->date }}",
                "endDate":"{{ $event->date }}",
                "startTime":"10:15",
                "endTime":"23:30",
                "location":"{{ $event->location }}",
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
        @endif
        <script src="https://cdn.jsdelivr.net/npm/add-to-calendar-button@1" async defer></script>
        <script>
            import * as addToCalendarButton from "https://cdn.jsdelivr.net/npm/add-to-calendar-button@1.14";
            addToCalendarButton.atcb_init;
        </script>

    </div>
</body>
