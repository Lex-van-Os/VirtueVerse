<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\EditorRoleController;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $editorRoleController = new EditorRoleController();

        $displayEditorButton = false;
        $hasApplied = $editorRoleController->checkEditorApplication($request->user()->id);
        $counts = $editorRoleController->checkCreatedRecords($request->user()->id);

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

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($request->user()->id)],
        ]);

        $request->user()->update($request->only(['name', 'email']));

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

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

    public function applyForEditor(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->appliedForEditor = true;
        $user->save();

        return redirect()->back()->with('success', 'You have successfully applied for editor.');
    }
}
