<?php

namespace TypiCMS\Modules\Menus\Models;

use TypiCMS\Modules\Core\Shells\Traits\Translatable;
use Laracasts\Presenter\PresentableTrait;
use TypiCMS\Modules\Core\Shells\Models\Base;
use TypiCMS\Modules\History\Shells\Traits\Historable;

class Menu extends Base
{
    use Historable;
    use Translatable;
    use PresentableTrait;

    protected $presenter = 'TypiCMS\Modules\Menus\Shells\Presenters\ModulePresenter';

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
        return $this->hasMany('TypiCMS\Modules\Menus\Shells\Models\Menulink')->orderBy('position', 'asc');
    }

}
