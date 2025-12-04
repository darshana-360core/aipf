<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use function App\Helpers\is_mobile;

class sessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $type = $request->input("type");
        if ($type != "API") {
            $user_id = $request->session()->get('user_id');
            if (empty($user_id)) {
                $data['status_code'] = "0";
                $data['message'] = "Disconnected, Please Connect Again.";
                return redirect()->route("flogin")->with(['data' => $data]);
            }
        }
        return $next($request);
    }
}
