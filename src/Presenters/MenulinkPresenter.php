<?php

namespace TypiCMS\Modules\Menus\Presenters;

use TypiCMS\Modules\Core\Custom\Presenters\Presenter;

class MenulinkPresenter extends Presenter
{
    public function menuclass()
    {
        return $this->entity->menuclass;
    }
}
