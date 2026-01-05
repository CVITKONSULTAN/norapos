<?php

namespace App\Http\Controllers;

use App\Media;
use Storage;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        try {
            $user = $request->user();
            $result = Media::uploadMedia($user->business_id, $user, request(), 'file_data', true);
            if(empty($result) && $request->has('file_data') && $request->has('absensi')){
                $file_name = '/media/file_data-'.time() . '_' . mt_rand().'.png';
                $image = str_replace('data:image/png;base64,', '', $request->file_data);
                $image = str_replace(' ', '+', $image);
                $callback = Storage::put($file_name, base64_decode($image));
                if($callback){
                    $result = url('/uploads'.$file_name);
                }
            }
            return [
                "status"=>true,
                "data"=>$result,
            ];
        } catch (\Throwable $th) {
            //throw $th;
            return [
                "status"=>false,
                "message"=>$th->getMessage(),
            ];
        }
    }

    /**
     * Upload file bebas - dapat upload file apa saja
     * @param Request $request - support 'file', 'file_data', atau key apapun
     * @return array
     */
    public function uploadAny(Request $request)
    {
        try {
            $file = null;
            $fileKey = null;

            // Cek berbagai kemungkinan key
            $possibleKeys = ['file', 'file_data', 'upload', 'document', 'attachment'];
            
            foreach ($possibleKeys as $key) {
                if ($request->hasFile($key)) {
                    $file = $request->file($key);
                    $fileKey = $key;
                    break;
                }
            }

            // Jika tidak ada, ambil file pertama yang ada
            if (!$file) {
                $allFiles = $request->allFiles();
                if (!empty($allFiles)) {
                    $fileKey = array_key_first($allFiles);
                    $file = $allFiles[$fileKey];
                }
            }

            if (!$file) {
                return [
                    "status" => false,
                    "message" => "No file uploaded. Keys checked: " . implode(', ', $possibleKeys),
                    "debug" => [
                        "all_inputs" => array_keys($request->all()),
                        "has_files" => $request->hasFile('file') || $request->hasFile('file_data'),
                    ]
                ];
            }

            // Validasi file valid dan bisa dibaca
            if (!$file->isValid()) {
                return [
                    "status" => false,
                    "message" => "Invalid file upload: " . $file->getErrorMessage(),
                ];
            }

            // Generate nama file unik
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = pathinfo($originalName, PATHINFO_FILENAME);
            $fileName = preg_replace('/[^A-Za-z0-9\-_]/', '_', $fileName);
            $uniqueFileName = $fileName . '_' . time() . '_' . mt_rand() . '.' . $extension;

            // Path folder - gunakan path langsung
            $uploadPath = public_path('uploads/files');
            
            // Buat folder jika belum ada
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
                chmod($uploadPath, 0777);
            }

            $destinationPath = $uploadPath . '/' . $uniqueFileName;

            // Alternatif: copy file content langsung daripada move
            try {
                $content = file_get_contents($file->getRealPath());
                if ($content === false) {
                    throw new \Exception("Cannot read uploaded file");
                }
                
                $written = file_put_contents($destinationPath, $content);
                if ($written === false) {
                    throw new \Exception("Cannot write file to destination");
                }
                
                chmod($destinationPath, 0644);
            } catch (\Exception $e) {
                return [
                    "status" => false,
                    "message" => "Failed to save file: " . $e->getMessage(),
                ];
            }

            // Get file info
            $fileSize = filesize($destinationPath);
            $mimeType = mime_content_type($destinationPath);
            
            $filePath = 'uploads/files/' . $uniqueFileName;

            return [
                "status" => true,
                "data" => [
                    "url" => url($filePath),
                    "path" => $filePath,
                    "filename" => $uniqueFileName,
                    "original_name" => $originalName,
                    "extension" => $extension,
                    "size" => $fileSize,
                    "mime_type" => $mimeType,
                    "uploaded_as" => $fileKey,
                ],
                "message" => "File uploaded successfully",
            ];
        } catch (\Throwable $th) {
            return [
                "status" => false,
                "message" => $th->getMessage(),
                "trace" => $th->getTraceAsString(),
            ];
        }
    }
}
