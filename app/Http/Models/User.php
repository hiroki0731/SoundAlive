<?php

namespace App\Http\Models;

use App\Mail\SendPasswordReset;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * パスワードリセット通知の送信
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new SendPasswordReset($token));
    }

    /**
     * ユーザ名の変更
     * @param $id
     * @param $name
     * @return bool
     */
    public function updateUserName($id, $name)
    {
        $user = $this->find($id);
        $user->name = $name;
        return $user->save();
    }
}
