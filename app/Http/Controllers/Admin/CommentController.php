<?php

namespace App\Http\Controllers\Admin;
use Thread;
use App\Comment;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class CommentController extends AdminController
{
    public function home(Request $request){

        $page=1;
        if($request->has('page')){
            $page=$request->input('page');
        }

        $page--;
        $size=10;

        $items=DB::table('item_comment')
            ->join('users','users.id','=','item_comment.id_user')
            ->join('good_item','good_item.id','=','item_comment.id_good_item')

            ->select('item_comment.id','item_comment.comment','item_comment.is_active','item_comment.rating','item_comment.is_new','users.name as user_name',
                'good_item.name as good_name',
                'good_item.id as good_id')
            ->orderBy('item_comment.is_new','DESC ')
            ->orderBy('item_comment.created_at','DESC')
            ->skip($page*$size)
            ->take($size)
            ->get();

        $count=DB::table('item_comment')->count();
        $this->data['good_brand']=$items;




        $this->data['current_page']=$page+1;
        $this->data['max_page']=ceil($count/$size);

        return view('admin.listObjects.item_comment',$this->data);
    }
    public function recalculatingRating($id){
        $item=Item::find(intval($id));
        if($item!=null){
            $comments=Comment::where('id_good_item',$item->id)
                ->where('is_active',1)
                ->get();
            $newRate=0.00;
            foreach ($comments as $com){
                $newRate+=$com->rating;
            }
            if(count($comments)!=0){
                $newRate=$newRate/count($comments);


                $item->rating=$newRate;
                $item->save();
            }
        }
    }

    public function ajax(Request $request){
        $action=$request->input('action');
        switch ($action){
            case 'set_new':
                $id=$request->input('id');
                $comment=Comment::find($id);
                if($comment!=null){
                    if($comment->is_new==1){
                        $comment->is_new=0;
                        $comment->save();
                        $this->recalculatingRating($comment->id_good_item);
                        return 0;
                    }else{
                        $comment->is_new=1;
                        $comment->save();
                        $this->recalculatingRating($comment->id_good_item);
                        return 1;
                    }

                }
                break;
            case 'set_active':
                $id=$request->input('id');
                $comment=Comment::find($id);
                if($comment!=null){
                    if($comment->is_active==1){
                        $comment->is_active=0;
                        $comment->save();

                        $this->recalculatingRating($comment->id_good_item);
                        return 0;
                    }else{
                        $comment->is_active=1;
                        $comment->save();
                        $this->recalculatingRating($comment->id_good_item);
                        return 1;
                    }

                }
                break;
        }
    }
}
