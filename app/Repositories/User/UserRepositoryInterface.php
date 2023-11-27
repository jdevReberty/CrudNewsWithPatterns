<?php

namespace App\Repositories\User;

use App\DTO\User\{CreateUserDTO, UpdateUserDTO};
use App\Repositories\PaginationInterface;
use stdClass;

interface UserRepositoryInterface {
    
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null ): PaginationInterface;
    public function getAll(string $filter = null) : array|object;
    public function findOne(string $id) : object | null;
    public function create(CreateUserDTO $dto) : object;
    public function update(UpdateUserDTO $dto) : object|null;
    public function delete(string $id) : void;
} 