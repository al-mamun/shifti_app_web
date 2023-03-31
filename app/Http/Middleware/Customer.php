<?php
namespace App\Http\Middleware;
use Closure;

class Cusomer {
   public function handle($request, Closure $next, $role) {
      echo "Role: ".$role;
      return $next($request);
   }
}