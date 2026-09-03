{!! view_render_event('bagisto.shop.layout.bottom_nav.before') !!}

<v-bottom-nav>
    <nav
        class="fixed inset-x-0 bottom-0 z-40 border-t border-arina-border bg-white/95 backdrop-blur-xl lg:hidden"
        aria-label="@lang('shop::app.components.layouts.header.mobile.categories')"
    >
        <div class="shimmer mx-10 my-2 h-12 rounded-xl"></div>
    </nav>
</v-bottom-nav>

{!! view_render_event('bagisto.shop.layout.bottom_nav.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-bottom-nav-template"
    >
        <div>
            <nav
                class="fixed inset-x-0 bottom-0 z-40 border-t border-arina-border bg-white/95 backdrop-blur-xl lg:hidden"
                aria-label="@lang('shop::app.components.layouts.header.mobile.categories')"
            >
                <div class="grid grid-cols-4 px-2 pb-[env(safe-area-inset-bottom)]">
                    <a
                        href="{{ route('shop.home.index') }}"
                        class="flex flex-col items-center gap-0.5 py-2 text-[11px] font-medium {{ request()->routeIs('shop.home.index') ? 'text-navyBlue' : 'text-zinc-500' }}"
                    >
                        <svg
                            class="h-6 w-6"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M3.5 10.5 12 3.5l8.5 7"></path>
                            <path d="M5.5 9.5V20h13V9.5"></path>
                            <path d="M9.5 20v-5.5h5V20"></path>
                        </svg>

                        @lang('shop::app.checkout.cart.index.home')
                    </a>

                    <button
                        type="button"
                        class="flex flex-col items-center gap-0.5 py-2 text-[11px] font-medium"
                        :class="isSheetOpen ? 'text-navyBlue' : 'text-zinc-500'"
                        @click="isSheetOpen = true"
                        aria-haspopup="dialog"
                    >
                        <span class="icon-grid-view text-2xl leading-none"></span>

                        @lang('shop::app.components.layouts.header.desktop.bottom.categories')
                    </button>

                    <a
                        href="{{ route('shop.checkout.cart.index') }}"
                        class="flex flex-col items-center gap-0.5 py-2 text-[11px] font-medium {{ request()->routeIs('shop.checkout.cart.*') ? 'text-navyBlue' : 'text-zinc-500' }}"
                    >
                        <span class="icon-cart text-2xl leading-none"></span>

                        @lang('shop::app.checkout.cart.index.cart')
                    </a>

                    <a
                        href="{{ route('shop.customers.account.index') }}"
                        class="flex flex-col items-center gap-0.5 py-2 text-[11px] font-medium {{ request()->routeIs('shop.customers.account.*') ? 'text-navyBlue' : 'text-zinc-500' }}"
                    >
                        <span class="icon-users text-2xl leading-none"></span>

                        @lang('shop::app.components.layouts.header.mobile.account')
                    </a>
                </div>
            </nav>

            <div
                class="fixed inset-0 z-50 lg:hidden"
                v-if="isSheetOpen"
                role="dialog"
                aria-modal="true"
                aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.categories')"
            >
                <div
                    class="absolute inset-0 bg-zinc-900/50"
                    @click="isSheetOpen = false"
                ></div>

                <div class="absolute inset-x-0 bottom-0 max-h-[75vh] overflow-auto rounded-t-3xl bg-white px-6 pb-10 pt-3 shadow-2xl">
                    <div
                        class="mx-auto mb-4 h-1 w-12 rounded-full bg-zinc-300"
                        @click="isSheetOpen = false"
                    ></div>

                    <p class="mb-3 font-dmserif text-xl">
                        @lang('shop::app.components.layouts.header.desktop.bottom.categories')
                    </p>

                    <div
                        class="grid gap-1"
                        v-if="categories.length"
                    >
                        <div v-for="category in categories" :key="category.id">
                            <a
                                :href="category.url"
                                class="flex items-center justify-between py-2.5 text-base font-medium"
                            >
                                @{{ category.name }}

                                <span
                                    class="icon-arrow-right text-lg text-zinc-400"
                                    v-if="! (category.children && category.children.length)"
                                ></span>
                            </a>

                            <div
                                class="grid gap-1 border-arina-border ltr:ml-3 ltr:border-l ltr:pl-4 rtl:mr-3 rtl:border-r rtl:pr-4"
                                v-if="category.children && category.children.length"
                            >
                                <a
                                    :href="child.url"
                                    class="py-1.5 text-sm text-zinc-600"
                                    v-for="child in category.children"
                                    :key="child.id"
                                >
                                    @{{ child.name }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div
                        class="grid gap-2.5 py-4"
                        v-else
                    >
                        <div
                            class="shimmer h-6 rounded"
                            v-for="index in 6"
                            :key="index"
                        ></div>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-bottom-nav', {
            template: '#v-bottom-nav-template',

            data() {
                return {
                    isSheetOpen: false,

                    categories: [],
                };
            },

            mounted() {
                this.getCategories();
            },

            methods: {
                getCategories() {
                    this.$axios.get("{{ route('shop.api.categories.tree') }}")
                        .then(response => {
                            this.categories = response.data.data;
                        }).catch(error => {
                            console.log(error);
                        });
                },
            },
        });
    </script>
@endPushOnce
