<?php

namespace Tests\Feature;

use App\Models\{User,Quest}; 
use App\Models\Contents\Article;
use Tests\TestCase;
use QuestsTableSeeder;

class ArticleTest extends TestCase
{
    /** @var \App\User */
    protected $user;


    public function setUp(): void
    {
     
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->article = factory(Article::class)->create([ 'user_id' => $this->user->id]);
        $this->seed(QuestsTableSeeder::class);
    }

    /** @test */
    public function add_article()
    {
      
        $this->actingAs($this->user)
            ->postJson('/api/update-or-create/article', [
                'title' => 'Test Title',
                'content' => 'Test Content',
            ])
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'title', 'content']);

    }

    /** @test */
    public function update_article()
    {
        $this->actingAs($this->user)
            ->postJson("/api/update-or-create/article/{$this->article->id}", [
                'title' => 'Update Test Title',
                'content' => 'Update Test Content',
            ])
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'title', 'content']);

            $this->assertDatabaseHas('articles', [
                'id' => $this->article->id,
                'title' => 'Update Test Title',
                'content' => 'Update Test Content',
            ]);

    }

    /** @test */
    public function delete_article()
    {
        $this->actingAs($this->user)
            ->deleteJson("/api/article/{$this->article->id}")
            ->assertSuccessful();

            $this->assertDeleted('articles', ['id' => $this->article->id]);

    }

     /** @test */
     public function get_article()
     {
         $this->actingAs($this->user)
             ->getJson("/api/article/{$this->article->id}")
             ->assertSuccessful()
             ->assertJsonStructure(['id', 'title', 'content']);
 
     }

      /** @test */
      public function article_add_comment()
      {
          $this->actingAs($this->user)
              ->postJson("/api/article/{$this->article->id}/add-comment",[
                  'content' => 'Test Comment Content'
              ])
              ->assertSuccessful()
              ->assertJsonStructure(['id', 'content', 'commentable_id', 'commentable_type']);

              $this->assertDatabaseHas('comments', [
               'content' => 'Test Comment Content',
               'commentable_type' => Article::class,
           ]);
  
      }


       /** @test */
       public function article_add_first_comment()
       {
           $user = factory(User::class)->create();
           $this->actingAs($user)
               ->postJson("/api/article/{$this->article->id}/add-comment",[
                   'content' => 'Test Comment Content'
               ])
               ->assertSuccessful()
               ->assertJsonStructure(['id', 'content', 'commentable_id', 'commentable_type']);

            $this->assertDatabaseHas('users', [
                'id' => $this->user->id,
                'rating' => Quest::where('key','first_comment')->first()->points,
            ]);

       }

        /** @test */
      public function article_add_like()
      {
          $this->actingAs($this->user)
              ->postJson("/api/article/{$this->article->id}/add-like",[
                  'is_like' => 1,
              ])
              ->assertSuccessful()
              ->assertJsonStructure(['like', 'model']);

  
      }

}
