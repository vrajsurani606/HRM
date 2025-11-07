<!-- resources/views/welcome.blade.php -->
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>HRPortal — Modern HR for People-First Companies</title>

  <!-- Tailwind (CDN for demo; for production compile with PostCSS) -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <!-- Swiper -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

  <style>
    /* Extra custom styles for soft lights and subtle glass */
    :root{
      --accent: #2563eb; /* indigo-600 */
      --soft-1: #eef2ff; /* very soft background */
      --glass: rgba(255,255,255,0.72);
    }
    /* utility to use the custom soft background across the site */
    .bg-soft-1 { background-color: var(--soft-1); }
    /* prevent background scroll when mobile menu is open */
    .no-scroll { overflow: hidden; height: 100vh; }
    .glass {
      background: linear-gradient(180deg, rgba(255,255,255,0.85), rgba(255,255,255,0.65));
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
    }
    /* subtle gradient blob */
    .blob {
      position: absolute;
      filter: blur(64px);
      opacity: .55;
      transform: translate(-50%, -50%);
      z-index: -1;
    }
    /* animated icon hover */
    .feature-card:hover .feature-icon { transform: translateY(-6px) scale(1.04); }
    .feature-icon { transition: transform 320ms cubic-bezier(.16,.84,.2,1); }
    /* pricing accent */
    .popular-badge { background: linear-gradient(90deg,#34d399,#60a5fa); color: white; }
    /* minimal focus outline */
    .focus-ring:focus { outline: 2px solid rgba(37,99,235,0.18); outline-offset: 3px; }
    /* Responsive Lottie container */
    #lottieHero { width: 100%; max-width: 640px; aspect-ratio: 16/10; height: auto; }
  </style>
</head>
<body class="antialiased text-slate-800 bg-soft-1">

  <!-- TOP NAVBAR -->
  <header class="fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
      <a href="#" class="flex items-center gap-3">
        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow">
          <!-- logo svg -->
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" class="text-indigo-600">
            <rect x="2" y="2" width="20" height="20" rx="5" fill="#eef2ff"></rect>
            <path d="M7 12h10M7 8h10M7 16h6" stroke="#2563eb" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <span class="text-lg font-semibold">HRPortal</span>
      </a>

      <nav class="hidden md:flex items-center gap-8 text-sm text-slate-700">
        <a href="#features" class="hover:text-indigo-600">Features</a>
        <a href="#integrations" class="hover:text-indigo-600">Integrations</a>
        <a href="#pricing" class="hover:text-indigo-600">Pricing</a>
        <a href="#resources" class="hover:text-indigo-600">Resources</a>
        <a href="#contact" class="hover:text-indigo-600">Contact</a>
      </nav>

     <div class="flex items-center gap-3">
    <!-- Login Button -->
    <a href="{{ route('login') }}"
       class="text-sm px-4 py-2 rounded-lg border border-slate-200 hover:bg-white focus-ring">
       Login
    </a>

    <!-- Signup Button -->
    <a href="{{ route('register') }}"
       class="hidden md:inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700 transition">
       Start free
    </a>

    <!-- Mobile Menu Button -->
    <button id="mobileBtn" class="md:hidden ml-2 p-2 rounded-md focus-ring bg-white shadow" aria-controls="mobileNav" aria-expanded="false">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
            <path d="M4 7h16M4 12h16M4 17h16"
                  stroke="#0f172a" stroke-width="1.6" stroke-linecap="round"/>
        </svg>
    </button>
</div>

    </div>

    <!-- mobile nav -->
    <div id="mobileNav" class="hidden md:hidden fixed inset-x-0 top-16 z-40 bg-white/95 border-t border-slate-100 shadow">
      <div class="px-6 py-4 flex flex-col gap-1">
        <a href="#features" class="py-2">Features</a>
        <a href="#integrations" class="py-2">Integrations</a>
        <a href="#pricing" class="py-2">Pricing</a>
        <a href="#resources" class="py-2">Resources</a>
        <a href="#contact" class="py-2">Contact</a>
      </div>
    </div>
  </header>

  <!-- HERO -->
  <section class="pt-28 pb-20 relative overflow-hidden">
    <div class="blob left-1/4 top-8 w-96 h-96 rounded-full bg-gradient-to-br from-indigo-100 via-sky-100 to-rose-50"></div>
    <div class="blob right-10 top-48 w-72 h-72 rounded-full bg-gradient-to-br from-cyan-50 via-indigo-50 to-pink-50"></div>

    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
      <div class="z-10">
        <div class="inline-flex items-center gap-3 bg-white/75 glass px-3 py-1 rounded-full text-sm shadow-sm">
          <span class="text-indigo-600 font-semibold">New</span>
          <span class="text-slate-600">AI-driven onboarding & payroll</span>
        </div>

        <h1 class="mt-6 text-4xl md:text-5xl font-extrabold leading-tight">
          HR simplified — <span class="text-indigo-600">people-first</span> processes, faster outcomes
        </h1>
        <p class="mt-4 text-lg text-slate-600 max-w-xl">
          Build delightful employee experiences and automate payroll, time-off, performance reviews, and compliance — all from a single beautiful dashboard.
        </p>

        <div class="mt-6 flex flex-wrap gap-3">
          <a href="#signup" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-3 rounded-lg shadow hover:bg-indigo-700 transition">
            Get started free
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 5l7 7-7 7" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
          <a href="#demo" class="inline-flex items-center gap-2 px-5 py-3 rounded-lg border border-slate-200 hover:bg-white focus-ring">
            Request demo
          </a>
        </div>

        <!-- quick features row -->
        <div class="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-4">
          <div class="flex items-start gap-3">
            <div class="w-10 h-10 bg-white rounded-lg shadow flex items-center justify-center">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 11c2 0 4-1 4-4s-2-4-4-4-4 1-4 4 2 4 4 4zM6 20v-1c0-1.657 2.686-3 6-3s6 1.343 6 3v1" stroke="#2563eb" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div class="text-sm">
              <div class="font-semibold text-slate-700">Onboard</div>
              <div class="text-slate-500">Fast employee setup</div>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <div class="w-10 h-10 bg-white rounded-lg shadow flex items-center justify-center">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 3v18M3 12h18" stroke="#06b6d4" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div class="text-sm">
              <div class="font-semibold text-slate-700">Payroll</div>
              <div class="text-slate-500">Auto calculations</div>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <div class="w-10 h-10 bg-white rounded-lg shadow flex items-center justify-center">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 4v16M4 12h16" stroke="#34d399" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div class="text-sm">
              <div class="font-semibold text-slate-700">Time-off</div>
              <div class="text-slate-500">Smart approvals</div>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <div class="w-10 h-10 bg-white rounded-lg shadow flex items-center justify-center">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M3 6h18M3 12h18M3 18h18" stroke="#fb7185" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div class="text-sm">
              <div class="font-semibold text-slate-700">Reviews</div>
              <div class="text-slate-500">Goals & feedback</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right: animated mock dashboard (Lottie) -->
      <div class="relative">
        <div id="lottieHero" class="mx-auto"></div>

        <!-- floating feature cards -->
        <div class="absolute top-6 left-6 w-44 p-4 rounded-2xl glass shadow-lg feature-card">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-lg bg-white flex items-center justify-center feature-icon shadow">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 12v7M7 8a5 5 0 1010 0" stroke="#2563eb" stroke-width="1.4" stroke-linecap="round"/></svg>
            </div>
            <div>
              <div class="text-sm font-semibold">Active 1,210</div>
              <div class="text-xs text-slate-500">employees</div>
            </div>
          </div>
        </div>

        <div class="absolute bottom-10 right-10 w-56 p-5 rounded-2xl bg-white shadow-lg">
          <div class="text-sm text-slate-500">Payroll run</div>
          <div class="mt-2 flex items-baseline gap-3">
            <div class="text-2xl font-bold text-indigo-600">$128,430</div>
            <div class="text-xs text-slate-400">Last 30 days</div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- FEATURES GRID - interactive -->
  <section id="features" class="py-20">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center max-w-2xl mx-auto">
        <h2 class="text-3xl font-extrabold">Comprehensive HR features — designed for teams</h2>
        <p class="mt-3 text-slate-600">Everything HR needs: onboarding, payroll, performance, compliance and people analytics — with powerful automation and integrations.</p>
      </div>

      <div class="mt-12 grid md:grid-cols-3 gap-8">
        <!-- interactive card -->
        <article class="p-6 bg-white rounded-2xl shadow hover:shadow-xl transition feature-card">
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-indigo-50 flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zM6 20v-1a4 4 0 014-4h4a4 4 0 014 4v1" stroke="#2563eb" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
              <h3 class="font-semibold text-lg">Smart Onboarding</h3>
              <p class="mt-1 text-sm text-slate-500">Automate offers, e-signatures, document collection and induction workflows.</p>
            </div>
          </div>
          <div class="mt-4 text-xs text-slate-400">Templates, auto-reminders & compliance checks</div>
        </article>

        <article class="p-6 bg-white rounded-2xl shadow hover:shadow-xl transition feature-card">
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-emerald-50 flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 8v8M8 12h8M4 4h16v16H4z" stroke="#059669" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
              <h3 class="font-semibold text-lg">Payroll & Compliance</h3>
              <p class="mt-1 text-sm text-slate-500">Multi-jurisdiction payroll engine, tax rules and audit logs built-in.</p>
            </div>
          </div>
          <div class="mt-4 text-xs text-slate-400">Payslips, auto-calcs & exports</div>
        </article>

        <article class="p-6 bg-white rounded-2xl shadow hover:shadow-xl transition feature-card">
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-yellow-50 flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 20v-6M8 12h8M12 6v.01" stroke="#f59e0b" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
              <h3 class="font-semibold text-lg">Performance & OKRs</h3>
              <p class="mt-1 text-sm text-slate-500">Goal setting, continuous feedback and performance cycles that scale.</p>
            </div>
          </div>
          <div class="mt-4 text-xs text-slate-400">1:1s, reviews & recognition</div>
        </article>
      </div>
    </div>
  </section>

  <!-- INTEGRATIONS -->
  <section id="integrations" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
      <div class="flex items-center justify-between flex-col sm:flex-row gap-4 sm:gap-0">
        <div>
          <h3 class="text-2xl font-extrabold">Integrates with the tools your team already uses</h3>
          <p class="text-slate-600 mt-2">Connect Slack, Google Workspace, Microsoft Teams, ADP and more — single sign-on & SCIM supported.</p>
        </div>
        <div class="flex items-center gap-3 flex-wrap justify-center sm:justify-start">
          <a class="px-4 py-2 bg-white border rounded-lg shadow" href="#"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/slack/slack-original.svg" class="h-6 sm:h-7" alt="Slack"></a>
          <a class="px-4 py-2 bg-white border rounded-lg shadow" href="#"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg" class="h-6 sm:h-7" alt="Google"></a>
          <a class="px-4 py-2 bg-white border rounded-lg shadow" href="#"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/microsoft/microsoft-original.svg" class="h-6 sm:h-7" alt="MS"></a>
        </div>
      </div>

      <div class="mt-8 grid md:grid-cols-4 gap-6">
        <div class="p-4 bg-slate-50 rounded-xl text-center">
          <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/slack/slack-original.svg" alt="" class="h-10 mx-auto" />
          <div class="mt-2 text-sm font-medium">Slack</div>
        </div>
        <div class="p-4 bg-slate-50 rounded-xl text-center">
          <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg" alt="" class="h-10 mx-auto" />
          <div class="mt-2 text-sm font-medium">Google Workspace</div>
        </div>
        <div class="p-4 bg-slate-50 rounded-xl text-center">
          <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/microsoft/microsoft-original.svg" alt="" class="h-10 mx-auto" />
          <div class="mt-2 text-sm font-medium">Microsoft</div>
        </div>
        <div class="p-4 bg-slate-50 rounded-xl text-center">
          <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/github/github-original.svg" alt="" class="h-10 mx-auto" />
          <div class="mt-2 text-sm font-medium">GitHub</div>
        </div>
      </div>
    </div>
  </section>

  <!-- STATS with animated counters -->
  <section class="py-16">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid md:grid-cols-3 gap-8 text-center">
        <div class="bg-white p-6 rounded-2xl shadow">
          <div class="text-3xl font-extrabold text-indigo-600" data-target="12840">0</div>
          <div class="mt-2 text-slate-500">Employees Managed</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow">
          <div class="text-3xl font-extrabold text-indigo-600" data-target="860">0</div>
          <div class="mt-2 text-slate-500">Companies</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow">
          <div class="text-3xl font-extrabold text-indigo-600" data-target="99.9">0%</div>
          <div class="mt-2 text-slate-500">Uptime</div>
        </div>
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS (Swiper) -->
  <section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6">
      <h3 class="text-2xl font-extrabold text-center">What HR leaders say</h3>
      <div class="swiper mt-8">
        <div class="swiper-wrapper">
          <div class="swiper-slide bg-white p-8 rounded-2xl shadow">
            <p class="text-slate-600">“Switching to HRPortal reduced our payroll time by 70% and improved employee satisfaction.”</p>
            <div class="mt-4 font-semibold">— Ananya Rao, Head of People</div>
          </div>
          <div class="swiper-slide bg-white p-8 rounded-2xl shadow">
            <p class="text-slate-600">“The onboarding automation gave us the structure and compliance checks we needed.”</p>
            <div class="mt-4 font-semibold">— Dinesh Kumar, HR Manager</div>
          </div>
          <div class="swiper-slide bg-white p-8 rounded-2xl shadow">
            <p class="text-slate-600">“Intuitive dashboards and real-time analytics — a must for scaling teams.”</p>
            <div class="mt-4 font-semibold">— Meera Singh, COO</div>
          </div>
        </div>
        <div class="swiper-pagination mt-6"></div>
      </div>
    </div>
  </section>

  <!-- PRICING with monthly/annual toggle -->
  <section id="pricing" class="py-24 bg-soft-1">
    <div class="max-w-6xl mx-auto px-6">
      <div class="text-center">
        <h3 class="text-3xl font-extrabold">Pricing built for teams</h3>
        <p class="mt-2 text-slate-600">Transparent plans — no hidden fees. Try free for 14 days.</p>

        <div class="inline-flex items-center gap-3 mt-6 bg-white rounded-full p-1 shadow">
          <span class="text-sm text-slate-600">Monthly</span>
          <button id="billingToggle" class="w-14 h-7 rounded-full bg-indigo-600 relative transition" aria-pressed="false">
            <span class="absolute w-6 h-6 rounded-full bg-white shadow transform translate-x-0" id="billingKnob"></span>
          </button>
          <span class="text-sm text-slate-600">Annual <span class="text-xs text-emerald-600 font-medium">Save 20%</span></span>
        </div>
      </div>

      <div class="mt-10 grid md:grid-cols-3 gap-6">
        <div class="p-6 bg-white rounded-2xl shadow">
          <div class="flex items-center justify-between">
            <div>
              <h4 class="font-semibold">Starter</h4>
              <div class="text-slate-500 text-sm">For small teams</div>
            </div>
            <div class="text-indigo-600 font-bold text-xl" data-price-month="19" data-price-year="182">$19</div>
          </div>
          <ul class="mt-4 text-sm text-slate-600 space-y-2">
            <li>Up to 25 employees</li>
            <li>Payroll exports</li>
            <li>Basic analytics</li>
          </ul>
          <a href="#" class="mt-6 inline-block w-full text-center bg-indigo-600 text-white py-3 rounded-lg">Start trial</a>
        </div>

        <div class="p-6 bg-white rounded-2xl shadow-lg border-2 border-indigo-50 transform scale-105">
          <div class="flex items-center justify-between">
            <div>
              <h4 class="font-semibold">Pro <span class="ml-2 px-2 py-1 text-xs rounded-full popular-badge">Popular</span></h4>
              <div class="text-slate-500 text-sm">For growing companies</div>
            </div>
            <div class="text-indigo-600 font-bold text-xl" data-price-month="49" data-price-year="470">$49</div>
          </div>
          <ul class="mt-4 text-sm text-slate-600 space-y-2">
            <li>Unlimited employees</li>
            <li>Advanced analytics</li>
            <li>Priority support</li>
          </ul>
          <a href="#" class="mt-6 inline-block w-full text-center bg-indigo-600 text-white py-3 rounded-lg">Start trial</a>
        </div>

        <div class="p-6 bg-white rounded-2xl shadow">
          <div class="flex items-center justify-between">
            <div>
              <h4 class="font-semibold">Enterprise</h4>
              <div class="text-slate-500 text-sm">Custom solutions</div>
            </div>
            <div class="text-indigo-600 font-bold text-xl">Custom</div>
          </div>
          <ul class="mt-4 text-sm text-slate-600 space-y-2">
            <li>Dedicated CSM</li>
            <li>Custom integrations</li>
            <li>SLA & compliance</li>
          </ul>
          <a href="#" class="mt-6 inline-block w-full text-center border border-indigo-600 text-indigo-600 py-3 rounded-lg">Contact sales</a>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section id="faq" class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-6">
      <h3 class="text-2xl font-extrabold text-center">Frequently asked questions</h3>
      <div class="mt-6 space-y-3">
        <details class="p-4 bg-slate-50 rounded-lg">
          <summary class="font-semibold cursor-pointer">Is there a free trial?</summary>
          <div class="mt-2 text-slate-600">Yes — 14 days with full access to Pro features. No card required.</div>
        </details>
        <details class="p-4 bg-slate-50 rounded-lg">
          <summary class="font-semibold cursor-pointer">How secure is my data?</summary>
          <div class="mt-2 text-slate-600">We use AES-256 encryption in transit & at rest, strict access controls and SOC2 practices.</div>
        </details>
        <details class="p-4 bg-slate-50 rounded-lg">
          <summary class="font-semibold cursor-pointer">Do you support payroll in my country?</summary>
          <div class="mt-2 text-slate-600">We support multiple countries — contact sales for exact jurisdiction availability and compliance details.</div>
        </details>
      </div>
    </div>
  </section>

  <!-- RESOURCES -->
  <section id="resources" class="py-20 bg-soft-1">
    <div class="max-w-7xl mx-auto px-6">
      <div class="flex items-center justify-between">
        <h4 class="text-2xl font-extrabold">Learn & scale</h4>
        <a href="#" class="text-sm text-indigo-600">View all resources →</a>
      </div>

      <div class="mt-6 grid md:grid-cols-3 gap-6">
        <article class="p-6 bg-white rounded-lg shadow">
          <h5 class="font-semibold">Guide: Onboarding checklist</h5>
          <p class="mt-2 text-sm text-slate-500">A step-by-step checklist to ramp new hires quickly and compliantly.</p>
          <a href="#" class="mt-4 inline-block text-indigo-600 text-sm">Read more →</a>
        </article>
        <article class="p-6 bg-white rounded-lg shadow">
          <h5 class="font-semibold">Webinar: Payroll best practices</h5>
          <p class="mt-2 text-sm text-slate-500">Expert panel discussion about payroll automation and audits.</p>
          <a href="#" class="mt-4 inline-block text-indigo-600 text-sm">Watch →</a>
        </article>
        <article class="p-6 bg-white rounded-lg shadow">
          <h5 class="font-semibold">Template: Remote offer letter</h5>
          <p class="mt-2 text-sm text-slate-500">Customizable offer letter template built for distributed teams.</p>
          <a href="#" class="mt-4 inline-block text-indigo-600 text-sm">Download →</a>
        </article>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section id="signup" class="py-16">
    <div class="max-w-4xl mx-auto px-6 text-center bg-white rounded-2xl shadow p-10">
      <h3 class="text-2xl font-extrabold">Ready to modernize HR?</h3>
      <p class="mt-2 text-slate-600">Start a free trial or book a live demo with our product experts.</p>
      <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">
        <a href="#" class="px-6 py-3 rounded-lg bg-indigo-600 text-white">Start free 14-day trial</a>
        <a href="#demo" class="px-6 py-3 rounded-lg border border-slate-200">Book a demo</a>
      </div>
    </div>
  </section>

  <!-- CONTACT / FOOTER -->
  <footer id="contact" class="bg-white border-t mt-10">
    <div class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-3 gap-6">
      <div>
        <h5 class="font-semibold text-lg">HRPortal</h5>
        <p class="mt-3 text-slate-600 max-w-sm">People-first HR software built for growth. Secure, compliant and delightful.</p>
        <div class="mt-4 flex gap-3">
          <a href="#" class="text-slate-500">Terms</a>
          <a href="#" class="text-slate-500">Privacy</a>
        </div>
      </div>

      <div>
        <h6 class="font-semibold">Office</h6>
        <p class="mt-2 text-slate-600">Mumbai, India</p>
        <p class="mt-1 text-slate-500 text-sm">support@hrportal.example</p>
      </div>

      <div>
        <h6 class="font-semibold">Contact</h6>
        <form class="mt-3 grid grid-cols-1 gap-3">
          <input class="p-3 border rounded-lg" placeholder="Name" />
          <input class="p-3 border rounded-lg" placeholder="Email" />
          <textarea class="p-3 border rounded-lg" rows="2" placeholder="Message"></textarea>
          <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg">Send message</button>
        </form>
      </div>
    </div>

    <div class="border-t py-6">
      <div class="max-w-7xl mx-auto px-6 text-sm text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2 text-center sm:text-left">
        <div>© <span id="year"></span> HRPortal. All rights reserved.</div>
        <div>Made with ♥ for HR teams</div>
      </div>
    </div>
  </footer>

  <!-- SCRIPTS: GSAP, Lottie, Swiper -->
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/gsap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/ScrollTrigger.min.js"></script>
  <script src="https://unpkg.com/lottie-web@5.9.6/build/player/lottie.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

  <script>
    // Mobile nav toggle with aria+scroll lock
    const mobileBtn = document.getElementById('mobileBtn');
    const mobileNav = document.getElementById('mobileNav');
    const bodyEl = document.body;
    function setMenu(open){
      if(open){
        mobileNav.classList.remove('hidden');
        mobileBtn.setAttribute('aria-expanded', 'true');
        bodyEl.classList.add('no-scroll');
      } else {
        mobileNav.classList.add('hidden');
        mobileBtn.setAttribute('aria-expanded', 'false');
        bodyEl.classList.remove('no-scroll');
      }
    }
    mobileBtn.addEventListener('click', ()=>{
      const isOpen = mobileBtn.getAttribute('aria-expanded') === 'true';
      setMenu(!isOpen);
    });
    // Close menu on resize to md and up
    window.addEventListener('resize', ()=>{
      if(window.innerWidth >= 768){ setMenu(false); }
    });
    // Close menu when a mobile nav link is tapped
    mobileNav.querySelectorAll('a').forEach(a=>{
      a.addEventListener('click', ()=> setMenu(false));
    });

    // Year
    document.getElementById('year').textContent = new Date().getFullYear();

    // Lottie hero animation (replace with your animation URL)
    lottie.loadAnimation({
      container: document.getElementById('lottieHero'),
      renderer: 'svg',
      loop: true,
      autoplay: true,
      path: 'https://assets6.lottiefiles.com/packages/lf20_jmBauI.json' // demo HR/dashboard style
    });

    // GSAP entrance animations
    gsap.registerPlugin(ScrollTrigger);
    gsap.utils.toArray('section').forEach((sec)=>{
      gsap.from(sec, {
        opacity: 0, y: 24, duration: .9, ease: "power2.out",
        scrollTrigger: { trigger: sec, start: "top 85%" }
      });
    });

    // Floating card subtle animation
    gsap.to('.feature-card', {
      y: -6, duration: 2.5, ease: "sine.inOut", repeat: -1, yoyo: true, stagger: 0.25
    });

    // Animated counters (on view)
    const counters = document.querySelectorAll('[data-target]');
    counters.forEach(c=>{
      const target = c.dataset.target;
      let started = false;
      ScrollTrigger.create({
        trigger: c,
        start: "top 80%",
        onEnter: ()=> {
          if (started) return;
          started = true;
          if(target.includes('.')) {
            // percent
            let val = 0;
            const end = parseFloat(target);
            const step = (end / 120);
            const t = setInterval(()=>{
              val = +(val + step).toFixed(1);
              if(val >= end){ c.textContent = end + '%'; clearInterval(t); }
              else c.textContent = val + '%';
            }, 16);
          } else {
            let val = 0;
            const end = parseInt(target,10);
            const step = Math.max(1, Math.floor(end / 120));
            const t = setInterval(()=>{
              val += step;
              if(val >= end){ c.textContent = end.toLocaleString(); clearInterval(t); }
              else c.textContent = val.toLocaleString();
            }, 16);
          }
        }
      });
    });

    // Swiper
    const swiper = new Swiper('.swiper', {
      loop: true,
      slidesPerView: 1,
      pagination: { el: '.swiper-pagination', clickable: true },
      autoplay: { delay: 4200, disableOnInteraction: false },
      speed: 800
    });

    // Billing toggle
    const billingToggle = document.getElementById('billingToggle');
    const billingKnob = document.getElementById('billingKnob');
    let annual = false;
    billingToggle.addEventListener('click', ()=>{
      annual = !annual;
      billingToggle.setAttribute('aria-pressed', annual);
      if(annual){
        billingKnob.style.transform = 'translateX(26px)';
      } else {
        billingKnob.style.transform = 'translateX(0)';
      }
      // update prices
      document.querySelectorAll('[data-price-month]').forEach(el=>{
        const m = parseFloat(el.getAttribute('data-price-month'));
        const y = parseFloat(el.getAttribute('data-price-year'));
        el.textContent = annual ? ('$' + y) : ('$' + m);
      });
      document.querySelectorAll('[data-price-month]').forEach(el=>{
        // keep currency format minimal; you can expand formatting logic
      });
    });

    // small accessibility: enable keyboard toggle
    billingToggle.addEventListener('keydown', (e)=>{
      if(e.key === 'Enter' || e.key === ' ') { e.preventDefault(); billingToggle.click(); }
    });

  </script>
</body>
</html>
