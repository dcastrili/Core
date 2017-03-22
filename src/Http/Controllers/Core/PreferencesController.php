<?php

namespace LaravelEnso\Core\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\User;
use LaravelEnso\Core\Enums\DefaultPreferencesEnum;
use LaravelEnso\Core\Models\Preference;

class PreferencesController extends Controller
{

    public static function getPreferences($page)
    {
        $userPreferences = request()->user()->preferences
            ->where('key', $page)->first();

        $defaultPreferencesEnum = new DefaultPreferencesEnum;

        $result = $userPreferences ?
            $userPreferences->value
            : json_encode($defaultPreferencesEnum->getValueByKey($page));

        return $result;
    }

    public function setPreferences()
    {
        $preferences = request()->user()->preferences
            ->where('key', request()->key)->first();

        if (!$preferences) {

            $preferences          = new Preference;
            $preferences->user_id = request()->user()->id;
            $preferences->key     = request()->key;
        }

        $preferences->value = request()->value;

        $preferences->save();
    }

    public function resetToDefaut()
    {
        $preferences = request()->user()->preferences
            ->where('key', request()->key)->first();

        $defaultPreferencesEnum = new DefaultPreferencesEnum;
        $defaultPreferences = json_encode($defaultPreferencesEnum->getValueByKey(request()->key));

        if($preferences) {

            $preferences->value = $defaultPreferences;
            $preferences->save();
        }

        return json_decode($defaultPreferences, true);
    }
}
