<!-- resources/views/welcome.blade.php -->
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>HRPortal — Modern HR for People-First Companies</title>
  <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

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
    #lottieHero { width: 100%; height: auto; aspect-ratio: 16/9; }
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

    <div class="max-w-7xl xl:max-w-[80rem] 2xl:max-w-[90rem] mx-auto px-6 grid md:[grid-template-columns:1fr_1.35fr] xl:[grid-template-columns:1fr_1.5fr] gap-12 items-center">
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

       

      </div>
    </div>
  </section>

  <!-- QUICK ACCESS (Internal portal) -->
  <section id="quick-access" class="py-16">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center max-w-2xl mx-auto">
        <h2 class="text-3xl font-extrabold">Quick Access</h2>
        <p class="mt-3 text-slate-600">Jump straight to modules you use every day.</p>
      </div>
      <div class="mt-10 grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <a href="{{ route('employees.index') }}" class="p-5 bg-white rounded-2xl shadow hover:shadow-lg transition block">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-lg bg-indigo-50 flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 11c2 0 4-1 4-4s-2-4-4-4-4 1-4 4 2 4 4 4zM6 20v-1c0-1.657 2.686-3 6-3s6 1.343 6 3v1" stroke="#2563eb" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
              <div class="font-semibold">Employees</div>
              <div class="text-xs text-slate-500">Directory & onboarding</div>
            </div>
          </div>
        </a>
        <a href="{{ route('payroll.index') }}" class="p-5 bg-white rounded-2xl shadow hover:shadow-lg transition block">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-lg bg-emerald-50 flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 6h16M6 10h12M8 14h8M10 18h4" stroke="#059669" stroke-width="1.4" stroke-linecap="round"/></svg>
            </div>
            <div>
              <div class="font-semibold">Payroll</div>
              <div class="text-xs text-slate-500">Runs & rules</div>
            </div>
          </div>
        </a>
        <a href="{{ route('inquiries.index') }}" class="p-5 bg-white rounded-2xl shadow hover:shadow-lg transition block">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-lg bg-amber-50 flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 6h16v12H4zM8 10h8" stroke="#f59e0b" stroke-width="1.4" stroke-linecap="round"/></svg>
            </div>
            <div>
              <div class="font-semibold">Inquiries</div>
              <div class="text-xs text-slate-500">Leads & contact</div>
            </div>
          </div>
        </a>
        <a href="{{ route('quotations.index') }}" class="p-5 bg-white rounded-2xl shadow hover:shadow-lg transition block">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-lg bg-sky-50 flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M6 4h12v16H6zM8 8h8M8 12h6M8 16h5" stroke="#0284c7" stroke-width="1.4" stroke-linecap="round"/></svg>
            </div>
            <div>
              <div class="font-semibold">Quotations</div>
              <div class="text-xs text-slate-500">Quotes & proposals</div>
            </div>
          </div>
        </a>
        <a href="{{ route('companies.index') }}" class="p-5 bg-white rounded-2xl shadow hover:shadow-lg transition block">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-lg bg-violet-50 flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M3 20h18M4 18V6a2 2 0 012-2h6v14M12 9h6v9" stroke="#7c3aed" stroke-width="1.4" stroke-linecap="round"/></svg>
            </div>
            <div>
              <div class="font-semibold">Companies</div>
              <div class="text-xs text-slate-500">Accounts & clients</div>
            </div>
          </div>
        </a>
        <a href="{{ route('projects.index') }}" class="p-5 bg-white rounded-2xl shadow hover:shadow-lg transition block">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-lg bg-cyan-50 flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 6h16M6 10h12M6 14h8M6 18h10" stroke="#06b6d4" stroke-width="1.4" stroke-linecap="round"/></svg>
            </div>
            <div>
              <div class="font-semibold">Projects</div>
              <div class="text-xs text-slate-500">Boards & tasks</div>
            </div>
          </div>
        </a>
        <a href="{{ route('performas.index') }}" class="p-5 bg-white rounded-2xl shadow hover:shadow-lg transition block">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-lg bg-slate-50 flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M6 4h12v16H6zM8 8h8M8 12h6M8 16h5" stroke="#334155" stroke-width="1.4" stroke-linecap="round"/></svg>
            </div>
            <div>
              <div class="font-semibold">Performas</div>
              <div class="text-xs text-slate-500">Proforma bills</div>
            </div>
          </div>
        </a>
        <a href="{{ route('invoices.index') }}" class="p-5 bg-white rounded-2xl shadow hover:shadow-lg transition block">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-lg bg-emerald-50 flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M6 4h12v16H6zM8 8h8M8 12h6M8 16h5" stroke="#059669" stroke-width="1.4" stroke-linecap="round"/></svg>
            </div>
            <div>
              <div class="font-semibold">Invoices</div>
              <div class="text-xs text-slate-500">Billing</div>
            </div>
          </div>
        </a>
        <a href="{{ route('receipts.index') }}" class="p-5 bg-white rounded-2xl shadow hover:shadow-lg transition block">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-lg bg-yellow-50 flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M6 4h12v16H6zM8 8h8M8 12h6" stroke="#f59e0b" stroke-width="1.4" stroke-linecap="round"/></svg>
            </div>
            <div>
              <div class="font-semibold">Receipts</div>
              <div class="text-xs text-slate-500">Payments</div>
            </div>
          </div>
        </a>
        <a href="{{ route('tickets.index') }}" class="p-5 bg-white rounded-2xl shadow hover:shadow-lg transition block">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-lg bg-rose-50 flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 8h16v8H4z" stroke="#e11d48" stroke-width="1.4" stroke-linecap="round"/></svg>
            </div>
            <div>
              <div class="font-semibold">Tickets</div>
              <div class="text-xs text-slate-500">Support & issues</div>
            </div>
          </div>
        </a>
        <a href="{{ route('attendance.report') }}" class="p-5 bg-white rounded-2xl shadow hover:shadow-lg transition block">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-lg bg-blue-50 flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M6 6h12M6 10h12M6 14h8" stroke="#3b82f6" stroke-width="1.4" stroke-linecap="round"/></svg>
            </div>
            <div>
              <div class="font-semibold">Attendance</div>
              <div class="text-xs text-slate-500">Reports</div>
            </div>
          </div>
        </a>
        <a href="{{ route('leave-approval.index') }}" class="p-5 bg-white rounded-2xl shadow hover:shadow-lg transition block">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-lg bg-fuchsia-50 flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M12 5l7 7-7 7" stroke="#a21caf" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
              <div class="font-semibold">Leave Approval</div>
              <div class="text-xs text-slate-500">Approvals</div>
            </div>
          </div>
        </a>
        <a href="{{ route('events.index') }}" class="p-5 bg-white rounded-2xl shadow hover:shadow-lg transition block">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-lg bg-purple-50 flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M7 4v3M17 4v3M4 9h16v11H4z" stroke="#8b5cf6" stroke-width="1.4" stroke-linecap="round"/></svg>
            </div>
            <div>
              <div class="font-semibold">Events</div>
              <div class="text-xs text-slate-500">Calendar</div>
            </div>
          </div>
        </a>
        <a href="{{ route('settings.index') }}" class="p-5 bg-white rounded-2xl shadow hover:shadow-lg transition block">
          <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-lg bg-slate-50 flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" stroke="#334155" stroke-width="1.4"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V22a2 2 0 01-4 0v-.09a1.65 1.65 0 00-1-1.51 1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H2a2 2 0 010-4h.09a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 007 4.6V4a2 2 0 014 0v.09c0 .66.39 1.26 1 1.51.5.24 1.08.24 1.58 0a1.65 1.65 0 001-1.51V4a2 2 0 014 0v.6c0 .66.39 1.26 1 1.51l.06.06a2 2 0 012.83 2.83l-.06.06c-.47.47-.61 1.18-.33 1.82.24.5.85.89 1.51.89H22a2 2 0 010 4h-.6c-.66 0-1.26.39-1.51 1z" stroke="#334155" stroke-width="1.4"/></svg>
            </div>
            <div>
              <div class="font-semibold">Settings</div>
              <div class="text-xs text-slate-500">Configuration</div>
            </div>
          </div>
        </a>
      </div>
    </div>
  </section>

  <!-- ABOUT (brief) -->
  <section id="about" class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
      <div>
        <h3 class="text-2xl font-extrabold">About HRPortal</h3>
        <p class="mt-3 text-slate-600">A unified internal system to manage people, projects and billing. Optimized for speed, clarity and daily workflows — not marketing.</p>
      </div>
      <div class="grid grid-cols-2 gap-4 text-sm">
        <div class="p-4 rounded-xl bg-slate-50">
          <div class="font-semibold">Modules</div>
          <div class="text-slate-500 mt-1">HR, Payroll, Projects, Billing, Attendance, Events</div>
        </div>
        <div class="p-4 rounded-xl bg-slate-50">
          <div class="font-semibold">Access</div>
          <div class="text-slate-500 mt-1">Role-based permissions with clear navigation</div>
        </div>
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
      path: "{{ asset('public/lottie/Project-config.json') }}" // local Lottie JSON
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
