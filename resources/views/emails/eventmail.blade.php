
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>event Information</title>
    <style>
        @import "https://cdn.jsdelivr.net/npm/add-to-calendar-button/assets/css/atcb.min.css";
        .body{
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
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
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
    <div class="body">
        <h4>Event Name: {{$event['name']}}</h4>
        <h4>Event Date: {{$event['date']}}</h4>
        <h4>Event Address :{{$event['address']}}</h4>
        <h4>Event Description :{{$event['description']}} </h4>
        <div class="atcb" style="display:none;">
            {
              "name":"{{$event['name']}}",
              "description":"{{$event['description']}}:<br>→ [url]https://github.com/add2cal/add-to-calendar-button[/url]",
              "startDate":"{{$event['date_format']}}",
              "endDate":"{{$event['date_format']}}",
              "startTime":"10:15",
              "endTime":"23:30",
              "location":"{{$event['address']}}",
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


        {{-- <div class="dropdown">
            <button class="dropbtn" style="background-color: #003ea5;padding:10px;color:#fff;cursor: pointer">Add To Calendar</button>
            <div class="dropdown-content">
                <div style="margin-bottom: 10px !important">
                    <a style="color:#003ea5;text-decoration: none;margin-bottom: 10px" href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=My Event&details={{$event['description']}} text&dates={{$event['date_format']}}/{{$event['date_format']}} &location={{$event['address']}}">Add To Coogle Calendar </a>

                </div>
                <div style="margin-bottom: 10px !important">
                    <a style="color:#003ea5;text-decoration: none;margin-bottom: 10px" href="https://outlook.office.com/calendar/0/deeplink/compose?subject=My Event&body={{$event['description']}} text&startdt={{$event['date_format']}}&enddt={{$event['date_format']}}&location={{$event['address']}}&path=%2Fcalendar%2Faction%2Fcompose&rru=addevent">Add to Outlook</a>
                </div>
                <div style="margin-bottom: 10px !important">
                    <a style="color:#003ea5;text-decoration: none;margin-bottom: 10px" href="https://outlook.office.com/calendar/0/deeplink/compose?body=Learn%20all%20about%20the%20rules%20of%20the%20Motorway%20and%20how%20to%20access%20the%20fast%20lane.%0A%0Ahttps%3A%2F%2Fen.wikipedia.org%2Fwiki%2FGridlock_%28Doctor_Who%29&enddt={{$event['date_format']}}&location={{$event['address']}}&path=%2Fcalendar%2Faction%2Fcompose&rru=addevent&startdt={{$event['date_format']}}&subject=Welcome%20to%20the%20Motorway">Microsoft 365</a>
                </div>


            </div>
          </div> --}}
    </div>

</body>
