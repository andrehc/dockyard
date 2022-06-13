<?php

namespace Tests\Feature\Models;

use App\Models\Container;
use App\Models\Yard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContainerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_volume_is_calculated()
    {
        $container = Container::factory()->for(Yard::factory()->create())->create();

        $volumeExpected = ($container->width * $container->length * $container->height) / 1000000;

        $this->assertSame($volumeExpected, $container->volume);
    }
}
