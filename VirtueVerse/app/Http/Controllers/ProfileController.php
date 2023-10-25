<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Controllers\Auth\EditorRoleController;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $editorRoleController = new EditorRoleController();

        $displayEditorButton = false;
        $hasApplied = $editorRoleController->checkEditorApplication($request->userId);
        $counts = $editorRoleController->checkCreatedRecords($request->userId);

        $bookCount = $counts['books'];
        $bookEditionsCount = $counts['bookEditions'];

        $totalCount = $bookCount + $bookEditionsCount;

        if (!$hasApplied && $totalCount >= 5) 
        {
            $displayEditorButton = true;
        }


        return view('profile.edit', [
            'user' => $request->user(),
            'displayEditorButton' => $displayEditorButton,
        ]);
    }

    
    public function applyForEditor(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->update(['appliedForEditor' => true]);

        return redirect()->back()->with('success', 'You have successfully applied for editor.');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
