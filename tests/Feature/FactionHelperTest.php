<?php

namespace SquadMS\Foundation\Tests\Feature;

use SquadMS\Foundation\Helpers\FactionHelper;
use SquadMS\Foundation\Tests\TestCase;

class FactionHelperTest extends TestCase
{
    /**
     * Validate that the getHumanReadableName helper function is working as intended.
     *
     * @return void
     */
    public function test_get_faction_tag()
    {
        $this->assertSame('im', FactionHelper::getFactionTag('Irregular Militia Forces'));
        $this->assertSame('ins', FactionHelper::getFactionTag('Insurgent Forces'));
        $this->assertSame('ru', FactionHelper::getFactionTag('Russian Ground Forces'));
    }
}
