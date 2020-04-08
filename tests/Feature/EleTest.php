<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     * 
     * topにアクセスしてタイトルがあるか
     */
    public function testSee()
    {
        $response = $this->get('/elections');
        $response->assertSee('みんなの選挙');
        $response->assertStatus(200);
    }

    // public function Election_register()
    // {
    //     // Auth::loginUsingId(2);
    //     // this->store();
    // }

     /**
     * ログインした状態でリクエストが正しく処理されるか
     * ユーザーを自動で作る
     */

    public function testLoggedIn()
    {
        $user = factory(\App\User::class)->create();
 
        $response = $this->actingAs($user)
                         ->get('/');
 
        $response->assertStatus(200);
    }

    /**
     * Undocumented function
     *
     * @return void
     * 選挙を作成して、マイページに飛んだ時、タイトルが表示されるか
     */
    public function testCreate()
    {
        //Ele作る
        $election = factory('App\Election')->create();
        // $candidate = factory('App\Candidate')->create();
        //electionの一覧を表示するURLにアクセスすると
        $response = $this->get('/elections');
        
        //electionが見える
        $response->assertSee($election->title)
                ->assertSee($election->subtitle);

    }
    /**
     * Undocumented function
     *
     * @return void
     * 
     */
    // public function testCreateElection()
    // {
    //     //  electionsからリレーションでcandidateを作成
    // $elections = factory(\App\Election::class)->create()
    //      ->each(function ($election)
    //      { 
    //          $election->candidates()->save(factory(\App\Candidate::class)->make());
    //          });
    //          $elections->assertTrue($elections);
    // }
    // public function testBoard()
    // {
    // $this->visit('/elections')//  トップページにアクセス
    // $this->assertSee('みんなの選挙')//      文字列が見える
    // ->see('選挙作成')//        
    // ->click('選挙作成')//       リンクをクリックしてみる
    // ->seePageIs('/elections/new')// 新規投稿ページに遷移する
    // ->see('選挙登録');//     新規投稿ページには「新規記事投稿」という文字列がある
    // }

    // _登録処理が成功する事を検証
    // public function insert()
    // {
    //     $name = 'test';
    //     $email = 'test@email.com';
    //     $pass = 'testtest';

    //     $this->users->insert($name, $email, $pass);

    //     $this->assertDatabaseHas('users', [
    //         'name' => $name,
    //         'email' => $email,
    //         'password' => $pass
    //     ]);
    // }
//     public function update_更新処理が成功する事を検証()
//     {
//         $id = 1;
//         $name = 'MEMBER_1';

//         $this->Members->update($id, $name);

//         $this->assertDatabaseHas('members', [
//             'id' => $id,
//             'name' => $name
//         ]);
//     }
//     public function store()
//     {
//         $Election = new Controller;
//     $books = $BookController->api('9784197037292');

//     $this->post('/books', $books);
//          ->assertSee('Are you happy with the following?')
//          ->assertSee('Title')
//          ->assertSee('Author')
//          ->assertSee('Isbn')
//          ->assertSee('Confirm')
//          ->assertSee('火垂るの墓')
//          ->assertSee('野坂昭如／著 高畑勲／著')
//          ->assertSee('9784197037292');

//     $this->register_from_web($books);
//   }

//   private function register_from_web($book)
//   {
//     $this->post('/register_from_web', $book);

//     $this->assertDatabaseHas('books', [
//       'title' => '火垂るの墓',
//       'author' => '野坂昭如／著 高畑勲／著',
//       'isbn' => '9784197037292'
//     ]);

//     Book::where('title', '火垂るの墓')->delete();
//   }
    // }
}
