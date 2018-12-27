<?php
declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Models\User;

/**
 * Userモデルのビジネスロジッククラス
 * @package App\Http\Service
 */
class UserService
{
    private $model;

    /**
     * コンストラクタ
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * ユーザ名を変更
     * @param string $id
     * @param string $name
     * @return bool
     */
    public function updateUserName(string $id, string $name): bool
    {
        return $this->model->updateUserName($id, $name);
    }
}