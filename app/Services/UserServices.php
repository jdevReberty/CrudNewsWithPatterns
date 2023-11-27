<?php

namespace App\Services;

use App\DTO\User\{CreateUserDTO, UpdateUserDTO};
use App\Enums\RoleStatus;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use stdClass;

class UserServices 
{
    public function __construct(protected UserRepositoryInterface $repository){}

    public function getAll(string $filter = null) : array {       
        return $this->repository->getAll($filter);
    }

    public function findOne(string $id) : stdClass|null {
        return $this->repository->findOne($id);
    }

    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null) {       
        return $this->repository->paginate(page: $page, totalPerPage: $totalPerPage, filter: $filter);
    }

    public function create(CreateUserDTO $dto) : object {
        return $this->repository->create($dto);
    }

    public function update(UpdateUserDTO $dto) : object|null {
        return $this->repository->update($dto);
    }

    public function delete(string $id) : void {
        $this->repository->delete($id);
    }

    public static function isAdmin() : bool {
        $roles = (Auth::user() ?? auth()->user())->roles()->get(['roles.name']);
        foreach($roles as $role) {
            if($role->name == RoleStatus::admin->value) return true;
        }
        return false;
    }
}