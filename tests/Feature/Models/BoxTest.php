<?php

namespace Tests\Feature\Models;

use App\Models\Box;
use App\Models\Container;
use App\Models\Yard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BoxTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_box_volume_is_calculated()
    {
        $box = Box::factory()
            ->for(
                Container::factory()
                ->for(Yard::factory()->create())
                ->create())
            ->create();

        $volumeExpected = ($box->width * $box->length * $box->height) / 1000000;

        $this->assertSame($volumeExpected, $box->volume);
    }
}
