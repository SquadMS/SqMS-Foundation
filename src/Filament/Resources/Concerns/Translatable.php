<?php

namespace SquadMS\Foundation\Filament\Resources\Concerns;

trait Translatable {
  use \Filament\Resources\Concerns\Translatable;
  
  public static function getTranslatableLocales(): array
  {
      return config('sqms.locales');
  }
}
