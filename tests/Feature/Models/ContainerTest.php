<?php

namespace Tests\Feature\Models;

use App\Models\Box;
use App\Models\Container;
use App\Models\Yard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContainerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_container_volume_is_calculated()
    {
        $container = Container::factory()->for(Yard::factory()->create())->create();

        $volumeExpected = round(($container->width * $container->length * $container->height) / 1000000, 2);

        $this->assertSame($volumeExpected, $container->volume);
    }

    public function test_container_gross_weight_is_calculated()
    {
        $container = Container::factory()
            ->for(Yard::factory()->create())
            ->create();
        
        $boxes = Box::factory()        
            ->count(15)
            ->for($container)
            ->create();
        
        $boxes_weight = 0;

        foreach ($boxes as $box) {
            $boxes_weight += $box->weight;
        }

        $expectedWeight = round(($boxes_weight + $container->tare_weight) / 1000, 2);

        $this->assertSame($expectedWeight, $container->gross_weight);

    }

    public function test_container_net_weight_is_calculated()
    {
        $container = Container::factory()
            ->for(Yard::factory()->create())
            ->create();
        
        $boxes = Box::factory()        
            ->count(15)
            ->for($container)
            ->create();
        
        $boxes_weight = 0;

        foreach ($boxes as $box) {
            $boxes_weight += $box->weight;
        }

        $expectedWeight = round($boxes_weight/1000, 2);

        $this->assertSame($expectedWeight, $container->net_weight);

    }

    public function test_container_net_volume_is_calculated()
    {
        $container = Container::factory()
            ->for(Yard::factory()->create())
            ->create();
        
        $boxes = Box::factory()        
            ->count(15)
            ->for($container)
            ->create();
        
        $net_volume = 0;

        foreach ($boxes as $box) {
            $net_volume += $box->volume;
        }       
        
        $this->assertSame(round($net_volume, 2), $container->net_volume);
    }

    public function test_container_free_volume_is_calculated()
    {
        $container = Container::factory()
            ->for(Yard::factory()->create())
            ->create();
        
        $boxes = Box::factory()        
            ->count(15)
            ->for($container)
            ->create([
                'width' => 100,
                'height' => 100,
                'length' => 100,
            ]);
        
        $net_volume = 0;

        foreach ($boxes as $box) {
            $net_volume += $box->volume;
        }       

        $expected = $container->volume - $net_volume;
        
        $this->assertSame(round($expected, 2), $container->free_volume);
    }

    


}
