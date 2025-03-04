<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;

class DashboardController extends Controller
{


    public function dashboard($upload = null)
    {


        $data = [
            'uploads' => [
                [
                    'id' => 2,
                    'uuid' => '12345678-abcd-efgh-ijkl-987654321000',
                    'count' => 99,
                    'status' => 1,
                    'description' => 'Fake HR Description',
                    'user_id' => 'Fake User',
                    'created_at' => '2025-01-01T00:00:00.000000Z',
                    'updated_at' => '2025-01-02T12:00:00.000000Z',
                ],
                [
                    'id' => 1,
                    'uuid' => 'abcdef12-3456-7890-ghij-klmnopqrstuv',
                    'count' => 88,
                    'status' => 1,
                    'description' => 'Fake News',
                    'user_id' => 'Anonymous',
                    'created_at' => '2025-02-01T00:00:00.000000Z',
                    'updated_at' => '2025-02-02T12:00:00.000000Z',
                ]
            ],
            'active_upload' => [
                'id' => 2,
                'uuid' => '12345678-abcd-efgh-ijkl-987654321000',
                'count' => 99,
                'status' => 1,
                'description' => 'Fake Active Upload',
                'user_id' => 'Ghost User',
                'created_at' => '2025-01-01T00:00:00.000000Z',
                'updated_at' => '2025-01-02T12:00:00.000000Z',
            ],
            'developer_birthday_cake_details' => [
                [
                    'cake_day' => '2025-01-03',
                    'type' => 'small',
                    'developers' => ['John Doe'],
                ],
                [
                    'cake_day' => '2025-01-07',
                    'type' => 'large',
                    'developers' => ['Jane Doe', 'Alice'],
                ],
                [
                    'cake_day' => '2025-01-21',
                    'type' => 'small',
                    'developers' => ['Bob'],
                ],
                [
                    'cake_day' => '2025-06-09',
                    'type' => 'large',
                    'developers' => ['Charlie', 'David', 'Eve'],
                ],
                [
                    'cake_day' => '2025-06-30',
                    'type' => 'small',
                    'developers' => ['Mallory'],
                ],
                [
                    'cake_day' => '2025-07-08',
                    'type' => 'small',
                    'developers' => ['Trudy'],
                ],
                [
                    'cake_day' => '2025-07-16',
                    'type' => 'large',
                    'developers' => ['Walter', 'Peggy'],
                ],
                [
                    'cake_day' => '2025-07-24',
                    'type' => 'large',
                    'developers' => ['Victor', 'Oscar', 'Nina'],
                ],
                [
                    'cake_day' => '2025-09-23',
                    'type' => 'small',
                    'developers' => ['Sybil'],
                ],
                [
                    'cake_day' => '2025-12-24',
                    'type' => 'large',
                    'developers' => ['Hank', 'Grace'],
                ]
            ],
            'total_developers' => 999,
            'total_large_cake' => 50,
            'total_small_cake' => 100,
        ];


        $active_upload = $data;

        // return $active_upload;

        return view('dashboard', [
            'active_upload' => $active_upload
        ]);

    }


    public function uploads()
    {

        $uploads = [];

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

    public function uploaddetails()
    {
        $dashboardService = new DashboardService();
        $active_upload = $dashboardService->getUploads();

        return view('dashboard', [
            'active_upload' => $active_upload
        ]);

    }

}
