<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantSelected
{
    public function handle(Request $request, Closure $next): Response
    {
        $panel = Filament::getCurrentPanel();

        if ($panel && $panel->getId() === 'seller') {
            $user = auth()->user();
            if (! $user) {
                return $next($request);
            }

            $stores = $user->stores;

            if ($stores->isEmpty()) {
                // لو مفيش متاجر، ممكن توجه إلى صفحة إنشاء أو رسالة خطأ
                abort(403, 'ليس لديك متاجر. يرجى إنشاء واحد.');
            }

            if ($stores->count() === 1) {
                Filament::setTenant($stores->first());
                session(['tenant_selected' => true]);
                return $next($request);
            }

            if ($stores->count() > 1 && ! session('tenant_selected', false)) {
                // عرض الـ view مباشرة بدل redirect
                return response()->view('select-store', ['stores' => $stores]);
            }
        }

        return $next($request);
    }
}
