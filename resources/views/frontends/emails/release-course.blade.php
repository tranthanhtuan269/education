<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <title>Order Completed</title>
</head>
<body>
    {{-- <h3 style="color: orange">{{$mailSubject}}</h3> --}}
    {{-- <h3>Chào {{$userName}},</h3> --}}
    {{-- <div>{!!$mailContent!!}</div> --}}
    <div class="container">
        <div class="modal-header text-center">
            <h4 class="modal-title" style="color: #00B7F1">Đơn hàng #{{ $order->id }}</h4>
        </div>
        <div class="modal-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Thông tin học viên </th>
                        <th scope="col">Thông tin thanh toán</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width:38%;">
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="width:45%;">Họ tên: </td>
                                        <td>{{$user->name}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:45%;">Ngày tạo:</td>
                                        <td>{{$order->created_at}}</td>
                                    </tr>
                                    <tr>
                                        <td>Trạng thái: </td>
                                        <td style="width:45%;"><span class="btn btn-sm text-center btn-success">Đã thanh toán</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="width:62%;">
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="width:45%;">Địa chỉ: </td>
                                        <td>{{$user->address}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:45%;">Email: </td>
                                        <td>{{$user->email}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:45%;">Số điện thoại: </td>
                                        <td>{{$user->phone}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width:45%;">Thanh toán: </td>
                                        <td> THẺ NỘI ĐỊA: INTERNET BANKING</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Khoá học</th>
                        <th scope="col">Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                    <tr>
                        <td>{{$course->name}}</td>
                        <td>599.000 đ</td>                            
                    </tr>
                    @endforeach
                    <tr>
                        <td><b>Total</b></td>
                        <td style="color:red; font-size:18px;">599.000 đ</td>
                    </tr>
                </tbody>
            </table>
            <p>Cám ơn bạn đã mua khoá học trên Courdemy!</p>
            <p>Học thật vui, làm thật nhiệt nhé!</p>
            <p>Đội hỗ trợ Courdemy</p>
        </div> 
    </div>
    
</body>
</html>