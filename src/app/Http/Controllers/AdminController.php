<?php

namespace Xylophone\CRUD\app\Http\Controllers;

use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(xylophone_middleware());
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $this->data['title'] = trans('xylophone::base.dashboard'); // set the page title
        $this->data['breadcrumbs'] = [
            trans('xylophone::crud.admin')     => xylophone_url('dashboard'),
            trans('xylophone::base.dashboard') => false,
        ];

        return view(xylophone_view('dashboard'), $this->data);
    }

    /**
     * Redirect to the dashboard.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(xylophone_url('dashboard'));
    }
}
