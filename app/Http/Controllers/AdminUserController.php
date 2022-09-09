<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(): Application|View|Factory
    {
        /** @var string $by */
        $by = request('by') ?? 'created_at';

        /** @var string $sort */
        $sort = request('sort') ?? 'DESC';

        return view('admin.users.index', [
            'users' => User::filter(request(['admin_search']))
                ->orderBy($by, $sort)
                ->paginate(25)
                ->onEachSide(1),
            'roles' => Role::all()
        ]);
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->user()?->getAuthIdentifier()) {
            return back()->with('failure', "You can not delete Yourself");
        }

        $user->delete();

        return back()->with('success', "User deleted successfully");
    }

    public function update(User $user, int $id): RedirectResponse
    {
        /** @var Request|null $request */
        $request = request();

        if (!is_null($request)) {
            if (($currentUser = $request->user()) && $currentUser->id === $user->id) {
                return back()->with('failure', 'You cannot update Your own role');
            }

            $oldRole = DB::table('model_has_roles')->where('model_id', $user->id);

            $oldRole->update(['role_id' => $id]);

            return back()->with('success', sprintf('%s\' role updated', $user->username));
        }

        return back()->with('failure', 'Something went wrong');
    }
}
