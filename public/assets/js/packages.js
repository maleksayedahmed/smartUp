// Packages Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize package tabs
    initializePackageTabs();
    
    // System tabs are wired at the bottom (single source of truth)
    
    // Initialize video player
    initializeVideoPlayer();
});

// Package Tabs Functionality
function initializePackageTabs() {
    const packageTabs = document.querySelectorAll('.package-tab');
    const activePackageTab = document.querySelector('.package-tab.active');
    
    packageTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            packageTabs.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Update hero content based on attributes on the tab
            const tabTitle = this.getAttribute('data-title');
            const tabSubtitle = this.getAttribute('data-subtitle');
            const defaultSystem = this.getAttribute('data-default-system');

            if (tabTitle) {
                const heroTitle = document.querySelector('.hero-title');
                if (heroTitle) heroTitle.textContent = tabTitle;
            }
            if (tabSubtitle) {
                const heroSubtitle = document.querySelector('.hero-subtitle');
                if (heroSubtitle) heroSubtitle.textContent = tabSubtitle;
            }

            // Switch package content from JSON payload (overrides static DOM)
            if (window.switchPackage) {
                window.switchPackage(this.getAttribute('data-package'));
            }
        });
    });

    // Ensure the currently active package (from HTML) applies its configuration on load
    if (activePackageTab) {
        const initialTitle = activePackageTab.getAttribute('data-title');
        const initialSubtitle = activePackageTab.getAttribute('data-subtitle');
        const initialDefaultSystem = activePackageTab.getAttribute('data-default-system');

        if (initialTitle) {
            const heroTitle = document.querySelector('.hero-title');
            if (heroTitle) heroTitle.textContent = initialTitle;
        }
        if (initialSubtitle) {
            const heroSubtitle = document.querySelector('.hero-subtitle');
            if (heroSubtitle) heroSubtitle.textContent = initialSubtitle;
        }
        if (initialDefaultSystem) {
            const targetSystemTab = document.querySelector(`.system-tab[data-system="${initialDefaultSystem}"]`);
            if (targetSystemTab) targetSystemTab.click();
        }
    }
}

// Removed JS-driven content maps; hero and default system come from HTML data-* attributes

// No JS configuration; switching uses data-default-system on the tab

// System Tabs Functionality
// No content mutation; HTML contains the full data for each system.

// Video Player Functionality
function initializeVideoPlayer() {
    const playButton = document.querySelector('.play-button');
    const videoContainer = document.querySelector('.video-container');
    
    if (playButton && videoContainer) {
        playButton.addEventListener('click', function() {
            // Simulate video play
            this.innerHTML = '<i class="fas fa-pause"></i>';
            this.style.background = 'rgba(255, 255, 255, 0.8)';
            
            // Add video playing effect
            videoContainer.style.transform = 'scale(1.02)';
            setTimeout(() => {
                videoContainer.style.transform = 'scale(1)';
            }, 200);
        });
    }
}

// No page-specific copy functionality here to avoid conflicts with global handlers

// System Tab Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Dynamic package switcher using embedded JSON from blade
    function switchPackage(slug) {
        try {
            const jsonEl = document.getElementById('packages-json');
            if (!jsonEl) return;
            const data = JSON.parse(jsonEl.textContent || '[]');
            const localeAttr = jsonEl.getAttribute('data-locale');
            const locale = localeAttr || document.documentElement.getAttribute('lang') || 'ar';
            const pkg = (data || []).find(p => p.slug === slug);
            if (!pkg) return;


            // Update hero
            const heroTitle = document.querySelector('.hero-title');
            const heroSubtitle = document.querySelector('.hero-subtitle');
            if (heroTitle) heroTitle.textContent = (pkg.title && pkg.title[locale]) || '';
            if (heroSubtitle) heroSubtitle.textContent = (pkg.desc && pkg.desc[locale]) || '';

            // Rebuild systems tabs and content
            const tabsWrap = document.querySelector('.systems-tabs');
            const contentWrap = document.querySelector('.system-content');
            if (!tabsWrap || !contentWrap) return;
            tabsWrap.innerHTML = '';
            contentWrap.innerHTML = '';

            (pkg.systems || []).forEach((sys, idx) => {
                const isActive = idx === 0;
                const sysSlug = sys.slug || ('sys' + idx);

                const btn = document.createElement('button');
                btn.className = 'system-tab' + (isActive ? ' active' : '');
                btn.setAttribute('data-system', sysSlug);
                btn.textContent = (sys.title && sys.title[locale]) || '';
                tabsWrap.appendChild(btn);

                const detail = document.createElement('div');
                detail.className = 'system-detail' + (isActive ? ' active' : '');
                detail.setAttribute('data-system', sysSlug);
                detail.innerHTML = `
                    <div class="package-detail-content">
                        <div class="package-visuals">
                            <div class="surveillance-video">
                                <div class="video-container">
                                    <video src="" poster="/assets/images/image-1.svg" controls playsinline></video>
                                </div>
                            </div>
                            <div class="camera-images">
                                ${(sys.images || []).map(url => `
                                    <div class="camera-image gallery-item" onclick=\"openModal(this)\" data-src=\"${url}\" data-title=\"\" data-description=\"\">
                                        <img src=\"${url}\" alt=\"${(sys.title && sys.title[locale]) || ''}\">
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        <div class="package-content">
                            <div class="package-icon">
                                <img src="/assets/images/Security Camera Icon.svg" alt="icon">
                            </div>
                            <div class="package-header">
                                <h3 class="package-name">${(sys.title && sys.title[locale]) || ''}</h3>
                                <p class="package-description">${(sys.description && sys.description[locale]) || ''}</p>
                            </div>
                            <div class="feature-tags">
                                ${(sys.features || []).map(f => `<span class="feature-tag">${(f && f[locale]) || ''}</span>`).join('')}
                            </div>
                        </div>
                    </div>`;
                contentWrap.appendChild(detail);
            });

            // Re-bind system tabs behavior
            bindSystemTabs();

            // Benefits
            const benefitsWrap = document.querySelector('.key-benefits-global');
            if (benefitsWrap) {
                benefitsWrap.innerHTML = '';
                (pkg.benefits || []).forEach(b => {
                    const card = document.createElement('div');
                    card.className = 'benefit-card';
                    card.innerHTML = `
                        <div class="benefit-icon"><i class="fas fa-bolt"></i></div>
                        <div class="benefit-content">
                            <div class="benefit-number">${b.number || ''}</div>
                            <div class="benefit-label">${(b.label && b.label[locale]) || ''}</div>
                        </div>`;
                    benefitsWrap.appendChild(card);
                });
            }
        } catch (e) {
            console.error('Failed to switch package', e);
        }
    }

    function bindSystemTabs() {
        const systemTabs = document.querySelectorAll('.system-tab');
        const systemDetails = document.querySelectorAll('.system-detail');
        function switchSystem(systemName) {
            systemTabs.forEach(tab => tab.classList.remove('active'));
            systemDetails.forEach(detail => { detail.classList.remove('active'); detail.style.display = 'none'; });
            const activeTab = document.querySelector(`.system-tab[data-system="${systemName}"]`);
            const activeDetail = document.querySelector(`.system-detail[data-system="${systemName}"]`);
            if (activeTab && activeDetail) {
                activeTab.classList.add('active');
                activeDetail.classList.add('active');
                activeDetail.style.display = 'block';
            }
        }
        const systemsTabsContainer = document.querySelector('.systems-tabs');
        if (systemsTabsContainer) {
            systemsTabsContainer.addEventListener('click', function(event) {
                const tab = event.target.closest('.system-tab');
                if (!tab) return;
                const systemName = tab.getAttribute('data-system');
                switchSystem(systemName);
            });
        }
        const initialActive = document.querySelector('.system-tab.active');
        if (initialActive) switchSystem(initialActive.getAttribute('data-system'));
    }

    // expose globally for package tabs handler
    window.switchPackage = switchPackage;
    const systemTabs = document.querySelectorAll('.system-tab');
    const systemDetails = document.querySelectorAll('.system-detail');

    // Function to switch between systems (class/visibility only)
    function switchSystem(systemName) {
        // Remove active class from all tabs and details
        systemTabs.forEach(tab => tab.classList.remove('active'));
        systemDetails.forEach(detail => {
            detail.classList.remove('active');
            detail.style.display = 'none';
        });

        // Add active class to selected tab and detail
        const activeTab = document.querySelector(`.system-tab[data-system="${systemName}"]`);
        const activeDetail = document.querySelector(`.system-detail[data-system="${systemName}"]`);
        
        if (activeTab && activeDetail) {
            activeTab.classList.add('active');
            activeDetail.classList.add('active');
            activeDetail.style.display = 'block';
        }

        // No content updates here; HTML is the source of truth
    }

    // Event delegation for reliability
    const systemsTabsContainer = document.querySelector('.systems-tabs');
    if (systemsTabsContainer) {
        systemsTabsContainer.addEventListener('click', function(event) {
            const tab = event.target.closest('.system-tab');
            if (!tab) return;
            const systemName = tab.getAttribute('data-system');
            switchSystem(systemName);
            // If this was a real user click, stop the auto-rotation
            if (event.isTrusted) stopAutoRotate();
        });
    }

    // Ensure default state is applied on load
    const initialActive = document.querySelector('.system-tab.active');
    if (initialActive) {
        switchSystem(initialActive.getAttribute('data-system'));
    }

    // --- Auto-rotate systems (every 3s) ---
    // Rotates through `.system-tab` items until the user manually clicks a tab.
    let rotationInterval = null;
    let autoRotateActive = true;

    function startAutoRotate() {
        // avoid multiple intervals
        if (rotationInterval) return;
        rotationInterval = setInterval(() => {
            if (!autoRotateActive) return;
            const tabs = document.querySelectorAll('.system-tab');
            if (!tabs || tabs.length === 0) return;
            const active = document.querySelector('.system-tab.active');
            const idx = Array.from(tabs).indexOf(active);
            const nextIndex = (idx === -1) ? 0 : (idx + 1) % tabs.length;
            const nextTab = tabs[nextIndex];
            if (nextTab) {
                const nextSystem = nextTab.getAttribute('data-system');
                // programmatic switch should NOT stop rotation (event.isTrusted is false)
                switchSystem(nextSystem);
            }
        }, 3000); // 3.0s
    }

    function stopAutoRotate() {
        autoRotateActive = false;
        if (rotationInterval) {
            clearInterval(rotationInterval);
            rotationInterval = null;
        }
    }

    // Start rotation after initial state applied
    startAutoRotate();

    // Cleanup on unload
    window.addEventListener('beforeunload', () => stopAutoRotate());
});

// All global UI handlers are centralized in script.js to avoid conflicts
