import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import persist from '@alpinejs/persist';
import 'flowbite';
import '@fortawesome/fontawesome-free/js/all.js';

Alpine.plugin(focus);

window.Alpine = Alpine;

Alpine.start();
document.addEventListener('alpine:init', () => {
    Alpine.store('showSidebar', {
        on: true, // Initial state: Sidebar is visible
        
        toggle() {
            this.on = !this.on; 
            // Toggle the sidebar state
        },
        
        turnOff() {
            this.on = false; // Explicitly turn off the sidebar
        }
    });
});


