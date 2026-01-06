@php
    $logo = $tenant?->logo;

@endphp

@if($logo)
    <div class="flex justify-center py-4">
        <img
            src="{{ Storage::disk('public')->url($logo) }}"
            alt="Tenant Logo"
            style="width:100px; height:84px; border-radius:50%; object-fit:cover;"
            onmouseover="this.style.transform='scale(1.1)'"
            onmouseout="this.style.transform='scale(1)'"
        >
    </div>
@endif
