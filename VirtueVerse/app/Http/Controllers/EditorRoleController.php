<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\BookEdition;
use Illuminate\Support\Facades\Log;

class EditorRoleController extends Controller
{
    public function checkCreatedRecords($userId) 
    {
        $bookCount = Book::where('created_by', $userId)->count();
        $bookEditionsCount = BookEdition::where('created_by', $userId)->count();

        return [
            'books' => $bookCount,
            'bookEditions' => $bookEditionsCount,
        ];
    }

    public function checkEditorApplication($userId)
    {
        $user = User::find($userId);

        if ($user) {
            // Check if the user's role is editor (You need to define the role_id for editors)
            $isEditor = $user->user_role_id === 2; // Replace YourEditorRoleId with the actual role ID for editors
            // Check if the user has applied for editor (assuming appliedForEditor is the field)
            $hasApplied = $user->appliedForEditor;

            // If the user is an editor or has applied, return true
            if ($isEditor || $hasApplied) {
                return true;
            }
        }

        // If none of the conditions are met, return false
        return false;
    }
}