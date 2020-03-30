<?php

namespace App\Http\Controllers;

use App\User;
use App\Vote;
use App\Election;
use App\Candidate;

use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ElectionsController extends Controller
{
   
    // 新規登録ページ
    public function new()
    {
        return view('elections.new', compact('elections'));
    }
    // 登録機能・バリデーション
    public function create(Request $request)
    { // request クラスのvalidateメソッド
        $request->validate([
            // name属性 => required:必須
            'title' => 'required|string|max:255',
            'subtitle' => 'string|nullable|max:255',
            'name0' => 'required|string|max:255',
            'name1' => 'string|nullable|max:255', // nullを許容しないと、空の時エラーが出る
            'name2' => 'string|nullable|max:255', // nullを許容するときは、nullableを入れる
            'name3' => 'string|nullable|max:255', // さらにDBの方もnull許容を設定しないといけない
            'name4' => 'string|nullable|max:255',
            'name5' => 'string|nullable|max:255',
            'name6' => 'string|nullable|max:255',
            'name7' => 'string|nullable|max:255',
            'name8' => 'string|nullable|max:255',
            'name9' => 'string|nullable|max:255',
            'com0' => 'required|string|max:255',
            'com1' => 'string|nullable|max:255', // nullを許容しないと、空の時エラーが出る
            'com2' => 'string|nullable|max:255', // nullを許容するときは、nullableを入れる
            'com3' => 'string|nullable|max:255', // さらにDBの方もnull許容を設定しないといけない
            'com4' => 'string|nullable|max:255',
            'com5' => 'string|nullable|max:255',
            'com6' => 'string|nullable|max:255',
            'com7' => 'string|nullable|max:255',
            'com8' => 'string|nullable|max:255',
            'com9' => 'string|nullable|max:255',
        ]);

        $election = new Election;
        $election->title = $request->title;
        $election->subtitle = $request->subtitle;

        // $election->img = $request->img;
        // $election->img = $request->img;
        // $election->img = $request->img;
        // $election->img = $request->img;  
        $election->user_id = Auth::user()->id;
        $election->save();

        // $election->fill($request->all())->save();
        // Auth::user()->elections()->save($election->fill($request->all()));
        
        $candidate = new Candidate;
        $candidate->name0 = $request->name0;
        $candidate->name1 = $request->name1;
        $candidate->name2 = $request->name2;
        $candidate->com0 = $request->com0;
        $candidate->com1 = $request->com1;
        $candidate->com2 = $request->com2;
        $candidate->election_id = $election->id;
        $candidate->save();

        return redirect('/elections/mypage')->with('flash_message', __('Registered.'));

    }

    // 編集画面 election_idがくる
    public function edit($id)
    {
        // GETパラメータが数字かどうかをチェックする
        // 事前にチェックしておくことでDBへの無駄なアクセスが減らせる（WEBサーバーへのアクセスのみで済む）
        if(!ctype_digit($id)){
            return redirect('/elections/new')->with('flash_message', __('1Invalid operation was performed.'));
        }
        // 主キーを使うのがfind,他のキーを使うのがfirst,whereで条件指定
// User hasmany Election ..........o
        // $election_id = $id; // 送られてくるのはelection_id
        // 下2つは同じ、collection object
        // $u_e1 = User::find(3)->elections; //userid3のelection要素は取れる->election2つ取れる
        // $elections = Auth::user()->elections; // login userのelectionのレコードを取得したobjectのプロパティ参照
// Election belongsto User ........x
        // オブジェクト
        // $election = Candidate::find($id); //e_idは３だけど、c_idは２つまり、findは主キーなので、eleの2が入って、c_id２が取れてくる
        $election = Election::find($id);
        if($election->delete_flg==1){
            return redirect('/elections/new')->with('flash_message', __('1Invalid operation was performed.'));
        }
        // if($election->delete_flg==1){
        //     return redirect('/elections/mypage')->with('flash_message', __('削除済の選挙です'));
        // } // これがnull?
        // $e_u1 = $e_id->user->id; // belongstoが効いてない？
        // $job = User::where('election_id', $abcd)->first();
// Election hasone Candidate.......o
        // $a = Candidate::find(1); //c_id1が取れる
        $candidate = Candidate::where('election_id',$id)->get(); // 取れる！ 外部キーele_id２のcan_id1は取れる
        // $candidate_id = Candidate::find($candidate); // これはオブジェクト表示だが、vue bladeの方では取れる
        // $e_c1 = Candidate::select('election_id')->get($id); //コレクションオブジェクト ele_id 2,3が取れる
        // Log::debug('$election='.$election); // $data->result=1 

// Candidate belongsto Election .......o
        // $c_e1 = Election::find($id); // electionのidのあるレコードを取得したオブジェクト
        // $ces = Candidate::select('election_id')->first(); // ele_idを取得
        // $cess = $ces->election; // 使える！やはり、foreign_idが余計だったか。上で撮ったidのレコード取得

        return view('elections.edit', compact('candidate', 'election','name', 'com'));
    }

    // 更新用
    public function update(Request $request, $id)
    {
    // GETパラメータが数字かどうかをチェックする
    if(!ctype_digit($id)){
        return redirect('/elections/new')->with('flash_message', __('2Invalid operation was performed.'));
    }

    // $election = new Election;
    $election = Election::find($id);
    // $election = Auth::user()->elections()->find($id);
    // $election->fill($request->all())->save();
    $election->title = $request->title;
    $election->subtitle = $request->subtitle;
    $election->user_id = Auth::user()->id;
    $election->save();

    $candidate_id = Candidate::where('election_id',$id)->get('id'); // 取れる！ 外部キーele_id２のcan_id1は取れる
    $candidate = Candidate::find($candidate_id);
    // $candidate = Candidate::find('election_id'$id); // 取れる！ 外部キーele_id２のcan_id1は取れる
    // $candidate = new Candidate; // 取れる！ 外部キーele_id２のcan_id1は取れる
    // $candidate->fill([
    
    // ])->save();

    foreach($candidate as $candidate){
    $candidate->name0 = $request->name0;
    $candidate->name1 = $request->name1;
    $candidate->name2 = $request->name2;
    $candidate->com0 = $request->com0;
    $candidate->com1 = $request->com1;
    $candidate->com2 = $request->com2;
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

    return view('elections.show', compact('vote_user','voted','election','candidates'));
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
