<?php

namespace App\Services;

use App\DTO\News\{CreateNewsDTO, UpdateNewsDTO};
use App\Repositories\News\NewsRepositoryInterface;
use stdClass;

class NewsServices 
{

    public function __construct(protected NewsRepositoryInterface $repository){}

    public function getAll(string $filter = null) : array {       
        return $this->repository->getAll($filter);
    }

    public function findOne(string $id) : stdClass|null {
        return $this->repository->findOne($id);
    }

    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null) {       
        return $this->repository->paginate(page: $page, totalPerPage: $totalPerPage, filter: $filter);
    }

    public function create(CreateNewsDTO $dto) : object {
        return $this->repository->create($dto);
    }

    public function update(UpdateNewsDTO $dto) : object|null {
        return $this->repository->update($dto);
    }

    public function delete(string $id) : void {
        $this->repository->delete($id);
    }
}