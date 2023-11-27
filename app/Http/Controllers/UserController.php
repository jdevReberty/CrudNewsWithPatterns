<?php

namespace App\Http\Controllers;

use App\DTO\User\{CreateUserDTO, UpdateUserDTO};
use App\Enums\RoleStatus;
use App\Http\Requests\UserCreateRequest;
use App\Models\Policy\Role;
use App\Models\User;
use App\Services\UserServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function __construct(
        protected UserServices $service
    ){}

    public function index(Request $request) {
        $users = $this->service->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 3),
            filter: $request->filter
        );
        $filterValues = '';
        $filter = [$request->get('filter', '')];
        foreach ($filter as $key => $value) {
            $filterValues == '' ? $filterValues .= $value : $filterValues .= ' '.$value;
        }
        return view('auth.list_user', compact('users', 'filter', 'filterValues'));
    }

    public function create() {
        return view('auth.create');
    }

    public function store(UserCreateRequest $request) {
        try {
            DB::beginTransaction();
            $user = $this->service->create(
                CreateUserDTO::makeFromRequest($request)
            );
            // dd($user->roles->pivot);
            DB::table('user_roles')->insert([
                'id_user' => $user->id,
                'id_role' => Role::where('name', RoleStatus::commum->value)->get()->first()->id
            ]);
            DB::commit();
            if(!Auth::check()) {
                return redirect()->route('login.index');
            } elseif($this->service->isAdmin()) {
                return redirect()->route('user.index');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function edit(User $user) {
        return view('auth.edit', compact('user'));
    }

    public function update(UserCreateRequest $request, string|null $id) {
        try {
            $user = User::find($id);
            if(!Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages(['A senha informada está incorreta']);
            }
            $this->service->update(
                UpdateUserDTO::makeFromRequest($request, $id)
            );
            if($this->service->isAdmin() && (Auth::user()->id != $id)) {
                return redirect()->route('user.index');
            }
            return redirect()->route('news.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function delete(User $user) {
        try {
            if($user->id == Auth::user()->id) throw new Exception("The user cannot delete their own account");
            $dontHasNews = $user->news()->get()->isEmpty();
            
            if($dontHasNews) {
                DB::table('user_roles')->where('id_user', $user->id)->delete();
                $user->delete();
                return redirect()->route("user.index");
            } 
            throw new Exception("Fail! This user has news created");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }
}
