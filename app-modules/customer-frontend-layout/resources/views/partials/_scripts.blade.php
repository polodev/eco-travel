<!-- Livewire Scripts (auto-starts) -->
@livewireScripts

<!-- Toast Notification Handler -->
<script>
    // Toast notification handler
    document.addEventListener('livewire:init', function () {
        Livewire.on('toast', (event) => {
            console.log('Toast event received:', event);
            
            // Handle both array format and object format
            const data = Array.isArray(event) ? event[0] : event;
            
            if (!data || !data.message) {
                console.error('Invalid toast data:', data);
                return;
            }
            
            // Determine background color based on type
            let bgColor = 'bg-gray-500'; // default
            let icon = 'fa-info-circle'; // default
            
            switch(data.type) {
                case 'success':
                    bgColor = 'bg-green-500';
                    icon = 'fa-check-circle';
                    break;
                case 'error':
                    bgColor = 'bg-red-500';
                    icon = 'fa-exclamation-circle';
                    break;
                case 'warning':
                    bgColor = 'bg-yellow-500';
                    icon = 'fa-exclamation-triangle';
                    break;
                case 'info':
                    bgColor = 'bg-blue-500';
                    icon = 'fa-info-circle';
                    break;
            }
            
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white transition-all duration-300 transform translate-x-full ${bgColor}`;
            toast.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${icon} mr-2"></i>
                    <span>${data.message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 300);
            }, 5000);
        });
    });
</script>

<!-- Custom Scripts -->
@stack('scripts')