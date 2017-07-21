<?php

namespace TypiCMS\Modules\Menus\Models;

use TypiCMS\Modules\Core\Shells\Traits\Translatable;
use InvalidArgumentException;
use Laracasts\Presenter\PresentableTrait;
use Log;
use TypiCMS\Modules\Core\Shells\Models\Base;
use TypiCMS\Modules\History\Shells\Traits\Historable;
use TypiCMS\NestableTrait;

class Menulink extends Base
{
    use Historable;
    use Translatable;
    use PresentableTrait;
    use NestableTrait;

    protected $presenter = 'TypiCMS\Modules\Menus\Shells\Presenters\MenulinkPresenter';

    protected $fillable = [
        'menu_id',
        'page_id',
        'parent_id',
        'position',
        'target',
        'restricted_to',
        'class',
        'icon_class',
        'link_type',
        'has_categories',
        // Translatable columns
        'title',
        'url',
        'status',
    ];

    /**
     * Translatable model configs.
     *
     * @var array
     */
    public $translatedAttributes = [
        'title',
        'url',
        'status',
    ];

    protected $appends = [];

    /**
     * A menulink belongs to a menu.
     */
    public function menu()
    {
        return $this->belongsTo('TypiCMS\Modules\Menus\Shells\Models\Menu');
    }

    /**
     * A menulink can belongs to a page.
     */
    public function page()
    {
        return $this->belongsTo('TypiCMS\Modules\Pages\Shells\Models\Page')->select(['pages.id', 'title', 'uri', 'status']);
    }

    /**
     * A menulink can have children.
     */
    public function children()
    {
        return $this->hasMany('TypiCMS\Modules\Menus\Shells\Models\Menulink', 'parent_id');
    }

    /**
     * A menulink can have a parent.
     */
    public function parent()
    {
        return $this->belongsTo('TypiCMS\Modules\Menus\Shells\Models\Menulink', 'parent_id');
    }

    /**
     * Get edit url of model.
     *
     * @return string|void
     */
    public function editUrl()
    {
        try {
            return route('admin::edit-menulink', [$this->menu_id, $this->id]);
        } catch (InvalidArgumentException $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Get back office’s index of models url.
     *
     * @return string|void
     */
    public function indexUrl()
    {
        try {
            return route('admin::edit-menu', $this->menu_id);
        } catch (InvalidArgumentException $e) {
            Log::error($e->getMessage());
        }
    }

}
