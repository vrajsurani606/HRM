<!DOCTYPE html>
<html lang="en">
<head>
   <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
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
  <style>
    /* Password Toggle Styles */
    .password-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }
    .password-wrapper input {
      padding-right: 45px !important;
    }
    .password-toggle-btn {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: transparent;
      border: none;
      cursor: pointer;
      padding: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #6b7280;
      transition: color 0.2s;
      z-index: 10;
    }
    .password-toggle-btn:hover {
      color: #374151;
    }
    .password-toggle-btn svg {
      width: 20px;
      height: 20px;
    }
  </style>
</head>
<body class="min-h-screen bg-white dark:bg-slate-900 font-[Instrument_Sans]">

  <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
    <div class="hidden lg:flex items-center justify-center p-8 bg-white dark:bg-slate-800">
      <div class="w-full h-full max-w-4xl max-h-[90vh] flex items-center justify-center">
        <lottie-player
          src="{{ asset('public/lottie/hr-animation.json') }}"
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
              <div class="password-wrapper">
                <input type="password" name="password" id="password" required autocomplete="current-password"
                       class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-lg px-4 py-3 outline-none focus-visible:ring-[3px] focus-visible:ring-emerald-500/30 focus-visible:border-emerald-500 transition"
                       placeholder="••••••••">
              </div>
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

  <!-- Password Toggle Script -->
  <script>
    (function() {
      function initPasswordToggles() {
        const wrappers = document.querySelectorAll('.password-wrapper');
        
        wrappers.forEach(wrapper => {
          const input = wrapper.querySelector('input[type="password"], input[type="text"][data-password]');
          if (!input) return;
          
          // Check if button already exists
          if (wrapper.querySelector('.password-toggle-btn')) return;
          
          // Create toggle button
          const button = document.createElement('button');
          button.type = 'button';
          button.className = 'password-toggle-btn';
          button.setAttribute('aria-label', 'Toggle password visibility');
          button.innerHTML = `
            <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg class="eye-closed" style="display:none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            </svg>
          `;
          
          // Add click handler
          button.addEventListener('click', function() {
            const eyeOpen = button.querySelector('.eye-open');
            const eyeClosed = button.querySelector('.eye-closed');
            
            if (input.type === 'password') {
              input.type = 'text';
              eyeOpen.style.display = 'none';
              eyeClosed.style.display = 'block';
            } else {
              input.type = 'password';
              eyeOpen.style.display = 'block';
              eyeClosed.style.display = 'none';
            }
          });
          
          wrapper.appendChild(button);
        });
      }
      
      // Initialize on DOM ready
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPasswordToggles);
      } else {
        initPasswordToggles();
      }
    })();
  </script>

</body>
</html>
