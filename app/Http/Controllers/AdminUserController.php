<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidOrderArgumentException;
use App\Exceptions\InvalidPaginationInfoException;
use App\Models\User;
use App\Services\Interfaces\ModelPaginator;
use App\ValueObjects\AdminUsersOrderBy;
use App\ValueObjects\PaginationInfo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    public function __construct(private readonly ModelPaginator $paginator)
    {
    }

    public function index(): Factory|View|Application|RedirectResponse
    {
        $perPage = 25;

        /** @var string $by */
        $by = request('by') ?? 'created_at';

        /** @var string $order */
        $order = request('order') ?? 'DESC';

        /** @var int $page */
        $page = request('page') ?? 1;

        try {
            $orderBy = new AdminUsersOrderBy($order, $by);
            $paginationInfo = new PaginationInfo($page, $perPage);
        } catch (InvalidOrderArgumentException|InvalidPaginationInfoException $e) {
            return back()->with('failure', $e->getMessage());
        }

        $roles = Role::select([
                'id',
                'name'
            ])
            ->get()
            ->toArray();

        return view('admin.users.index', [
            'users' => $this->paginator->users($orderBy, $paginationInfo),
            'roles' => $roles,
        ]);
    }

    public function destroy(User $user): RedirectResponse
    {
        /** @var User $loggedUser */
        $loggedUser = auth()->user();

        if ($user->getAuthIdentifier() === $loggedUser->getAuthIdentifier()) {
            return back()->with('failure', "You cannot delete Yourself");
        }

        $user->delete();

        return back()->with('success', "User deleted successfully");
    }

    public function update(Request $request, User $user, int $id): RedirectResponse
    {
        /** @var User $loggedUser */
        $loggedUser = $request->user();

        /** @var string $userId */
        $userId = $user->getAuthIdentifier();

        if ($loggedUser->getAuthIdentifier() === $userId) {
            return back()->with('failure', 'You cannot update Your own role');
        }

        $role = DB::table('model_has_roles')->where('model_id', $userId);

        $role->update(['role_id' => $id]);

        return back()->with('success', sprintf('%s\'s role updated', $user->username));
    }
}
