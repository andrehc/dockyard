<?php

namespace Tests\Feature\Http;

use App\Models\Box;
use App\Models\Container;
use App\Models\Yard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class BoxControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Tests if the list of yards endpoint is working
     *
     * @return void
     */
    public function test_boxs_are_listed()
    {
        $items = rand(1, 15);

        $box = Box::factory()
        ->count($items)
        ->for(
            Container::factory()
                ->for(Yard::factory()->create())
                ->create())
        ->create();        

        $response = $this->getJson('api/boxes');
        $response
            ->assertStatus(200)
            ->assertJsonCount($items, 'data');
    }

    public function test_empty_box_list_returns_ok()
    {
        Box::whereNotNull('id')->delete();
        $response = $this->getJson('api/boxes');
        $response
            ->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    public function test_specific_box_is_displayed()
    {
        $box = Box::factory()
            ->for(
                Container::factory()
                    ->for(Yard::factory()->create())
                    ->create())
            ->create();                       
        
            $response = $this->getJson("api/boxes/{$box->id}");
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $box->id]);
    }

    public function test_box_can_be_created()
    {
        $box = Box::factory()
            ->for(
                Container::factory()
                    ->for(Yard::factory()->create())
                    ->create())
            ->make();
        $response = $this->postJson("api/boxes", $box->toArray());
        $response
            ->assertStatus(201);
    }

    public function test_box_can_not_be_updated()
    {
       $this->assertFalse(Route::has('boxes.update'));
    }


    public function test_box_can_be_deleted()
    {
        $box = Box::factory()
            ->for(
                Container::factory()
                    ->for(Yard::factory()->create())
                    ->create())
            ->create();

        $response = $this->deleteJson("api/boxes/{$box->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('boxes', [
            'id' => $box->id
        ]);
    }
}
