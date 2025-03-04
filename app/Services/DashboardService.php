<?php

namespace App\Services;

use App\Models\Developer;
use App\Models\Holiday;
use App\Models\Upload;
use Carbon\Carbon;

class DashboardService
{


    public function getActiveUpload($upload_id)
    {
        $cakeDayService = new CakeDayService();

        $uploads =  Upload::orderByDesc('created_at')->get();

        if (!is_null($upload_id)) {
            $active_upload = $uploads->where('uuid', $upload_id)->first();
            $developer_birthday_cake_details = $cakeDayService->calculateCakeDays($upload_id ?? null);
        } else {
            $active_upload = $uploads->where('status', 1)->first();
            // exit(json_encode($active_upload));
            if (!$active_upload) {
                $active_upload = Upload::orderByDesc('created_at')->first();
                // $active_upload[] = $active_upload;
            }
            // exit(json_encode($active_upload));
            // return $active_upload;
            $developer_birthday_cake_details = $cakeDayService->calculateCakeDays($active_upload->uuid ?? null);
        }

        // $active_upload = Upload::where('status', 1)->first();
        // $developer_birthday_cake_details = $cakeDayService->calculateCakeDays($active_upload->uuid ?? null);

        $total_large_cake = 0;
        $total_small_cake = 0;

        foreach ($developer_birthday_cake_details as $detail) {

            if (trim($detail['type']) == 'large') {
                $total_large_cake =  $total_large_cake + 1;
            } else {
                $total_small_cake =  $total_small_cake + 1;
            }
        }


        return [
            'uploads' =>  $uploads,
            'active_upload' =>  $active_upload,
            'developer_birthday_cake_details' => $developer_birthday_cake_details,
            'total_developers' => count($developer_birthday_cake_details),
            'total_large_cake' => $total_large_cake,
            'total_small_cake' => $total_small_cake,
        ];
    }

    public function getUploads()
    {
        $uploads = Upload::get();
        return $uploads ?? [];
    }

    public function getDeveloperBirthdayCake($upload_id)
    {
        $developer_birthday_cake_data = Developer::where('upload_id', $upload_id);

        $developer_birthday_cake_count = $developer_birthday_cake_data->count();

        $developer_birthday_cakes =  $developer_birthday_cake_data->get();

        return [
            'developer_birthday_cakes' => $developer_birthday_cakes,
            'developer_birthday_cake_count' => $developer_birthday_cake_count,
        ];
    }
}
