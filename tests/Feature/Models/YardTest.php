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

        $areaExpected = $yard->width * $yard->length;

        $this->assertSame($areaExpected, $yard->area);
    }

    public function test_stacks_area_calculated()
    {
        $yard = Yard::factory()->create();
        $containers = Container::factory()
            ->count(15)
            ->for($yard)
            ->create();
        $stacksExpected = 2;
        
        $this->assertSame($stacksExpected, $yard->stacks);
    }
}
