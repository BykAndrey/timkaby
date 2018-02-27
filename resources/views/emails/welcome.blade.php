<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<table width="500" style="margin:auto;
    font-family:Arial, Helvetica, sans-serif;
    background-color: #f8f6f6;
    padding:10px;">
    <tr>
        <td  style="text-align:center;

                      color:white;
                      height:100px;" >
            <img src="{{URL::asset('/static/img/logo.png')}}" width="250px" alt="timka.by">>
            <h5 style="background-color:#4ab4de; padding:10px;">
                Интерент-магазин товаров для детей
            </h5>
        </td>
    </tr>
    <tr>
        <td style="
                    font-size: 13px;
                    padding:10px;
                    color: #424242;
                    ">
            <h3>Вы зарегистрировались в интернет-магазине Timka.by</h3>
            <p>{{$name}}, cпасибо за регистрацию на нашем сайте!
                Теперь вы будете узнавать о акциях и скидках быстрее и сможете экономить!</p>
        </td>
    </tr>
    <tr>
        <td  style="text-align:center;
                    color:white;
                    font-size: 13px;
                      padding:10px;
                       margin-top:10px;" bgcolor="#4ab4de">
            <h6 style="text-align:center;
                            color:#424242;
                            font-size: 13px;
                           ">Контактная информация</h6>
            <span> Телефон: +375 (25) 123-23-25 (МТС, Viber)</span> <br>
            <span>Email: support@timka.by</span>

        </td>
    </tr>
</table>
</body>
</html>