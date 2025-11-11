class FloatingActionButton {
    constructor() {
        this.init();
    }

    init() {
        this.bindElements();
        this.bindEvents();
        this.isFabExpanded = false;
    }

    bindElements() {
        this.fabMainButton = document.getElementById('fab-main-button');
        this.fabMainIcon = document.getElementById('fab-main-icon');
        this.fabOptions = this.getAllFabOptions();
        this.fabTooltipClosed = document.getElementById('fab-tooltip-closed');
        this.fabTooltipOpen = document.getElementById('fab-tooltip-open');
    }

    getAllFabOptions() {
        return Array.from(document.querySelectorAll('.fab-option'));
    }

    bindEvents() {
        if (this.fabMainButton) {
            this.fabMainButton.addEventListener('click', () => this.toggleFab());
        }

        this.fabOptions.forEach(option => {
            option.addEventListener('click', (e) => this.handleOptionClick(e));
        });

        document.addEventListener('click', (e) => this.handleOutsideClick(e));
    }

    toggleFab() {
        this.isFabExpanded = !this.isFabExpanded;
        
        if (this.isFabExpanded) {
            this.expandFab();
        } else {
            this.collapseFab();
        }
    }

    expandFab() {
        this.fabMainButton.classList.add('expanded');
        this.updateTooltips(true);
        this.animateOptions(true);
    }

    collapseFab() {
        this.fabMainButton.classList.remove('expanded');
        this.updateTooltips(false);
        this.animateOptions(false);
    }

    updateTooltips(isExpanded) {
        if (isExpanded) {
            this.fabTooltipClosed?.classList.add('hidden');
            this.fabTooltipOpen?.classList.remove('hidden');
        } else {
            this.fabTooltipClosed?.classList.remove('hidden');
            this.fabTooltipOpen?.classList.add('hidden');
        }
    }

    animateOptions(show) {
        const options = show ? this.fabOptions : this.fabOptions.slice().reverse();
        
        options.forEach((button, index) => {
            setTimeout(() => {
                if (show) {
                    button.classList.add('active');
                } else {
                    button.classList.remove('active');
                }
            }, index * 50);
        });
    }

    handleOptionClick(event) {
        const option = event.currentTarget;
        const optionId = option.id;
        
        // Dispatch custom event for flexibility
        window.dispatchEvent(new CustomEvent('fabOptionClicked', {
            detail: { optionId, element: option }
        }));
        
        this.toggleFab();
    }

    handleOutsideClick(event) {
        const isClickInsideFab = this.fabMainButton?.contains(event.target) || 
                                this.fabOptions.some(option => option.contains(event.target));
        
        if (this.isFabExpanded && !isClickInsideFab) {
            this.toggleFab();
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new FloatingActionButton();
});

// Handle FAB option clicks
window.addEventListener('fabOptionClicked', (event) => {
    const { optionId } = event.detail;
    
    switch(optionId) {
        case 'fab-option-whatsapp':
            window.open('https://wa.me/1234567890', '_blank');
            break;
        case 'fab-option-magic':
            // Handle AI chat
            console.log('Opening AI chat...');
            break;
        case 'fab-option-chat':
            // Handle support chat
            console.log('Opening support chat...');
            break;
        default:
            console.log(`Unknown option: ${optionId}`);
    }
});