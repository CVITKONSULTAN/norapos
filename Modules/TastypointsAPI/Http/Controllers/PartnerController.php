<?php

namespace Modules\TastypointsAPI\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('tastypointsapi::partner.index');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function industry()
    {
        return view('tastypointsapi::partner.industry');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function partner_types()
    {
        return view('tastypointsapi::partner.partner-types');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function photo_types()
    {
        return view('tastypointsapi::partner.photo-types');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function phone_types()
    {
        return view('tastypointsapi::partner.phone-type');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function partner_status()
    {
        return view('tastypointsapi::partner.partner-status');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function week_days()
    {
        return view('tastypointsapi::partner.week-days');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function pos_management()
    {
        return view('tastypointsapi::partner.pos-management');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function menu_access()
    {
        return view('tastypointsapi::partner.menu-access');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function staff_title()
    {
        return view('tastypointsapi::partner.staff-title');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function settings()
    {
        return view('tastypointsapi::partner.settings');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function delivery_settings()
    {
        return view('tastypointsapi::partner.delivery-settings');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function admin_level()
    {
        return view('tastypointsapi::partner.admin-level-menu');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function menu_items()
    {
        return view('tastypointsapi::partner.menu-item-management');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function sidemenu_manage()
    {
        return view('tastypointsapi::partner.app-sidemenu-management');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('tastypointsapi::partner.partner-page.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('tastypointsapi::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data["id"] = $id;
        return view('tastypointsapi::partner.partner-page.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
