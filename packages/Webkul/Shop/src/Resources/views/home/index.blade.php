@php
    $channel = core()->getCurrentChannel();
@endphp

<!-- SEO Meta Content -->
@push ('meta')
    <meta
        name="title"
        content="{{ $channel->home_seo['meta_title'] ?? '' }}"
    />

    <meta
        name="description"
        content="{{ $channel->home_seo['meta_description'] ?? '' }}"
    />

    <meta
        name="keywords"
        content="{{ $channel->home_seo['meta_keywords'] ?? '' }}"
    />
@endPush

@push('scripts')
    @if(! empty($categories))
        <script>
            localStorage.setItem('arina_categories_v1', JSON.stringify(@json($categories)));
        </script>
    @endif
@endpush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{  $channel->home_seo['meta_title'] ?? '' }}
    </x-slot>

    <!-- Loop over the storefront sections -->
    @foreach ($sections as $section)
        @php ($data = $section->options) @endphp

        {{-- Only the types this page renders; the layout marks the ones it draws. --}}
        @php ($marks = ($preview ?? false) && in_array($section->type, [
            $section::IMAGE_CAROUSEL,
            $section::STATIC_CONTENT,
            $section::CATEGORY_CAROUSEL,
            $section::PRODUCT_CAROUSEL,
        ]))

        @if ($marks)
            <div
                data-section-id="{{ $section->id }}"
                data-section-name="{{ $section->name }}"
            >
        @endif

        <!-- Static Content -->
        @switch ($section->type)
            @case ($section::IMAGE_CAROUSEL)
                <!-- Image Carousel -->
                <x-shop::carousel
                    :options="$data"
                    aria-label="{{ trans('shop::app.home.index.image-carousel') }}"
                />

                @break
            @case ($section::STATIC_CONTENT)
                <!-- Push Style -->
                @if (! empty($data['css']))
                    @push ('styles')
                        <style>
                            {!! $data['css'] !!}
                        </style>
                    @endpush
                @endif

                <!-- Render HTML -->
                @if (! empty($data['html']))
                    {!! $data['html'] !!}
                @endif

                @break
            @case ($section::CATEGORY_CAROUSEL)
                <!-- Categories carousel -->
                <x-shop::categories.carousel
                    :title="$data['title'] ?? ''"
                    :src="route('shop.api.categories.index', $data['filters'] ?? [])"
                    :navigation-link="route('shop.home.index')"
                    aria-label="{{ trans('shop::app.home.index.categories-carousel') }}"
                />

                @break
            @case ($section::PRODUCT_CAROUSEL)
                <!-- Product Carousel -->
                <x-shop::products.carousel
                    :title="$data['title'] ?? ''"
                    :src="route('shop.api.products.index', $data['filters'] ?? [])"
                    :navigation-link="route('shop.search.index', $data['filters'] ?? [])"
                    aria-label="{{ trans('shop::app.home.index.product-carousel') }}"
                />

                @break
        @endswitch

        @if ($marks)
            </div>
        @endif
    @endforeach

    @unless ($preview ?? false)
        <div class="container mt-20 max-lg:px-8 max-md:mt-8 max-sm:mt-7 max-sm:!px-4">
            <div class="grid items-center gap-8 overflow-hidden rounded-[24px] bg-arina-light px-10 py-10 md:grid-cols-2 md:px-14 max-sm:rounded-2xl max-sm:px-6 max-sm:py-8">
                <div>
                    <span class="mb-3 block h-1 w-14 rounded-full bg-arina/70"></span>

                    <h2 class="font-dmserif text-3xl text-arina-deep max-md:text-2xl max-sm:text-xl">
                        @lang('shop::app.home.index.app-strip.title')
                    </h2>

                    <p class="mt-3 max-w-md text-sm text-zinc-600 max-sm:text-xs">
                        @lang('shop::app.home.index.app-strip.subtitle')
                    </p>

                    <div class="mt-5 flex flex-wrap items-center gap-2.5">
                        <span class="rounded-full bg-navyBlue px-5 py-2.5 text-sm font-medium text-white max-sm:text-xs">
                            @lang('shop::app.home.index.app-strip.button')
                        </span>

                        <span class="rounded-full border border-arina-border bg-white px-4 py-2 text-xs font-semibold text-arina-deep">
                            Android
                        </span>

                        <span class="rounded-full border border-arina-border bg-white px-4 py-2 text-xs font-semibold text-arina-deep">
                            iOS
                        </span>
                    </div>
                </div>

                <div class="relative mx-auto w-full max-w-[260px]">
                    <div class="rounded-[28px] border border-arina-border bg-white p-3 shadow-[0_24px_60px_-24px_rgba(166,62,88,0.5)]">
                        <div class="rounded-2xl bg-arina-cream p-3">
                            <div class="shimmer mb-2.5 h-36 rounded-xl"></div>

                            <div class="shimmer mb-2 h-4 w-3/4 rounded"></div>

                            <div class="shimmer mb-3 h-4 w-1/3 rounded"></div>

                            <div class="rounded-full bg-navyBlue py-2 text-center text-xs font-medium text-white">
                                @lang('shop::app.components.products.card.add-to-cart')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endunless

    @if ($preview ?? false)
        @include('shop::home.preview-bridge')
    @endif
</x-shop::layouts>
