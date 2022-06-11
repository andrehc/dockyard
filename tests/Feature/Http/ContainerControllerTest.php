<?php

namespace Tests\Feature\Http;

use App\Models\Container;
use App\Models\Yard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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


    public function test_container_can_not_be_updated()
    {
        $yard = Yard::factory()->create();
        $container = Container::factory()->for($yard)->create();
        $new_attributes = [
            'locator' => $container->locator,
            'width' => $container->width/2,
            'length' => $container->length/2,
            'yard_id' => $yard->id
        ];
        $response = $this->putJson("api/containers/{$container->id}", $new_attributes);
        
        $response
            ->assertStatus(405);
    }


    public function test_container_can_be_deleted()
    {
        $container = Container::factory()->for(Yard::factory()->create())->create();
        $response = $this->deleteJson("api/containers/{$container->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('containers', [
            'locator' => $container->locator
        ]);
    }
}
