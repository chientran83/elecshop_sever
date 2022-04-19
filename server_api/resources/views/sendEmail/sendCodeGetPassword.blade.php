<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .container {
            padding: 10px;
            background-color: rgb(146, 221, 235);
            text-align: center;
            border: 3px solid blue;
        }
        .code{
            background-color:greenyellow;
            padding: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lấy lại mật khẩu</h1>
        <h2>{{ $data['body'] }}</h2>
        <h3>Mã code của bạn là :</h3>
        <div class="code">
            <h1>{{ $data['code'] }}</h1>
        </div>
    </div>
</body>
</html>