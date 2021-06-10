<?php

namespace SquadMS\Foundation\Tests\Feature;

use SquadMS\Foundation\Helpers\LocaleHelper;
use SquadMS\Foundation\Tests\TestCase;

class LocaleHelperTest extends TestCase
{
    /**
     * Validate that the getHumanReadableName helper function is working as intended.
     *
     * @return void
     */
    public function test_get_human_readable_name()
    {
        $this->app->setLocale('en');

        $this->assertSame('English', LocaleHelper::getHumanReadableName('en'));

        $this->app->setLocale('de');

        $this->assertSame('Englisch', LocaleHelper::getHumanReadableName('en'));
    }
}
