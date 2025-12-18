@extends('layouts.macos')
@section('page_title', 'Employee ID Card Showcase')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Employee ID Card System</h1>
        <p class="text-gray-600">Professional digital ID cards for your employees with QR code verification, multiple formats, and easy sharing.</p>
    </div>

    <!-- Features Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-id-card text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 ml-3">Professional Design</h3>
            </div>
            <p class="text-gray-600">Clean, modern corporate look with company branding and professional color palette.</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-emerald-500">
            <div class="flex items-center mb-4">
                <div class="bg-emerald-100 p-3 rounded-full">
                    <i class="fas fa-qrcode text-emerald-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 ml-3">QR Code Verification</h3>
            </div>
            <p class="text-gray-600">Auto-generated QR codes linking to employee profiles for easy verification and sharing.</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center mb-4">
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-mobile-alt text-purple-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 ml-3">Multi-Format Export</h3>
            </div>
            <p class="text-gray-600">Download as PDF, PNG image, or view in mobile-optimized compact format.</p>
        </div>
    </div>

    <!-- ID Card Sizes Demo -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">ID Card Formats</h2>
        
        <!-- Standard Size -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Standard Format (350x220px)</h3>
            <div class="flex justify-center">
                <x-employee-id-card :employee="$employees->first()" size="standard" />
            </div>
        </div>

        <!-- Compact Size -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Compact Format (300x180px)</h3>
            <div class="flex justify-center">
                <x-employee-id-card :employee="$employees->first()" size="compact" />
            </div>
        </div>

        <!-- Mini Size -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Mini Format (250x150px)</h3>
            <div class="flex justify-center">
                <x-employee-id-card :employee="$employees->first()" size="mini" />
            </div>
        </div>
    </div>

    <!-- Multiple Employees Grid -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Employee ID Cards Gallery</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($employees->take(6) as $employee)
                <x-employee-id-card :employee="$employee" size="compact" />
            @endforeach
        </div>
    </div>

    <!-- Usage Examples -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Usage Examples</h2>
        
        <div class="space-y-6">
            <!-- Blade Component Usage -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Blade Component Usage</h3>
                <div class="bg-gray-100 rounded-lg p-4 font-mono text-sm">
                    <div class="text-gray-600 mb-2"><!-- Standard ID Card --></div>
                    <div>&lt;x-employee-id-card :employee="$employee" /&gt;</div>
                    
                    <div class="text-gray-600 mb-2 mt-4"><!-- Compact without actions --></div>
                    <div>&lt;x-employee-id-card :employee="$employee" size="compact" :showActions="false" /&gt;</div>
                    
                    <div class="text-gray-600 mb-2 mt-4"><!-- Mini without QR code --></div>
                    <div>&lt;x-employee-id-card :employee="$employee" size="mini" :showQr="false" /&gt;</div>
                </div>
            </div>

            <!-- Route Examples -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Available Routes</h3>
                <div class="bg-gray-100 rounded-lg p-4 font-mono text-sm space-y-2">
                    <div><span class="text-blue-600">GET</span> /employees/{employee}/id-card</div>
                    <div><span class="text-blue-600">GET</span> /employees/{employee}/id-card/compact</div>
                    <div><span class="text-blue-600">GET</span> /employees/{employee}/id-card/pdf</div>
                </div>
            </div>

            <!-- Controller Methods -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Controller Methods</h3>
                <div class="bg-gray-100 rounded-lg p-4 font-mono text-sm space-y-2">
                    <div>showIdCard(Employee $employee)</div>
                    <div>showCompactIdCard(Employee $employee)</div>
                    <div>downloadIdCardPdf(Employee $employee)</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Technical Specifications -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Technical Specifications</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Card Specifications -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Card Specifications</h3>
                <ul class="space-y-2 text-gray-600">
                    <li><strong>Standard:</strong> 350×220px (Credit card ratio)</li>
                    <li><strong>Compact:</strong> 300×180px (Mobile optimized)</li>
                    <li><strong>Mini:</strong> 250×150px (Thumbnail size)</li>
                    <li><strong>PDF:</strong> 85.6×54mm (ISO/IEC 7810 ID-1)</li>
                    <li><strong>Print DPI:</strong> 300 DPI for high quality</li>
                </ul>
            </div>

            <!-- Features -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Features</h3>
                <ul class="space-y-2 text-gray-600">
                    <li>✅ Dynamic employee data binding</li>
                    <li>✅ QR code auto-generation</li>
                    <li>✅ Responsive design (desktop + mobile)</li>
                    <li>✅ Print-optimized styles</li>
                    <li>✅ PDF export with proper dimensions</li>
                    <li>✅ Image download (PNG format)</li>
                    <li>✅ Access control integration</li>
                    <li>✅ Professional typography (Inter font)</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 text-center">
        <div class="space-x-4">
            <a href="{{ route('employees.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-users mr-2"></i>
                View All Employees
            </a>
            <a href="{{ route('employees.id-card.show', $employees->first()) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                <i class="fas fa-id-card mr-2"></i>
                View Sample ID Card
            </a>
        </div>
    </div>
</div>
@endsection