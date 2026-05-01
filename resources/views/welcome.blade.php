<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="theme-color" content="#000000" />
        <meta
            name="description"
            content="Conrad.Works — a human, father, husband, consultant, entrepreneur, writer, trainer and songwriter."
        />
        <title>Conrad.Works</title>

        <!-- Tailwind (CDN) -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Single font resource: Instrument Serif only (body uses system UI stack) -->
        <link
            href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&display=swap"
            rel="stylesheet"
        />

        <!-- Alpine.js -->
        <script
            defer
            src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
        ></script>

        <style>
            :root {
                --cw-bg: #000000;
                --cw-fg: #ffffff;
                --cw-muted: #6b6b6b;
                --cw-border: #2a2a2a;
                --cw-border-strong: #3a3a3a;
            }
            html, body {
                background: #000000 !important;
                color: #ffffff !important;
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif !important;
                -webkit-font-smoothing: antialiased;
                text-rendering: optimizeLegibility;
            }
            /* Serif font anchored in <style> so it can't be wiped by a replaced Tailwind config */
            .cw-serif {
                font-family: 'Instrument Serif', ui-serif, Georgia, serif !important;
            }
            /* Lock typography weights so they don't flip when Tailwind preflight is re-applied inside the iframe */
            h1, h2, h3, h4, h5, h6 { font-weight: 400 !important; }
            h1.cw-h1, .cw-h1 { font-weight: 400 !important; }
            .cw-card-h3 { font-weight: 600 !important; }
            .cw-card-h4 { font-weight: 600 !important; }
            .cw-card-name { font-weight: 600 !important; }
            .cw-brand { font-weight: 500 !important; }
            .cw-thin { font-weight: 300 !important; }
            ::selection { background:#ffffff; color:#000000; }

            .wheel-mask {
                -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 18%, black 82%, transparent 100%);
                mask-image: linear-gradient(to bottom, transparent 0%, black 18%, black 82%, transparent 100%);
            }
            .wheel-scroll {
                scroll-snap-type: y mandatory;
                scrollbar-width: none;
                -ms-overflow-style: none;
                overscroll-behavior: contain;
            }
            .wheel-scroll::-webkit-scrollbar { display: none; }
            .wheel-item {
                scroll-snap-align: center;
                scroll-snap-stop: always;
                transition: transform 320ms cubic-bezier(.2,.8,.2,1), opacity 320ms cubic-bezier(.2,.8,.2,1);
                will-change: transform, opacity;
            }

            .role-pill {
                transition: background-color 260ms ease, color 260ms ease, border-color 260ms ease, transform 260ms ease;
            }
            .role-pill.is-selected { }
            .role-label { color: #8a8a8a; transition: color 260ms ease; }
            .role-label .keyword {
                font-style: italic; font-weight: 700; color: #8a8a8a;
                transition: color 260ms ease;
            }
            .role-row.is-selected .role-label,
            .role-row.is-selected .role-label .keyword { color: #ffffff; }
            .role-row.is-expanded .role-label .keyword { color: #ffffff; }

            .role-pill.is-open-simple { background:#ffffff; color:#000000;  }
            .rich-card { background:#ffffff; color:#000000; border-radius:18px; }
            .rich-card .mini-card { border:1px solid rgba(0,0,0,.12); border-radius:12px; }
            /* Selected rich card caps at viewport height and scrolls internally */
            .rich-scroll {
                max-height: calc(100vh - 8rem);
                overflow-y: auto;
                overscroll-behavior: contain;
                scrollbar-width: thin;
                scrollbar-color: rgba(0,0,0,0.25) transparent;
            }
            .rich-scroll::-webkit-scrollbar { width: 6px; }
            .rich-scroll::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.2); border-radius: 3px; }

            /* Subtle grain overlay */
            .grain::before {
                content:''; position:fixed; inset:0; pointer-events:none;
                z-index:1; opacity:.035; mix-blend-mode:overlay;
                background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='160' height='160'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='2' stitchTiles='stitch'/></filter><rect width='100%25' height='100%25' filter='url(%23n)' opacity='0.9'/></svg>");
            }

            @keyframes fadeUp { from { opacity:0; transform: translateY(6px); } to { opacity:1; transform: translateY(0); } }
            .fade-up { animation: fadeUp 420ms cubic-bezier(.2,.8,.2,1) both; }

            .link-underline { position: relative; }
            .link-underline::after {
                content:''; position:absolute; left:0; right:100%; bottom:-2px; height:1px;
                background: currentColor; transition: right 320ms cubic-bezier(.2,.8,.2,1);
            }
            .link-underline:hover::after { right: 0; }

            .logo-mark { font-family: 'Instrument Serif', Georgia, serif; font-style: italic; letter-spacing: -0.02em; }

            /* Reset button defaults (Tailwind preflight may be disabled in iframe) */
            button {
                background: transparent;
                border: 0;
                padding: 0;
                margin: 0;
                color: inherit;
                font: inherit;
                cursor: pointer;
                -webkit-appearance: none;
                appearance: none;
            }
            [x-cloak] { display: none !important; }

            /* Hide the emergent posthog recorder-style overlay just in case */
            #root { display: contents; }
        </style>


    </head>
    <body class="grain min-h-screen">
        <noscript>You need to enable JavaScript to run this app.</noscript>
        <div
            x-data="conradWorks()"
            x-init="init()"
            x-cloak
            class="relative min-h-screen w-full"
        >
            <!-- Top-left brand -->
            <header
                class="pointer-events-none fixed left-0 top-0 z-20 flex w-full items-start justify-between px-6 py-6 md:px-10"
            >
                <a
                    href="#"
                    class="pointer-events-auto flex items-center gap-3"
                    data-testid="brand-logo"
                    @click.prevent="collapse()"
                >
                    <span class="flex h-9 w-9 items-center justify-center rounded-md border border-white/80 bg-white text-black">
                        <span class="logo-mark text-[15px] leading-none">CW</span>
                    </span>
                    <span class="cw-brand text-[17px] tracking-tight">
                        Conrad<span class="opacity-60">.</span>Works
                    </span>
                </a>

                <nav class="pointer-events-auto hidden items-center gap-6 text-xs text-white/50 md:flex">
                    <button type="button" class="link-underline hover:text-white" data-testid="nav-about" @click="scrollToKey('human')">about</button>
                    <button type="button" class="link-underline hover:text-white" data-testid="nav-work" @click="scrollToKey('entrepreneur')">work</button>
                    <button type="button" class="link-underline hover:text-white" data-testid="nav-words" @click="scrollToKey('writer')">words</button>
                </nav>
            </header>

            <!-- Main layout -->
            <main
                class="relative z-10 mx-auto grid min-h-screen w-full max-w-[1400px] grid-cols-1 gap-8 px-6 py-24 md:grid-cols-[minmax(0,1fr)_minmax(0,2.1fr)] md:gap-16 md:px-12 md:py-0"
            >
                <!-- Left: tagline -->
                <aside class="order-2 hidden items-center md:order-1 md:flex" aria-hidden="true">
                    <div class="max-w-sm pl-2">
                        <p class="cw-thin cw-serif text-[13px] italic tracking-wide text-white/40">— a portfolio of roles</p>
                        <h1 class="cw-h1 cw-serif mt-3 text-4xl leading-[1.05] tracking-tight sm:text-5xl">
                            I am many
                            <span class="italic" style="color: rgba(255,255,255,0.85)">things</span>,
                            <br />
                            all at once.
                        </h1>
                        <p class="cw-thin mt-4 max-w-[22rem] text-[13px] text-white/40">
                            Scroll the list. Tap a role to see what it means today.
                        </p>
                    </div>
                </aside>

                <!-- Right: wheel / expanded -->
                <section class="order-1 relative flex min-h-screen w-full items-center justify-center md:order-2">
                    <!-- Expanded panel -->
                    <template x-if="expandedIndex !== null">
                        <div
                            class="absolute inset-0 flex flex-col items-stretch justify-center gap-6 px-2 py-12 md:px-0"
                            data-testid="expanded-view"
                        >
                            <div class="role-row is-expanded grid grid-cols-1 items-start gap-2 md:grid-cols-[200px_minmax(0,1fr)] md:gap-6">
                                <div class="role-label pt-1 text-left cw-serif text-[13px] italic md:pt-6 md:text-right md:text-[15px]">
                                    <span>as </span><span x-text="expanded.article + ' '"></span><span class="keyword" x-text="expanded.label"></span>
                                </div>

                                <template x-if="expanded.type === 'simple'">
                                    <button
                                        type="button"
                                        class="role-pill is-open-simple fade-up w-full px-6 py-5 text-left text-[15px] rounded-lg"
                                        :data-testid="`role-open-${expanded.key}`"
                                        @click="collapse()"
                                    >
                                        <span x-text="expanded.content"></span>
                                    </button>
                                </template>

                                <template x-if="expanded.type === 'rich'">
                                    <div
                                        class="rich-card rich-scroll fade-up w-full cursor-pointer p-8"
                                        :data-testid="`role-open-${expanded.key}`"
                                        @click.self="collapse()"
                                    >
                                        <h3 class="cw-card-h3 text-[20px] tracking-tight">
                                            <span x-text="expanded.title"></span>
                                        </h3>
                                        <div class="mt-3 space-y-1 text-[13px] leading-relaxed text-black/70">
                                            <template x-for="p in expanded.description" :key="p">
                                                <p x-text="p"></p>
                                            </template>
                                        </div>

                                        <template x-for="(group, gi) in expanded.groups" :key="group.heading">
                                            <div :class="gi === 0 ? 'mt-8' : 'mt-10'">
                                                <h4 class="cw-card-h4 text-[14px]" x-text="group.heading"></h4>
                                                <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-5">
                                                    <template x-for="item in group.items" :key="item.name">
                                                        <a
                                                            :href="item.url"
                                                            target="_blank"
                                                            rel="noopener"
                                                            class="mini-card flex flex-col gap-3 p-4 transition hover:border-black/40"
                                                            @click.stop
                                                        >
                                                            <div class="cw-card-name text-[13px]" x-text="item.name"></div>
                                                            <p class="min-h-[7rem] text-[11px] leading-[1.5] text-black/70" x-text="item.desc"></p>
                                                            <div class="mt-auto text-right text-[10px] text-black/50" x-text="item.url.replace(/^https?:\/\//, '')"></div>
                                                        </a>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>

                                        <div class="mt-8 flex justify-end">
                                            <button
                                                type="button"
                                                class="cw-thin text-[11px] uppercase tracking-[0.2em] text-black/40 hover:text-black"
                                                data-testid="collapse-btn"
                                                @click.stop="collapse()"
                                            >close</button>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Faded hint under the selected role -->
                            <button
                                type="button"
                                class="cw-thin mt-6 self-center text-[10px] uppercase tracking-[0.3em] text-white/30 transition hover:text-white/70"
                                data-testid="esc-hint"
                                @click="collapse()"
                            >
                                esc to go back
                            </button>
                        </div>
                    </template>

                    <!-- Wheel -->
                    <div
                        x-show="expandedIndex === null"
                        x-transition.opacity
                        class="wheel-mask relative h-[85vh] w-full overflow-hidden"
                    >
                        <div
                            x-ref="wheel"
                            class="wheel-scroll h-full w-full overflow-y-auto"
                            @scroll.passive="onScroll()"
                            data-testid="wheel-container"
                        >
                            <div :style="`height: ${halfViewport}px`"></div>

                            <template x-for="(item, i) in loopedRoles" :key="i + '-' + item.key">
                                <div
                                    class="wheel-item flex items-center justify-center py-3"
                                    :style="itemStyle(i)"
                                    :data-index="i"
                                >
                                    <button
                                        type="button"
                                        class="role-row grid w-full grid-cols-[auto_minmax(0,1fr)] items-center gap-6 md:grid-cols-[200px_minmax(0,1fr)]"
                                        :class="{ 'is-selected': i === centerIndex }"
                                        :data-testid="`wheel-row-${item.key}-${i}`"
                                        @click="onRowClick(i)"
                                    >
                                        <div class="role-label text-left cw-serif text-[13px] italic md:text-right md:text-[15px]">
                                            <span>as </span><span x-text="item.article + ' '"></span><span class="keyword" x-text="item.label"></span>
                                        </div>
                                        <div class="role-pill px-2 py-2 text-left text-[14px] text-white/85 border border-gray-900 rounded-md"  :class="{ 'is-selected, border-white/40': i === centerIndex  }">
                                            <span class="opacity-70" x-text="item.preview"></span>
                                        </div>
                                    </button>
                                </div>
                            </template>

                            <div :style="`height: ${halfViewport}px`"></div>
                        </div>

                        <div class="pointer-events-none absolute bottom-6 left-1/2 -translate-x-1/2 text-[10px] uppercase tracking-[0.3em] text-white/30" data-testid="scroll-hint">
                            scroll · tap
                        </div>
                    </div>
                </section>
            </main>

            <footer class="pointer-events-none fixed bottom-0 left-0 z-20 flex w-full items-end justify-between px-6 pb-6 md:px-10">
                <div class="text-[10px] uppercase tracking-[0.25em] text-white/30">© Conrad.Works</div>
                <div class="text-[10px] uppercase tracking-[0.25em] text-white/30">ver. 1.0</div>
            </footer>
        </div>

        <!-- React root (intentionally empty; App.js renders null) -->
        <div id="root"></div>

        <script>
            function conradWorks() {
                const ROLES = [
                    { key: 'human', label: 'human', article: 'a', type: 'simple',
                      preview: 'Eating, sleeping, working out and everything else.',
                      content: 'Eating, sleeping, working out and everything else.' },
                    { key: 'father', label: 'father', article: 'a', type: 'simple',
                      preview: 'Being there for my daughter.',
                      content: 'Being there for my daughter.' },
                    { key: 'husband', label: 'husband', article: 'a', type: 'simple',
                      preview: 'Trying to be there for my wife whenever she needs me.',
                      content: 'Trying to be there for my wife whenever she needs me.' },
                    { key: 'consultant', label: 'consultant', article: 'a', type: 'simple',
                      preview: 'Helping first time entrepreneurs overcome their obstacles.',
                      content: 'Helping first time entrepreneurs overcome their obstacles.' },
                    { key: 'entrepreneur', label: 'entrepreneur', article: 'an', type: 'rich',
                      preview: 'Testing out ideas and seeing what sticks.',
                      title: 'Testing out ideas and seeing what sticks.',
                      description: [
                        'Occasionally, an idea hits me that seems like a fun weekend product that I end up giving it a try.',
                        'Also, I might accept a more hands on involvement in some early stage startups in exchange for equity (Currently, not open to this).'
                      ],
                      groups: [
                        { heading: 'Developing on my own', items: [
                          { name: 'plan.gifts',    desc: 'Gift analytics. I know, right? Everything you need to never forget again, to pick the right gift and to impress your friends and family with gifts for weird occasions.', url: 'https://plan.gifts' },
                          { name: 'notional.studio', desc: 'Gift analytics. I know, right? Everything you need to never forget again, to pick the right gift and to impress your friends and family with gifts for weird occasions.', url: 'https://plan.gifts' },
                          { name: 'well.ness.land',  desc: 'Gift analytics. I know, right? Everything you need to never forget again, to pick the right gift and to impress your friends and family with gifts for weird occasions.', url: 'https://plan.gifts' },
                          { name: 'valid.guide',     desc: 'Gift analytics. I know, right? Everything you need to never forget again, to pick the right gift and to impress your friends and family with gifts for weird occasions.', url: 'https://plan.gifts' },
                          { name: 'business.in',     desc: 'Gift analytics. I know, right? Everything you need to never forget again, to pick the right gift and to impress your friends and family with gifts for weird occasions.', url: 'https://plan.gifts' }
                        ]},
                        { heading: 'Investing in', items: [
                          { name: 'blckdsgn.com', desc: 'Gift analytics. I know, right? Everything you need to never forget again, to pick the right gift and to impress your friends and family with gifts for weird occasions.', url: 'https://plan.gifts' },
                          { name: 'urboly.com',   desc: 'Gift analytics. I know, right? Everything you need to never forget again, to pick the right gift and to impress your friends and family with gifts for weird occasions.', url: 'https://plan.gifts' },
                          { name: 'ordser.com',   desc: 'Gift analytics. I know, right? Everything you need to never forget again, to pick the right gift and to impress your friends and family with gifts for weird occasions.', url: 'https://plan.gifts' },
                          { name: 'teandle.com',  desc: 'Gift analytics. I know, right? Everything you need to never forget again, to pick the right gift and to impress your friends and family with gifts for weird occasions.', url: 'https://plan.gifts' },
                          { name: 'engeve.com',   desc: 'Gift analytics. I know, right? Everything you need to never forget again, to pick the right gift and to impress your friends and family with gifts for weird occasions.', url: 'https://plan.gifts' }
                        ]}
                      ]
                    },
                    { key: 'writer', label: 'writer', article: 'a', type: 'simple',
                      preview: 'Putting down ideas, analyses or simple crazy thoghts into words.',
                      content: 'Putting down ideas, analyses or simple crazy thoghts into words.' },
                    { key: 'trainer', label: 'trainer', article: 'a', type: 'simple',
                      preview: 'Helping first time entrepreneurs overcome their obstacles.',
                      content: 'Helping first time entrepreneurs overcome their obstacles.' },
                    { key: 'songwriter', label: 'songwriter', article: 'a', type: 'simple',
                      preview: 'This just started but I am loving it...',
                      content: 'This just started but I am loving it...' }
                ];

                const REPEATS = 7;

                return {
                    roles: ROLES,
                    loopedRoles: [],
                    centerIndex: 0,
                    expandedIndex: null,
                    halfViewport: 0,
                    itemHeight: 0,
                    _scrollAf: null,
                    _rebalanceLock: false,

                    get expanded() {
                        if (this.expandedIndex === null) return null;
                        return this.loopedRoles[this.expandedIndex];
                    },
                    get neighborsAbove() {
                        if (this.expandedIndex === null) return [];
                        const out = [];
                        for (let off = 2; off >= 1; off--) {
                            out.push(this.loopedRoles[this._wrap(this.expandedIndex - off)]);
                        }
                        return out;
                    },
                    get neighborsBelow() {
                        if (this.expandedIndex === null) return [];
                        const out = [];
                        for (let off = 1; off <= 1; off++) {
                            out.push(this.loopedRoles[this._wrap(this.expandedIndex + off)]);
                        }
                        return out;
                    },

                    init() {
                        if (this._inited) return;
                        this._inited = true;
                        this.loopedRoles = [];
                        for (let r = 0; r < REPEATS; r++) {
                            for (const role of ROLES) this.loopedRoles.push(role);
                        }
                        this.$nextTick(() => {
                            this._measure();
                            const middleCopy = Math.floor(REPEATS / 2);
                            const defaultLocalIdx = ROLES.findIndex(r => r.key === 'entrepreneur');
                            const startIndex = middleCopy * ROLES.length + defaultLocalIdx;
                            this._scrollToIndex(startIndex, false);
                            this.centerIndex = startIndex;
                        });
                        this._onResize = () => this._measure();
                        this._onKeyDown = (e) => {
                            if (this.expandedIndex !== null) {
                                if (e.key === 'Escape') this.collapse();
                                return;
                            }
                            if (e.key === 'ArrowDown') { e.preventDefault(); this._stepBy(1); }
                            else if (e.key === 'ArrowUp') { e.preventDefault(); this._stepBy(-1); }
                            else if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); this.expand(this.centerIndex); }
                        };
                        window.addEventListener('resize', this._onResize);
                        window.addEventListener('keydown', this._onKeyDown, { capture: true });
                    },

                    _stepBy(delta) {
                        // Guard against duplicate invocations within a single keystroke frame
                        const now = Date.now();
                        if (this._lastStepAt && now - this._lastStepAt < 120) return;
                        this._lastStepAt = now;

                        const next = this.centerIndex + delta;
                        this._programmaticLock = true;
                        this._scrollToIndex(next, true);
                        clearTimeout(this._progTimer);
                        this._progTimer = setTimeout(() => { this._programmaticLock = false; }, 450);
                    },

                    _measure() {
                        const wheel = this.$refs.wheel;
                        if (!wheel) return;
                        this.halfViewport = wheel.clientHeight / 2;
                        const first = wheel.querySelector('.wheel-item');
                        if (first) this.itemHeight = first.getBoundingClientRect().height;
                    },

                    _scrollToIndex(index, smooth) {
                        const wheel = this.$refs.wheel;
                        if (!wheel) return;
                        const items = wheel.querySelectorAll('.wheel-item');
                        const el = items[index];
                        if (!el) return;
                        const target = el.offsetTop - wheel.clientHeight / 2 + el.offsetHeight / 2;
                        // Temporarily disable scroll-snap so smooth scroll lands exactly on target
                        // without snap engine pulling to an adjacent item.
                        const prevSnap = wheel.style.scrollSnapType;
                        wheel.style.scrollSnapType = 'none';
                        wheel.scrollTo({ top: target, behavior: smooth ? 'smooth' : 'auto' });
                        this.centerIndex = index;
                        clearTimeout(this._snapRestoreTimer);
                        this._snapRestoreTimer = setTimeout(() => {
                            wheel.style.scrollSnapType = prevSnap || '';
                        }, smooth ? 500 : 60);
                    },

                    onScroll() {
                        if (this._programmaticLock) return; // ignore scroll while we're driving it
                        if (this._scrollAf) cancelAnimationFrame(this._scrollAf);
                        this._scrollAf = requestAnimationFrame(() => {
                            const wheel = this.$refs.wheel;
                            if (!wheel) return;
                            const items = wheel.querySelectorAll('.wheel-item');
                            const mid = wheel.scrollTop + wheel.clientHeight / 2;
                            let nearest = 0;
                            let best = Infinity;
                            items.forEach((el, i) => {
                                const c = el.offsetTop + el.offsetHeight / 2;
                                const d = Math.abs(c - mid);
                                if (d < best) { best = d; nearest = i; }
                            });
                            this.centerIndex = nearest;

                            if (!this._rebalanceLock) {
                                const cycle = this.roles.length;
                                if (nearest < cycle) {
                                    this._rebalanceLock = true;
                                    const newIdx = nearest + cycle * Math.floor(REPEATS / 2);
                                    this._scrollToIndex(newIdx, false);
                                    setTimeout(() => (this._rebalanceLock = false), 80);
                                } else if (nearest >= this.loopedRoles.length - cycle) {
                                    this._rebalanceLock = true;
                                    const newIdx = nearest - cycle * Math.floor(REPEATS / 2);
                                    this._scrollToIndex(newIdx, false);
                                    setTimeout(() => (this._rebalanceLock = false), 80);
                                }
                            }
                        });
                    },

                    itemStyle(i) {
                        const dist = Math.abs(i - this.centerIndex);
                        const scale = Math.max(0.78, 1 - dist * 0.06);
                        const opacity = Math.max(0.25, 1 - dist * 0.18);
                        return `transform: scale(${scale}); opacity: ${opacity};`;
                    },

                    onRowClick(i) {
                        if (i === this.centerIndex) this.expand(i);
                        else this._scrollToIndex(i, true);
                    },

                    expand(i) { this.expandedIndex = i; },

                    collapse() {
                        if (this.expandedIndex === null) return;
                        const prev = this.expandedIndex;
                        this.expandedIndex = null;
                        this.$nextTick(() => {
                            this._measure();
                            this._scrollToIndex(prev, false);
                        });
                    },

                    _wrap(i) {
                        const n = this.loopedRoles.length;
                        return ((i % n) + n) % n;
                    },

                    getGlobalIndex(key) {
                        const base = this.expandedIndex !== null ? this.expandedIndex : this.centerIndex;
                        let best = -1; let bestD = Infinity;
                        this.loopedRoles.forEach((r, i) => {
                            if (r.key !== key) return;
                            const d = Math.abs(i - base);
                            if (d < bestD) { bestD = d; best = i; }
                        });
                        return best;
                    },

                    scrollToKey(key) {
                        const idx = this.getGlobalIndex(key);
                        if (idx < 0) return;
                        if (this.expandedIndex !== null) this.expandedIndex = idx;
                        else this._scrollToIndex(idx, true);
                    }
                };
            }
        </script>
    </body>
</html>
