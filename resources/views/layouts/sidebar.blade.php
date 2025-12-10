<aside x-data="{ 
    openMenus: {
        hrm: false,
        inquiry: false,
        quotation: false,
        company: false,
        invoice: false,
        payroll: false,
        project: false,
        attendance: false
    }
}" class="w-64 bg-white shadow-lg h-screen overflow-y-auto">
    <!-- Logo -->
    <div class="p-4 border-b">
        <h2 class="text-xl font-bold text-gray-800">HR Portal</h2>
    </div>

    <!-- Navigation Menu -->
    <nav class="mt-4">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
            <img src="{{ asset('side_icon/dashboard.svg') }}" alt="Dashboard" class="w-5 h-5 mr-3">
            <span>Dashboard</span>
        </a>

        <!-- HRM -->
        <div class="relative">
            <button @click="openMenus.hrm = !openMenus.hrm" class="w-full flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                <div class="flex items-center">
                    <img src="{{ asset('side_icon/hr.svg') }}" alt="HRM" class="w-5 h-5 mr-3">
                    <span>HRM</span>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="openMenus.hrm ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openMenus.hrm" x-transition class="bg-gray-50">
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">Add New Hiring Lead</a>
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">List of Hiring Lead</a>
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">Employee List</a>
            </div>
        </div>

        <!-- Inquiry Management -->
        <div class="relative">
            <button @click="openMenus.inquiry = !openMenus.inquiry" class="w-full flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                <div class="flex items-center">
                    <img src="{{ asset('side_icon/inquirymanagment.svg') }}" alt="Inquiry" class="w-5 h-5 mr-3">
                    <span>Inquiry Management</span>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="openMenus.inquiry ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openMenus.inquiry" x-transition class="bg-gray-50">
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">Add New Inquiry</a>
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">List of Inquiry</a>
            </div>
        </div>

        <!-- Quotation Management -->
        <div class="relative">
            <button @click="openMenus.quotation = !openMenus.quotation" class="w-full flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                <div class="flex items-center">
                    <img src="{{ asset('side_icon/quatation.svg') }}" alt="Quotation" class="w-5 h-5 mr-3">
                    <span>Quotation Management</span>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="openMenus.quotation ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openMenus.quotation" x-transition class="bg-gray-50">
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">Add Quotation</a>
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">List of Quotation</a>
            </div>
        </div>

        <!-- Company -->
        <div class="relative">
            <button @click="openMenus.company = !openMenus.company" class="w-full flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                <div class="flex items-center">
                    <img src="{{ asset('side_icon/company.svg') }}" alt="Company" class="w-5 h-5 mr-3">
                    <span>Company</span>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="openMenus.company ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openMenus.company" x-transition class="bg-gray-50">
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">Add Company</a>
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">List of Company</a>
            </div>
        </div>

        <!-- Invoice Management -->
        <div class="relative">
            <button @click="openMenus.invoice = !openMenus.invoice" class="w-full flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                <div class="flex items-center">
                    <img src="{{ asset('side_icon/invoice.svg') }}" alt="Invoice" class="w-5 h-5 mr-3">
                    <span>Invoice Management</span>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="openMenus.invoice ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openMenus.invoice" x-transition class="bg-gray-50">
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">Add Proforma</a>
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">Proforma List</a>
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">Tax Invoice List</a>
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">Add Receipt</a>
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">List Of Receipt</a>
            </div>
        </div>

        <!-- Payroll Management -->
        <div class="relative">
            <button @click="openMenus.payroll = !openMenus.payroll" class="w-full flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                <div class="flex items-center">
                    <img src="{{ asset('side_icon/payroll.svg') }}" alt="Payroll" class="w-5 h-5 mr-3">
                    <span>Payroll Management</span>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="openMenus.payroll ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openMenus.payroll" x-transition class="bg-gray-50">
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">Add Payroll</a>
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">List of Payroll</a>
            </div>
        </div>

        <!-- Project & Task Management -->
        <div class="relative">
            <button @click="openMenus.project = !openMenus.project" class="w-full flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                <div class="flex items-center">
                    <img src="{{ asset('side_icon/projectManager.svg') }}" alt="Project" class="w-5 h-5 mr-3">
                    <span>Project & Task Management</span>
                </div>
                <svg class="w-4 h-4 transition-transform" :class="openMenus.project ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openMenus.project" x-transition class="bg-gray-50">
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">Add Project</a>
                <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">List of Project</a>
            </div>
        </div>

        <!-- Ticket Support System -->
        @can('Tickets Management.manage ticket')
            <a href="{{ route('tickets.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('tickets.*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                <img src="{{ asset('side_icon/ticketsupport.svg') }}" alt="Ticket" class="w-5 h-5 mr-3">
                <span>Ticket Support System</span>
            </a>
        @elsecan('Tickets Management.view ticket')
            <a href="{{ route('tickets.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('tickets.*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                <img src="{{ asset('side_icon/ticketsupport.svg') }}" alt="Ticket" class="w-5 h-5 mr-3">
                <span>Ticket Support System</span>
            </a>
        @endcan

        <!-- Attendance Management -->
        @can('Attendance Management.manage attendance')
            <div class="relative">
                <button @click="openMenus.attendance = !openMenus.attendance" class="w-full flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                    <div class="flex items-center">
                        <img src="{{ asset('side_icon/attendance.svg') }}" alt="Attendance" class="w-5 h-5 mr-3">
                        <span>Attendance Management</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="openMenus.attendance ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openMenus.attendance" x-transition class="bg-gray-50">
                    <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">Attendance Report</a>
                    <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">Leave Approval</a>
                </div>
            </div>
        @elsecan('Attendance Management.view attendance')
            <div class="relative">
                <button @click="openMenus.attendance = !openMenus.attendance" class="w-full flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                    <div class="flex items-center">
                        <img src="{{ asset('side_icon/attendance.svg') }}" alt="Attendance" class="w-5 h-5 mr-3">
                        <span>Attendance Management</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="openMenus.attendance ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openMenus.attendance" x-transition class="bg-gray-50">
                    <a href="#" class="block px-12 py-2 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600">Attendance Report</a>
                </div>
            </div>
        @endcan

        <!-- Events Management -->
        <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
            <img src="{{ asset('side_icon/event.svg') }}" alt="Events" class="w-5 h-5 mr-3">
            <span>Events Management</span>
        </a>

        <!-- Rules & Regulations -->
        <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
            <img src="{{ asset('side_icon/rule.svg') }}" alt="Rules" class="w-5 h-5 mr-3">
            <span>Rules & Regulations</span>
        </a>
    </nav>
</aside>