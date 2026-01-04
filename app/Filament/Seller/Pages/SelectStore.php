<?php

namespace App\Filament\Seller\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class SelectStore extends Page
{
    protected string $view = 'filament.seller.pages.select-store';

    protected static bool $shouldRegisterNavigation = false;

    public $stores;

    public function mount()
    {
        $this->stores = Auth::user()->stores;

        // لو واحد بس، اختاره تلقائيًا
        if ($this->stores->count() === 1) {
            Filament::setTenant($this->stores->first());
            session(['tenant_selected' => true]);
            return redirect()->route('filament.seller.pages.dashboard');
        }
    }

    public function selectStore($storeId)
    {
        $store = $this->stores->find($storeId);
        if ($store) {
            Filament::setTenant($store);
            session(['tenant_selected' => true]); // Flag لمنع التوجيه مرة أخرى
            return redirect()->route('filament.seller.pages.dashboard');
        }
    }
}
