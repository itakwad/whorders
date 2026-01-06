<?php

namespace App\Providers\Filament;

use App\Models\Store;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class SellerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {


        return $panel
            ->id('seller')
            ->path('seller')
            ->login()
            ->globalSearch(false) // هذا السطر يلغي شريط البحث العلوي تماماً

            ->tenant(Store::class, slugAttribute: 'slug', ownershipRelationship: 'user')
            ->renderHook(
                PanelsRenderHook::SIDEBAR_NAV_START,
                fn () => view('filament.seller.panel.logo', [
                    'tenant' => Filament::getTenant(),
                ])
            )
            ->colors([
                'primary' => Color::Green,
            ])
            ->discoverResources(in: app_path('Filament/Seller/Resources'), for: 'App\Filament\Seller\Resources')
            ->discoverPages(in: app_path('Filament/Seller/Pages'), for: 'App\Filament\Seller\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Seller/Widgets'), for: 'App\Filament\Seller\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])


            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
               \App\Http\Middleware\EnsureTenantSelected::class, // أضف هنا
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->tenantMiddleware([
                \Filament\Http\Middleware\Authenticate::class,
            ], isPersistent: true);
    }
}
