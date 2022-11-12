<?php

namespace App\Http\Controllers;

use App\Facades\ArrayPagination;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    public function index(): Application|View|Factory
    {
        $perPage = 25;

        /** @var string $by */
        $by = request('by') ?? 'created_at';

        /** @var string $order */
        $order = request('order') ?? 'DESC';

        /** @var int $page */
        $page = request('page') ?? 1;

        /** @var int $total */
        $total = DB::scalar('SELECT count(id) FROM users');

        $users = User::select([
                'users.id',
                'username',
                'users.name',
                'users.username',
                'email',
                'roles.name AS role',
                'users.created_at'
            ])
            ->filter(request(['admin_search']))
            ->orderBy('users.'.$by, $order)
            ->join('model_has_roles', 'model_id', 'users.id')
            ->join('roles', 'roles.id', 'model_has_roles.role_id')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get()
            ->toArray();

        $roles = Role::select([
                'id',
                'name'
            ])
            ->get()
            ->toArray();

        return view('admin.users.index', [
            'users' => ArrayPagination::paginate($users, $total, $page, $perPage),
            'roles' => $roles,
        ]);
    }

    public function destroy(User $user): RedirectResponse
    {
        /** @var User $loggedUser */
        $loggedUser = auth()->user();

        if ($user->id === $loggedUser->getAuthIdentifier()) {
            return back()->with('failure', "You cannot delete Yourself");
        }

        $user->delete();

        return back()->with('success', "User deleted successfully");
    }

    public function update(User $user, int $id): RedirectResponse
    {
        /** @var Request $request */
        $request = request();

        if (($currentUser = $request->user()) && $currentUser->id === $user->id) {
            return back()->with('failure', 'You cannot update Your own role');
        }

        $role = DB::table('model_has_roles')->where('model_id', $user->id);

        $role->update(['role_id' => $id]);

        return back()->with('success', sprintf('%s\' role updated', $user->username));
    }
}
