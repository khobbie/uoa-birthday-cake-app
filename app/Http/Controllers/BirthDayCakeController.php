<?php

namespace App\Http\Controllers;

use App\Services\CakeDayService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Upload;
use App\Models\Developer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BirthDayCakeController extends Controller
{
    public function home()
    {
        $uploads =  Upload::orderByDesc('created_at')->get();

        if(count($uploads) < 1 || empty($uploads)){
            return view('guestnotfound', [
                'message' => 'No uploads',
                'uploads' => $uploads
            ]);
        }

        $upload = $uploads->where('status', 1)->first();

        if (is_null($upload)) {
            return view('guestnotfound', [
                'message' => 'There is no active upload. Please activate an upload status.',
                'uploads' => $uploads
            ]);
        }

        $upload_id = $upload->uuid;


        $cakeDayService = new cakeDayService();
        $birthdays = $cakeDayService->calculateCakeDays($upload_id);

        // return $birthdays;
        return view('welcome', [
            'birthdays' => $birthdays,
            'upload' => $upload
        ]);
    }

    public function upload(Request $request)
    {
        // Validate file upload
        $request->validate([
            'file' => 'required|file|max:10240', // Changed max to a more standard 10MB (10240 KB)
            'description' => 'required|string|max:255'
        ]);

        if ($request->file('file')->getClientOriginalExtension() !== 'txt') {
            return response()->json(['error' => 'Only .txt files are allowed'], 422);
        }

        // DB::beginTransaction();

        try {

            $file = $request->file('file');
            $fileContents = file($file->getPathname(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            $developers = [];
            $errors = [];

            $createUploadBatch = Upload::create([
                'uuid' => Str::uuid(),
                'count' => count($developers),
                'status' => 0,
                'description' => $request->description ?? '',
                'user_id' => Auth::user()->name
            ]);

            // return $createUploadBatch;

            $cakeDayService = new cakeDayService();

            $currentYear = Carbon::now()->year;
            $holidays = $cakeDayService->getUkHolidays($currentYear);


            foreach ($fileContents as $lineNumber => $line) {
                $parts = explode(',', $line);

                if (count($parts) !== 2) {
                    $errors[] = "Line " . ($lineNumber + 1) . " is incorrectly formatted.";
                    continue;
                }

                $name = trim($parts[0]);
                $dob = trim($parts[1]);

                // Validate date format (YYYY-MM-DD)
                if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob) || !strtotime($dob)) {
                    $errors[] = "Line " . ($lineNumber + 1) . ": Invalid date format.";
                    continue;
                }


                $birthday = Carbon::parse($dob)->year($currentYear);




                $cakedayInfo = $cakeDayService->getNextWorkingDay($name,  $dob, $birthday, $holidays);


                $developers[] = [
                    'upload_id' => $createUploadBatch->uuid,
                    'name' => $name,
                    'date_of_birth' => $dob,
                    'birthday' => $cakedayInfo['birthday'],
                    'off_day' => $cakedayInfo['off_day'],
                    'is_weekend' => $cakedayInfo['isWeekend'],
                    'is_holiday' => $cakedayInfo['isHoliday'],
                    'next_working_day' => $cakedayInfo['next_working_day'],
                    'cake_day' => '---',
                    'logs' => '---',
                    'created_at' => now(),
                    'updated_at' => now()
                ];


            }

            if (!empty($errors)) {
                exit(json_encode($errors));
                return response()->json(['errors' => $errors], 422);
            }



            // Insert into database
            $results =  Developer::insert($developers);


            $update_upload_count = Upload::where('uuid', $createUploadBatch->uuid)
                ->update([
                    'count' => count($developers)
                ]);



            if ($results) {
                return $this->getUploadById($createUploadBatch->uuid);
            } else {
                return response()->json(['error' => 'geting the cake day'], 422);
            }


            // Start the transaction

            // return



            //    Developer::create($developers);

            // Commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // Rollback the transaction if anything fails
            // DB::rollBack();

            // Handle the error (you could log it or return an error response)
            return response()->json(['errors' => $e], 500);
        }

        return response()->json([
            'message' => 'File uploaded successfully!',
            'data' => $developers
        ]);
    }


    public function getUploadById($upload_id)
    {
        $currentYear = Carbon::now()->year;

        $cakeDayService = new CakeDayService();

        $cakeDays = $cakeDayService->calculateCakeDays($upload_id);
        return  response()->json([
            'message' => 'File uploaded successfully!',
            'data' => $cakeDays
        ], 200);
    }
}
