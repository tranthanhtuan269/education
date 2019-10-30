<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    {{-- <h3 style="color: orange">{{$mailSubject}}</h3> --}}
    <div>Xin chào <b>{{$userName}}</b></div>
    <br>
    <div style="line-height: 2">{!!$mailContent!!}</div>
    <br>
    <p style="padding-left:15px">Trân trọng!</p>
    <p><b>Courdemy Team</b></p>
</body>
</html>