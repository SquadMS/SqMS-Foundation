<?php

namespace SquadMS\Foundation\Resources\Concerns\Translatable;

trait Translatable {
  use \Filament\Resources\Concerns\Translatable;
  
  public static function getTranslatableLocales(): array
  {
      return config('sqms.locales');
  }
}
