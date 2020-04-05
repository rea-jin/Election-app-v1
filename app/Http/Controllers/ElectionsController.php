<?php

namespace App\Http\Controllers;

use App\User;
use App\Vote;
use App\Election;
use App\Candidate;
use App\Http\Requests\CreateElectionRequest;
use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ElectionsController extends Controller
{
   
    // 新規登録ページ
    public function new()
    {
        return view('elections.new', compact('elections'));
    }
    // 登録機能・バリデーション
    public function create(CreateElectionRequest $request)
    { // request クラスのvalidateメソッド ->フォームリクエストを使う

        $election = new Election;
        $election->title = $request->title;
        $election->subtitle = $request->subtitle;

        // $election->img0 = $request->img0;
        // $election->img0 = $request->img0->store('public/candidate_img');
        // $election->img1 = $request->img1->store('public/candidate_img');
        // 画像保存
        for($i=1;$i<=3;$i++)
        {
            $img = 'img'.($i-1);
            if(!empty($request->$img))
            {
                $election->$img = $request->$img->store('public/candidate_img');
            }
        }
        // $election->img1 = $request->img1;
        // $election->img = $request->img;
        // $election->img = $request->img;  
        $election->user_id = Auth::user()->id;
        $election->save();

        // $election->fill($request->all())->save();
        // Auth::user()->elections()->save($election->fill($request->all()));
        
        $candidate = new Candidate;
        // 候補名保存
        for($i=1;$i<=3;$i++)
        {
            $name = 'name'.($i-1);
            if(!empty($request->$name))
            {
                $candidate->$name = $request->$name;
            }
        }
        // コメント保存
        for($i=1;$i<=3;$i++)
        {
            $com = 'com'.($i-1);
            if(!empty($request->$com))
            {
                $candidate->$com = $request->$com;
            }
        }
      
        $candidate->election_id = $election->id;
        $candidate->save();

        return redirect('/elections/mypage')->with('flash_message', __('Registered.'));

    }

    // 編集画面 election_idがくる
    public function edit($id)
    {
  
        if(!ctype_digit($id)){
            return redirect('/elections/new')->with('flash_message', __('1Invalid operation was performed.'));
        }
    
        $election = Election::find($id);
        if($election->delete_flg==1){
            return redirect('/elections/new')->with('flash_message', __('1Invalid operation was performed.'));
        }
    
        $candidate = Candidate::where('election_id',$id)->get(); // 取れる！ 外部キーele_id２のcan_id1は取れる
     
        $is_image = false;
        if (Storage::disk('local')->exists('public/candidate_img/')) 
        {
            $is_image = true;
        }
        // $read_temp_path = str_replace('public/', 'storage/', $temp_path);

        return view('elections.edit', compact('is_image','candidate', 'election','name', 'com'));
    }

    // 更新用
    public function update(CreateElectionRequest $request, $id)
    {
    // GETパラメータが数字かどうかをチェックする
    if(!ctype_digit($id)){
        return redirect('/elections/new')->with('flash_message', __('2Invalid operation was performed.'));
    }

    // $election = new Election;
    $election = Election::find($id);
    // $election = Auth::user()->elections()->find($id);
    // $election->fill($request->all())->save();
    for($i=1;$i<=3;$i++)
        {
            $img = 'img'.($i-1);
            if(!empty($request->$img))
            {
                $election->$img = $request->$img->store('public/candidate_img');
            }
        }
    $election->title = $request->title;
    $election->subtitle = $request->subtitle;
    // $election->img0 = $request->img0->store('public/candidate_img');

    $election->user_id = Auth::user()->id;
    $election->save();

    $candidate_id = Candidate::where('election_id',$id)->get('id'); // 取れる！ 外部キーele_id２のcan_id1は取れる
    $candidate = Candidate::find($candidate_id);
    // $candidate = Candidate::find('election_id'$id); // 取れる！ 外部キーele_id２のcan_id1は取れる
    // $candidate = new Candidate; // 取れる！ 外部キーele_id２のcan_id1は取れる
    // $candidate->fill([
    
    // ])->save();

    foreach($candidate as $candidate){
    // $candidate->name0 = $request->name0;
    // $candidate->name1 = $request->name1;
    // $candidate->name2 = $request->name2;
    for($i=1;$i<=3;$i++)
        {
            $com = 'com'.($i-1);
            if(!empty($request->$com))
            {
                $candidate->$com = $request->$com;
            }
        }
    // $candidate->com0 = $request->com0;
    // $candidate->com1 = $request->com1;
    // $candidate->com2 = $request->com2;
    for($i=1;$i<=3;$i++)
        {
            $name = 'name'.($i-1);
            if(!empty($request->$name))
            {
                $candidate->$name = $request->$name;
            }
        }
    $candidate->election_id =$id;
    // $candidate->fill($request->all())->save();
    $candidate->save();
    }

    return redirect('/elections/mypage')->with('flash_message', __('Registered.'));
    }

     // 一覧表示ページ
     public function index()
     {
         $elections = Election::where('delete_flg',0)->where('start_flg',1)->paginate(8);
 
         return view('elections.index', compact('elections'));
     }
 
    // 削除処理
    public function destroy($id)
    {  
    // GETパラメータが数字かどうかをチェックする
    if(!ctype_digit($id)){
        return redirect('/elections')->with('flash_message', __('3Invalid operation was performed.'));
    }

    // こう書いた方がスマート
    // Election::find($id)->delete();
    // $election = Auth::user()->elections()->find($id)->delete();
    $election = Auth::user()->elections()->find($id);
    $election->delete_flg = 1;
    $election->save();
    Log::debug('$election='.$election); // $data->result=1 
    return redirect('/elections/mypage')->with('flash_message', __('Deleted.'));
    }

    // 表示処理
    public function show($id)
    {
    // GETパラメータが数字かどうかをチェックする
    if(!ctype_digit($id)){
        return redirect('/elections')->with('flash_message', __('4Invalid operation was performed.'));
    }
    // 候補表示用
    $election = Election::find($id); 
    $candidates = Candidate::where('election_id',$id)->get();
    // 投票したか eloqでログインuserのvoteを取り、ele_idが渡されたidと一致しているものがあるか
    $vote_user = Auth::user()->votes()->where('election_id',$id)->exists();
    // 投票数を数える 指定の選挙のvotedを取得
    $vote = Vote::all(); 
    // $count_votes = Vote::all()->count(); 
    // 総投票数
    $total = Vote::all()->where('election_id',$id); 
    $total_vote =$total->count(); 
    // 各投票数
    $count = [];
    for($i=1;$i<=10;$i++)
    {
        $c = 'name'.($i-1);
        $value = $total->where('voted',$c)->count();
        $count[] = $value; //配列に入れる
    }
    
    // $value = $total->where($a,$b)->count();
    // $counts = Vote::where('voted',$value)->count();
    // $vote_total = Vote::where()->count(); // OK!

    // $values = $count_votes->get('voted');
    // foreach($values as $value){
        // $counts = $value;

    // }
    // $count_votes = Votes$election->votes()->count();
    // foreach($count_votes as $count_vote)
    // {
        // for($i = 1; $i<=10; $i++)
        // {
            // $count[($i-1)] = $count_vote->count('name'.($i-1));
            // $name9 = $count_vote->count();
        // }
    // }
    return view('elections.show', compact('a','value2','total_vote','total','value','counts', 'vote_total','name9','count_votes','count_vote','count', 'vote_user','voted','election','candidates'));
    }

    // 投稿処理
    public function vote(Request $request, $id){
        if(!ctype_digit($id)){
            return redirect('/elections')->with('flash_message', __('5Invalid operation was performed.'));
        }
        $request->validate([
            // name属性 => required:必須
            'voted' => 'required|string|max:255'
        ]);
        $vote = new Vote;

        $vote->user_id = Auth::user()->id;
        $vote->election_id = Election::find($id)->id;

        $candidate = Candidate::where('election_id',$id);
        $vote->voted = $request->voted;
        $vote->save();

        return redirect('/elections/mypage')->with('flash_message', __('投票しました！'));
    }
    // マイページ
    public function mypage()
    {   
        $user_id = Auth::user()->id;
        $elections = Election::where('user_id',$user_id)->get();
        // $elections = User::find($user_id)->elections();

        $vote_e_id = Vote::where('user_id',$user_id)->get('election_id');
        
        if(!empty($vote_e_id)){
            // foreach($vote_e_id as $vote_e_id)
            // {
                $elections_v = Election::find($vote_e_id);
        // }
        }
    // DEBUG
    // Log::debug('$elections="'.$elections.'""');
    Log::debug('$elections_v="'.$elections_v.'""');
    return view('elections.mypage', compact('user_id','vote_e_id','elections_v','user','elections','votes','e_title'));
    }

    public function data(Request $request)
    {
        
        $user_id = Auth::user()->id;
      $user = User::find($user_id);
      $user->delete();
    //   $elections = Election::all();
    //   $user_id = Auth::user();
    //   return view('elections.index',compact('elections'));
    //   return view('elections.mypage');
      return redirect('/elections/mypage')->with('flash_message', __('退会しました。'));
     
    }

    public function start($id)
    {
        $election = Election::find($id);
        $election->start_flg = 1;
        $election->save();
        return redirect('/elections')->with('flash_message', __('投票開始しました'));
    }

}
