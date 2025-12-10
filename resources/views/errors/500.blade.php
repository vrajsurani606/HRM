<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 | Server Error</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="text-center p-6">

        <!-- Subtle animated icon -->
        <div class="flex justify-center">
            <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center animate-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v3m0 4h.01M4.93 4.93l14.14 14.14M12 2a10 10 0 100 20 10 10 0 000-20z" />
                </svg>
            </div>
        </div>

        <!-- Status Code -->
        <h1 class="text-8xl font-extrabold text-gray-800 mt-6">500</h1>

        <!-- Heading -->
        <h2 class="text-3xl font-semibold text-gray-700 mt-4">
            Internal Server Error
        </h2>

        <!-- Message -->
        <p class="text-gray-500 mt-3 leading-relaxed max-w-md mx-auto">
            Something went wrong on the server.  
            Our technical team has been notified. Please try again in a moment.
        </p>

        <!-- Button -->
        <a href="/" 
           class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition shadow-md">
            Back to Dashboard
        </a>
    </div>
</body>
</html>
