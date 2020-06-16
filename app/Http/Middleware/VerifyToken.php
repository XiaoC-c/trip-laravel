<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class VerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        $token = $request->header('token', '');
        $token = $request->input('token', '');
        if (empty($token)) return response()->json(['status'=>401, 'message' => '用户登录授权失败']);
        $user = User::where('token', $token)->first();
        if (empty($user) || $user->status != 1) return response()->json(['status'=>401, 'message' => '用户不存在或者已删除']);
        $request->user = $user;
        return $next($request);
    }
}
