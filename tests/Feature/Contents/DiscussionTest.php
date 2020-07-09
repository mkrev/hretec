<?php

namespace Tests\Feature;

use App\Models\{User, Quest};
use App\Models\Contents\Discussion;
use Tests\TestCase;
use QuestsTableSeeder;

class DiscussionTest extends TestCase
{
    /** @var \App\User */
    protected $user;


    public function setUp(): void
    {

        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->discussion = factory(Discussion::class)->create(['user_id' => $this->user->id]);
        $this->seed(QuestsTableSeeder::class);
    }

    /** @test */
    public function add_discussion()
    {

        $this->actingAs($this->user)
            ->postJson('/api/update-or-create/discussion', [
                'title' => 'Test Title',
                'description' => 'Test Description',
            ])
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'title', 'description']);
    }

    /** @test */
    public function update_discussion()
    {
        $this->actingAs($this->user)
            ->postJson("/api/update-or-create/discussion/{$this->discussion->id}", [
                'title' => 'Update Test Title',
                'description' => 'Update Test Description',
            ])
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'title', 'description']);

        $this->assertDatabaseHas('discussions', [
            'id' => $this->discussion->id,
            'title' => 'Update Test Title',
            'description' => 'Update Test Description',
        ]);
    }

    /** @test */
    public function delete_discussion()
    {
        $this->actingAs($this->user)
            ->deleteJson("/api/discussion/{$this->discussion->id}")
            ->assertSuccessful();

        $this->assertDeleted('discussions', ['id' => $this->discussion->id]);
    }

    /** @test */
    public function get_discussion()
    {
        $this->actingAs($this->user)
            ->getJson("/api/discussion/{$this->discussion->id}")
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'title', 'description']);
    }

    /** @test */
    public function discussion_add_comment()
    {
        $this->actingAs($this->user)
            ->postJson("/api/discussion/{$this->discussion->id}/add-comment", [
                'content' => 'Test Comment Content'
            ])
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'content', 'commentable_id', 'commentable_type']);

        $this->assertDatabaseHas('comments', [
            'content' => 'Test Comment Content',
            'commentable_type' => Discussion::class,
        ]);
    }


    /** @test */
    public function discussion_add_first_comment()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->postJson("/api/discussion/{$this->discussion->id}/add-comment", [
                'content' => 'Test Comment Content'
            ])
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'content', 'commentable_id', 'commentable_type']);

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'rating' => Quest::where('key', 'first_comment')->first()->points,
        ]);
    }

      /** @test */
      public function discussion_add_like()
      {
          $this->actingAs($this->user)
              ->postJson("/api/discussion/{$this->discussion->id}/add-like",[
                  'is_like' => 1,
              ])
              ->assertSuccessful()
              ->assertJsonStructure(['like', 'model']);

  
      }
}
