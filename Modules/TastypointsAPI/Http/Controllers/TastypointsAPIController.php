<?php

namespace Modules\TastypointsAPI\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\TastypointsAPI\Entities\Tastyconfig;
use Lang;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use Artisan;
use Exception;
use Session;
use File;
use Log;
use Yajra\DataTables\Facades\DataTables;

use Html2Pdf;

class TastypointsAPIController extends Controller
{

    public function print()
    {
        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML('<h1>HelloWorld</h1>This is my first test');
        $html2pdf->output();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('tastypointsapi::tastyapi.index');
    }

    /**
     * Display a setup form.
     * @return Response
     */
    public function setup()
    {
        $data["config"] = Tastyconfig::first();
        return view('tastypointsapi::tastyapi.setup',$data);
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
     * Setup Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function setup_update(Request $request)
    {
        $data = $request->all();
        $config = Tastyconfig::first();
        if(empty($config)){
            Artisan::call('module:seed', ['module' => "TastypointsAPI"]);
            $config = Tastyconfig::first();
        }
        $data["result"] = $config->update($data);

        return [
            "status"=>"success",
            "message"=> Lang::get( 'tastypointsapi::lang.success_update' ),
            "data"=>$data,
        ];
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

     /**
     * get config in database
     * @return Model
     */
    protected function getConfig()
    {
        try{
            $config = Tastyconfig::first();
            if(empty($config)) {
                Artisan::call('module:seed', ['module' => "TastypointsAPI"]);
                $config = Tastyconfig::first();
            }
            return $config;
        } catch(Exception $e) {
            return "https://tastypoints.io/akm/restapi.php";
        }
    }

    /**
     * connection to mainnet
     * @return json
     */
    public function testnet(Request $request)
    {
        try{

            $client = new Client();
            $link = $this->getConfig()->link;
            $data = $request->all();
            // DD($data);
            $input = json_decode($data["input"],true);

            $request = $client->request('POST', $link, [
                'body' => json_encode([
                    "input" => $input
                ]),
                'headers' => [
                    'Content-Type'     => 'application/json',
                ]
            ]);

            return $request->getBody();

        } catch (RequestException $e) {
            $response = [
                "request" =>$e->getRequest(),
            ];
            if ($e->hasResponse()) {
                $response["response"] = $e->getResponse();
            }
            return $response;
        }
    }

    /**
     * connection to mainnet and convert to datatables format
     * @return json
     */
    public function datatables(Request $request)
    {
        if(isset($request->scr_name) && isset($request->input)){

            $json = json_decode($request->input);
            if( isset($request->draw) )  $json->pagination = ( intVal($request->start)+intVal($request->length) ) - intVal($request->length);
            if( isset($request->length) ) $json->max_row_per_page = $request->length;
            if( isset($request->search["value"]) ) $json->search_term = $request->search["value"];
            $request->input = json_encode($json);

            $result = $this->testnet($request);
            $json = json_decode($result->getContents(),true);
            if($json["status"]){

                $data = json_decode($json["data"],true);
                try {
                    $rows = $data[$request->scr_name];
                } catch (\Throwable $th) {
                    DD($data,$th);
                }
                if($rows == null) $rows = [];
                return DataTables::of($rows)->make(true);
                // return [
                //     "draw"=>$data["pagination"],
                //     "recordsTotal"=>$data["total_records"],
                //     "recordsFiltered"=>$data["total_records"],
                //     "data"=>$rows
                // ];
            }
        }
    }

    public function verification(Request $request)
    {
        if( $request->session()->has("tasty_session") ) 
        return redirect()->route("tastypointsapi.index");

        return view("tastypointsapi::verify");
    }

    public function test_session(Request $request)
    {
        $session = Session::put("tasty_session",$request->session);
        if($request->session()->has("initiate_url")) return redirect()->to($request->session()->get("initiate_url"));
        return redirect()->route("tastypointsapi.index");
    }

    public function logout(Request $request)
    {
        $request->session()->forget("tasty_session");
        return redirect()->route("tastypointsapi.verification");

    }

    public function scdata_labs()
    {
        $data["config"] = Tastyconfig::first();
        return view('tastypointsapi::tastyapi.scdata_labs',$data);
    }

    public function pageBuilder()
    {
        return view("tastypointsapi::pagebuilder.builder");
    }

    public function geoSettings()
    {
        return view("tastypointsapi::geosettings.country");
    }

    public function state()
    {
        return view("tastypointsapi::geosettings.state");
    }

    public function city()
    {
        return view("tastypointsapi::geosettings.city");
    }

    public function subcity()
    {
        return view("tastypointsapi::geosettings.subcity");
    }
    public function language()
    {
        return view("tastypointsapi::geosettings.language");
    }
    public function currency()
    {
        return view("tastypointsapi::geosettings.currency");
    }
    public function timezone()
    {
        return view("tastypointsapi::geosettings.timezone");
    }

    public function app_screens()
    {
        return view("tastypointsapi::tastyapi.app-screens");
    }

    public function sclab_category()
    {
        return view("tastypointsapi::tastyapi.sclab_category");
    }

    public function sclab_status()
    {
        return view("tastypointsapi::tastyapi.sclab_status");
    }

    public function sample_profile_image()
    {
        return view("tastypointsapi::tastyapi.sample-profile-image");
    }

    public function upload(Request $request, $type)
    {
        try {
            $destination_folder = "/tasty";
            $ext = $request->file->getClientOriginalExtension();
            
            switch ($type) {
                case 'image':
                    $destination_folder = $destination_folder."/images";
                break;
                default:
                    $destination_folder = $destination_folder."/".$type;
                break;
            }

            if(!File::isDirectory($destination_folder)){
        
                File::makeDirectory($destination_folder, 0777, true, true);
        
            }
    
            $imageName = $type."-".time().'.'.$ext;
            $destinate = $request->file->move(public_path($destination_folder), $imageName);

            $link = env("APP_URL");
            switch ($type) {
                case 'image':
                    $link .= "/tasty/images/".$imageName;
                break;
                default:
                    $link .= "/tasty/".$type."/".$imageName;
                break;
            }

            return [
                'success' => true, 
                'message' => 'Successfully uploaded file.',
                "link" => $link,
            ];
        } catch (Exception $e) {
            return [
                'success' => false, 
                'message' => $e->getMessage()
            ];
        }

    }

    public function test(Request $request)
    {
        try {
            return $request->all();
        } catch (\Throwable $th) {
            return ["x"=>"1"];
        }
    }

    public function fcm(Request $request)
    {
        $client = new Client();
        $link = "https://fcm.googleapis.com/fcm/send";
        $data = $request->all();
        
        $request = $client->request('POST', $link, [
            'body' => json_encode($data),
            'headers' => [
                "Authorization" => "key=AIzaSyCfkUjS-Ejimb2AMs91RgFU_OKKx5VWcMc",
                'Content-Type'     => 'application/json',
            ]
        ]);
    
        Log::info("FCM => ".json_encode($data));

        try{
            return json_decode($request->getBody(),true);
        } catch (RequestException $e) {
            $response = [
                "request" =>$e->getRequest(),
                "req_body"=>$request->all()
            ];
            if ($e->hasResponse()) {
                $response["response"] = $e->getResponse();
            }
            return $response;
        }
    }

    public function stripe_endpoints(Request $request)
    {
        $endpoints = "https://tastystripe.onprocess.work/?".$request->param;
        // list_payment_intent
        try{

            $data = file_get_contents($endpoints);
            DD($data);

            $client = new Client();
            $link = $endpoints;
            $input = $request->all();
            $request = $client->request('GET', $link, [
                'body' => json_encode([
                    "input" => $input
                ]),
                'headers' => [
                    'Content-Type'     => 'application/json',
                ]
            ]);

            return $request->getBody();

        } catch (RequestException $e) {
            $response = [
                "request" =>$e->getRequest(),
            ];
            if ($e->hasResponse()) {
                $response["response"] = $e->getResponse();
            }
            return $response;
        }

    }
}
