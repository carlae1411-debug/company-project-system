<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => 'required|in:administrator,manager,staff',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
    'name' => $validated['name'],
    'email' => $validated['email'],
    'role' => $validated['role'],
    'password' => Hash::make($validated['password']),
]);

ActivityLog::record(
    'created_user',
    'Created user ' .
    $user->name .
    ' (' .
    $user->email .
    ') as ' .
    ucfirst($user->role)
);
        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('users', 'email')->ignore($user->id),
        ],
        'role' => 'required|in:administrator,manager,staff',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Prevent Administrator from changing their own role
    |--------------------------------------------------------------------------
    */
    if (
        $user->id === auth()->id() &&
        $user->role === 'administrator' &&
        $validated['role'] !== 'administrator'
    ) {
        return redirect()
            ->route('users.edit', $user)
            ->with(
                'error',
                'You cannot change your own Administrator role.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Protect the last Administrator
    |--------------------------------------------------------------------------
    */
    if (
        $user->role === 'administrator' &&
        $validated['role'] !== 'administrator'
    ) {
        $administratorCount = User::where(
            'role',
            'administrator'
        )->count();

        if ($administratorCount <= 1) {
            return redirect()
                ->route('users.edit', $user)
                ->with(
                    'error',
                    'The last administrator account cannot be changed to another role.'
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Update User
    |--------------------------------------------------------------------------
    */
    $oldName = $user->name;
$oldName = $user->name;
$oldEmail = $user->email;
$oldRole = $user->role;

$user->name = $validated['name'];
$user->email = $validated['email'];
$user->role = $validated['role'];

if (!empty($validated['password'])) {
    $user->password = Hash::make($validated['password']);
}

$user->save();

ActivityLog::record(
    'updated_user',
    'Updated user ' .
    $oldName .
    ' (' .
    $oldEmail .
    ')'
);

    return redirect()
        ->route('users.show', $user)
        ->with(
            'success',
            'User updated successfully.'
        );
}
 public function destroy(User $user)
{
    // Prevent the logged-in administrator from deleting their own account.
    if ($user->id === auth()->id()) {
        return redirect()
            ->route('users.show', $user)
            ->with(
                'error',
                'You cannot delete your own account.'
            );
    }

    // Prevent deletion of the last administrator account.
    if ($user->role === 'administrator') {

        $administratorCount = User::where(
            'role',
            'administrator'
        )->count();

        if ($administratorCount <= 1) {
            return redirect()
                ->route('users.show', $user)
                ->with(
                    'error',
                    'The last administrator account cannot be deleted.'
                );
        }
    }

    $userName = $user->name;
$userEmail = $user->email;

$user->delete();

ActivityLog::record(
    'deleted_user',
    'Deleted user ' .
    $userName .
    ' (' .
    $userEmail .
    ')'
);

    return redirect()
        ->route('users.index')
        ->with(
            'success',
            'User deleted successfully.'
        );
}

public function restore($id)
{
    $user = User::onlyTrashed()->findOrFail($id);

    $userName = $user->name;
    $userEmail = $user->email;

    $user->restore();

    ActivityLog::record(
        'restored_user',
        'Restored user ' .
        $userName .
        ' (' .
        $userEmail .
        ')'
    );

    return redirect()
        ->route('users.index')
        ->with(
            'success',
            'User restored successfully.'
        );
}

public function trashed()
{
    $users = User::onlyTrashed()
        ->latest('deleted_at')
        ->get();

    return view('users.trashed', compact('users'));
}

public function forceDelete($id)
{
    $user = User::onlyTrashed()->findOrFail($id);

    // Prevent deleting yourself
    if ($user->id === auth()->id()) {
        return redirect()
            ->route('users.trashed')
            ->with(
                'error',
                'You cannot permanently delete your own account.'
            );
    }

    // Prevent deleting the last administrator
    if ($user->role === 'administrator') {
        $administratorCount = User::where(
            'role',
            'administrator'
        )->count();

        if ($administratorCount <= 1) {
            return redirect()
                ->route('users.trashed')
                ->with(
                    'error',
                    'You cannot permanently delete the last administrator account.'
                );
        }
    }

    $userName = $user->name;
    $userEmail = $user->email;

    $user->forceDelete();

    ActivityLog::record(
        'permanently_deleted_user',
        'Permanently deleted user ' .
        $userName .
        ' (' .
        $userEmail .
        ')'
    );

    return redirect()
        ->route('users.trashed')
        ->with(
            'success',
            'User permanently deleted.'
        );
}


}