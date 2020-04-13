<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class EleTest extends TestCase
{
    // use RefreshDatabase;
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

     /**
     * ログインした状態でリクエストが正しく処理されるか
     * ユーザーを自動で作る
     */

    public function testLoggedIn()
    {
        $user = factory(\App\User::class)->make();
 
        $response = $this->actingAs($user)
                         ->get('/');
 
        $response->assertStatus(200);
    }
    /**
     * Undocumented function
     *
     * @return void
     * データベースが指定の値を持っているか
     */
    public function testDatabase()
    {
    // アプリケーションを呼び出す…

    $this->assertDatabaseHas('users', [
        'email' => 'aa@email.com'
    ]);
    }
    /**
     * Undocumented function
     *
     * @return void
     * 選挙を作成して、マイページに飛んだ時、タイトルが表示されるか
     */

    public function testDatabase2()
    {
        // 一つのApp\Userインスタンスを作成
        // $users = factory(\App\User::class)->create()
        //    ->each(function ($user) {
        //         $user->elections()->save(factory(\App\Election::class)->make());
        //     });

              // electionsからリレーションでcandidateを作成
         $elections = factory(\App\Election::class)->make()
                ->each(function ($election)
                { 
                    $election->candidates()->save(factory(\App\Candidate::class)->make());
                    });
         
                    $this->assertTrue($elections);

                    // candidateからリレーションでelectionはできない？
        //  $candidate = factory(\App\Candidate::class)->create()
        //             ->each(function ($candidate)
        //             { 
        //                 $candidate->election()->save(factory(\App\Election::class)->make());
        //                 });
        // $readElection = $elections->first(); // 取れない
        // foreach($election as $election)
        // {
            //     $this->assertNotNull($election->title); // データが取得できたかテスト
            // }
            // $table='elections';
        // $this->assertDatabaseHas($table, ['title',$readElection->title]);
        // $this->assertTrue('title', $readElection->title);
        
        //electionの一覧を表示するURLにアクセスすると
        //electionが見える
        // $response->assertSee($election->title);
    }
    
    // }
    /**
     * Undocumented function
     *
     * @return void
     * 
     * _登録処理が成功する事を検証
     */
    
    public function insert()
    {
        $response = $this->get(route('elections.show', ['id' => 19]));
        $response->assertSee('候補');
        $response->assertStatus(200);
    }

    public function postVotes()
    {
        $response = $this->get(route('elections.show', ['id' => 19]));

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'id'   => 19,
                'title' => 'aa',
            ]),
            $response->content()
            );
            
            $response = $this->post('/elections/show', [
                'voted' => 'name1'
                ]);
                $this->assertDatabaseHas('votes', [
                    'voted' => 'name1',
                    ]);
   }
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
