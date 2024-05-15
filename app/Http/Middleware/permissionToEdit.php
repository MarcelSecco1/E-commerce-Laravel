<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Pessoa;
use Symfony\Component\HttpFoundation\Response;

class permissionToEdit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $people = Pessoa::findOrFail($request->id);
        if (auth()->user()->id != $people->user_id){
            return abort(403);
        }
        return $next($request);
    }
}
