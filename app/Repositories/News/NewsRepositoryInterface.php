<?php

namespace App\Repositories\News;

use App\DTO\News\{CreateNewsDTO, UpdateNewsDTO};
use App\Repositories\PaginationInterface;
use stdClass;

interface NewsRepositoryInterface {
    
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null ): PaginationInterface;
    public function getAll(string $filter = null) : array|object;
    public function findOne(string $id) : object | null;
    public function create(CreateNewsDTO $dto) : object;
    public function update(UpdateNewsDTO $dto) : object|null;
    public function delete(string $id) : void;
} 