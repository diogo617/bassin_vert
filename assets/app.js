/*
 * Welcome to your app's main JavaScript file!
 */
import './styles/app.css';

console.log('Bassin Vert App Loaded 🌿');

// Mobile Navigation Toggle
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('.mobile-toggle');
    const nav = document.querySelector('.nav-links');
    if (toggle && nav) {
        toggle.addEventListener('click', () => {
            nav.classList.toggle('active');
        });
    }

    // Dark Mode Toggle
    const themeToggle = document.getElementById('theme-toggle');
    const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
    
    // Check local storage or system preference
    const currentTheme = localStorage.getItem('theme');
    
    if (currentTheme === 'dark') {
        document.body.classList.add('dark-mode');
        themeToggle.textContent = '☀️';
    } else if (currentTheme === 'light') {
        document.body.classList.remove('dark-mode');
        themeToggle.textContent = '🌙';
    } else if (prefersDarkScheme.matches) {
        // Optional: auto-set class if system is dark, to sync UI state
        // document.body.classList.add('dark-mode'); 
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            
            let theme = 'light';
            if (document.body.classList.contains('dark-mode')) {
                theme = 'dark';
                themeToggle.textContent = '☀️';
            } else {
                themeToggle.textContent = '🌙';
            }
            localStorage.setItem('theme', theme);
        });
    }
});
