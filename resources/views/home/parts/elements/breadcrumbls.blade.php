<div class="bread_crumbls" >
    @php
        $position=1;
    @endphp
    <ul itemscope itemtype="http://schema.org/BreadcrumbList">
        @foreach($bread_crumbs as $key=>$item)
            <li itemprop="itemListElement" itemscope
                itemtype="http://schema.org/ListItem">
                <a itemprop="item" href="{{$item}}">

                    <span itemprop="name">{{$key}}</span>


                </a>
                <meta itemprop="position" content="{{$position}}" />/
            </li>
            @php
                $position++;
            @endphp
        @endforeach
    </ul>
</div>