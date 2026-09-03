@props(['options'])

@php
    $carouselImages = $options['images'] ?? [];

    $firstImage = data_get($carouselImages, '0.image');

    $firstImageTitle = data_get($carouselImages, '0.title');

    $firstImageLink = data_get($carouselImages, '0.link');

    $totalSlides = count($carouselImages);
@endphp

@if ($firstImage)
    @push('meta')
        <link
            rel="preload"
            as="image"
            href="{{ str_replace('storage', 'cache/small', $firstImage) }}"
            imagesrcset="{{ $firstImage }} 1920w, {{ str_replace('storage', 'cache/large', $firstImage) }} 1280w, {{ str_replace('storage', 'cache/medium', $firstImage) }} 1024w, {{ str_replace('storage', 'cache/small', $firstImage) }} 768w"
            imagesizes="100vw"
            fetchpriority="high"
        >
    @endpush
@endif

<section class="relative h-[86svh] max-h-[900px] min-h-[540px] w-full overflow-hidden bg-zinc-950 max-sm:min-h-[500px]">
<v-carousel :images="{{ json_encode($carouselImages) }}">
    @if ($firstImage)
        <div class="absolute inset-0">
            <img
                src="{{ $firstImage }}"
                srcset="{{ $firstImage }} 1920w, {{ str_replace('storage', 'cache/large', $firstImage) }} 1280w, {{ str_replace('storage', 'cache/medium', $firstImage) }} 1024w, {{ str_replace('storage', 'cache/small', $firstImage) }} 768w"
                sizes="100vw"
                class="absolute inset-0 h-full w-full object-cover"
                style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;display:block"
                alt="{{ $firstImageTitle ?? trans('shop::app.home.index.image-carousel') }}"
                fetchpriority="high"
                decoding="sync"
            >

            <div class="absolute inset-0 bg-gradient-to-r from-zinc-950/60 via-zinc-950/10 to-transparent"></div>

            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-zinc-950/80 via-zinc-950/25 to-transparent pb-14 pt-28 max-sm:pb-10"></div>

            <div class="absolute inset-x-0 bottom-0 pb-14 max-sm:pb-10">
                <div class="px-[60px] max-1180:px-8 max-sm:px-4">
                    <p class="mb-4 flex items-baseline gap-2 text-white">
                        <span class="font-dmserif text-5xl leading-none max-sm:text-4xl">01</span>

                        <span class="text-sm font-medium tracking-[0.3em] text-white/70">/ {{ str_pad($totalSlides, 2, '0', STR_PAD_LEFT) }}</span>
                    </p>

                    @if ($firstImageTitle)
                        <h2 class="font-dmserif max-w-3xl text-[clamp(2.5rem,6vw,5.5rem)] leading-[1.02] text-white drop-shadow-xl">
                            {{ $firstImageTitle }}
                        </h2>
                    @endif

                    @if ($firstImageLink)
                        <a
                            href="{{ $firstImageLink }}"
                            class="mt-7 inline-flex items-center gap-2.5 rounded-full bg-white py-3.5 pl-7 pr-6 text-sm font-semibold text-zinc-950 shadow-2xl transition-all duration-300 hover:gap-3.5 hover:bg-zinc-100 max-sm:mt-5 max-sm:py-3 max-sm:pl-6"
                        >
                            @lang('shop::app.home.index.shop-now')

                            <span class="icon-arrow-right text-base leading-none"></span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="shimmer absolute inset-0"></div>
    @endif
</v-carousel>
</section>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-carousel-template"
    >
        <div
            class="relative h-full w-full overflow-hidden"
            @mouseenter="pauseAutoplay"
            @mouseleave="resumeAutoplay"
        >
            <!-- Slides -->
            <div
                class="inline-flex h-full translate-x-0 cursor-pointer transition-transform duration-700 ease-out will-change-transform"
                ref="sliderContainer"
            >
                <div
                    class="relative h-full w-full shrink-0"
                    v-for="(image, index) in images"
                    :key="index"
                    @click="visitLink(image)"
                    ref="slide"
                >
                    <x-shop::media.images.lazy
                        class="absolute inset-0 h-full w-full select-none object-cover transition-transform duration-300 ease-in-out will-change-transform"
                        ::class="{ 'hero-ken-burns': index === Math.abs(currentIndex) }"
                        ::lazy="index === 0 ? false : true"
                        ::src="image.image"
                        ::srcset="image.image + ' 1920w, ' + image.image.replace('storage', 'cache/large') + ' 1280w,' + image.image.replace('storage', 'cache/medium') + ' 1024w, ' + image.image.replace('storage', 'cache/small') + ' 768w'"
                        sizes="100vw"
                        ::alt="image?.title || 'Carousel Image ' + (index + 1)"
                        tabindex="0"
                        ::fetchpriority="index === 0 ? 'high' : 'low'"
                        ::decoding="index === 0 ? 'sync' : 'async'"
                    />

                    <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-zinc-950/60 via-zinc-950/10 to-transparent"></div>

                    <div class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-zinc-950/80 via-zinc-950/25 to-transparent pb-14 pt-28 max-sm:pb-10"></div>

                    <div class="absolute inset-x-0 bottom-0 pb-14 max-sm:pb-10">
                        <div class="px-[60px] max-1180:px-8 max-sm:px-4">
                            <p class="mb-4 flex items-baseline gap-2 text-white">
                                <span
                                    class="font-dmserif text-5xl leading-none max-sm:text-4xl"
                                    v-text="String(Math.abs(currentIndex) + 1).padStart(2, '0')"
                                ></span>

                                <span
                                    class="text-sm font-medium tracking-[0.3em] text-white/70"
                                    v-text="'/ ' + String(images.length).padStart(2, '0')"
                                ></span>
                            </p>

                            <h2
                                class="font-dmserif max-w-3xl text-[clamp(2.5rem,6vw,5.5rem)] leading-[1.02] text-white drop-shadow-xl"
                                v-if="image.title"
                                v-text="image.title"
                            ></h2>

                            <a
                                v-if="image.link"
                                :href="image.link"
                                @click.stop
                                class="mt-7 inline-flex items-center gap-2.5 rounded-full bg-white py-3.5 pl-7 pr-6 text-sm font-semibold text-zinc-950 shadow-2xl transition-all duration-300 hover:gap-3.5 hover:bg-zinc-100 max-sm:mt-5 max-sm:py-3 max-sm:pl-6"
                            >
                                @lang('shop::app.home.index.shop-now')

                                <span class="icon-arrow-right text-base leading-none"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Story progress segments -->
            <div
                class="absolute inset-x-0 top-0 z-10 px-[60px] pt-5 max-1180:px-8 max-sm:px-4 max-sm:pt-4"
                v-if="images?.length >= 2"
            >
                <div class="flex gap-2">
                    <div
                        v-for="(image, index) in images"
                        :key="'segment-' + index"
                        class="h-[3px] flex-1 cursor-pointer overflow-hidden rounded-full bg-white/25 backdrop-blur-sm"
                        role="button"
                        tabindex="0"
                        :aria-label="'Go to slide ' + (index + 1)"
                        @click="navigateByPagination(index)"
                        @keydown.enter="navigateByPagination(index)"
                        @keydown.space.prevent="navigateByPagination(index)"
                    >
                        <span
                            v-if="index < Math.abs(currentIndex)"
                            class="block h-full w-full bg-white"
                        ></span>

                        <span
                            v-else-if="index === Math.abs(currentIndex)"
                            :key="Math.abs(currentIndex) + '-' + cycle"
                            class="hero-progress-fill block h-full w-full bg-white"
                            :style="{ 'animation-play-state': isPaused ? 'paused' : 'running' }"
                        ></span>
                    </div>
                </div>
            </div>

            <!-- Glass arrows -->
            <div
                class="absolute bottom-14 right-[60px] z-10 hidden gap-3 md:flex max-1180:right-8"
                v-if="images?.length >= 2"
            >
                <span
                    class="icon-arrow-left cursor-pointer rounded-full bg-white/15 p-3.5 text-xl text-white ring-1 ring-white/30 backdrop-blur-md transition-all duration-300 hover:bg-white hover:text-zinc-950"
                    :class="{ 'cursor-not-allowed opacity-40': direction == 'ltr' && currentIndex == 0 }"
                    role="button"
                    aria-label="@lang('shop::components.carousel.previous')"
                    tabindex="0"
                    @click="navigate('prev')"
                    @keydown.enter="navigate('prev')"
                    @keydown.space.prevent="navigate('prev')"
                >
                </span>

                <span
                    class="icon-arrow-right cursor-pointer rounded-full bg-white/15 p-3.5 text-xl text-white ring-1 ring-white/30 backdrop-blur-md transition-all duration-300 hover:bg-white hover:text-zinc-950"
                    :class="{ 'cursor-not-allowed opacity-40': direction == 'rtl' && currentIndex == 0 }"
                    role="button"
                    aria-label="@lang('shop::components.carousel.next')"
                    tabindex="0"
                    @click="navigate('next')"
                    @keydown.enter="navigate('next')"
                    @keydown.space.prevent="navigate('next')"
                >
                </span>
            </div>
        </div>
    </script>

    <script type="module">
        app.component("v-carousel", {
            template: '#v-carousel-template',

            props: ['images'],

            data() {
                return {
                    isDragging: false,
                    startPos: 0,
                    currentTranslate: 0,
                    prevTranslate: 0,
                    animationID: 0,
                    currentIndex: 0,
                    slider: '',
                    slides: [],
                    autoPlayInterval: null,
                    direction: 'ltr',
                    startFrom: 1,
                    cycle: 0,
                    isPaused: false,
                    autoPlayDelay: 5000,
                };
            },

            mounted() {
                this.slider = this.$refs.sliderContainer;

                if (
                    this.$refs.slide
                    && typeof this.$refs.slide[Symbol.iterator] === 'function'
                ) {
                    this.slides = Array.from(this.$refs.slide);
                }

                // Use requestIdleCallback for non-critical initialization
                if ('requestIdleCallback' in window) {
                    requestIdleCallback(() => {
                        this.init();
                        setTimeout(() => {
                            this.play();
                        }, 4000);
                    });
                } else {
                    setTimeout(() => {
                        this.init();
                        setTimeout(() => {
                            this.play();
                        }, 4000);
                    });
                }
            },

            beforeUnmount() {
                this.cleanup();
            },

            methods: {
                init() {
                    this.direction = document.dir;

                    if (this.direction == 'rtl') {
                        this.startFrom = -1;
                    }

                    this.slides.forEach((slide, index) => {
                        slide.querySelector('img')?.addEventListener('dragstart', (e) => e.preventDefault());

                        slide.addEventListener('mousedown', this.handleDragStart);

                        slide.addEventListener('touchstart', this.handleDragStart, { passive: true });

                        slide.addEventListener('mouseup', this.handleDragEnd);

                        slide.addEventListener('mouseleave', this.handleDragEnd);

                        slide.addEventListener('touchend', this.handleDragEnd, { passive: true });

                        slide.addEventListener('mousemove', this.handleDrag);

                        slide.addEventListener('touchmove', this.handleDrag, { passive: true });
                    });

                    window.addEventListener('resize', this.setPositionByIndex);
                },

                handleDragStart(event) {
                    this.startPos = event.type === 'mousedown' ? event.clientX : event.touches[0].clientX;

                    this.isDragging = true;

                    this.animationID = requestAnimationFrame(this.animation);
                },

                handleDrag(event) {
                    if (! this.isDragging) {
                        return;
                    }

                    const currentPosition = event.type === 'mousemove' ? event.clientX : event.touches[0].clientX;

                    this.currentTranslate = this.prevTranslate + currentPosition - this.startPos;
                },

                handleDragEnd(event) {
                    clearInterval(this.autoPlayInterval);

                    cancelAnimationFrame(this.animationID);

                    this.isDragging = false;

                    const movedBy = this.currentTranslate - this.prevTranslate;

                    if (this.direction == 'ltr') {
                        if (
                            movedBy < -100
                            && this.currentIndex < this.slides.length - 1
                        ) {
                            this.currentIndex += 1;
                        }

                        if (
                            movedBy > 100
                            && this.currentIndex > 0
                        ) {
                            this.currentIndex -= 1;
                        }
                    } else {
                        if (
                            movedBy > 100
                            && this.currentIndex < this.slides.length - 1
                        ) {
                            if (Math.abs(this.currentIndex) != this.slides.length - 1) {
                                this.currentIndex -= 1;
                            }
                        }

                        if (
                            movedBy < -100
                            && this.currentIndex < 0
                        ) {
                            this.currentIndex += 1;
                        }
                    }

                    this.setPositionByIndex();

                    this.play();
                },

                animation() {
                    this.setSliderPosition();

                    if (this.isDragging) {
                        requestAnimationFrame(this.animation);
                    }
                },

                setPositionByIndex() {
                    const slideWidth = this.slides.length ? this.slides[0].clientWidth : window.innerWidth;

                    this.currentTranslate = this.currentIndex * -slideWidth;

                    this.prevTranslate = this.currentTranslate;

                    this.setSliderPosition();
                },

                setSliderPosition() {
                    if (this.slider) {
                        this.slider.style.transform = `translateX(${this.currentTranslate}px)`;
                    }
                },

                visitLink(image) {
                    if (image.link) {
                        window.location.href = image.link;
                    }
                },

                navigate(type) {
                    clearInterval(this.autoPlayInterval);

                    if (this.direction === 'rtl') {
                        type === 'next' ? this.prev() : this.next();
                    } else {
                        type === 'next' ? this.next() : this.prev();
                    }

                    this.setPositionByIndex();

                    this.play();
                },

                next() {
                    this.currentIndex = (this.currentIndex + this.startFrom) % this.images.length;
                },

                prev() {
                    this.currentIndex = this.direction == 'ltr'
                        ? this.currentIndex > 0 ? this.currentIndex - 1 : 0
                        : this.currentIndex < 0 ? this.currentIndex + 1 : 0;
                },

                navigateByPagination(index) {
                    this.direction == 'rtl' ? index = -index : '';

                    clearInterval(this.autoPlayInterval);

                    this.currentIndex = index;

                    this.setPositionByIndex();

                    this.play();
                },

                pauseAutoplay() {
                    this.isPaused = true;

                    clearInterval(this.autoPlayInterval);
                },

                resumeAutoplay() {
                    this.isPaused = false;

                    this.play();
                },

                play() {
                    clearInterval(this.autoPlayInterval);

                    this.cycle += 1;

                    this.autoPlayInterval = setInterval(() => {
                        this.currentIndex = (this.currentIndex + this.startFrom) % this.images.length;

                        this.setPositionByIndex();
                    }, this.autoPlayDelay);
                },

                cleanup() {
                    // Clear intervals and animation frames
                    clearInterval(this.autoPlayInterval);
                    cancelAnimationFrame(this.animationID);

                    // Remove event listeners
                    if (this.slides) {
                        this.slides.forEach(slide => {
                            slide.removeEventListener('mousedown', this.handleDragStart);
                            slide.removeEventListener('touchstart', this.handleDragStart);
                            slide.removeEventListener('mouseup', this.handleDragEnd);
                            slide.removeEventListener('mouseleave', this.handleDragEnd);
                            slide.removeEventListener('touchend', this.handleDragEnd);
                            slide.removeEventListener('mousemove', this.handleDrag);
                            slide.removeEventListener('touchmove', this.handleDrag);
                        });
                    }

                    window.removeEventListener('resize', this.setPositionByIndex);
                },
            },
        });
    </script>
@endpushOnce
