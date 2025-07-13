import axios from "axios";
import Alpine from "alpinejs";

// Setup axios
window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

// Setup Alpine but don't auto-start
window.Alpine = Alpine;

// Start Alpine after Livewire is ready
document.addEventListener('DOMContentLoaded', function() {
    let alpineStarted = false;
    
    function startAlpine() {
        if (!alpineStarted) {
            alpineStarted = true;
            Alpine.start();
        }
    }
    
    // Check if Livewire is available
    if (window.Livewire) {
        // Listen for Livewire to be ready
        document.addEventListener('livewire:init', startAlpine);
        
        // Fallback in case the event already fired
        setTimeout(startAlpine, 100);
    } else {
        // No Livewire, start Alpine normally
        startAlpine();
    }
});
