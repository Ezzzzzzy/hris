<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Member;
use Mail;
use Illuminate\Support\Facades\Log;

class BulkAddMembers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $members;
    protected $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($members,$email)
    {
        $this->members = $members;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //This is a laravel queuing job that helpts the controller add Bulk members that are imported from a csv file 
        //and then sends you an email when the builk adding of users is done.
        //This is used in an HRIS
        try {
            \DB::beginTransaction();
            Log::info('Pasok');
            foreach ($this->members as $member) {
                $temp = [
                    'existing_member_id' => $member->existing_member_id,
                    'first_name' => $member->first_name,
                    'last_name' => $member->last_name,
                    'permanent_address' => $member->permanent_address,
                    'present_city' => $member->present_city,
                    'permanent_city' => $member->permanent_city,
                    'permanent_address' => $member->permanent_address,
                    'gender' => $member->gender,
                    'civil_status' => $member->civil_status,
                    'birthdate' => $member->birthdate,
                    'birthplace' => $member->birthplace,
                    'mobile_number' => [],
                    'telephone_number' => [],
                    'references_data' => [],
                    'school_data' => [],
                    'emp_history_data' => [],
                    'family_data' => [],
                    'emergency_data' => [],
                ];

                $member_model = new Member;

                if ($member_model->create($temp)) {
                    \DB::commit();
                    Log::info('1 item created'.$temp["existing_member_id"]);
                }
            }

            \Mail::raw("Uplading done",function($message){
                $message->to($this->email, 'Ezra Paz')->subject('New Members Uploaded');
                $message->from('ezrapaz.botbros@gmail.com', 'Ezra Paz');
            });

           

        } catch (QueryException $e) {
            \DB::rollback();
            Log::error($e->getMessage());
        }

    }
}
