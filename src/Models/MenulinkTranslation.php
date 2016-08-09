<?php

namespace TypiCMS\Modules\Menus\Models;

use TypiCMS\Modules\Core\Shells\Models\BaseTranslation;

class MenulinkTranslation extends BaseTranslation
{
    /**
     * get the parent model.
     */
    public function menulink()
    {
        return $this->belongsTo('TypiCMS\Modules\Menus\Shells\Models\Menulink');
    }

    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Menus\Shells\Models\Menulink', 'menulink_id')->withoutGlobalScopes();
    }
}
