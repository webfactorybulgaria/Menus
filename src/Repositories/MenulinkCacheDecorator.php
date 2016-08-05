<?php

namespace TypiCMS\Modules\Menus\Repositories;

use TypiCMS\Modules\Core\Custom\Repositories\CacheAbstractDecorator;
use TypiCMS\Modules\Core\Custom\Services\Cache\CacheInterface;

class MenulinkCacheDecorator extends CacheAbstractDecorator implements MenulinkInterface
{
    public function __construct(MenulinkInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }
}
