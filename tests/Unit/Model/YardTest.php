<?php

namespace Tests\Unit\Model;

use App\Models\Yard;
use PHPUnit\Framework\TestCase;

class YardTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_area_is_calculated()
    {
        $yard = new Yard([
            'locator' => 'ABC',
            'width' => 100,
            'length' => 300
        ]);

        $areaExpected = $yard->width * $yard->length;

        $this->assertSame($areaExpected, $yard->area);
    }
}
