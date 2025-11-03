// Mobile Menu System - Completely Separate from Desktop
document.addEventListener('DOMContentLoaded', function () {
    const mobileMenuSystem = document.getElementById('mobileMenuSystem');
    const searchToggle = document.getElementById('navbarSearchToggle');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    
    if (!mobileMenuSystem) return;

    // Detectar se é mobile
    const isMobile = () => window.matchMedia('(max-width: 991.98px)').matches;

    // Sistema de navegação mobile
    class MobileMenuManager {
        constructor() {
            this.currentPanel = null;
            this.isOpen = false;
            this.init();
        }

        init() {
            this.bindEvents();
            this.handleInitialState();
        }

        handleInitialState() {
            // Prevent desktop behavior on mobile
            if (isMobile()) {
                // Remove Bootstrap collapse behavior from hamburger
                mobileMenuToggle?.removeAttribute('data-bs-toggle');
                mobileMenuToggle?.removeAttribute('data-bs-target');
                
                // Hide Bootstrap navbar collapse on mobile
                const navbarCollapse = document.getElementById('navbarSupportedContent');
                if (navbarCollapse) {
                    navbarCollapse.style.display = 'none';
                }
            }
        }

        bindEvents() {
            // Search button
            searchToggle?.addEventListener('click', (e) => {
                if (isMobile()) {
                    e.preventDefault();
                    e.stopPropagation();
                    this.openPanel('mobileSearchPanel');
                }
            });

            // Hamburger button  
            mobileMenuToggle?.addEventListener('click', (e) => {
                if (isMobile()) {
                    e.preventDefault();
                    e.stopPropagation();
                    this.openPanel('mobileMainPanel');
                }
            });

            // Panel navigation
            mobileMenuSystem.addEventListener('click', (e) => {
                const action = e.target.closest('[data-action]')?.dataset.action;
                const target = e.target.closest('[data-target]')?.dataset.target;

                switch (action) {
                    case 'close':
                        this.closeMenu();
                        break;
                    case 'back':
                        if (target) this.openPanel(target);
                        break;
                    case 'navigate':
                        if (target) this.openPanel(target);
                        break;
                }
            });

            // Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.isOpen && isMobile()) {
                    this.closeMenu();
                }
            });

            // Handle resize
            window.addEventListener('resize', () => {
                if (!isMobile() && this.isOpen) {
                    this.closeMenu();
                }

                this.handleInitialState();
            });
        }

        openPanel(panelId) {
            const panel = document.getElementById(panelId);
            if (!panel) return;

            // Close current panel
            if (this.currentPanel) {
                this.currentPanel.classList.remove('active');
            }

            // Open new panel with animation
            this.currentPanel = panel;
            panel.classList.add('active');
            
            // Activate system
            if (!this.isOpen) {
                mobileMenuSystem.classList.add('active');
                document.body.classList.add('mobile-menu-open');
                this.isOpen = true;
            }

            // Focus first input if search panel
            if (panelId === 'mobileSearchPanel') {
                setTimeout(() => {
                    const input = panel.querySelector('input[type="text"]');
                    if (input) {
                        input.focus();
                        input.click(); // For better mobile keyboard trigger
                    }
                }, 350); // Wait for animation
            }
        }

        closeMenu() {
            if (this.currentPanel) {
                this.currentPanel.classList.remove('active');
                this.currentPanel = null;
            }
            
            mobileMenuSystem.classList.remove('active');
            document.body.classList.remove('mobile-menu-open');
            this.isOpen = false;

            // Blur any focused input
            const activeElement = document.activeElement;
            if (activeElement && activeElement.tagName === 'INPUT') {
                activeElement.blur();
            }
        }
    }

    // Initialize mobile menu manager only
    const mobileMenu = new MobileMenuManager();

    // Log for debugging
    console.log('Mobile Menu System initialized');
});