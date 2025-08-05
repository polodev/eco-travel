<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.hotel_search') }}</x-slot>
    
    <!-- Hero Section with Beach Background -->
    <div class="relative min-h-screen flex items-center justify-center"
         style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 51, 234, 0.1) 100%), url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTkyMCIgaGVpZ2h0PSIxMDgwIiB2aWV3Qm94PSIwIDAgMTkyMCAxMDgwIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgo8ZGVmcz4KPHN0eWxlPgouYmVhY2gtZ3JhZGllbnQgewogIGJhY2tncm91bmQ6IGxpbmVhci1ncmFkaWVudCgxODBkZWcsICNmZGY5ZmYgMCUsICNlNGY0ZmQgMTAwJSk7Cn0KPC9zdHlsZT4KPC9kZWZzPgo8cmVjdCB3aWR0aD0iMTkyMCIgaGVpZ2h0PSIxMDgwIiBjbGFzcz0iYmVhY2gtZ3JhZGllbnQiLz4KPHN2ZyBjbGFzcz0id2F2ZXMiIHg9IjAiIHk9IjgwMCIgd2lkdGg9IjE5MjAiIGhlaWdodD0iMjgwIiB2aWV3Qm94PSIwIDAgMTkyMCAyODAiIGZpbGw9Im5vbmUiPgo8cGF0aCBkPSJNMCwxNDBMMTkyMCw3MEwxOTIwLDI4MEwwLDI4MFoiIGZpbGwtb3BhY2l0eT0iMC4xIiBmaWxsPSIjMDZiNmQ0Ii8+CjxwYXRoIGQ9Ik0wLDE4MEwxOTIwLDExMEwxOTIwLDI4MEwwLDI4MFoiIGZpbGwtb3BhY2l0eT0iMC4wNSIgZmlsbD0iIzA2YjZkNCIvPgo8L3N2Zz4KPC9zdmc+') center/cover no-repeat;">
        
        <div class="absolute inset-0 bg-gradient-to-b from-blue-50/80 via-white/90 to-cyan-50/80"></div>
        
        <!-- Main Content -->
        <div class="relative z-10 w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Search Widget Card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                
                <!-- Tab Navigation -->
                <div class="flex bg-gray-50 border-b">
                    <a href="{{ route('flight::dynamic.index') }}" class="flex-1 flex items-center justify-center py-4 px-6 text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fas fa-plane text-lg mr-3"></i>
                        <span class="font-medium">{{ __('messages.flights') }}</span>
                    </a>
                    <button class="flex-1 flex items-center justify-center py-4 px-6 bg-white text-blue-600 border-b-2 border-blue-600 font-semibold">
                        <i class="fas fa-hotel text-lg mr-3"></i>
                        <span class="font-medium">{{ __('messages.hotels') }}</span>
                    </button>
                </div>

                <!-- Hotel Search Form -->
                <livewire:hotel--hotel-search />
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>