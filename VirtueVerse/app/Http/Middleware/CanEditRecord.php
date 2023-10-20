<?php

namespace App\Http\Middleware;

use App\Models\StudyTrajectory;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use App\Models\Author;
use App\Models\BookEdition;
use App\Models\Book;

class CanEditRecord
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $record = null;
        $modelName = null;
        $routeType = null;
        $segments = $request->segments();

        Log::info("Handling edit route");
        Log::info($user->id);

        foreach ($segments as $segment) {
            if (strcasecmp($segment, 'book') === 0) {
                $routeType = 'book';
                break;
            } elseif (strcasecmp($segment, 'book-edition') === 0) {
                $routeType = 'book-edition';
                break;
            } elseif (strcasecmp($segment, 'author') === 0) {
                $routeType = 'author';
                break;
            } elseif (strcasecmp($segment, 'study-trajectory') === 0) {
                $routeType = 'study-trajectory';
                break;
            }
        }

        Log::info($routeType);

        switch ($routeType) {
            case 'author':
                $modelName = 'Author';
                $record = Author::find($request->route('id'));
                break;
            case 'book':
                $modelName = 'Book';
                $record = Book::find($request->route('id'));
                break;
            case 'book-edition':
                $modelName = 'BookEdition';
                $record = BookEdition::find($request->route('id'));
                break;
            case 'study-trajectory':
                $modelName = 'StudyTrajectory';
                $record = StudyTrajectory::find($request->route('id'));
                break;
            default:
                Log::info("default handling");
                break;
        }
    
        // Admin or editor? Grant access
        if ($user->user_role_id === 1 || $user->user_role_id === 2) {
            return $next($request);
        }
    
        // User and own record? Grant access
        if ($record && $user->id === $record->created_by) {
            return $next($request); 
        }
    
        return redirect()->route('home')->with('error', 'You do not have permission to edit this record.');
    }
}