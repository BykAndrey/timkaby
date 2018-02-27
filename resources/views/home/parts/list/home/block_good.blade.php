<!-- ПРИ ДОБАВЛЕНИИ НУЖНО НАПИСАТЬ

 <div class="block_good">
 @includ e('......block_good')
 </div>

 -->

<!--

{
    'name':'NAME',
    'tabs':{
        'name':'NAME',
        'id':0,
        'items':{},
    },
}




-->


<div class="block_good tabs" id="t">
    <div class="head">
        <h2><a href="{{route('home::catalog',['url'=>$block['url']])}}">{{$block['name']}}</a></h2>
        <ul>
            @php
            $i=0;
            @endphp
            @foreach($block['tabs'] as $tab)
                @if($i==0)
                    <li><a href="#{{$tab['id']}}" class="tab active">{{$tab['name']}}</a></li>
                    @else
                    <li><a href="#{{$tab['id']}}" class="tab ">{{$tab['name']}}</a></li>
                    @endif

                @php
                $i++;
                @endphp
                @endforeach

        </ul>
    </div>
    @php
        $i=0;
    @endphp
    @foreach($block['tabs'] as $tab)
        @if($i==0)
            <div id="{{$tab['id']}}" class="tab-content active " style="opacity: 1;">
        @else
            <div id="{{$tab['id']}}" class="tab-content  " style="opacity: 0;">
        @endif


        @php
            $i++;
        @endphp
        <div class="list_good">

          @foreach($tab['items'] as $item)
          @include('home.parts.elements.good',['item'=>$item])



@endforeach


        </div>
    </div>
  @endforeach
</div>
