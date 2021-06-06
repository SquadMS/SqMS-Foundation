<?php

namespace SquadMS\Foundation\Helpers;

class LevelHelper {
    /**
     * Converts the level name to a CSS compatible class name
     * 
     * https://stackoverflow.com/a/12351201
     *
     * @param string $level
     * @return string
     */
    static function levelToClass(string $level) : string
    {
        return preg_replace('/\W+/','',strtolower(strip_tags($level)));
    }
}