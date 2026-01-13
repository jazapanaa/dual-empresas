<?php

namespace App\Http\Traits;

use App\Models\ClientSetting;
use App\Models\Setting;

trait SettingsTrait
{
    public function getModulesSettings()
    {
        return Setting::where('key','like','modules%');
    }

    public function getModuleSetting($module_setting_id)
    {
        return Setting::find($module_setting_id);
    }
    public function setModuleSetting($modules)
    {
        foreach ($modules as $module) {
            Setting::where('id', $module['id'] )->update(['value' => json_encode((bool)$module['value'])]);
        }
    }
    public function getModulesArray()
    {
        return Setting::where('key','like','modules%')->get()->pluck('value','key')->toArray();
    }

}
