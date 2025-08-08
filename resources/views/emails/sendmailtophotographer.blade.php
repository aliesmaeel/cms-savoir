<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        form{
            display:inline-block;
        }
    </style>
</head>
<body>
    <h2> Hello {{ $details['photographer_name'] }}!</h2>
    <h3> You have a new request to book an appointment</h3>
    <h4> Date: {{$details['date']}}</h4>
    <h4> Time: {{$details['time']}}</h4>
    <h4> Name: {{$details['agent_name']}}</h4>
    <h4> Location: {{$details['location']}}</h4>
    <h4> Photoshoot Type: {{$details['photoshoot']}}</h4>
    <h4>
        <form method="GET" target="_blank" action="{{route('confirm_appointment',[$details['appointment_id'],$details['agent_id']])}}">
            @csrf
            @method('GET')
            <button style="background-color: #003ea5;padding:10px;color:#fff;cursor: pointer" type="send" class="btn btn-danger">
                Confirm
            </button>
        </form>
        <form method="GET" target="_blank" action="{{route('reject_appointment',[$details['appointment_id'],$details['agent_id']])}}">
            @csrf
            @method('GET')
            <button type="send" style="background-color: tomato;padding:10px;color:#fff;cursor: pointer" class="btn btn-danger">
                reject
            </button>
        </form>
    </h4>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
