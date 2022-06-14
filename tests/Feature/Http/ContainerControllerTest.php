<?php

namespace Tests\Feature\Http;

use App\Models\Box;
use App\Models\Container;
use App\Models\Yard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ContainerControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Tests if the list of yards endpoint is working
     *
     * @return void
     */
    public function test_containers_are_listed()
    {
        $items = rand(1, 15);

        Container::factory()
            ->count($items)
            ->for(Yard::factory()->create())
            ->create();

        $response = $this->getJson('api/containers');
        $response
            ->assertStatus(200)
            ->assertJsonCount($items, 'data');
    }

    public function test_empty_container_list_returns_ok()
    {
        Container::whereNotNull('locator')->delete();
        $response = $this->getJson('api/containers');
        $response
            ->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    public function test_specific_container_is_displayed()
    {
        $container = Container::factory()->for(Yard::factory()->create())->create();
        $response = $this->getJson("api/containers/{$container->id}");
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['locator' => $container->locator]);
    }

    public function test_container_can_be_created()
    {
        $container = Container::factory()->for(Yard::factory()->create())->make();
        $response = $this->postJson("api/containers", $container->toArray());
        $response
            ->assertStatus(201)
            ->assertJsonFragment(['locator' => $container->locator]);
    }

    public function test_container_locator_must_have_one_letter_and_two_digits()
    {
        $locators = ['ABC', '123', 'A2B'];

        foreach ($locators as $locator) {
            $container = Container::factory()->for(Yard::factory()->create())->make(['locator' => $locator]);
            $response = $this->postJson("api/containers", $container->toArray());
            $response
                ->assertStatus(422)
                ->assertJsonStructure(['message', 'errors' => ['locator']]);
        }
    }

    public function test_oversized_container_cannot_be_created()
    {
        $container = Container::factory()->oversized()->for(Yard::factory()->create())->make();
        $response = $this->postJson("api/containers", $container->toArray());
        $response->assertStatus(422);
    }

    public function test_container_can_not_be_created_without_free_area_in_yard()
    {
        $yard = Yard::factory()->create([
            'width' => 500,
            'length' => 1500
        ]);
        $maximum_stacking = 9;
        $y_containers = 2;
        $x_containers = 2;

        $container_capacity_expected = $y_containers * $x_containers * $maximum_stacking;

        Container::factory()
            ->count($container_capacity_expected)
            ->for($yard)
            ->create();

        $container = Container::factory()->for($yard)->make();
        $response = $this->postJson("api/containers", $container->toArray());
        $response
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'=>['no_free_area']]);
    }


    public function test_container_can_not_be_updated()
    {
        $this->assertFalse(Route::has('containers.update'));
    }


    public function test_container_can_be_soft_deleted()
    {
        $container = Container::factory()->for(Yard::factory()->create())->create();
        $response = $this->deleteJson("api/containers/{$container->id}");
        $response->assertStatus(200);        
    }

    public function test_container_with_boxes_cant_be_deleted()
    {
        $container = Container::factory()->for(Yard::factory()->create())->create();
        Box::factory()->count(3)->for($container)->create();
        $response = $this->deleteJson("api/containers/{$container->id}");
        $response
            ->assertStatus(422)
            ->assertJsonStructure(['message']);
       
    }
}
