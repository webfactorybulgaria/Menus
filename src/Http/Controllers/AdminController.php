<?php

namespace TypiCMS\Modules\Menus\Http\Controllers;

use TypiCMS\Modules\Core\Custom\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Menus\Custom\Http\Requests\FormRequest;
use TypiCMS\Modules\Menus\Custom\Models\Menu;
use TypiCMS\Modules\Menus\Custom\Repositories\MenuInterface;

class AdminController extends BaseAdminController
{
    public function __construct(MenuInterface $menu)
    {
        parent::__construct($menu);
    }

    /**
     * List models.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $models = $this->repository->all([], true);
        app('JavaScript')->put('models', $models);

        return view('menus::admin.index');
    }

    /**
     * Create form for a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $model = $this->repository->getModel();

        return view('menus::admin.create')
            ->with(compact('model'));
    }

    /**
     * Edit form for the specified resource.
     *
     * @param \TypiCMS\Modules\Menus\Custom\Models\Menu $menu
     *
     * @return \Illuminate\View\View
     */
    public function edit(Menu $menu)
    {
        $models = app('TypiCMS\Modules\Menus\Custom\Repositories\MenulinkInterface')->allNestedBy('menu_id', $menu->id, [], true);
        app('JavaScript')->put('models', $models);

        return view('menus::admin.edit')
            ->with(['model' => $menu]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \TypiCMS\Modules\Menus\Custom\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FormRequest $request)
    {
        $menu = $this->repository->create($request->all());

        return $this->redirect($request, $menu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \TypiCMS\Modules\Menus\Custom\Models\Menu               $menu
     * @param \TypiCMS\Modules\Menus\Custom\Http\Requests\FormRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Menu $menu, FormRequest $request)
    {
        $this->repository->update($request->all());

        return $this->redirect($request, $menu);
    }
}
