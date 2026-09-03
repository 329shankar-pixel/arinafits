{!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.before') !!}

<div class="shop-main-bar w-full border border-b border-l-0 border-r-0 border-t-0 px-[60px] max-1180:px-8">
    <!-- Row 1 : logo, search, account actions -->
    <div class="shop-main-row flex min-h-[76px] items-center gap-x-8 py-2.5 max-[1180px]:gap-x-5">
        <!-- Left : logo -->
        <div class="flex shrink-0 items-center">
            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.logo.before') !!}

            <a
                href="{{ route('shop.home.index') }}"
                aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.bagisto')"
            >
                <img
                    src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                    class="h-12 w-auto object-contain"
                    width="48"
                    height="48"
                    alt="{{ core()->getCurrentChannel()->logo_alt ?: config('app.name') }}"
                >
            </a>

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.logo.after') !!}
        </div>

        <!-- Center : search -->
        <div class="min-w-0 flex-1">
            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.search_bar.before') !!}

            <!-- Search Bar Container -->
            <div class="relative mx-auto w-full max-w-[640px]">
                <form
                    action="{{ route('shop.search.index') }}"
                    class="relative flex items-center"
                    role="search"
                    toolname="search_products"
                    tooldescription="{{ trans('shop::app.components.layouts.webmcp.search-products') }}"
                    toolautosubmit
                >
                    <label
                        for="organic-search"
                        class="sr-only"
                    >
                        @lang('shop::app.components.layouts.header.desktop.bottom.search')
                    </label>

                    <div class="icon-search pointer-events-none absolute top-2.5 flex items-center text-xl ltr:left-3 rtl:right-3"></div>

                    <input
                        id="shop-search-input"
                        type="text"
                        name="query"
                        value="{{ request('query') }}"
                        toolparamdescription="{{ trans('shop::app.components.layouts.webmcp.search-products-query') }}"
                        class="block w-full py-3 text-sm font-medium text-gray-900 transition-all border-2 border-transparent rounded-full bg-zinc-100 px-11 hover:border-zinc-300 focus:border-arina focus:bg-white focus:ring-2 focus:ring-arina/20"
                        minlength="{{ core()->getConfigData('catalog.products.search.min_query_length') }}"
                        maxlength="{{ core()->getConfigData('catalog.products.search.max_query_length') }}"
                        placeholder="@lang('shop::app.components.layouts.header.desktop.bottom.search-text')"
                        aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.search-text')"
                        aria-required="true"
                        pattern="[^\\]+"
                        required
                    >

                    <kbd class="pointer-events-none absolute hidden items-center rounded-md border border-gray-200 bg-white px-1.5 py-0.5 text-[11px] font-semibold text-zinc-400 ltr:right-3 rtl:left-3 md:flex">⌘K</kbd>

                    <button
                        type="submit"
                        class="hidden"
                        aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.submit')"
                    >
                    </button>

                    @if (core()->getConfigData('catalog.products.settings.image_search'))
                        @include('shop::search.images.index')
                    @endif
                </form>
            </div>

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.search_bar.after') !!}
        </div>

        <!-- Right : actions -->
        <div class="flex shrink-0 items-center gap-x-7 max-[1100px]:gap-x-5">
            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.compare.before') !!}

            <!-- Compare -->
            @if(core()->getConfigData('catalog.products.settings.compare_option'))
                <a
                    href="{{ route('shop.compare.index') }}"
                    aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.compare')"
                >
                    <span
                        class="inline-block text-2xl cursor-pointer icon-compare"
                        role="presentation"
                    ></span>
                </a>
            @endif

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.compare.after') !!}

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.mini_cart.before') !!}

            <!-- Mini cart -->
            @if(core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                @include('shop::checkout.cart.mini-cart')
            @endif

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.mini_cart.after') !!}

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.profile.before') !!}

            <!-- user profile -->
            <x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
                <x-slot:toggle>
                    <span
                        class="inline-block text-2xl cursor-pointer icon-users"
                        role="button"
                        aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.profile')"
                        tabindex="0"
                    ></span>
                </x-slot>

                <!-- Guest Dropdown -->
                @guest('customer')
                    <x-slot:content>
                        <div class="grid gap-2.5">
                            <p class="text-xl font-dmserif">
                                @lang('shop::app.components.layouts.header.desktop.bottom.welcome-guest')
                            </p>

                            <p class="text-sm">
                                @lang('shop::app.components.layouts.header.desktop.bottom.dropdown-text')
                            </p>
                        </div>

                        <p class="w-full mt-3 border border-zinc-200"></p>

                        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.customers_action.before') !!}

                        <div class="flex gap-4 mt-6">
                            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.sign_in_button.before') !!}

                            <a
                                href="{{ route('shop.customer.session.create') }}"
                                class="block m-0 mx-auto text-base text-center primary-button w-max rounded-2xl px-7 max-md:rounded-lg ltr:ml-0 rtl:mr-0"
                            >
                                @lang('shop::app.components.layouts.header.desktop.bottom.sign-in')
                            </a>

                            <a
                                href="{{ route('shop.customers.register.index') }}"
                                class="block m-0 mx-auto text-base text-center border-2 secondary-button w-max rounded-2xl px-7 max-md:rounded-lg max-md:py-3 ltr:ml-0 rtl:mr-0"
                            >
                                @lang('shop::app.components.layouts.header.desktop.bottom.sign-up')
                            </a>

                            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.sign_up_button.after') !!}
                        </div>

                        @if (core()->getConfigData('sales.eu_withdrawal.general.enabled', core()->getCurrentChannelCode()))
                            <a
                                href="{{ route('shop.eu-withdrawal.guest.lookup') }}"
                                class="mt-4 inline-flex items-center gap-1.5 text-xs font-medium text-navyBlue hover:underline"
                            >
                                @lang('shop::app.eu_withdrawal.guest_dropdown.link')
                            </a>
                        @endif

                        {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.customers_action.after') !!}
                    </x-slot>
                @endguest

                <!-- Customers Dropdown -->
                @auth('customer')
                    <x-slot:content class="!p-0">
                        <div class="grid gap-2.5 p-5 pb-0">
                            <p class="text-xl font-dmserif" v-pre>
                                @lang('shop::app.components.layouts.header.desktop.bottom.welcome')’
                                {{ auth()->guard('customer')->user()->first_name }}
                            </p>

                            <p class="text-sm">
                                @lang('shop::app.components.layouts.header.desktop.bottom.dropdown-text')
                            </p>
                        </div>

                        <p class="w-full mt-3 border border-zinc-200"></p>

                        <div class="mt-2.5 grid gap-1 pb-2.5">
                            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.profile_dropdown.links.before') !!}

                            <a
                                class="px-5 py-2 text-base cursor-pointer hover:bg-gray-100"
                                href="{{ route('shop.customers.account.profile.index') }}"
                            >
                                @lang('shop::app.components.layouts.header.desktop.bottom.profile')
                            </a>

                            <a
                                class="px-5 py-2 text-base cursor-pointer hover:bg-gray-100"
                                href="{{ route('shop.customers.account.orders.index') }}"
                            >
                                @lang('shop::app.components.layouts.header.desktop.bottom.orders')
                            </a>

                            @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                                <a
                                    class="px-5 py-2 text-base cursor-pointer hover:bg-gray-100"
                                    href="{{ route('shop.customers.account.wishlist.index') }}"
                                >
                                    @lang('shop::app.components.layouts.header.desktop.bottom.wishlist')
                                </a>
                            @endif

                            <!--Customers logout-->
                            @auth('customer')
                                <x-shop::form
                                    method="DELETE"
                                    action="{{ route('shop.customer.session.destroy') }}"
                                    id="customerLogout"
                                />

                                <a
                                    class="px-5 py-2 text-base cursor-pointer hover:bg-gray-100"
                                    href="{{ route('shop.customer.session.destroy') }}"
                                    onclick="event.preventDefault(); document.getElementById('customerLogout').submit();"
                                >
                                    @lang('shop::app.components.layouts.header.desktop.bottom.logout')
                                </a>
                            @endauth

                            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.profile_dropdown.links.after') !!}
                        </div>
                    </x-slot>
                @endauth
            </x-shop::dropdown>

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.profile.after') !!}
        </div>
    </div>

    <!-- Row 2 : category strip -->
    {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.category.before') !!}

    <v-desktop-category>
        <div class="flex h-11 items-center gap-2 border-t border-zinc-100">
            <span
                class="h-6 w-24 rounded shimmer"
                role="presentation"
            ></span>

            <span
                class="h-6 w-20 rounded shimmer"
                role="presentation"
            ></span>

            <span
                class="h-6 w-20 rounded shimmer"
                role="presentation"
            ></span>

            <span
                class="h-6 w-24 rounded shimmer"
                role="presentation"
            ></span>
        </div>
    </v-desktop-category>

    {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.category.after') !!}
</div>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-desktop-category-template"
    >
        <!-- Loading State -->
        <div
            class="flex h-11 items-center gap-2 border-t border-zinc-100"
            v-if="isLoading"
        >
            <span
                class="h-6 w-24 rounded shimmer"
                role="presentation"
            ></span>

            <span
                class="h-6 w-20 rounded shimmer"
                role="presentation"
            ></span>

            <span
                class="h-6 w-20 rounded shimmer"
                role="presentation"
            ></span>

            <span
                class="h-6 w-24 rounded shimmer"
                role="presentation"
            ></span>
        </div>

        <!-- Category strip -->
        <div
            class="border-t border-zinc-100"
            v-else
        >
            <div class="relative flex h-11 items-stretch">
                <!-- "All" button opening the category sidebar -->
                <button
                    type="button"
                    class="flex shrink-0 items-center gap-2 border-b-2 border-transparent px-4 text-sm font-semibold uppercase transition-colors hover:border-navyBlue hover:text-navyBlue"
                    @click="toggleCategoryDrawer"
                    aria-haspopup="dialog"
                >
                    <span class="icon-hamburger text-xl"></span>

                    @lang('shop::app.components.layouts.header.desktop.bottom.all')
                </button>

                <span class="my-2.5 w-px shrink-0 bg-zinc-200"></span>

                <!-- Top level categories with mega dropdowns -->
                <div
                    class="group/level relative flex items-stretch"
                    v-for="category in categories"
                    :key="category.id"
                >
                    <a
                        :href="category.url"
                        class="flex items-center whitespace-nowrap border-b-2 border-transparent px-4 text-[13px] font-medium uppercase tracking-wide transition-colors group-hover/level:border-navyBlue group-hover/level:text-navyBlue max-[1180px]:px-3"
                    >
                        @{{ category.name }}
                    </a>

                    <div
                        class="pointer-events-none absolute top-full z-30 max-h-[580px] w-max max-w-[1260px] translate-y-1 overflow-auto rounded-b-2xl border border-[#F3F3F3] bg-white p-8 opacity-0 shadow-[0_24px_50px_-12px_rgba(0,0,0,.25)] transition duration-300 ease-out group-hover/level:pointer-events-auto group-hover/level:translate-y-0 group-hover/level:opacity-100 group-hover/level:duration-200 group-hover/level:ease-in ltr:left-0 rtl:right-0"
                        data-mega-menu-dropdown
                        v-if="category.children && category.children.length"
                    >
                        <div class="flex justify-between gap-x-[70px]">
                            <div
                                class="grid w-full min-w-max max-w-[170px] flex-auto grid-cols-[1fr] content-start gap-5"
                                v-for="pairCategoryChildren in pairCategoryChildren(category)"
                            >
                                <template v-for="secondLevelCategory in pairCategoryChildren">
                                    <p class="font-semibold text-navyBlue">
                                        <a :href="secondLevelCategory.url">
                                            @{{ secondLevelCategory.name }}
                                        </a>
                                    </p>

                                    <ul
                                        class="grid grid-cols-[1fr] gap-2.5"
                                        v-if="secondLevelCategory.children && secondLevelCategory.children.length"
                                    >
                                        <li
                                            class="text-sm font-medium text-zinc-500 transition-colors hover:text-navyBlue"
                                            v-for="thirdLevelCategory in secondLevelCategory.children"
                                        >
                                            <a :href="thirdLevelCategory.url">
                                                @{{ thirdLevelCategory.name }}
                                            </a>
                                        </li>
                                    </ul>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category dropdown panel : drops downward from the strip -->
            <div
                v-if="isSidebarOpen"
                class="absolute top-full z-40 max-h-[70vh] w-[330px] overflow-auto rounded-b-2xl border border-t-0 border-zinc-200 bg-white shadow-[0_30px_60px_-15px_rgba(0,0,0,0.3)] ltr:left-0 rtl:right-0"
            >
                <div class="flex items-center justify-between border-b border-zinc-100 px-6 py-3">
                    <p class="font-dmserif text-lg">
                        @lang('shop::app.components.layouts.header.desktop.bottom.categories')
                    </p>

                    <button
                        type="button"
                        class="icon-cancel cursor-pointer text-xl text-zinc-400 transition-colors hover:text-navyBlue"
                        @click="closeSidebar"
                        :aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.categories')"
                    ></button>
                </div>

                <nav
                    class="py-2"
                    aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.categories')"
                >
                    <div
                        v-for="category in categories"
                        :key="category.id"
                        @mouseenter="openFlyout(category, $event)"
                        @mouseleave="scheduleCloseFlyout"
                    >
                        <a
                            :href="category.url"
                            class="group/row flex items-center gap-3.5 px-6 py-3 transition-colors hover:bg-arina-light"
                            @focus="openFlyout(category, $event)"
                        >
                            <span
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-arina-light font-dmserif text-lg text-arina-deep transition-colors group-hover/row:bg-navyBlue group-hover/row:text-white"
                                v-text="category.name.charAt(0)"
                            ></span>

                            <span
                                class="min-w-0 flex-1 truncate text-[15px] font-medium transition-colors group-hover/row:text-navyBlue"
                                v-text="category.name"
                            ></span>

                            <span
                                class="icon-arrow-right rtl:icon-arrow-left shrink-0 text-lg text-zinc-300 transition-all group-hover/row:translate-x-0.5 group-hover/row:text-navyBlue"
                                v-if="category.children && category.children.length"
                            ></span>
                        </a>
                    </div>
                </nav>
            </div>

            <teleport to="body">
                <div
                    v-if="flyout"
                    ref="flyoutPanel"
                    class="fixed z-[70] max-h-[80vh] w-[520px] max-w-[calc(100vw-400px)] overflow-auto rounded-2xl border border-arina-border bg-white p-7 shadow-[0_30px_60px_-15px_rgba(166,62,88,0.35)]"
                    :style="flyout.style"
                    @mouseenter="cancelCloseFlyout"
                    @mouseleave="scheduleCloseFlyout"
                >
                    <a
                        :href="flyout.category.url"
                        class="mb-5 inline-flex items-center gap-1.5 font-dmserif text-xl text-navyBlue hover:underline"
                    >
                        @{{ flyout.category.name }}

                        <span class="icon-arrow-right rtl:icon-arrow-left text-lg"></span>
                    </a>

                    <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                        <div v-for="child in flyout.category.children" :key="child.id">
                            <a
                                :href="child.url"
                                class="font-semibold text-navyBlue hover:underline"
                            >
                                @{{ child.name }}
                            </a>

                            <ul
                                class="mt-2 grid gap-1.5"
                                v-if="child.children && child.children.length"
                            >
                                <li v-for="grandchild in child.children" :key="grandchild.id">
                                    <a
                                        :href="grandchild.url"
                                        class="text-sm text-zinc-500 transition-colors hover:text-navyBlue"
                                    >
                                        @{{ grandchild.name }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <a
                        :href="flyout.category.url"
                        class="mt-6 inline-block text-sm font-semibold text-navyBlue hover:underline"
                    >
                        @lang('shop::app.components.products.carousel.view-all') @{{ flyout.category.name }}
                    </a>
                </div>
            </teleport>
        </div>
    </script>

    <script type="module">
        app.component('v-desktop-category', {
            template: '#v-desktop-category-template',

            data() {
                return {
                    isLoading: true,
                    categories: [],
                    isSidebarOpen: false,
                    flyout: null,
                    flyoutCloseTimer: null
                }
            },

            mounted() {
                this.initCategories();

                window.addEventListener('resize', this.positionMegaMenus);

                window.addEventListener('scroll', this.closeFlyout, { passive: true });

                window.addEventListener('keydown', this.handleFlyoutKeydown);

                document.addEventListener('click', this.handleOutsideClick);
            },

            beforeUnmount() {
                window.removeEventListener('resize', this.positionMegaMenus);

                window.removeEventListener('scroll', this.closeFlyout);

                window.removeEventListener('keydown', this.handleFlyoutKeydown);

                document.removeEventListener('click', this.handleOutsideClick);
            },

            methods: {
                initCategories() {
                    try {
                        const stored = localStorage.getItem('arina_categories_v1');

                        if (stored) {
                            this.categories = JSON.parse(stored);
                            this.isLoading = false;

                            this.$nextTick(this.positionMegaMenus);
                        }

                    } catch (e) {}

                    this.getCategories();
                },

                getCategories() {
                    this.$axios.get("{{ route('shop.api.categories.tree') }}")
                        .then(response => {
                            this.isLoading = false;
                            this.categories = response.data.data;

                            try {
                                localStorage.setItem('arina_categories_v1', JSON.stringify(this.categories));

                                localStorage.removeItem('categories');
                            } catch (e) {}

                            this.$nextTick(this.positionMegaMenus);
                        })
                        .catch(error => {
                            console.log(error);
                        });
                },

                pairCategoryChildren(category) {
                    if (! category.children) return [];

                    return category.children.reduce((result, value, index, array) => {
                        if (index % 2 === 0) {
                            result.push(array.slice(index, index + 2));
                        }
                        return result;
                    }, []);
                },

                toggleCategoryDrawer() {
                    this.isSidebarOpen = ! this.isSidebarOpen;

                    if (! this.isSidebarOpen) {
                        this.closeFlyout();
                    }
                },

                closeSidebar() {
                    this.isSidebarOpen = false;

                    this.closeFlyout();
                },

                handleOutsideClick(event) {
                    if (
                        this.isSidebarOpen
                        && this.$el
                        && ! this.$el.contains(event.target)
                    ) {
                        this.closeSidebar();
                    }
                },

                openFlyout(category, event) {
                    if (! category.children || ! category.children.length) {
                        this.closeFlyout();

                        return;
                    }

                    this.cancelCloseFlyout();

                    const anchor = event.currentTarget.getBoundingClientRect();

                    const isRtl = document.dir === 'rtl';

                    const panelWidth = 520;

                    const edge = isRtl
                        ? Math.max(12, window.innerWidth - anchor.left + 12)
                        : anchor.right + 12;

                    this.flyout = {
                        category,
                        style: {
                            top: Math.max(12, Math.min(anchor.top, window.innerHeight - 320)) + 'px',
                            left: isRtl ? 'auto' : Math.min(edge, window.innerWidth - panelWidth - 12) + 'px',
                            right: isRtl ? Math.min(edge, window.innerWidth - panelWidth - 12) + 'px' : 'auto'
                        }
                    };

                    this.$nextTick(() => {
                        if (! this.flyout || ! this.$refs.flyoutPanel) {
                            return;
                        }

                        const height = this.$refs.flyoutPanel.offsetHeight;

                        const top = Math.max(12, Math.min(anchor.top, window.innerHeight - height - 12));

                        this.flyout.style.top = top + 'px';
                    });
                },

                scheduleCloseFlyout() {
                    this.cancelCloseFlyout();

                    this.flyoutCloseTimer = setTimeout(() => {
                        this.closeFlyout();
                    }, 140);
                },

                cancelCloseFlyout() {
                    if (this.flyoutCloseTimer) {
                        clearTimeout(this.flyoutCloseTimer);

                        this.flyoutCloseTimer = null;
                    }
                },

                closeFlyout() {
                    this.cancelCloseFlyout();

                    this.flyout = null;
                },

                handleFlyoutKeydown(event) {
                    if (event.key === 'Escape') {
                        this.closeSidebar();
                    }
                },

                positionMegaMenus() {
                    const MARGIN = 12;
                    const viewport = document.documentElement.clientWidth;

                    (this.$el.querySelectorAll?.('[data-mega-menu-dropdown]') ?? []).forEach(dropdown => {
                        const edge = getComputedStyle(dropdown).direction === 'rtl' ? 'right' : 'left';

                        dropdown.style.left = dropdown.style.right = '';
                        dropdown.style.maxWidth = Math.min(1260, viewport - 2 * MARGIN) + 'px';

                        const rect = dropdown.getBoundingClientRect();

                        // Positive when it spills off the right edge, negative off the left, 0 when it fits.
                        const overflow = Math.max(0, rect.right - (viewport - MARGIN)) - Math.max(0, MARGIN - rect.left);

                        if (overflow) {
                            const base = parseFloat(getComputedStyle(dropdown)[edge]) || 0;

                            dropdown.style[edge] = base + (edge === 'left' ? -overflow : overflow) + 'px';
                        }
                    });
                }
            },
        });
    </script>
@endPushOnce
