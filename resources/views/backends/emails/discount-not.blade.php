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
    <h3>Chào {{$userName}},</h3>
    <div>{!!$mailContent!!}</div>
    
    <p>Cám ơn,</p>
    <p>Nhóm hỗ trợ Courdemy</p>
</body>
</html>