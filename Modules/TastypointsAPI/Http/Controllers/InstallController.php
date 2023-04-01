<?php

namespace Modules\TastypointsAPI\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\System;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Storage;

class InstallController extends Controller
{
    public function __construct()
    {
        $this->module_name = 'TastypointsAPi';
        $this->appVersion = config('tastypointsapi.module_version');
    }

    public static function copy_directory($directory, $destination)
 {
     $destination = $destination . basename($directory);
     # The directory will be created
     if (!file_exists($destination)) {
         if (!mkdir($destination)) {
             return false;
         }
     }
     $directory_list = @scandir($directory);
     # Directory scanning
     if (!$directory_list) {
         return false;
     }
     foreach ($directory_list as $item_name) {
         $item = $directory . DIRECTORY_SEPARATOR . $item_name;
         if ($item_name == '.' || $item_name == '..') {
             continue;
         }
         if (filetype($item) == 'dir') {
             self::copy_directory($item, $destination . DIRECTORY_SEPARATOR);
         } else {
             var_dump($item);
             var_dump($destination . DIRECTORY_SEPARATOR . $item_name);
             if (!copy($item, $destination . DIRECTORY_SEPARATOR . $item_name)) {
                 return false;
             }
         }
     }
     return true;
 }

    /**
     * Install
     * @return Response
     */
    public function index()
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');

        $this->installSettings();
        
        //Check if installed or not.
        $is_installed = System::getProperty($this->module_name . '_version');
        if (empty($is_installed)) {
            DB::statement('SET default_storage_engine=INNODB;');
            Artisan::call('module:migrate', ['module' => "TastypointsAPI"]);
            Artisan::call('module:seed', ['module' => "TastypointsAPI"]);
            Artisan::call('storage:link');
            
            System::addProperty($this->module_name . '_version', $this->appVersion);

            // DD(
            //     base_path('Modules/TastypointsAPI/Required/logo.png'),
            //     base_path('storage/public/logo.png')
            // );

            // \File::copy(
            //     base_path('Modules/TastypointsAPI/Required/logo.png'), 
            //     public_path('images/logo.png')
            // );
            // \File::copy(
            //     base_path('Modules/TastypointsAPI/Required/easy.qrcode.min.js'),
            //     public_path('js/easy.qrcode.min.js')
            // );

           // self::copy_directory(
            //    base_path('Modules/TastypointsAPI/Required/tasty'), 
            //    public_path()
   	    //);
            shell_exec('cp -rf '.base_path('Modules/TastypointsAPI/Required/tasty').' '.public_path());

        }

        $output = ['success' => 1,
                    'msg' => 'TastypointsAPI module installed succesfully'
                ];

        return redirect()
            ->route("tastypointsapi.index")
            ->with('status', $output);
    }

    /**
     * Initialize all install functions
     *
    */
    private function installSettings()
    {
        config(['app.debug' => true]);
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
    }

    //Updating
    public function update()
    {
        //Check if superadmin_version is same as appVersion then 404
        //If appVersion > superadmin_version - run update script.
        //Else there is some problem.

        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            ini_set('max_execution_time', 0);
            ini_set('memory_limit', '512M');
            
            $superadmin_version = System::getProperty($this->module_name . '_version');
            
            if (Comparator::greaterThan($this->appVersion, $superadmin_version)) {
                ini_set('max_execution_time', 0);
                ini_set('memory_limit', '512M');
                $this->installSettings();
                
                DB::statement('SET default_storage_engine=INNODB;');
                Artisan::call('module:migrate', ['module' => "TastypointsAPI"]);
                Artisan::call('module:seed', ['module' => "TastypointsAPI"]);

                System::setProperty($this->module_name . '_version', $this->appVersion);
            } else {
                abort(404);
            }

            DB::commit();
            
            $output = ['success' => 1,
                        'msg' => 'TastypointsAPI module updated Succesfully to version ' . $this->appVersion . ' !!'
                    ];

            return redirect()
            ->route("tastypointsapi.index")
            ->with('status', $output);
        } catch (Exception $e) {
            DB::rollBack();
            die($e->getMessage());
        }
    }

     /**
     * Uninstall
     * @return Response
     */
    public function uninstall()
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            System::removeProperty($this->module_name . '_version');

            $output = ['success' => true,
                            'msg' => __("lang_v1.success")
                        ];
        } catch (\Exception $e) {
            $output = ['success' => false,
                        'msg' => $e->getMessage()
                    ];
        }

        return redirect()->back()->with(['status' => $output]);
    }

}
