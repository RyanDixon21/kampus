@php
    $brandName = filament()->getBrandName();
    $brandLogo = filament()->getBrandLogo();
    $brandLogoHeight = filament()->getBrandLogoHeight() ?? '2.5rem';
    $darkModeBrandLogo = filament()->getDarkModeBrandLogo();
    $hasDarkModeBrandLogo = filled($darkModeBrandLogo);

    $getLogoClasses = fn (bool $isDarkMode): string => \Illuminate\Support\Arr::toCssClasses([
        'fi-logo',
        'fi-logo-light' => $hasDarkModeBrandLogo && (! $isDarkMode),
        'fi-logo-dark' => $isDarkMode,
    ]);

    $logoStyles = "height: {$brandLogoHeight}";
@endphp

@capture($content, $logo, $isDarkMode = false)
    <div style="display: flex; align-items: center; gap: 12px;">
        @if ($logo instanceof \Illuminate\Contracts\Support\Htmlable)
            <div
                {{
                    $attributes
                        ->class([$getLogoClasses($isDarkMode)])
                        ->style([$logoStyles])
                }}
            >
                {{ $logo }}
            </div>
        @elseif (filled($logo))
            <img
                alt="{{ __('filament-panels::layout.logo.alt', ['name' => $brandName]) }}"
                src="{{ $logo }}"
                {{
                    $attributes
                        ->class([$getLogoClasses($isDarkMode)])
                        ->style([$logoStyles])
                }}
            />
        @endif
        
        @if (filled($brandName))
            <span class="text-lg font-semibold text-gray-900 dark:text-white" style="white-space: nowrap;">
                {{ $brandName }}
            </span>
        @endif
    </div>
@endcapture

{{ $content($brandLogo) }}

@if ($hasDarkModeBrandLogo)
    {{ $content($darkModeBrandLogo, isDarkMode: true) }}
@endif
