<?php

namespace Modules\TastypointsAPI\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CommunicationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('tastypointsapi::index');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function message_parameter()
    {
        return view('tastypointsapi::communications.message-parameter');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function sms_originators()
    {
        return view('tastypointsapi::communications.sms-originators');
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function sms_confirm_code()
    {
        return view('tastypointsapi::communications.sms-confirm-code');
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function sms_message_history()
    {
        return view('tastypointsapi::communications.sms-message-history');
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function manage_tasty_group()
    {
        return view('tastypointsapi::communications.manage-tasty-group');
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function send_sms()
    {
        return view('tastypointsapi::communications.send-sms-message');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function sms_template()
    {
        return view('tastypointsapi::communications.sms-message-template');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function send_push_notification()
    {
        return view('tastypointsapi::communications.send-push-notification');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function tasty_lovers()
    {
        return view('tastypointsapi::communications.tasty-lovers');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('tastypointsapi::create');
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
        return view('tastypointsapi::edit');
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
