<?php

namespace SquadMS\Foundation\View\Components\Layouts;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App as FacadesApp;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use SquadMS\Foundation\Facades\SquadMSNavigation;
use SquadMS\Foundation\Helpers\LocaleHelper;
use SquadMS\Foundation\Menu\Contracts\Walker;
use SquadMS\Foundation\Menu\NavigationWalker;

class App extends Component
{
    /**
     * CSS string added to the class of the main element.
     */
    public string $mainClass;

    /**
     * The Walker instance for the main navigation.
     */
    public Walker $navWalker;

    /**
     * Array of available locales with route, flag-icons class & name
     */
    public array  $locales;

    /**
     * flag-icons class for the current locale
     */
    public string $currentLocaleClass;

    /**
     * Determines if the direction is LTR (false) or RTL (true)
     */
    public bool   $direction = false;

    /**
     * Create the component instance.
     *
     * @param  ?string  $mainClass
     * @return void
     */
    public function __construct(string $mainClass = '')
    {
        $this->mainClass = $mainClass;
        $this->navWalker = new NavigationWalker(SquadMSNavigation::get('main'));

        $this->direction = LocaleHelper::isRTL(FacadesApp::currentLocale());

        $this->currentLocaleClass = LocaleHelper::localeToFlagIconsCSS(FacadesApp::currentLocale());

        $this->locales = Collection::make(LocaleHelper::getAvailableLocales(true))->mapWithKeys(fn (string $locale) => [
            $locale => [
                'url'   => Route::localizedUrl($locale),
                'class' => LocaleHelper::localeToFlagIconsCSS($locale),
                'name'  => locale_get_display_name($locale, FacadesApp::currentLocale()),
            ],
        ])->toArray();
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('sqms-foundation::layouts.app');
    }
}
