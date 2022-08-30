<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PeriodMiddleware
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
        $period = $request->route('period');

        if(!empty($period) && $period != 'all') {
            for($i=0; date("Ym", strtotime("-" . $i . "month"))>'202109'; $i++){
                if($period === date("Ym", strtotime("-" . $i . "month"))){
                    $howLongAgo = $i;
                }
            }

            $previousPeriod = date('Ym', strtotime('-' . $howLongAgo-1 . 'month'));
            $nextPeriod = date('Ym', strtotime('-' . $howLongAgo+1 . 'month'));

            $request->merge([
                'previousPeriod' => $previousPeriod,
                'nextPeriod' => $nextPeriod
            ]);

        }

        return $next($request);
    }
}
