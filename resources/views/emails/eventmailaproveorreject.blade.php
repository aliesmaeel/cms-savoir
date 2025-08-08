
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>event Information</title>
    <style>
        .option{
            cursor:default;
            pointer-events: none;
        }
    </style>
    <style>
        .body{
            width: 80%;
            margin: auto;


        }
        form{
            display:inline-block;
        }
    </style>
</head>
<body>
    <div class="body">
        <h4>Event Name: {{$event['name']}}</h4>
        <h4>Event Date: {{$event['date']}}</h4>
        <h4>Event Address: {{$event['address']}}</h4>
        <h4>Event Description: {{$event['description']}} </h4>
        <h4>
            <form method="GET"   target="_blank" action="{{route('aproved',$event['id'])}}">
                   @csrf
                   @method('GET')
                   <button style="background-color: #003ea5;padding:10px;color:#fff;cursor: pointer" type="send" class="btn btn_danger aproved ">
                     aproved
                  </button>
            </form>
            <form method="GET" target="_blank" action="{{route('reject',$event['id'])}}">
                @csrf
                @method('GET')
                <button type="send" style="background-color:tomato;padding:10px;color:#fff;cursor: pointer" class="btn btn_danger reject">
                    reject
                </button>
               </form>

           </h4>
</body>
