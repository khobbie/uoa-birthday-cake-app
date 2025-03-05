<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Services\CakeDayService;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{


    // upload_id allow for filtering at the dashboard
    public function dashboard($upload_id = null)
    {

        $active_upload = [];
        $dashboardService = new DashboardService();
        $uploads =  Upload::orderByDesc('created_at')->get();


        // return count($uploads) < 1 || empty($uploads);
        if(count($uploads) < 1 || empty($uploads)){
            return view('notfound', [
                'message' => 'No uploads',
                'uploads' => $uploads
            ]);
        }



        if (is_null($upload_id)) {

             $upload = $uploads->where('status', 1)->first();

            if (is_null($upload)) {
                return view('notfound', [
                    'message' => 'There is no active upload. Please activate an upload status.',
                    'uploads' => $uploads
                ]);
            }

            $upload_id = $upload->uuid;



        }else{
            $upload = $uploads->where('uuid', $upload_id)->first();
            if(is_null($upload)){
                return view('notfound', [
                    'message' => 'Does not exist yet',
                    'uploads' => $uploads
                ]);
            }else{
                // exit('Hi');

            }
        }

        $active_upload = $dashboardService->getActiveUpload($upload_id);




// return $active_upload;


        return view('dashboard', [
            'active_upload' => $active_upload,
            'uploads' => $uploads
        ]);

    }


    public function uploads()
    {
        $dashboardService = new DashboardService();
        $uploads = $dashboardService->getUploads();

        // return $uploads;

        return view('uploads', [
            'uploads' => $uploads
        ]);

    }

    public function notfound()
    {
        $dashboardService = new DashboardService();
        $uploads = $dashboardService->getUploads();

        // return $uploads;

        return view('uploads', [
            'uploads' => $uploads
        ]);

    }

    public function update_upload_status(Request $request)
    {

                // Validate request
                $request->validate([
                    'status' => 'required|integer',
                     'action_id' => 'required|string|max:255'
                 ]);

                 if($request->status == 0){

                 }else{
                    // Turn all status off
                 Upload::query()->update([
                    'status' => 0
                 ]);
                 }



                  // Turn only on status on
                 $result = Upload::where('uuid', $request->action_id)->update([
                    'status' => $request->status
                 ]);

                 if($result){
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Status updated successfully'
                    ], 200);
                 }else{
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'Failed to update status'
                    ], 422);
                 }

    }

    public function delete_upload(Request $request)
    {

                // Validate request
                $request->validate([
                     'action_id' => 'required|string|max:255'
                 ]);

                  // Turn only on status on
                 $upload = Upload::where('uuid', $request->action_id)->first();


                 if(!$upload){

                    return response()->json([
                        'status' => 'failed',
                        'message' => 'Record not found'
                    ], 422);

                 }

                $result = Upload::where('uuid', $upload->uuid)->delete();

                 if($result){
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Record deleted successfully'
                    ], 200);
                 }else{
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'Status updated successfully'
                    ], 500);
                 }

    }

    public function uploaddetails()
    {
        $dashboardService = new DashboardService();
        $active_upload = $dashboardService->getUploads();

        return view('dashboard', [
            'active_upload' => $active_upload
        ]);

    }

}
