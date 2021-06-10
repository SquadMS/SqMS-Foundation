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
        $this->assertSame('mea', FactionHelper::getFactionTag('Mutaha_Skirmish_v1', 2));
        $this->assertSame('mea', FactionHelper::getFactionTag('Logar_AAS_v2', 2));
        $this->assertSame('im', FactionHelper::getFactionTag('Kokan_Skirmish_v1', 1));
    }
}
