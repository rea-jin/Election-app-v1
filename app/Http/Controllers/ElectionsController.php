<?php

namespace App\Http\Controllers;

use App\User;
use App\Vote;
use App\Election;
use App\Candidate;
use Illuminate\Http\Request;
use App\Http\Requests\CreateElectionRequest;
// use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ElectionsController extends Controller
{
/**
 * topページ ==========================================
 */
public function top()
{
    return view('elections.top');
}
// 一覧表示ページ ======================================
public function index()
{
    $elections = Election::where('delete_flg',0)->where('start_flg',1)->paginate(8);

    return view('elections.index', compact('elections'));
}


// 新規登録ページ =======================================
    public function new()
    {
        return view('elections.new', compact('elections'));
    }

// 登録機能・バリデーション ================================
    public function create(CreateElectionRequest $request)
    { // request クラスのvalidateメソッド ->フォームリクエストを使う

        $election = new Election;
        $election->title = $request->title;
        $election->subtitle = $request->subtitle;

        // 画像保存
        for($i=1;$i<=10;$i++)
        {
            $img = 'img'.($i-1);
            if(!empty($request->$img))
            {
                $election->$img = $request->$img->store('public/candidate_img');
            }
        }
     
        $election->user_id = Auth::user()->id;
        $election->save();

      
        $candidate = new Candidate;
        // 候補名保存
        for($i=1;$i<=10;$i++)
        {
            $name = 'name'.($i-1);
            if(!empty($request->$name))
            {
                $candidate->$name = $request->$name;
            }
        }
        // コメント保存
        for($i=1;$i<=10;$i++)
        {
            $com = 'com'.($i-1);
            if(!empty($request->$com))
            {
                $candidate->$com = $request->$com;
            }
        };
      
        $candidate->election_id = $election->id;
        $candidate->save();

        return redirect('/elections/mypage')->with('flash_message', __('Registered.'));

    }

    
/**
 * // 編集画面 election_idがくる =========================
 */
    public function edit($id)
    {
  
        if(!ctype_digit($id)){
            return redirect('/elections/new')->with('flash_message', __('Invalid operation was performed.1'));
        }
    
        $election = Election::find($id);
        if($election->delete_flg==1){
            return redirect('/elections/new')->with('flash_message', __('Invalid operation was performed.2'));
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

// 更新用 ====================================
    public function update(CreateElectionRequest $request, $id)
    {
    // GETパラメータが数字かどうかをチェックする
    if(!ctype_digit($id)){
        return redirect('/elections/new')->with('flash_message', __('Invalid operation was performed.3'));
    }

    // $election = new Election;
    $election = Election::find($id);
    $election->title = $request->title;
    $election->subtitle = $request->subtitle;
    // 画像更新
    for($i=1;$i<=3;$i++)
        {
            $img = 'img'.($i-1);
            if(!empty($request->$img))
            {
                $election->$img = $request->$img->store('public/candidate_img');
            }
        };
   
    // $election->img0 = $request->img0->store('public/candidate_img');

    $election->user_id = Auth::user()->id;
    $election->save();

    // $candidate_id = Candidate::where('election_id',$id)->get('id'); // 取れる！ 外部キーele_id２のcan_id1は取れる
    $candidate_id = Candidate::where('election_id',$id)->first('id'); // 1つしかないので
    // dump($candidate_id); // デバッグ
    $candidate = Candidate::find($candidate_id);

    foreach($candidate as $candidate){
 
    for($i=1;$i<=3;$i++)
        {
            $com = 'com'.($i-1);
            if(!empty($request->$com))
            {
                $candidate->$com = $request->$com;
            }
        }

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


// 削除処理 ============================================
    public function destroy($id)
    {  
    // GETパラメータが数字かどうかをチェックする
    if(!ctype_digit($id)){
        return redirect('/elections')->with('flash_message', __('Invalid operation was performed.4'));
    }

    $election = Auth::user()->elections()->find($id);
    $election->delete_flg = 1;
    $election->save();
    Log::debug('$election='.$election); // $data->result=1 
    return redirect('/elections/mypage')->with('flash_message', __('Deleted.'));
    }

// 表示処理 ================================================
    public function show($id)
    {
    // GETパラメータが数字かどうかをチェックする
    if(!ctype_digit($id)){
        return redirect('/elections')->with('flash_message', __('Invalid operation was performed.5'));
    }
    // 候補表示用
    $election = Election::find($id); 
    $candidates = Candidate::where('election_id',$id)->first();
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
    
    return view('elections.show', compact('a','value2','total_vote','total','value','counts', 'vote_total','name9','count_votes','count_vote','count', 'vote_user','voted','election','candidates'));
    }

// 投稿処理 ========================================
    public function vote(Request $request, $id){
        if(!ctype_digit($id)){
            return redirect('/elections')->with('flash_message', __('Invalid operation was performed.6'));
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

// マイページ =============================================
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

// ユーザー退会 =======================================
    public function delete(Request $request)
    {
        
      $user_id = Auth::user()->id;
      $user = User::find($user_id);
      $user->delete();
  
      return redirect('/elections')->with('flash_message', __('退会しました。'));
     
    }

// 選挙開始 =============================================
    public function start($id)
    {
        $election = Election::find($id);
        $election->start_flg = 1;
        $election->save();
        return redirect('/elections')->with('flash_message', __('投票開始しました'));
    }

}
