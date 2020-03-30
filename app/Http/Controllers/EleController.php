<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Vote;
use App\Election;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ElectionsController extends Controller
{
    // 一覧表示ページ
    public function index()
    {
        $elections = Election::all();

        return view('elections.index', compact('elections'));
    }

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
            // 'category_name' => 'required|string|max:255',
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
        $election_id = $id; // 送られてくるのはelection_id
        // 下2つは同じ、collection object
        $u_e1 = User::find(3)->elections; //userid3のelection要素は取れる->election2つ取れる
        $u_e2 = Auth::user()->elections; // login userのelectionのレコードを取得したobjectのプロパティ参照 collection
// Election belongsto User ........x
        // オブジェクト
        $ele = Candidate::find($id); //e_idは３だけど、c_idは２つまり、findは主キーなので、eleの2が入って、c_id２が取れてくる
        // $e_id = Election::find('id'); // これがnull?
        // $e_u1 = $e_id->user->id; // belongstoが効いてない？
        // $job = User::where('election_id', $abcd)->first();
// Election hasone Candidate.......o
        // $a = Candidate::find(1); //c_id1が取れる
        $b = Candidate::where('election_id',$id)->get(); // オブジェクトレコード取れる！ 外部キーele_id２のcan_id1は展開しないと取れない
        $bb = Candidate::where('election_id',$id)->get('id'); // 外部キーele_id２のcan_id1取れる
        // $c = Candidate::find($a->id); // これはオブジェクト表示だが、vue bladeの方では展開しなくても取れる
        $cc = Candidate::find($bb); // これはコレクション表示だが、vue bladeの方では展開しなくても取れる
        $e_c1 = Candidate::select('election_id')->get($id); //コレクションオブジェクト ele_id 2,3が取れる

// Candidate belongsto Election .......o
        $c_e1 = Election::find($id); // electionのidのあるレコードを取得したオブジェクト
        $ces = Candidate::select('election_id')->first(); // ele_idを取得
        $cess = $ces->election; // 使える！やはり、foreign_idが余計だったか。上で撮ったidのレコード取得
        // $candidate = Candidate::
        // foreach($ces as $ce){
        //     $c_id = Candidate::where('election_id',$election_id);
        //     }

        // $candidate_id = $candidates->candidates;
            // $c_id = $candidate_id->get('id');
        // $c_id = $candidate->id;
        // $c_id = ;
        // $a = Candidate::where('id',1)->first()
        // $name = $candidate->name;
        // $com = $candidate->com;

        return view('elections.edit', compact('cc','bb','ele','cess','c_e1','e_c1','c','b','a','u_e1','u_e2','abc','job','abcd','emails','c_id','election_id','candidate_id','candidate', 'election','name', 'com'));
    }

    // 更新用
    public function update(Request $request, $id)
    {
    // GETパラメータが数字かどうかをチェックする
    if(!ctype_digit($id)){
        return redirect('/elections/new')->with('flash_message', __('2Invalid operation was performed.'));
    }

    $election = Election::find($id);
    $election = Auth::user()->elections()->find($id);
    $election->fill($request->all())->save();

    return redirect('/elections/mypage')->with('flash_message', __('Registered.'));
    }

    // 削除処理
    public function destroy($id)
    {  
    // GETパラメータが数字かどうかをチェックする
    if(!ctype_digit($id)){
        return redirect('/elections/new')->with('flash_message', __('3Invalid operation was performed.'));
    }

    // こう書いた方がスマート
    // Election::find($id)->delete();
    $election = Auth::user()->elections()->find($id)->delete();
    return redirect('/elections')->with('flash_message', __('Deleted.'));
    }

    // 表示処理
    public function show($id)
    {
    // GETパラメータが数字かどうかをチェックする
    if(!ctype_digit($id)){
        return redirect('/elections')->with('flash_message', __('4Invalid operation was performed.'));
    }

    $election = Election::find($id);

    return view('elections.show', ['election' => $election]);
    }

    // マイページ
    public function mypage()
    {
    $elections = Auth::user()->elections()->get();
    // $e_id = Auth::user()->elections()->id;
    // $e_title = Election::find($id);
    $votes = Auth::user()->votes()->get();
    return view('elections.mypage', compact('elections','votes','e_title'));
    }

}
