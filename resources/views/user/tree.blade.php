


<div class="tree">

    <h2>Профиль</h2>
    <ul class="no-padding">
        <li>
            <a class="not-decor" href="{{route('user::profile')}}">
                <div class="common-but">
                    Данные профиля
                </div>
            </a>
        </li>
        <li>
            <a class="not-decor" href="{{route('user::orders')}}">
                <div class="common-but">
                    Мои заказы
                </div>
            </a>
        </li>
        <li>
            <a class="not-decor" href="{{route('user::like-good')}}">
                <div class="common-but">
                    Избранное
                </div>
            </a>
        </li>

        @if(Auth::user()->id_role==1)
        <li>
            <a class="not-decor" href="{{route('user::allorders')}}">
                <div class="common-but common-but-red ">
                    Заказы клиентов
                </div>
            </a>
        </li>
        <li>
            <a class="not-decor" href="{{route('admin::home')}}">
                <div class="common-but common-but-red">
                    Панель администратора
                </div>
            </a>
        </li>
@endif


    </ul>
</div>