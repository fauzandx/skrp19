<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

class DownloadController extends Controller
{
    public function avatar(Request $request)
    {
        $type = $request->input('type');
        $file = decrypt($request->input('id'));


        $storagePath = 'upload/'.$type.'/'.$file;
        if( ! File::exists($storagePath)) {
            abort(404);
        } else {
            $mimeType = File::mimeType($storagePath);
            $headers = array(
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="'.$file.'"'
            );

            return response(file_get_contents($storagePath), 200, $headers);
        }
    }
}
