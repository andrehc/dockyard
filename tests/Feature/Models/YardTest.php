<?php

namespace Tests\Feature\Models;

use App\Models\Container;
use App\Models\Yard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class YardTest extends TestCase
{
    use RefreshDatabase;

    public function test_area_is_calculated()
    {
        $yard = Yard::factory()->create();

        $areaExpected = ($yard->width * $yard->length) / 10000;

        $this->assertSame($areaExpected, $yard->area);
    }

    public function test_stacks_are_calculated()
    {
        $yard = Yard::factory()->create();
        $containers = Container::factory()
            ->count(15)
            ->for($yard)
            ->create();
        $stacksExpected = 2;

        $this->assertSame($stacksExpected, $yard->stacks);
    }


    public function test_container_capacity_is_calculated()
    {
        $yard = Yard::factory()->create([
            'length' => 2000,
            'width' => 1000,
        ]);

        $maximum_stacking = 9;
        
        $container_length = 606;
        $container_width = 244;

        $y_containers = 3;
        $x_containers = 4;
        
        $container_capacity_expected = $y_containers * $x_containers * $maximum_stacking;

        $this->assertSame($container_capacity_expected, $yard->container_capacity);
    }
}
