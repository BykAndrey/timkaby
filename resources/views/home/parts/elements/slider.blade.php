
    <div class="list_photo">
        <div class="image active" style="background-image: url('{{URL::asset(\App\ItemGroup::getImage($photos,500,null))}}')"></div>
        @foreach($item_group_images as $img)
            <div class="image " style="" title="{{$img->name}}"></div>
        @endforeach
<!--background-image: url('{URL::asset(\App\ItemGroup::getImage($img->image,500,null))}}')-->
    </div>
    <div class="controls">
            <div class="left but" style="background-image: url('{{URL::asset('static/img/left-grey.svg')}}')">

            </div>
            <div class="miniatures" id="miniatures">
                <div class="box">
                    <div class="image active" style="background-image: url('{{URL::asset(\App\ItemGroup::getImage($photos,73,null))}}')" data-image="{{$photos}}"></div>
                    @foreach($item_group_images as $img)
                        <div class="image " style="background-image: url('{{URL::asset(\App\ItemGroup::getImage($img->image,73,null))}}')" data-image="{{$img->image}}" title="{{$img->name}}"></div>
                    @endforeach

                </div>
            </div>
        <div class="right but" style="background-image: url('{{URL::asset('static/img/right-grey.svg')}}')">

        </div>
    </div>
