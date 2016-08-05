<?php

namespace TypiCMS\Modules\Menus\Presenters;

use TypiCMS\Modules\Core\Custom\Presenters\Presenter;

class ModulePresenter extends Presenter
{
    /**
     * Get title.
     *
     * @return string
     */
    public function title()
    {
        return $this->entity->name;
    }
}
