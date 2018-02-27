@php
    switch($status){
        case -1:
            echo '<span style="background-color:#ff000080;color:white;">Анулирован</span>';
        break;

        case 0:
            echo '<span style="background-color:rgba(255, 126, 0, 0.57);color:white;">В обработке</span>';
        break;

        case 1:
            echo '<span style="background-color:#ffe100;color:white;">Доставляется</span>';
            break;
        case 2:
            echo '<span style="background-color:#00800099;color:white;">Выполнен</span>';
            break;
        }
@endphp