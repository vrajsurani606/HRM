<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login | HR Portal</title>
  <script>
    (function() {
      const appearance = 'system';
      if (appearance === 'system') {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (prefersDark) {
          document.documentElement.classList.add('dark');
        }
      }
    })();
  </script>
  <style>
    html { background-color: oklch(1 0 0); }
    html.dark { background-color: oklch(0.145 0 0); }
  </style>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js" defer></script>
</head>
<body class="min-h-screen bg-white dark:bg-slate-900 font-[Instrument_Sans]">

  <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
    <div class="hidden lg:flex items-center justify-center p-8 bg-white dark:bg-slate-800">
      <div class="w-full h-full max-w-4xl max-h-[90vh] flex items-center justify-center">
        <lottie-player
          src="{{ asset('lottie/hr-animation.json') }}"
          background="transparent"
          speed="1"
          loop
          autoplay
          style="width:100%;height:100%;max-height:90vh;"
        ></lottie-player>
      </div>
    </div>  

    <div class="flex items-center justify-center p-6 md:p-12 bg-slate-50 dark:bg-slate-900">
      <div class="w-full max-w-md">
        <div class="text-center lg:text-left mb-6">
          <h1 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Log in to your account</h1>
          <p class="text-slate-600 dark:text-slate-400">Enter your credentials to access your account</p>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-6 md:p-8 border border-slate-200 dark:border-slate-700">
          <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
              <input type="email" name="email" id="email" required autocomplete="email"
                     class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-lg px-4 py-3 outline-none focus-visible:ring-[3px] focus-visible:ring-emerald-500/30 focus-visible:border-emerald-500 transition"
                     placeholder="you@company.com">
            </div>
            <div>
              <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                <a href="{{ route('password.request') }}" class="text-emerald-600 hover:underline text-sm">Forgot Password?</a>
              </div>
              <input type="password" name="password" id="password" required autocomplete="current-password"
                     class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-lg px-4 py-3 outline-none focus-visible:ring-[3px] focus-visible:ring-emerald-500/30 focus-visible:border-emerald-500 transition"
                     placeholder="••••••••">
            </div>
            <div class="flex items-center justify-between text-sm">
              <label class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-emerald-600"> Remember me
              </label>
            </div>
            <button type="submit" class="w-full h-11 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-medium shadow-md hover:shadow-lg transition">Log in</button>
            <p class="text-center text-sm text-gray-600 dark:text-gray-400">Don't have an account? <a href="{{ route('register') }}" class="text-emerald-600 hover:underline font-medium">Sign up</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Remote Lottie URL you tried (may throw AccessDenied/CORS)
    const remoteLottie = 'https://assets7.lottiefiles.com/packages/lf20_9xcyzq.json';
    // Local fallback path (you must place this JSON in public/lottie/hr-animation.json)
    const localLottie = '{{ asset("lottie/hr-animation.json") }}';

    // A static SVG/PNG fallback (displayed if both remote and local JSON fail)
    const staticFallbackHTML = `
      <div style="display:flex;align-items:center;justify-content:center;flex-direction:column;">
        <!-- Put simple SVG or image here -->
        <svg width="220" height="160" viewBox="0 0 220 160" xmlns="http://www.w3.org/2000/svg" aria-hidden>
          <rect rx="12" width="220" height="160" fill="#eef2ff"></rect>
          <g transform="translate(24,28)" fill="#6366f1" fill-opacity="0.9">
            <circle cx="34" cy="36" r="22"></circle>
            <rect x="78" y="18" width="88" height="36" rx="8"></rect>
          </g>
        </svg>
        <div style="margin-top:10px;color:#6b7280;font-size:0.95rem;">Animation unavailable — showing fallback</div>
      </div>`;

    // Will try remote first, then local, then static fallback
    (async function loadLottieResilient() {
      const wrapper = document.getElementById('lottie-wrapper');
      const area = document.getElementById('animation-area');

      // Show area only on md+ (matching Tailwind class)
      area.classList.remove('hidden');

      // Helper: attempt to fetch a URL and check if it's JSON & accessible
      async function canFetchJSON(url) {
        try {
          const resp = await fetch(url, { method: 'GET', cache: 'no-cache' });
          if (!resp.ok) return false;
          const ct = resp.headers.get('content-type') || '';
          return ct.includes('application/json') || ct.includes('json');
        } catch (e) {
          return false;
        }
      }

      // Try remote
      let useUrl = null;
      if (await canFetchJSON(remoteLottie)) {
        useUrl = remoteLottie;
      } else if (await canFetchJSON(localLottie)) {
        useUrl = localLottie;
      }

      // Remove loading text
      const loading = document.getElementById('lottie-loading');
      if (loading) loading.remove();

      if (useUrl) {
        // Create lottie-player element
        const player = document.createElement('lottie-player');
        player.setAttribute('src', useUrl);
        player.setAttribute('background', 'transparent');
        player.setAttribute('speed', '1');
        player.setAttribute('loop', '');
        player.setAttribute('autoplay', '');
        player.style.width = '100%';
        player.style.height = '100%';
        player.style.maxHeight = '350px';
        // Append and done
        wrapper.appendChild(player);
      } else {
        // fallback to static SVG
        wrapper.innerHTML = staticFallbackHTML;
      }
    })();
  </script>

</body>
</html>
