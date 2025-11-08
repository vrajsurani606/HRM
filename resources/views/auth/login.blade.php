<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login | HR Portal</title>
   <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
  <!-- lottie player (used only as renderer) -->
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js" defer></script>
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-slate-100 min-h-screen flex items-center justify-center">

  <div class="bg-white/80 backdrop-blur-xl shadow-2xl rounded-2xl p-8 md:p-10 w-full max-w-5xl flex flex-col md:flex-row items-center">
    <!-- Left: animation container -->
    <div id="animation-area" class="hidden md:flex w-1/2 justify-center items-center">
      <!-- lottie-player will be injected here dynamically by JS -->
      <div id="lottie-wrapper" style="width:100%; max-width:420px; height:350px; display:flex; align-items:center; justify-content:center;">
        <!-- Loading spinner while deciding -->
        <div id="lottie-loading" class="text-gray-400">Loading animation…</div>
      </div>
    </div>

    <!-- Right: login form -->
    <div class="w-full md:w-1/2 space-y-6">
      <div class="text-center md:text-left">
        <h2 class="text-3xl font-bold text-gray-800">Welcome Back 👋</h2>
        <p class="text-gray-500 text-sm mt-2">Sign in to continue to your HR Dashboard</p>
      </div>

      <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <div>
          <label for="email" class="block text-gray-600 mb-1">Email Address</label>
          <input type="email" name="email" id="email" required
                 class="w-full border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 rounded-xl px-4 py-3 outline-none transition"
                 placeholder="you@company.com">
        </div>

        <div>
          <label for="password" class="block text-gray-600 mb-1">Password</label>
          <input type="password" name="password" id="password" required
                 class="w-full border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 rounded-xl px-4 py-3 outline-none transition"
                 placeholder="••••••••">
        </div>

        <div class="flex items-center justify-between text-sm">
          <label class="flex items-center gap-2 text-gray-500">
            <input type="checkbox" name="remember" class="text-indigo-600 rounded"> Remember me
          </label>
          <a href="{{ route('password.request') }}" class="text-indigo-600 hover:underline">Forgot Password?</a>
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 transition text-white font-semibold rounded-xl py-3 shadow-lg">
          Sign In
        </button>

        <p class="text-center text-sm text-gray-500 mt-4">
          Don’t have an account? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Create one</a>
        </p>
      </form>
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
