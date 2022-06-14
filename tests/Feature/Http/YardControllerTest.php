<?php

namespace Tests\Feature\Http;

use App\Models\Yard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class YardControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Tests if the list of yards endpoint is working
     *
     * @return void
     */
    public function test_yards_are_listed()
    {
        $items = rand(1, 15);
        
        Yard::factory()
            ->count($items)
            ->create();
        
        $response = $this->getJson('api/yards');
        $response
            ->assertStatus(200)
            ->assertJsonCount($items, 'data');
    }

    public function test_empty_yard_list_returns_ok()
    {
        Yard::whereNotNull('locator')->delete();
        $response = $this->getJson('api/yards');
        $response
            ->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    public function test_specific_yard_is_displayed()
    {
        $yard = Yard::factory()->create();
        $response = $this->getJson("api/yards/{$yard->id}");
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['locator' => $yard->locator]);
    }

    public function test_yard_can_be_created()
    {
        $yard = Yard::factory()->make();        
        $response = $this->postJson("api/yards", $yard->toArray());
        $response
            ->assertStatus(201)
            ->assertJsonFragment(['locator' => $yard->locator]);
    }

    public function test_yard_locator_must_contain_only_letters()
    {
        $locators = ['A2C', '123', 'AB%'];

        foreach ($locators as $locator) {

        $yard = Yard::factory()->make(['locator'=>$locator]);
        $response = $this->postJson("api/yards", $yard->toArray());
        $response
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'=>['locator']]);
        }
    }

    public function test_yard_can_be_updated()
    {        
        $yard = Yard::factory()->create();
        $new_attributes = [
            'locator' => $yard->locator,
            'width' => $yard->width+100,
            'length' => $yard->length+100
        ];
        $response = $this->putJson("api/yards/{$yard->id}", $new_attributes);
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['width'=>$new_attributes['width']]);
    }

    public function test_yard_can_not_be_updated_with_invalid_locator()
    {        
        $yard = Yard::factory()->create();
        $new_attributes = [
            'locator' => 'A1A',
            'width' => $yard->width+100,
            'length' => $yard->length+100
        ];
        $response = $this->putJson("api/yards/{$yard->id}", $new_attributes);
        $response
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'=>['locator']]);
    }

    public function test_yard_cant_have_area_decreased()
    {
        $yard = Yard::factory()->create();        
                
        $new_attributes = [
            'locator' => $yard->locator,
            'width' => $yard->width - (int)($yard->width*0.2),
            'length' => $yard->length
        ];

        $response = $this->putJson("api/yards/{$yard->id}", $new_attributes);
        $response
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors'=>['area']]);
    }

    public function test_yard_can_be_deleted()
    {
        $yard = Yard::factory()->create();
        $response = $this->deleteJson("api/yards/{$yard->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('yards', [
            'locator' => $yard->locator
        ]);
    }
}
