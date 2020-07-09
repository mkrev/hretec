<?php

namespace Tests\Feature;

use App\Models\{User, Quest};
use App\Models\Contents\Video;
use Tests\TestCase;
use QuestsTableSeeder;

class VideoTest extends TestCase
{
    /** @var \App\User */
    protected $user;


    public function setUp(): void
    {

        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->video = factory(Video::class)->create(['user_id' => $this->user->id]);
        $this->seed(QuestsTableSeeder::class);
    }

    /** @test */
    public function add_video()
    {

        $this->actingAs($this->user)
            ->postJson('/api/update-or-create/video', [
                'title' => 'Test Title',
                'description' => 'Test Description',
            ])
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'title', 'description']);
    }

    /** @test */
    public function update_video()
    {
        $this->actingAs($this->user)
            ->postJson("/api/update-or-create/video/{$this->video->id}", [
                'title' => 'Update Test Title',
                'description' => 'Update Test Description',
            ])
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'title', 'description']);

        $this->assertDatabaseHas('videos', [
            'id' => $this->video->id,
            'title' => 'Update Test Title',
            'description' => 'Update Test Description',
        ]);
    }

    /** @test */
    public function delete_video()
    {
        $this->actingAs($this->user)
            ->deleteJson("/api/video/{$this->video->id}")
            ->assertSuccessful();

        $this->assertDeleted('videos', ['id' => $this->video->id]);
    }

    /** @test */
    public function get_video()
    {
        $this->actingAs($this->user)
            ->getJson("/api/video/{$this->video->id}")
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'title', 'description']);
    }

    /** @test */
    public function video_add_comment()
    {
        $this->actingAs($this->user)
            ->postJson("/api/video/{$this->video->id}/add-comment", [
                'content' => 'Test Comment Content'
            ])
            ->assertSuccessful()
            ->assertJsonStructure(['id', 'content', 'commentable_id', 'commentable_type']);

        $this->assertDatabaseHas('comments', [
            'content' => 'Test Comment Content',
            'commentable_type' => Video::class,
        ]);
    }


    /** @test */
    public function video_add_first_comment()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->postJson("/api/video/{$this->video->id}/add-comment", [
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
      public function video_add_like()
      {
          $this->actingAs($this->user)
              ->postJson("/api/video/{$this->video->id}/add-like",[
                  'is_like' => 1,
              ])
              ->assertSuccessful()
              ->assertJsonStructure(['like', 'model']);

  
      }
}
