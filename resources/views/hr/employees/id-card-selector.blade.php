<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $employee->name }} - Choose ID Card Style</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #3b82f6;
            --secondary: #64748b;
            --accent: #0ea5e9;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1e293b;
            --light: #f8fafc;
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: var(--gray-800);
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 3rem;
            color: var(--white);
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header p {
            font-size: 1.125rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .employee-info {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 1.5rem;
            margin: 2rem auto;
            max-width: 500px;
            text-align: center;
        }

        .employee-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .employee-details {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            opacity: 0.9;
        }

        .employee-detail {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        /* Design Grid */
        .designs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .design-card {
            background: var(--white);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: var(--shadow-xl);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .design-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .design-preview {
            width: 100%;
            height: 200px;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        /* Professional Preview */
        .preview-professional {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
        }

        .preview-professional::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="10" height="10" patternUnits="userSpaceOnUse"><circle cx="5" cy="5" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
            opacity: 0.3;
        }

        /* Creative Preview */
        .preview-creative {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            position: relative;
        }

        .preview-creative::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        /* Futuristic Preview */
        .preview-futuristic {
            background: linear-gradient(135deg, #0a0a0f 0%, #1a1a2e 50%, #16213e 100%);
            position: relative;
            overflow: hidden;
        }

        .preview-futuristic::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #00f5ff, #bf00ff, #39ff14);
            animation: neonSweep 2s linear infinite;
        }

        @keyframes neonSweep {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* Minimalist Preview */
        .preview-minimalist {
            background: var(--white);
            border: 2px solid var(--gray-200);
            position: relative;
        }

        .preview-minimalist::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent), var(--success));
        }

        .preview-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 1rem;
        }

        .preview-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .preview-futuristic .preview-title {
            font-family: 'Orbitron', monospace;
            color: #00f5ff;
            text-shadow: 0 0 10px #00f5ff;
        }

        .preview-minimalist .preview-title {
            color: var(--gray-800);
        }

        .preview-description {
            font-size: 0.875rem;
            opacity: 0.8;
        }

        .preview-minimalist .preview-description {
            color: var(--gray-600);
        }

        .design-info {
            text-align: center;
        }

        .design-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
        }

        .design-description {
            font-size: 0.875rem;
            color: var(--gray-600);
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .design-features {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .feature-tag {
            background: var(--gray-100);
            color: var(--gray-700);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .select-btn {
            width: 100%;
            background: var(--primary);
            color: var(--white);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .select-btn:hover {
            background: var(--primary);
            filter: brightness(1.1);
            transform: translateY(-1px);
            color: var(--white);
        }

        .select-btn.creative {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .select-btn.futuristic {
            background: linear-gradient(135deg, #00f5ff 0%, #bf00ff 100%);
            font-family: 'Orbitron', monospace;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .select-btn.minimalist {
            background: var(--gray-800);
        }

        /* Button Group */
        .btn-group {
            display: flex;
            gap: 0.5rem;
        }

        .btn-group .select-btn {
            flex: 1;
        }

        .set-active-btn {
            flex: 1;
            background: var(--gray-200);
            color: var(--gray-700);
            border: 2px solid var(--gray-300);
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .set-active-btn:hover {
            background: var(--success);
            color: var(--white);
            border-color: var(--success);
        }

        .set-active-btn.is-active {
            background: var(--success);
            color: var(--white);
            border-color: var(--success);
            cursor: default;
        }

        /* Active Card Styling */
        .design-card.active-card {
            border: 3px solid var(--success);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }

        .active-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: var(--success);
            color: var(--white);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            z-index: 10;
        }

        .design-card {
            position: relative;
        }

        /* Back Button */
        .back-section {
            text-align: center;
            margin-top: 2rem;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: var(--white);
            padding: 0.75rem 2rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            color: var(--white);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .designs-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .employee-details {
                flex-direction: column;
                gap: 0.5rem;
            }
        }

        /* Loading Animation */
        .design-card {
            opacity: 0;
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .design-card:nth-child(1) { animation-delay: 0.1s; }
        .design-card:nth-child(2) { animation-delay: 0.2s; }
        .design-card:nth-child(3) { animation-delay: 0.3s; }
        .design-card:nth-child(4) { animation-delay: 0.4s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Choose Your ID Card Style</h1>
            <p>Select the perfect design that matches your company's brand and personality</p>
            
            <div class="employee-info">
                <div class="employee-name">{{ $employee->name }}</div>
                <div class="employee-details">
                    <div class="employee-detail">
                        <i class="fas fa-id-badge"></i>
                        {{ $employee->code ?? 'EMP-' . str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}
                    </div>
                    <div class="employee-detail">
                        <i class="fas fa-briefcase"></i>
                        {{ $employee->position ?? 'Employee' }}
                    </div>
                    <div class="employee-detail">
                        <i class="fas fa-envelope"></i>
                        {{ $employee->email }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Designs Grid -->
        <div class="designs-grid">
            <!-- Simple Design -->
            <div class="design-card {{ ($activeStyle ?? 'simple') === 'simple' ? 'active-card' : '' }}">
                @if(($activeStyle ?? 'simple') === 'simple')
                <div class="active-badge">✓ Active</div>
                @endif
                <div class="design-preview preview-minimalist" onclick="window.open('{{ route('id-cards.simple', $employee) }}', '_blank')">
                    <div class="preview-content">
                        <div class="preview-title">Simple & Clean</div>
                        <div class="preview-description">Minimalist design focused on essentials</div>
                    </div>
                </div>
                <div class="design-info">
                    <h3 class="design-name">Simple Style</h3>
                    <p class="design-description">A straightforward, no-nonsense design that focuses on clarity and readability. Perfect for quick implementation.</p>
                    <div class="design-features">
                        <span class="feature-tag">Minimalist</span>
                        <span class="feature-tag">Fast Loading</span>
                        <span class="feature-tag">Clear</span>
                        <span class="feature-tag">Accessible</span>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('id-cards.simple', $employee) }}" class="select-btn minimalist" target="_blank">
                            <i class="fas fa-eye"></i> Preview
                        </a>
                        <button type="button" class="set-active-btn {{ ($activeStyle ?? 'simple') === 'simple' ? 'is-active' : '' }}" onclick="setActiveStyle('simple')">
                            {{ ($activeStyle ?? 'simple') === 'simple' ? '✓ Active' : 'Set Active' }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modern Design -->
            <div class="design-card {{ ($activeStyle ?? '') === 'modern' ? 'active-card' : '' }}">
                @if(($activeStyle ?? '') === 'modern')
                <div class="active-badge">✓ Active</div>
                @endif
                <div class="design-preview preview-creative" onclick="window.open('{{ route('id-cards.modern', $employee) }}', '_blank')">
                    <div class="preview-content">
                        <div class="preview-title">Modern Gradient</div>
                        <div class="preview-description">Stunning gradient design with 3D effects</div>
                    </div>
                </div>
                <div class="design-info">
                    <h3 class="design-name">Modern Style</h3>
                    <p class="design-description">A contemporary design featuring beautiful gradients, 3D perspective effects, and smooth animations.</p>
                    <div class="design-features">
                        <span class="feature-tag">3D Effects</span>
                        <span class="feature-tag">Gradients</span>
                        <span class="feature-tag">Animated</span>
                        <span class="feature-tag">Premium</span>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('id-cards.modern', $employee) }}" class="select-btn creative" target="_blank">
                            <i class="fas fa-eye"></i> Preview
                        </a>
                        <button type="button" class="set-active-btn {{ ($activeStyle ?? '') === 'modern' ? 'is-active' : '' }}" onclick="setActiveStyle('modern')">
                            {{ ($activeStyle ?? '') === 'modern' ? '✓ Active' : 'Set Active' }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Professional Design -->
            <div class="design-card {{ ($activeStyle ?? '') === 'professional' ? 'active-card' : '' }}">
                @if(($activeStyle ?? '') === 'professional')
                <div class="active-badge">✓ Active</div>
                @endif
                <div class="design-preview preview-professional" onclick="window.open('{{ route('id-cards.professional', $employee) }}', '_blank')">
                    <div class="preview-content">
                        <div class="preview-title">Professional</div>
                        <div class="preview-description">Clean corporate design with modern elements</div>
                    </div>
                </div>
                <div class="design-info">
                    <h3 class="design-name">Professional Style</h3>
                    <p class="design-description">A clean, corporate design perfect for traditional business environments. Features professional typography.</p>
                    <div class="design-features">
                        <span class="feature-tag">Corporate</span>
                        <span class="feature-tag">Clean</span>
                        <span class="feature-tag">Professional</span>
                        <span class="feature-tag">Print-Ready</span>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('id-cards.professional', $employee) }}" class="select-btn" target="_blank">
                            <i class="fas fa-eye"></i> Preview
                        </a>
                        <button type="button" class="set-active-btn {{ ($activeStyle ?? '') === 'professional' ? 'is-active' : '' }}" onclick="setActiveStyle('professional')">
                            {{ ($activeStyle ?? '') === 'professional' ? '✓ Active' : 'Set Active' }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Creative Design -->
            <div class="design-card {{ ($activeStyle ?? '') === 'creative' ? 'active-card' : '' }}">
                @if(($activeStyle ?? '') === 'creative')
                <div class="active-badge">✓ Active</div>
                @endif
                <div class="design-preview preview-creative" onclick="window.open('{{ route('id-cards.creative', $employee) }}', '_blank')">
                    <div class="preview-content">
                        <div class="preview-title">Creative Showcase</div>
                        <div class="preview-description">Multiple stunning designs with glassmorphism</div>
                    </div>
                </div>
                <div class="design-info">
                    <h3 class="design-name">Creative Collection</h3>
                    <p class="design-description">Four unique designs including glassmorphism, neon cyberpunk, premium gradients, and clean minimalist styles.</p>
                    <div class="design-features">
                        <span class="feature-tag">Glassmorphism</span>
                        <span class="feature-tag">Neon Effects</span>
                        <span class="feature-tag">Gradients</span>
                        <span class="feature-tag">Modern</span>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('id-cards.creative', $employee) }}" class="select-btn creative" target="_blank">
                            <i class="fas fa-eye"></i> Preview
                        </a>
                        <button type="button" class="set-active-btn {{ ($activeStyle ?? '') === 'creative' ? 'is-active' : '' }}" onclick="setActiveStyle('creative')">
                            {{ ($activeStyle ?? '') === 'creative' ? '✓ Active' : 'Set Active' }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Futuristic Design -->
            <div class="design-card {{ ($activeStyle ?? '') === 'futuristic' ? 'active-card' : '' }}">
                @if(($activeStyle ?? '') === 'futuristic')
                <div class="active-badge">✓ Active</div>
                @endif
                <div class="design-preview preview-futuristic" onclick="window.open('{{ route('id-cards.futuristic', $employee) }}', '_blank')">
                    <div class="preview-content">
                        <div class="preview-title">FUTURISTIC</div>
                        <div class="preview-description">Cyberpunk-inspired with neon effects</div>
                    </div>
                </div>
                <div class="design-info">
                    <h3 class="design-name">Futuristic Cyberpunk</h3>
                    <p class="design-description">A cutting-edge design with neon glows, animated effects, and cyberpunk aesthetics. Perfect for tech companies.</p>
                    <div class="design-features">
                        <span class="feature-tag">Neon Glow</span>
                        <span class="feature-tag">Animations</span>
                        <span class="feature-tag">Cyberpunk</span>
                        <span class="feature-tag">Sci-Fi</span>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('id-cards.futuristic', $employee) }}" class="select-btn futuristic" target="_blank">
                            <i class="fas fa-rocket"></i> Preview
                        </a>
                        <button type="button" class="set-active-btn {{ ($activeStyle ?? '') === 'futuristic' ? 'is-active' : '' }}" onclick="setActiveStyle('futuristic')">
                            {{ ($activeStyle ?? '') === 'futuristic' ? '✓ Active' : 'Set Active' }}
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Back Section -->
        <div class="back-section">
            <a href="{{ route('employees.show', $employee) }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Employee Profile
            </a>
        </div>
    </div>

    <script>
        // Set active style function
        function setActiveStyle(style) {
            const baseUrl = '{{ url('id-cards/' . $employee->id . '/set-active') }}/' + style;
            
            fetch(baseUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    alert('Style set to ' + style.charAt(0).toUpperCase() + style.slice(1) + '!');
                    // Reload page to show updated active state
                    window.location.reload();
                } else {
                    alert('Error: ' + (data.error || 'Failed to set style'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to set style. Please try again.');
            });
        }

        // Add interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const previews = document.querySelectorAll('.design-preview');
            previews.forEach(preview => {
                preview.addEventListener('click', function() {
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);
                });
            });
        });
    </script>
</body>
</html>