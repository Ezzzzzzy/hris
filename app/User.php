<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;
use Mail;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, Notifiable;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'position', 'mobile_number', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // protected $guard_name = 'web';

    public function role()
    {
        return $this->belongsTo("App\Models\Role", "role_id", "id");
    }

    public static function getUsers()
    {
        $users = User::with(['roles', 'role'])->get();

        foreach ($users as $user) {
            $last_modified_at = Carbon::parse($user->updated_at)->toFormattedDateString();

            $res['id'] = $user->id;
            $res['name'] = $user->name;
            $res['email'] = $user->email;
            $res['group_id'] = $user->roles->first()->id;
            $res['group_name'] = $user->roles->first()->name;
            $res['color'] = $user->roles->first()->status_color;
            $res['status'] = $user->status;
            $res['last_modified_at'] = $last_modified_at;

            $result[] = $res;
        }

        return collect($result);
    }

    public static function sendInvite($subject, $data, $to)
    {
        try {
            $sender = env("MAIL_USERNAME", "dev01@botbros.ai");

            Mail::send("mail.invite", $data, function ($mail) use ($sender, $subject, $to) {
                $mail->from($sender);
                $mail->to($to);
                $mail->subject($subject);
            });

            if (count(Mail::failures()) > 0) {
                return false;
            }

            return true;
        } catch (\ErrorException $e) {
            return false;
        }
    }
}
