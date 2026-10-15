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
        <title>Conrad.Works - a portfolio of roles</title>

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
                height: 100vh;
                height: 100svh;
                overflow: hidden;
                overscroll-behavior: none;
                background: #000000 !important;
                color: #ffffff !important;
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif !important;
                -webkit-font-smoothing: antialiased;
                text-rendering: optimizeLegibility;
            }
            .cw-serif {
                font-family: 'Instrument Serif', ui-serif, Georgia, serif !important;
            }
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
                /* Keep native touch and trackpad scrolling fluid across multiple roles. */
                scroll-snap-type: none;
                scrollbar-width: none;
                -ms-overflow-style: none;
                overscroll-behavior: contain;
                -webkit-overflow-scrolling: touch;
            }
            .wheel-scroll::-webkit-scrollbar { display: none; }
            .wheel-item {
                transition: transform 320ms cubic-bezier(.2,.8,.2,1), opacity 320ms cubic-bezier(.2,.8,.2,1);
                will-change: transform, opacity;
            }

            .role-pill {
                transition: background-color 2600ms ease, color 260ms ease, border-color 260ms ease, transform 260ms ease;
            }
            .role-pill.is-selected { }
            .role-label { color: #8a8a8a; transition: color 2600ms ease; }
            .role-label .keyword {
                font-style: italic; font-weight: 700; color: #8a8a8a;
                transition: color 260ms ease;
            }
            .role-row.is-selected .role-label,
            .role-row.is-selected .role-label .keyword { color: #ffffff; }
            .role-row.is-expanded .role-label .keyword { color: #ffffff; }

            .role-pill.is-open-simple { background:#ffffff; color:#000000; }
            .rich-card { background:#ffffff; color:#000000; border-radius:18px; }
            .rich-card .mini-card { border:1px solid rgba(0,0,0,.12); border-radius:12px; }
            .rich-scroll {
                max-height: calc(100vh - 12rem);
                max-height: calc(100svh - 12rem);
                min-height: 0;
                overflow-y: auto;
                overscroll-behavior: contain;
                scrollbar-width: thin;
                scrollbar-color: rgba(0,0,0,0.25) transparent;
            }
            @media (max-width: 767px) {
                .rich-scroll {
                    max-height: none;
                    height: 100%;
                }
                .expanded-role-row {
                    height: 100%;
                    align-content: stretch;
                }
                .expanded-role-row .rich-scroll {
                    min-height: 0;
                    height: 100%;
                    max-height: none;
                }
            }
            .rich-scroll::-webkit-scrollbar { width: 6px; }
            .rich-scroll::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.2); border-radius: 3px; }

            /* Subtle grain overlay */
            .grain::before {
                content:''; position:fixed; inset:0; pointer-events:none;
                z-index:1; opacity:.035; mix-blend-mode:overlay;
                background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='160' height='160'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='2' stitchTiles='stitch'/></filter><rect width='100%25' height='100%25' filter='url(%23n)' opacity='0.9'/></svg>");
            }

            /* ── Intro reveal and continuous headline handoff ── */
            @keyframes introReveal {
                from { opacity: 0; filter: blur(5px); }
                to   { opacity: 1; filter: blur(0); }
            }
            @keyframes introRoleReveal {
                from { opacity: 0; translate: 0 -24px; filter: blur(4px); }
                to   { opacity: var(--role-opacity); translate: 0 0; filter: blur(0); }
            }
            .intro-reveal { animation: introReveal 850ms cubic-bezier(.2,.8,.2,1) both; }
            .intro-stage { background-color: #000; transition: background-color 1050ms cubic-bezier(.22,1,.36,1); }
            .intro-stage.is-transitioning { background-color: transparent; }
            .intro-headline { position: fixed; margin: 0; white-space: nowrap; transform-origin: top left; will-change: font-size, line-height; }
            .intro-target { opacity: 0; transition: opacity 1ms linear; }
            .intro-target.is-ready { opacity: 1; }
            .intro-delayed-elements {
                opacity: 0;
                visibility: hidden;
                transition: opacity 900ms cubic-bezier(.16,1,.3,1), visibility 0s linear 900ms;
            }
            .intro-delayed-elements.is-visible {
                opacity: 1;
                visibility: visible;
                transition: opacity 900ms cubic-bezier(.16,1,.3,1), visibility 0s;
            }
            .intro-role-reveal { animation: introRoleReveal 720ms cubic-bezier(.22,1,.36,1) both; animation-delay: var(--intro-delay, 0ms); }
            @media (prefers-reduced-motion: reduce) {
                .intro-reveal { animation-duration: 1ms; }
                .intro-stage { transition-duration: 1ms; }
                .intro-delayed-elements, .intro-delayed-elements.is-visible { transition: opacity 1ms linear, visibility 0s; }
                .intro-role-reveal { translate: none; }
                .intro-role-reveal { animation-duration: 1ms; animation-delay: 0ms; }
            }

            /* ── Expand / collapse animations ── */
            @keyframes expandDown {
                from { opacity:1; clip-path: inset(50% 0 50% 0); }
                to   { opacity:1; clip-path: inset(0% 0 0% 0); }
            }
            @keyframes collapseUp {
                from { opacity:1; clip-path: inset(0% 0 0% 0); }
                to   { opacity:0; clip-path: inset(50% 0 50% 0); }
            }
            .fade-up {
                animation: expandDown 780ms cubic-bezier(.2,.08,.2,1) both;
            }
            .fade-down {
                animation: collapseUp 360ms cubic-bezier(.4,0,.2,1) both;
                pointer-events: none;
            }

            

            .link-underline { position: relative; }
            .link-underline::after {
                content:''; position:absolute; left:0; right:100%; bottom:-2px; height:1px;
                background: currentColor; transition: right 320ms cubic-bezier(.2,.8,.2,1);
            }
            .link-underline:hover::after { right: 0; }

            .logo-mark { font-family: 'Instrument Serif', Georgia, serif; font-style: italic; letter-spacing: -0.02em; }
            .brand-path-enter { animation: brandPathReveal 480ms cubic-bezier(.2,.8,.2,1) both; }
            .brand-path-leave { animation: brandPathConceal 320ms cubic-bezier(.4,0,.2,1) both; }
            @keyframes brandPathReveal {
                from { opacity: 0; transform: translateY(-5px); filter: blur(3px); }
                to { opacity: 1; transform: translateY(0); filter: blur(0); }
            }
            @keyframes brandPathConceal {
                from { opacity: 0; transform: translateY(4px); filter: blur(2px); }
                to { opacity: 1; transform: translateY(0); filter: blur(0); }
            }
            @media (prefers-reduced-motion: reduce) {
                .brand-path-enter, .brand-path-leave { animation-duration: 1ms; }
            }

            button {
                background: transparent;
                padding: 0;
                margin: 0;
                color: inherit;
                font: inherit;
                cursor: pointer;
                -webkit-appearance: none;
                appearance: none;
            }
            [x-cloak] { display: none !important; }
            #root { display: contents; }
        </style>
    </head>
    <body class="grain h-[100vh] h-[100svh] overflow-hidden">
        <noscript>You need to enable JavaScript to run this app.</noscript>
        <div
            x-data="conradWorks()"
            x-init="init()"
            x-cloak
            class="relative h-[100vh] h-[100svh] w-full overflow-hidden"
        >
            <!-- Top-left brand -->
            <header
                class="intro-delayed-elements pointer-events-none fixed left-0 top-0 z-20 flex w-full items-start justify-center px-6 pt-6 md:justify-between md:px-10 md:py-6"
                :class="pageElementsVisible ? 'is-visible' : ''"
            >
                <a
                    href="#"
                    class="pointer-events-auto flex flex-col items-center gap-2 text-center md:flex-row md:gap-3"
                    data-testid="brand-logo"
                    @click.prevent="collapse()"
                >
                   <svg width="45" height="45" viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;">
                        <g>
                            <g transform="matrix(0.680357,-0.34132,0.404473,0.806241,-727.779,192.481)">
                                <path d="M1076.83,517.907L1076.83,667.523L1065.54,677.192L1065.54,513.125L1076.83,517.907Z" style="fill:white;stroke:white;stroke-width:1.2px;"/>
                            </g>
                            <g transform="matrix(-0.663036,-0.343896,-0.308092,0.594006,1186.21,338.913)">
                                <path d="M1076.83,510.624L1076.83,666.9L1065.54,677.192L1065.54,507.878L1076.83,510.624Z" style="fill:white;stroke:white;stroke-width:1.41px;"/>
                            </g>
                            <g transform="matrix(0.680357,-0.34132,0.726173,1.44749,-827.866,-241.769)">
                                <path d="M1076.83,515.787L1076.83,667.523L1065.54,677.192L1065.54,513.125L1076.83,515.787Z" style="fill:white;stroke:white;stroke-width:0.79px;"/>
                            </g>
                            <g transform="matrix(0.681241,-0.341763,0.591127,1.1783,-737.361,-103.223)">
                                <path d="M1076.83,516.4L1076.83,665.689L1065.54,677.192L1065.54,513.125L1076.83,516.4Z" style="fill:white;stroke:white;stroke-width:0.93px;"/>
                            </g>
                            <g transform="matrix(-0.675694,-0.350461,-0.234158,0.451459,1230.51,284.173)">
                                <path d="M1076.83,510.624L1076.83,665.689L1065.54,677.192L1065.54,501.802L1076.83,510.624Z" style="fill:white;stroke:white;stroke-width:1.54px;"/>
                            </g>
                            <g transform="matrix(-0.675694,-0.350461,-0.232641,0.448534,1148.79,396.459)">
                                <path d="M1076.83,510.624L1076.83,665.689L1065.54,677.192L1065.54,518.637L1076.83,510.624Z" style="fill:white;stroke:white;stroke-width:1.55px;"/>
                            </g>
                            <g transform="matrix(-0.675694,-0.350461,-0.15709,0.302871,1167.04,360.019)">
                                <path d="M1076.83,510.624L1076.83,665.689L1065.54,677.192L1065.54,497.559L1076.83,510.624Z" style="fill:white;stroke:white;stroke-width:1.7px;"/>
                            </g>
                            <g transform="matrix(-0.675694,-0.350461,-0.46822,0.902733,1444.8,53.7153)">
                                <path d="M1076.83,510.624L1076.83,665.689L1065.54,677.192L1065.54,506.241L1076.83,510.624Z" style="fill:white;stroke:white;stroke-width:1.11px;"/>
                            </g>
                            <g transform="matrix(-0.663036,-0.343896,-0.727389,1.40241,1587.92,-208.535)">
                                <path d="M1076.83,510.624L1076.83,666.9L1065.54,677.192L1065.54,507.878L1076.83,510.624Z" style="fill:white;stroke:white;stroke-width:0.81px;"/>
                            </g>
                            <g transform="matrix(0.911944,0,0,0.911944,-847.644,-234.139)">
                                <path d="M1168.42,465.845L1141.24,483.758C1123.17,456.34 1092.54,439.839 1059.7,439.839C1005.8,439.839 962.044,483.597 962.044,537.495C962.044,591.394 1005.8,635.152 1059.7,635.152C1090.25,635.152 1119.04,620.856 1137.5,596.516L1163.44,616.19C1138.82,648.642 1100.43,667.704 1059.7,667.704C987.836,667.704 929.492,609.36 929.492,537.495C929.492,465.631 987.836,407.287 1059.7,407.287C1103.48,407.287 1144.33,429.289 1168.42,465.845Z" style="fill-opacity:0;"/>
                                <path d="M1168.42,465.845L1141.24,483.758C1123.17,456.34 1092.54,439.839 1059.7,439.839C1005.8,439.839 962.044,483.597 962.044,537.495C962.044,591.394 1005.8,635.152 1059.7,635.152C1090.25,635.152 1119.04,620.856 1137.5,596.516L1163.44,616.19C1138.82,648.642 1100.43,667.704 1059.7,667.704C987.836,667.704 929.492,609.36 929.492,537.495C929.492,465.631 987.836,407.287 1059.7,407.287C1103.48,407.287 1144.33,429.289 1168.42,465.845ZM1156.01,463.522C1133.13,433.73 1097.59,416.059 1059.7,416.059C992.678,416.059 938.264,470.473 938.264,537.495C938.264,604.518 992.678,658.932 1059.7,658.932C1094.75,658.932 1127.94,643.798 1150.89,617.686L1138.9,608.589C1118.81,630.975 1090.05,643.924 1059.7,643.924C1000.96,643.924 953.271,596.235 953.271,537.495C953.271,478.756 1000.96,431.067 1059.7,431.067C1092.54,431.067 1123.37,446.214 1143.44,471.804L1156.01,463.522Z" style="fill:white;"/>
                            </g>
                        </g>
                    </svg>

                    <span class="flex items-baseline gap-0 text-[17px] tracking-tight whitespace-nowrap">
                        <span class="cw-brand">Conrad<span class="opacity-60">.</span>Works</span><span
                            x-show="expandedKey !== null"
                            x-cloak
                            :key="brandPathKey"
                            :class="brandPathAnimating ? 'brand-path-enter' : ''"
                            class="text-[17px] leading-none tracking-tight md:hidden"
                            data-testid="mobile-brand-path"
                            aria-live="polite"
                        ><span class="text-white/35">/as/</span><span class="text-white/35" x-text="brandPathArticle + '/'"></span><span class="cw-serif italic text-white" x-text="brandPathRole"></span></span>
                    </span>
                </a>

                <nav class="pointer-events-auto hidden items-center gap-6 text-xs text-white/50 md:flex">
                    <button type="button" class="link-underline hover:text-white" data-testid="nav-about" @click="scrollToKey('human')">about</button>
                    <button type="button" class="link-underline hover:text-white" data-testid="nav-words" @click="scrollToKey('writer')">words</button>
                    <button type="button" class="link-underline hover:text-white" data-testid="nav-work" @click="scrollToKey('entrepreneur')">work</button>
                    <button type="button" class="link-underline hover:text-white" data-testid="nav-contact" @click="scrollToKey('consultant')">contact</button>
                </nav>
            </header>

            <!-- Intro tagline: roles are revealed after the opening statement. -->
            <div
                x-show="introVisible"
                :class="['intro-reveal', 'intro-stage', introTransitioning ? 'is-transitioning' : '']"
                class="pointer-events-none fixed inset-0 z-[15] flex items-center justify-center bg-black px-8 text-center"
                data-testid="intro-reveal"
                aria-hidden="true"
            >
                <h1 x-ref="introHeadline" class="intro-headline cw-h1 cw-serif max-w-3xl text-5xl leading-[0.98] tracking-tight sm:text-6xl md:text-7xl">
                    I am many <span class="italic" style="color: rgba(255,255,255,0.85)">things</span>,<br />
                    <span>all at once.</span>
                </h1>
            </div>

            <!-- Main layout -->
            <main
                class="intro-delayed-elements relative z-10 mx-auto grid h-[100vh] h-[100svh] w-full max-w-[1400px] grid-cols-1 gap-8 overflow-hidden px-6 pt-24 pb-20 md:grid-cols-[minmax(0,1fr)_minmax(0,2.1fr)] md:gap-16 md:px-12 md:py-0"
                :class="pageElementsVisible ? 'is-visible' : ''"
            >
                <!-- Left: tagline -->
                <aside class="order-2 hidden items-center md:order-1 md:flex" aria-hidden="true">
                    <div class="max-w-sm pl-2">
                        <p class="cw-thin cw-serif text-[13px] italic tracking-wide text-white/40">— a portfolio of roles</p>
                        <h1 x-ref="desktopIntroTarget" :class="introComplete ? 'intro-target is-ready' : 'intro-target'" class="cw-h1 cw-serif mt-3 text-4xl leading-[1.05] tracking-tight sm:text-5xl" data-testid="desktop-intro-target">
                            I am many
                            <span class="italic" style="color: rgba(255,255,255,0.85)">things</span>,
                            <br />
                            all at once.
                        </h1>
                        <p class="cw-thin mt-4 max-w-[22rem] text-[13px] text-white/40">
                            Scroll the list. Tap a role to see what it means today. <br/>Bare in mind that this is still a work in progress though.
                        </p>
                    </div>
                </aside>

                <!-- Right: wheel / expanded -->
                <section class="order-1 relative flex h-full min-h-0 w-full flex-col items-center justify-start pt-2 md:order-2 md:justify-center md:pt-0">
                    <h1 x-ref="mobileIntroTarget" :class="introComplete ? 'intro-target is-ready' : 'intro-target'" class="cw-h1 cw-serif relative top-8 mb-3 w-full whitespace-nowrap text-center text-[25px] leading-tight tracking-tight md:hidden" data-testid="mobile-intro-target">
                        I am many <span class="italic" style="color: rgba(255,255,255,0.85)">things</span>, all at once.
                    </h1>

                    <!-- Expanded panel: Alpine only controls which server-rendered panel is visible. -->
                    <div
                        x-show="expandedKey !== null"
                        :class="isCollapsing ? 'fade-down' : 'fade-up'"
                        class="absolute inset-0 flex min-h-0 flex-col items-stretch justify-center gap-6 overflow-hidden px-2 py-4 md:px-0 md:py-12"
                        data-testid="expanded-view"
                        style="display:none"
                    >
                        @foreach($roles as $role)
                            <div
                                x-show="expandedKey === @js($role['key'])"
                                class="role-row is-expanded expanded-role-row grid min-h-0 grid-cols-1 content-center gap-2 md:grid-cols-[200px_minmax(0,1fr)] md:gap-6"
                            >
                                <div class="role-label hidden pt-1 text-left cw-serif text-[13px] italic md:block md:pt-6 md:text-right md:text-[25px]">
                                    <span>as {{ $role['article'] }} </span><span class="keyword">{{ $role['label'] }}</span>
                                </div>

                                @if($role['type'] === 'simple')
                                    <button type="button" class="role-pill is-open-simple w-full rounded-lg px-6 py-5 text-left text-[15px]" data-testid="role-open-{{ $role['key'] }}" @click="collapse()">
                                        {{ $role['content'] }}
                                    </button>
                                @else
                                    <div class="rich-card rich-scroll w-full cursor-pointer p-8 md:h-auto" data-testid="role-open-{{ $role['key'] }}" @click.self="collapse()">
                                        <h3 class="cw-card-h3 text-[20px] tracking-tight">{{ $role['title'] }}</h3>
                                        @if(count($role['description']))
                                            <div class="mt-3 space-y-1 text-[13px] leading-relaxed text-black/70">
                                                @foreach($role['description'] as $paragraph)<p>{{ $paragraph }}</p>@endforeach
                                            </div>
                                        @endif
                                        @foreach($role['groups'] as $group)
                                            <div class="{{ $loop->first ? 'mt-8' : 'mt-10' }}">
                                                @include('welcome.templates.' . $group['template'], ['group' => $group])
                                            </div>
                                        @endforeach
                                        <div class="mt-8 flex justify-end">
                                            <button type="button" class="cw-thin text-[11px] uppercase tracking-[0.2em] text-black/40 hover:text-black" data-testid="collapse-btn" @click.stop="collapse()">close</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        <button type="button" class="cw-thin mt-3 self-center text-[10px] uppercase tracking-[0.3em] text-white/30 transition hover:text-white/70" data-testid="esc-hint" @click="collapse()">back to all roles</button>
                    </div>

                    <!-- Wheel -->
                    <div
                        x-show="pageElementsVisible && introComplete && expandedIndex === null && !isCollapsing"
                        x-transition.opacity
                        class="wheel-mask relative min-h-0 w-full flex-1 overflow-hidden md:h-full md:flex-none"
                        @after-enter="revealRoles()"
                    >
                        <div
                            x-ref="wheel"
                            class="wheel-scroll h-full min-h-0 w-full overflow-y-auto"
                            @scroll.passive="onScroll()"
                            data-testid="wheel-container"
                        >
                            <div :style="`height: ${halfViewport}px`"></div>

                            <template x-for="(item, i) in loopedRoles" :key="i + '-' + item.key">
                                <div
                                    class="wheel-item flex items-center justify-center py-3"
                                    :class="roleRevealActive ? 'intro-role-reveal' : ''"
                                    :style="itemStyle(i)"
                                    :data-index="i"
                                >
                                    <button
                                        type="button"
                                        class="role-row grid w-full nogrid-cols-[auto_minmax(0,1fr)] items-center gap sm:gap-6 grid-cols-1 md:grid-cols-[200px_minmax(0,1fr)] border p-2 border-gray-800 rounded-md sm:border-0"
                                        :class="{ 'is-selected border-white/20': i === centerIndex }"
                                        :data-testid="`wheel-row-${item.key}-${i}`"
                                        @click="onRowClick(i)"
                                    >
                                        <div class="role-label text-left cw-serif text-[14px] italic md:text-right md:text-[15px]">
                                            <span>as </span><span x-text="item.article + ' '"></span><span class="keyword" x-text="item.label"></span>
                                        </div>
                                        <div class="role-pill sm:px-2 sm:py-2 py-0 text-left text-[12px] text-white/65 sm:border border-gray-900 rounded-md" :class="{ 'is-selected border-white/40': i === centerIndex }">
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

            <footer
                class="intro-delayed-elements pointer-events-none fixed bottom-0 left-0 z-20 flex w-full items-end justify-between px-6 pb-6 md:px-10"
                :class="pageElementsVisible ? 'is-visible' : ''"
            >
                <div class="text-[10px] uppercase tracking-[0.25em] text-white/30">© Conrad.Works</div>
                <div class="text-[10px] uppercase tracking-[0.25em] text-white/30">ver. 1.0</div>
            </footer>
        </div>

        <!-- React root (intentionally empty; App.js renders null) -->
        <div id="root"></div>

        <script>
            // Expose the component explicitly on window so Alpine can resolve it reliably
            // regardless of script/module scope or browser execution context.
            window.conradWorks = function conradWorks() {
                const ROLES = @json($roles);

                const REPEATS = 7;

                return {
                    roles: ROLES,
                    loopedRoles: [],
                    centerIndex: 0,
                    expandedIndex: null,
                    expandedKey: null,
                    brandPathArticle: '',
                    brandPathRole: '',
                    brandPathKey: 0,
                    brandPathAnimating: false,
                    _brandPathTimer: null,
                    isCollapsing: false,
                    introVisible: true,
                    introTransitioning: false,
                    introComplete: false,
                    pageElementsVisible: false,
                    roleRevealActive: false,
                    _roleRevealPlayed: false,
                    _introTimer: null,
                    _roleRevealTimer: null,
                    _introAnimation: null,
                    halfViewport: 0,
                    itemHeight: 0,
                    _scrollAf: null,
                    _rebalanceLock: false,

                    init() {
                        if (this._inited) return;
                        this._inited = true;
                        this.loopedRoles = [];
                        for (let r = 0; r < REPEATS; r++) {
                            for (const role of ROLES) this.loopedRoles.push(role);
                        }
                        const middleCopy = Math.floor(REPEATS / 2);
                        const defaultLocalIdx = ROLES.findIndex(r => r.key === 'entrepreneur');
                        this._introStartIndex = middleCopy * ROLES.length + Math.max(0, defaultLocalIdx);
                        this.centerIndex = this._introStartIndex;
                        this._onResize = () => this._measure();
                        this._onKeyDown = (e) => {
                            if (this.expandedKey !== null) {
                                if (e.key === 'Escape') this.collapse();
                                return;
                            }
                            if (e.key === 'ArrowDown') { e.preventDefault(); this._stepBy(1); }
                            else if (e.key === 'ArrowUp') { e.preventDefault(); this._stepBy(-1); }
                            else if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); this.expand(this.centerIndex); }
                        };
                        window.addEventListener('resize', this._onResize);
                        window.addEventListener('keydown', this._onKeyDown, { capture: true });

                        this.$nextTick(() => requestAnimationFrame(() => this._positionIntroHeadline()));

                        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                        this._introTimer = setTimeout(() => this._transitionIntro(reducedMotion), reducedMotion ? 350 : 1250);
                    },

                    _positionIntroHeadline() {
                        const headline = this.$refs.introHeadline;
                        const target = window.matchMedia('(min-width: 768px)').matches
                            ? this.$refs.desktopIntroTarget
                            : this.$refs.mobileIntroTarget;

                        if (!headline || !target) return;

                        const rect = target.getBoundingClientRect();
                        const targetStyle = getComputedStyle(target);
                        const isMobile = !window.matchMedia('(min-width: 768px)').matches;
                        Object.assign(headline.style, {
                            position: 'fixed',
                            left: `${isMobile ? rect.left + rect.width / 2 : rect.left}px`,
                            top: `${rect.top}px`,
                            width: 'max-content',
                            maxWidth: 'none',
                            margin: '0',
                            textAlign: targetStyle.textAlign,
                            transform: isMobile ? 'translateX(-50%)' : 'none',
                        });
                    },

                    _transitionIntro(reducedMotion) {
                        if (this.introTransitioning || this.introComplete) return;
                        this.introTransitioning = true;

                        this.$nextTick(() => {
                            this._measure();
                            this._scrollToIndex(this._introStartIndex, false);

                            requestAnimationFrame(() => {
                                const headline = this.$refs.introHeadline;
                                const target = window.matchMedia('(min-width: 768px)').matches
                                    ? this.$refs.desktopIntroTarget
                                    : this.$refs.mobileIntroTarget;

                                if (!headline || !target) {
                                    this._finishIntro();
                                    return;
                                }

                                // Keep the headline anchored to its final location from the start.
                                // Only its type size (and matching line-height) changes.
                                this._positionIntroHeadline();
                                const startStyle = getComputedStyle(headline);
                                const targetStyle = getComputedStyle(target);
                                const startFontSize = parseFloat(startStyle.fontSize) || 72;
                                const targetFontSize = parseFloat(targetStyle.fontSize) || 32;
                                const startLineHeight = parseFloat(startStyle.lineHeight) || startFontSize;
                                const targetLineHeight = parseFloat(targetStyle.lineHeight) || targetFontSize;
                                const duration = reducedMotion ? 1 : 950;

                                if (typeof headline.animate !== 'function') {
                                    this._finishIntro();
                                    return;
                                }

                                this._introAnimation = headline.animate([
                                    { fontSize: `${startFontSize}px`, lineHeight: `${startLineHeight}px` },
                                    { fontSize: `${targetFontSize}px`, lineHeight: `${targetLineHeight}px` },
                                ], {
                                    duration,
                                    easing: 'cubic-bezier(.4,0,.2,1)',
                                    fill: 'forwards',
                                });

                                this._introAnimation.onfinish = () => this._finishIntro();
                                this._introAnimation.oncancel = () => this._finishIntro();
                            });
                        });
                    },

                    revealRoles() {
                        if (this._roleRevealPlayed) return;
                        this._roleRevealPlayed = true;
                        this.roleRevealActive = true;
                        clearTimeout(this._roleRevealTimer);
                        // Let the stagger finish, then restore the wheel's live transforms.
                        this._roleRevealTimer = setTimeout(() => {
                            this.roleRevealActive = false;
                        }, 1050);
                    },

                    _finishIntro() {
                        if (this.introComplete) return;
                        this.introComplete = true;
                        this.introTransitioning = false;
                        this._introAnimation = null;
                        clearTimeout(this._elementsRevealTimer);
                        this._elementsRevealTimer = setTimeout(() => {
                            this.pageElementsVisible = true;
                            this.introVisible = false;
                        }, 2000);
                        this.$nextTick(() => this._measure());
                    },

                    _stepBy(delta) {
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
                        if (this._programmaticLock) return;
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
                        const introDelay = Math.min(dist, 6) * 55;
                        return `transform: scale(${scale}); opacity: ${opacity}; --role-scale: ${scale}; --role-opacity: ${opacity}; --intro-delay: ${introDelay}ms;`;
                    },

                    onRowClick(i) {
                        if (i === this.centerIndex) this.expand(i);
                        else this._scrollToIndex(i, true);
                    },

                    expand(i) {
                        const role = this.loopedRoles[i];
                        if (!role) return;
                        this.isCollapsing = false;
                        this.expandedIndex = i;
                        this.expandedKey = role.key;
                        this.brandPathArticle = role.article;
                        this.brandPathRole = role.label;
                        this.brandPathKey++;
                        this.brandPathAnimating = true;
                        clearTimeout(this._brandPathTimer);
                        this._brandPathTimer = setTimeout(() => {
                            this.brandPathAnimating = false;
                        }, 500);
                    },

                    collapse() {
                        if (this.expandedKey === null) return;
                        const prev = this.expandedIndex;
                        this.isCollapsing = true;
                        setTimeout(() => {
                            this.expandedKey = null;
                            this.expandedIndex = null;
                            this.brandPathArticle = '';
                            this.brandPathRole = '';
                            this.brandPathKey++;
                            this.brandPathAnimating = true;
                            clearTimeout(this._brandPathTimer);
                            this._brandPathTimer = setTimeout(() => {
                                this.brandPathAnimating = false;
                            }, 350);
                            this.isCollapsing = false;
                            this.$nextTick(() => {
                                this._measure();
                                this._scrollToIndex(prev, false);
                            });
                        }, 370);
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
                        this.expand(idx);
                    }
                };
            }
        </script>
    </body>
</html>