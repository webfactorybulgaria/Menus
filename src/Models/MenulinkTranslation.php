<?php

namespace TypiCMS\Modules\Menus\Models;

use TypiCMS\Modules\Core\Custom\Models\BaseTranslation;

class MenulinkTranslation extends BaseTranslation
{
    /**
     * get the parent model.
     */
    public function menulink()
    {
        return $this->belongsTo('TypiCMS\Modules\Menus\Custom\Models\Menulink');
    }

    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Menus\Custom\Models\Menulink', 'menulink_id')->withoutGlobalScopes();
    }
}
