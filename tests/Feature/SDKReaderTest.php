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
        $this->assertSame('United States Army', SDKDataReader::getFactionForTeamID('Tallil Outskirts RAAS v2', 1));
        $this->assertSame('Middle Eastern Alliance', SDKDataReader::getFactionForTeamID('Sumari_RAAS_v1', 2));
    }

    /**
     * Validate that the getSetupForTeamID helper is working as intended.
     *
     * @return void
     */
    public function test_get_setup_for_team_id()
    {
        $this->assertSame('US Brigade Combat Team', SDKDataReader::getSetupForTeamID('Tallil Outskirts RAAS v2', 1));
        $this->assertSame('MEA Combined Arms Battalion', SDKDataReader::getSetupForTeamID('Sumari_RAAS_v1', 2));
    }

    /**
     * Validate that the getSetupForTeamID helper is working as intended.
     *
     * @return void
     */
    public function test_get_layer_for_display_name()
    {
        $this->assertSame('FoolsRoad_TC_v1', SDKDataReader::getLayer('Fool\'s Road TC v1'));
        $this->assertSame('GooseBay_RAAS_v1', SDKDataReader::getLayer('CAF Goose Bay RAAS v1'));
    }

    /**
     * Validate that the getSetupForTeamID helper is working as intended.
     *
     * @return void
     */
    public function test_get_layer_to_level()
    {
        $this->assertSame('Narva', SDKDataReader::layerToLevel('Narva_Invasion_v1'));
        $this->assertSame('Fool\'s Road', SDKDataReader::layerToLevel('FoolsRoad_Destruction_v1'));
    }
}
