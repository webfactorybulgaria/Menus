<?php

namespace TypiCMS\Modules\Menus\Models;

use TypiCMS\Modules\Core\Custom\Traits\Translatable;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Custom\Models\Base;
use TypiCMS\Modules\History\Custom\Traits\Historable;

class Menu extends Base
{
    use Historable;
    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Menus\Custom\Presenters\ModulePresenter';

    protected $fillable = [
        'name',
        'class',
        // Translatable columns
        'status',
    ];

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = [
        'status',
    ];

    protected $appends = [];

    /**
     * Relations.
     */
    public function menulinks()
    {
        return $this->hasMany('TypiCMS\Modules\Menus\Custom\Models\Menulink')->orderBy('position', 'asc');
    }

}
