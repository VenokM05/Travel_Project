<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormValidationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
    }

    /** @test */
    public function itinerary_validation_requires_title()
    {
        $response = $this->actingAs($this->user)
            ->post(route('itineraries.store'), [
                'destination' => 'Paris, France',
                'start_date' => '2024-12-01',
                'end_date' => '2024-12-10',
                'status' => 'draft',
            ]);

        $response->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function itinerary_validation_requires_valid_dates()
    {
        $response = $this->actingAs($this->user)
            ->post(route('itineraries.store'), [
                'title' => 'Paris Adventure',
                'destination' => 'Paris, France',
                'start_date' => '2024-12-10',
                'end_date' => '2024-12-01', // End before start
                'status' => 'draft',
            ]);

        $response->assertSessionHasErrors(['end_date']);
    }

    /** @test */
    public function itinerary_validation_rejects_negative_budget()
    {
        $response = $this->actingAs($this->user)
            ->post(route('itineraries.store'), [
                'title' => 'Paris Adventure',
                'destination' => 'Paris, France',
                'start_date' => '2024-12-01',
                'end_date' => '2024-12-10',
                'budget_total' => -100,
                'status' => 'draft',
            ]);

        $response->assertSessionHasErrors(['budget_total']);
    }

    /** @test */
    public function itinerary_validation_rejects_invalid_status()
    {
        $response = $this->actingAs($this->user)
            ->post(route('itineraries.store'), [
                'title' => 'Paris Adventure',
                'destination' => 'Paris, France',
                'start_date' => '2024-12-01',
                'end_date' => '2024-12-10',
                'status' => 'invalid_status',
            ]);

        $response->assertSessionHasErrors(['status']);
    }

    /** @test */
    public function budget_validation_requires_name()
    {
        $response = $this->actingAs($this->user)
            ->post(route('budgets.store'), [
                'total_budget' => 5000,
                'currency' => 'USD',
                'type' => 'solo',
            ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function budget_validation_rejects_negative_amount()
    {
        $response = $this->actingAs($this->user)
            ->post(route('budgets.store'), [
                'name' => 'Paris Budget',
                'total_budget' => -100,
                'currency' => 'USD',
                'type' => 'solo',
            ]);

        $response->assertSessionHasErrors(['total_budget']);
    }

    /** @test */
    public function budget_validation_requires_valid_currency()
    {
        $response = $this->actingAs($this->user)
            ->post(route('budgets.store'), [
                'name' => 'Paris Budget',
                'total_budget' => 5000,
                'currency' => 'USDX', // 4 characters
                'type' => 'solo',
            ]);

        $response->assertSessionHasErrors(['currency']);
    }

    /** @test */
    public function budget_validation_requires_valid_type()
    {
        $response = $this->actingAs($this->user)
            ->post(route('budgets.store'), [
                'name' => 'Paris Budget',
                'total_budget' => 5000,
                'currency' => 'USD',
                'type' => 'invalid',
            ]);

        $response->assertSessionHasErrors(['type']);
    }

    /** @test */
    public function todo_validation_requires_title()
    {
        $response = $this->actingAs($this->user)
            ->post(route('todos.store'), [
                'priority' => 'high',
                'status' => 'pending',
            ]);

        $response->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function todo_validation_requires_valid_priority()
    {
        $response = $this->actingAs($this->user)
            ->post(route('todos.store'), [
                'title' => 'Book hotel',
                'priority' => 'critical', // Invalid
                'status' => 'pending',
            ]);

        $response->assertSessionHasErrors(['priority']);
    }

    /** @test */
    public function todo_validation_requires_valid_status()
    {
        $response = $this->actingAs($this->user)
            ->post(route('todos.store'), [
                'title' => 'Book hotel',
                'priority' => 'high',
                'status' => 'archived', // Invalid
            ]);

        $response->assertSessionHasErrors(['status']);
    }

    /** @test */
    public function memory_validation_requires_title()
    {
        $response = $this->actingAs($this->user)
            ->post(route('memories.store'), [
                'date' => '2024-12-05',
                'location' => 'Paris, France',
            ]);

        $response->assertSessionHasErrors(['title']);
    }

    /** @test */
    public function memory_validation_requires_valid_date()
    {
        $response = $this->actingAs($this->user)
            ->post(route('memories.store'), [
                'title' => 'Eiffel Tower Visit',
                'date' => 'not-a-date',
            ]);

        $response->assertSessionHasErrors(['date']);
    }

    /** @test */
    public function post_validation_requires_content()
    {
        $response = $this->actingAs($this->user)
            ->post(route('social.post.store'), [
                'privacy' => 'public',
            ]);

        $response->assertSessionHasErrors(['content']);
    }

    /** @test */
    public function post_validation_rejects_content_too_long()
    {
        $response = $this->actingAs($this->user)
            ->post(route('social.post.store'), [
                'content' => str_repeat('A', 2001), // Over 2000 limit
            ]);

        $response->assertSessionHasErrors(['content']);
    }

    /** @test */
    public function post_validation_requires_valid_privacy()
    {
        $response = $this->actingAs($this->user)
            ->post(route('social.post.store'), [
                'content' => 'Great post!',
                'privacy' => 'secret', // Invalid
            ]);

        $response->assertSessionHasErrors(['privacy']);
    }

    /** @test */
    public function comment_validation_requires_content()
    {
        // First create a post to comment on
        $post = \App\Models\Post::create([
            'user_id' => $this->user->id,
            'content' => 'Test post',
            'privacy' => 'public',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('social.post.comment', $post));

        $response->assertSessionHasErrors(['content']);
    }

    /** @test */
    public function comment_validation_rejects_content_too_long()
    {
        $post = \App\Models\Post::create([
            'user_id' => $this->user->id,
            'content' => 'Test post',
            'privacy' => 'public',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('social.post.comment', $post), [
                'content' => str_repeat('A', 1001), // Over 1000 limit
            ]);

        $response->assertSessionHasErrors(['content']);
    }

    /** @test */
    public function valid_itinerary_passes_validation()
    {
        $response = $this->actingAs($this->user)
            ->post(route('itineraries.store'), [
                'title' => 'Paris Adventure',
                'destination' => 'Paris, France',
                'start_date' => '2024-12-01',
                'end_date' => '2024-12-10',
                'budget_total' => 5000,
                'status' => 'draft',
                'description' => 'Amazing trip',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('itineraries.index'));
    }

    /** @test */
    public function valid_budget_passes_validation()
    {
        $response = $this->actingAs($this->user)
            ->post(route('budgets.store'), [
                'name' => 'Paris Budget',
                'total_budget' => 5000,
                'currency' => 'USD',
                'type' => 'solo',
            ]);

        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function valid_todo_passes_validation()
    {
        $response = $this->actingAs($this->user)
            ->post(route('todos.store'), [
                'title' => 'Book hotel',
                'priority' => 'high',
                'status' => 'pending',
                'due_date' => '2024-11-15',
            ]);

        $response->assertSessionHasNoErrors();
    }
}
