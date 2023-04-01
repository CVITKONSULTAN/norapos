<?php

namespace Modules\TastypointsAPI\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use \Modules\TastypointsAPI\Http\Controllers\TastypointsAPIController;
use Session;
use Exception;

class MarketingController extends Controller
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
    public function stamp_campaigns()
    {
        return view('tastypointsapi::marketing.stamp-campaigns');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function newsletter()
    {
        return view('tastypointsapi::marketing.email-newsletter');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function landingpage()
    {
        return view('tastypointsapi::marketing.landingpage-template');
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function newsletter_pagebuilder()
    {
        return view('tastypointsapi::marketing.newsletter-create');
    }

    public function newsletter_pagebuilder_edit($id,$type)
    {
        $data["id"] = $id;
        $data["item_id"] = 0;
        if(isset($type)){
            $data["item_id"] = $id;
        }
        return view('tastypointsapi::marketing.newsletter-builder',$data);
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function landingpage_pagebuilder()
    {
        return view('tastypointsapi::marketing.landingpage-pagebuilder');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function landingpage_pagebuilder_edit(Request $request,$id,$type)
    {
        $data["id"] = $id;
        $data["item_id"] = 0;
        if(isset($type)){
            $data["item_id"] = $id;
            
            // if($type == "create"){
            //     return view('tastypointsapi::marketing.landingpage-create',$data);
            // }
        }
        return view('tastypointsapi::marketing.landingpage-create',$data);
        // return view('tastypointsapi::marketing.landingpage-pagebuilder',$data);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function pos()
    {
        return view('tastypointsapi::marketing.pos-template');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function pos_builder()
    {
        return view('tastypointsapi::marketing.pos-create');
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

    public function render_landingpage(Request $request,$id,$random_id)
    {
        try {
            $session = Session::get("tasty_session");
            $session = json_decode($session);
            // $input = '{"scrdata_id": 1182,"sp_name": "OK","session_id": "'.$session->session_id.'","session_exp": "'.$session->session_exp.'","status": "OK","item_id": '.$id.',"max_row_per_page": 50,"search_term": "","search_term_header": "","pagination": 1,"filter_template_id": 0}';
            $input = '{"scrdata_id" : 1188,"item_id" : '.$id.',"landing_page_random_id" : '.$random_id.',"tid" : 0,"cookie" : ""}';
            $request->request->add([
                "input"=>$input
            ]);
            $api = new TastypointsAPIController;
            $result = $api->testnet($request);
            $json = json_decode($result->getContents(),true);
            $result = json_decode($json["data"]);
            // DD($json,$input);
            $landingpages = $result->landing_pages;
    
            if(!isset($landingpages)) return abort(404);
    
            $landingpages = $landingpages[0];
            $data["landingpages"] = $landingpages;
            $data["id"] = $landingpages->id;
            $data["html"] = $landingpages->html_code;
            $data["css"] = $landingpages->css_code;
            return view("tastypointsapi::article",$data);
        } catch (Exception $e) {
            //throw $th;
            info($e->getMessage());
            return abort(404);
        }


    }

    public function flow(Request $request)
    {
        return view('tastypointsapi::marketing.flow');
    }

    public function nodes_group()
    {
        return view('tastypointsapi::marketing.nodes_group');
    }

    public function create_node_screen()
    {
        return view('tastypointsapi::marketing.create_node_screen');
    }

    public function node_containers()
    {
        return view('tastypointsapi::marketing.node_containers');
    }

    public function add()
    {
        return view('tastypointsapi::marketing.automation-flow');
    }

    public function pos_builder_edit($id,$type)
    {
        $data["id"] = $id;
        $data["item_id"] = 0;
        if(isset($type)){
            $data["item_id"] = $id;
        }
        return view('tastypointsapi::marketing.pos-builder',$data);
    }

}
