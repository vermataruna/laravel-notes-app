<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeNote
{
    public function handle(Request $request, Closure $next): Response
    {
        $note = $request->route('note');

        if ($note && $note->user_id !== $request->user()->id) {
            abort(403);
        }

        return $next($request);
    }
}
