{!! view_render_event('bagisto.shop.layout.header.before') !!}

@if(core()->getCurrentChannel()->locales()->count() > 1 || core()->getCurrentChannel()->currencies()->count() > 1 )
    <div class="shop-topbar max-lg:hidden">
        <x-shop::layouts.header.desktop.top />
    </div>
@endif

<header class="shop-header shadow-gray sticky top-0 z-10 bg-white/85 shadow-sm backdrop-blur-xl transition-all duration-300 max-lg:shadow-none">
    <v-header-switcher>
        <!-- Desktop Header Shimmer -->
        <div class="flex flex-wrap max-lg:hidden">
            <div class="w-full px-[60px] max-1180:px-8">
                <div class="flex min-h-[76px] items-center justify-between gap-x-8 py-2.5">
                    <!-- Logo Shimmer -->
                    <span
                        class="shimmer block h-12 w-12 shrink-0 rounded-full"
                        role="presentation"
                    >
                    </span>

                    <!-- Search Bar Shimmer -->
                    <span
                        class="shimmer mx-auto block h-[46px] w-full max-w-[640px] rounded-full"
                        role="presentation"
                    >
                    </span>

                    <!-- Right Navigation Icons Shimmer -->
                    <div class="flex shrink-0 gap-x-7">
                        <span
                            class="shimmer h-6 w-6 rounded"
                            role="presentation"
                        >
                        </span>

                        <span
                            class="shimmer h-6 w-6 rounded"
                            role="presentation"
                        >
                        </span>

                        <span
                            class="shimmer h-6 w-6 rounded"
                            role="presentation"
                        >
                        </span>
                    </div>
                </div>

                <!-- Category Strip Shimmer -->
                <div class="flex h-11 items-center gap-2 border-t border-zinc-100">
                    <span
                        class="shimmer h-6 w-24 rounded"
                        role="presentation"
                    >
                    </span>

                    <span
                        class="shimmer h-6 w-20 rounded"
                        role="presentation"
                    >
                    </span>

                    <span
                        class="shimmer h-6 w-20 rounded"
                        role="presentation"
                    >
                    </span>

                    <span
                        class="shimmer h-6 w-24 rounded"
                        role="presentation"
                    >
                    </span>
                </div>
            </div>
        </div>

        <!-- Mobile Header Shimmer -->
        <div class="flex flex-wrap gap-4 px-4 pb-4 pt-6 shadow-sm lg:hidden">
            <div class="flex w-full items-center justify-between">
                <!-- Left Navigation -->
                <div class="flex items-center gap-x-1.5">
                    <!-- Hamburger Menu Shimmer -->
                    <span 
                        class="shimmer block h-6 w-6 rounded" 
                        role="presentation"
                    >
                    </span>
                    
                    <!-- Logo Shimmer -->
                    <span 
                        class="shimmer block h-[29px] w-[131px] rounded" 
                        role="presentation"
                    >
                    </span>
                </div>

                <!-- Right Navigation Icons -->
                <div class="flex items-center gap-x-5 max-md:gap-x-4">
                    <!-- Compare Icon Shimmer -->
                    <span 
                        class="shimmer block h-6 w-6 rounded" 
                        role="presentation"
                    >
                    </span>
                    
                    <!-- Cart Icon Shimmer -->
                    <span 
                        class="shimmer block h-6 w-6 rounded" 
                        role="presentation"
                    >
                    </span>
                    
                    <!-- Profile Icon Shimmer -->
                    <span 
                        class="shimmer block h-6 w-6 rounded" 
                        role="presentation"
                    >
                    </span>
                </div>
            </div>

            <!-- Search Bar Shimmer -->
            <div class="flex w-full items-center">
                <div class="relative w-full">
                    <span
                        class="shimmer block h-[42px] w-full rounded-xl px-11 py-3.5 max-md:rounded-lg"
                        role="presentation"
                    >
                    </span>
                </div>
            </div>
        </div>
    </v-header-switcher>
</header>

{!! view_render_event('bagisto.shop.layout.header.after') !!}

@pushOnce('scripts')
    <script 
        type="text/x-template" 
        id="v-header-switcher-template"
    >
        <v-desktop-header v-if="isDesktop"></v-desktop-header>
        
        <v-mobile-header v-else></v-mobile-header>
    </script>

    <script type="module">
        app.component('v-header-switcher', {
            template: '#v-header-switcher-template',

            data() {
                return {
                    isDesktop: window.innerWidth >= 1024
                }
            },

            mounted() {
                this.media = window.matchMedia('(min-width: 1024px)');

                this.media.addEventListener('change', this.handleMedia);
            },

            beforeUnmount() {
                this.media.removeEventListener('change', this.handleMedia);
            },

            methods: {
                handleMedia(e) {
                    this.isDesktop = e.matches;
                }
            }
        });

        app.component('v-desktop-header', {
            template: '#v-desktop-header-template'
        });

        app.component('v-mobile-header', {
            template: '#v-mobile-header-template'
        });
    </script>

    <script 
        type="text/x-template" 
        id="v-desktop-header-template"
    >
        <x-shop::layouts.header.desktop />
    </script>

    <script 
        type="text/x-template" 
        id="v-mobile-header-template"
    >
        <x-shop::layouts.header.mobile />
    </script>

    <script>
        window.addEventListener('scroll', () => {
            document.body.classList.toggle('shop-header-scrolled', window.scrollY > 24);
        }, { passive: true });

        window.addEventListener('keydown', (event) => {
            const isShortcut = (event.metaKey || event.ctrlKey) && event.key.toLowerCase() === 'k';

            if (! isShortcut) {
                return;
            }

            const searchInput = document.getElementById('shop-search-input');

            if (searchInput) {
                event.preventDefault();

                searchInput.focus();
            }
        });
    </script>
@endPushOnce
