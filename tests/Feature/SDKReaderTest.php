<?php

namespace SquadMS\Foundation\Tests\Feature;

use SquadMS\Foundation\Facades\SDKDataReader;
use SquadMS\Foundation\Tests\TestCase;

class SDKReaderTest extends TestCase
{
    /**
     * Validate that the getFactionForTeamID helper is working as intended.
     *
     * @return void
     */
    public function test_get_faction_for_team_id()
    {
        $this->assertSame('Middle Eastern Alliance', SDKDataReader::getFactionForTeamID('Fallujah_Invasion_v2', 1));
        $this->assertSame('Irregular Militia Forces', SDKDataReader::getFactionForTeamID('Fools_Road_Invasion_v1', 2));
    }

    /**
     * Validate that the getSetupForTeamID helper is working as intended.
     *
     * @return void
     */
    public function test_get_setup_for_team_id()
    {
        $this->assertSame('MEA Combined Arms Battalion', SDKDataReader::getSetupForTeamID('Fallujah_Invasion_v2', 1));
        $this->assertSame('Local Militia Group', SDKDataReader::getSetupForTeamID('Fools_Road_Invasion_v1', 2));
    }

    /**
     * Validate that the getSetupForTeamID helper is working as intended.
     *
     * @return void
     */
    public function test_get_layer_for_raw()
    {
        $this->assertSame('Jensens_Range_v1', SDKDataReader::getLayerForRaw('JensensRange_GB-MIL'));
        $this->assertSame('CAF_Gorodok_AAS_v1', SDKDataReader::getLayerForRaw('CAF_Gorodok_AAS_v1'));
    }
}
