<?php

namespace TypiCMS\Modules\Menus\Models;

use TypiCMS\Modules\Core\Shells\Models\BaseTranslation;

class MenuTranslation extends BaseTranslation
{
    /**
     * get the parent model.
     */
    public function owner()
    {
        return $this->belongsTo('TypiCMS\Modules\Menus\Shells\Models\Menu', 'menu_id')->withoutGlobalScopes();
    }
}
