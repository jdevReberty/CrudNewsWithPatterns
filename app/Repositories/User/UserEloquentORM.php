<?php 

namespace App\Repositories\User;

use App\DTO\User\{CreateUserDTO, UpdateUserDTO};
use App\Models\User;
use App\Repositories\{PaginationInterface, PaginationPresenter};
use Exception;
use Illuminate\Support\Facades\Auth;

class UserEloquentORM implements UserRepositoryInterface {
    
    public function __construct(protected User $model){}

    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null) : PaginationInterface {
        $result = $this->model
                    ->where(function($query) use ($filter) {
                        if($filter) {
                            $query->where('name', $filter);
                            $query->orWhere('email', 'like', "%{$filter}%");
                        }
                    })
                    ->paginate($totalPerPage, ["*"], 'page', $page);
          
        return new PaginationPresenter($result);
    }

    public function getAll(string $filter = null) : array|object{
        return $this->model
                    ->where(function($query) use ($filter) {
                        if($filter) {
                            $query->where('name', $filter);
                            $query->orWhere('email', 'like', "%{$filter}%");
                        }
                    })
                    ->get()
                    ->toArray();
    }
    public function findOne(string $id) : object | null {
        $notice = $this->model->find($id);
        if(!$notice) {
            return null;
        }
        return (object)$notice->toArray();
         
    }
    public function create(CreateUserDTO $dto) : object {
        try {
            $notice = (object) $this->model->create((array) $dto);
            return $notice;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    public function update(UpdateUserDTO $dto) : object|null {
        try {
            $notice = $this->model->find($dto->id);
            if(!$notice) {
                throw new Exception("Notice not found!");
            }
            return (object) $notice->update((array)$dto); 
            
        } catch (\Exception $e) {
            throw $e;
        }
        
    }
    public function delete(string $id) : void{
        $this->model->findOrFail($id)->delete();
    }
}