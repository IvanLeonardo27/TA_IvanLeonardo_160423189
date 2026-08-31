/**
 * BasaKula Search Dropdown Engine (Tokopedia Style with Javanese UI Labels)
 * Manages search history in localStorage and renders interactive suggestions dropdown.
 */
class BasaKulaSearchDropdown {
    constructor(options) {
        this.input = typeof options.input === 'string' ? document.querySelector(options.input) : options.input;
        if (!this.input) return;

        this.storageKey = options.storageKey || 'basakula_search_history_general';
        this.suggestions = options.suggestions || [];
        this.onSelect = options.onSelect || null;
        this.maxHistory = options.maxHistory || 5;

        this.dropdown = null;
        this.init();
    }

    init() {
        this.createDropdown();
        this.bindEvents();
    }

    createDropdown() {
        // Double check if wrapper already has relative positioning
        const parent = this.input.parentElement;
        if (getComputedStyle(parent).position === 'static') {
            parent.style.position = 'relative';
        }

        this.dropdown = document.createElement('div');
        this.dropdown.className = 'basakula-search-dropdown shadow-lg rounded-4 bg-white border d-none position-absolute w-100 overflow-hidden';
        this.dropdown.style.cssText = 'top: 105%; left: 0; z-index: 1050; border-color: #E2E8F0 !important; font-family: inherit;';
        
        parent.appendChild(this.dropdown);
    }

    getHistory() {
        try {
            const raw = localStorage.getItem(this.storageKey);
            return raw ? JSON.parse(raw) : [];
        } catch (e) {
            return [];
        }
    }

    saveHistory(query) {
        if (!query || !query.trim()) return;
        const cleanQuery = query.trim();
        let history = this.getHistory();
        
        // Remove existing duplicate
        history = history.filter(item => item.toLowerCase() !== cleanQuery.toLowerCase());
        // Insert at beginning
        history.unshift(cleanQuery);
        // Limit max items
        if (history.length > this.maxHistory) {
            history = history.slice(0, this.maxHistory);
        }

        try {
            localStorage.setItem(this.storageKey, JSON.stringify(history));
        } catch (e) {}
    }

    removeHistoryItem(index) {
        let history = this.getHistory();
        history.splice(index, 1);
        try {
            localStorage.setItem(this.storageKey, JSON.stringify(history));
        } catch (e) {}
        this.render();
    }

    clearHistory() {
        try {
            localStorage.removeItem(this.storageKey);
        } catch (e) {}
        this.render();
    }

    render() {
        const query = this.input.value.trim().toLowerCase();
        const history = this.getHistory();

        let html = '';

        // 1. HISTORI PENCARIAN TERAKHIR (Riwayat Golèk)
        if (!query && history.length > 0) {
            html += `
                <div class="p-3 border-bottom bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <small class="fw-bold text-dark text-uppercase tracking-wider" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                            <i class="fa-regular fa-clock me-1.5 text-primary"></i> Riwayat Golèk
                        </small>
                        <button type="button" class="btn btn-link p-0 text-decoration-none text-muted fw-semibold btn-clear-all" style="font-size: 0.72rem;">
                            Busak Kabeh
                        </button>
                    </div>
                    <div class="d-flex flex-column gap-1">
            `;

            history.forEach((item, idx) => {
                html += `
                    <div class="d-flex align-items-center justify-content-between p-2 rounded-3 hover-bg-light cursor-pointer item-history-row" data-val="${this.escapeHtml(item)}">
                        <div class="d-flex align-items-center gap-2 text-dark font-medium" style="font-size: 0.88rem;">
                            <i class="fa-regular fa-clock text-muted opacity-50 fs-6"></i>
                            <span>${this.escapeHtml(item)}</span>
                        </div>
                        <button type="button" class="btn btn-sm btn-light border-0 rounded-circle text-muted p-0 d-flex align-items-center justify-content-center btn-remove-item" data-idx="${idx}" style="width: 24px; height: 24px;">
                            <i class="fa-solid fa-xmark" style="font-size: 0.75rem;"></i>
                        </button>
                    </div>
                `;
            });

            html += `
                    </div>
                </div>
            `;
        }

        // 2. TEMBUNG POPULER / SARAN PILIHAN (Popular Suggestions)
        if (!query && this.suggestions.length > 0) {
            html += `
                <div class="p-3 bg-white">
                    <small class="fw-bold text-dark text-uppercase tracking-wider d-block mb-2.5" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                        <i class="fa-solid fa-arrow-trend-up me-1.5 text-success"></i> Tembung Populer
                    </small>
                    <div class="d-flex flex-wrap gap-1.5">
            `;

            this.suggestions.forEach(sugg => {
                html += `
                    <button type="button" class="btn btn-sm btn-light border rounded-pill px-3 py-1 text-dark fw-semibold item-suggestion-tag hover-primary" data-val="${this.escapeHtml(sugg)}" style="font-size: 0.8rem; background: #F8FAFC;">
                        <i class="fa-solid fa-magnifying-glass me-1 opacity-50" style="font-size: 0.7rem;"></i> ${this.escapeHtml(sugg)}
                    </button>
                `;
            });

            html += `
                    </div>
                </div>
            `;
        }

        // 3. LIVE MATCHES (Saat Mengetik)
        if (query) {
            const matches = this.suggestions.filter(s => s.toLowerCase().includes(query));
            html += `
                <div class="p-3 bg-white">
                    <small class="fw-bold text-muted text-uppercase tracking-wider d-block mb-2" style="font-size: 0.7rem;">
                        Saran Tembung
                    </small>
            `;

            if (matches.length > 0) {
                html += `<div class="d-flex flex-column gap-1">`;
                matches.forEach(item => {
                    html += `
                        <div class="d-flex align-items-center gap-2 p-2 rounded-3 hover-bg-light cursor-pointer item-history-row" data-val="${this.escapeHtml(item)}">
                            <i class="fa-solid fa-magnifying-glass text-primary opacity-75 fs-6"></i>
                            <span class="text-dark font-semibold" style="font-size: 0.88rem;">${this.highlightMatch(item, query)}</span>
                        </div>
                    `;
                });
                html += `</div>`;
            } else {
                html += `
                    <div class="p-2 text-muted small">
                        <i class="fa-solid fa-circle-info me-1"></i> Pencarian <strong>"${this.escapeHtml(query)}"</strong>
                    </div>
                `;
            }
            html += `</div>`;
        }

        // 4. PITUDUH GOLÈK FOOTER (Search Tip)
        html += `
            <div class="p-2.5 bg-light border-top d-flex align-items-center justify-content-between text-muted" style="font-size: 0.75rem;">
                <span><i class="fa-regular fa-lightbulb text-warning me-1"></i> <strong>Pituduh Golèk:</strong> Ketik tembung sing arep digolèki</span>
                <span class="badge bg-white text-muted border rounded-pill px-2">BasaKula</span>
            </div>
        `;

        this.dropdown.innerHTML = html;
        this.dropdown.classList.remove('d-none');
        this.attachDropdownEvents();
    }

    attachDropdownEvents() {
        // Clear all button
        const clearBtn = this.dropdown.querySelector('.btn-clear-all');
        if (clearBtn) {
            clearBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.clearHistory();
            });
        }

        // Remove single item button
        const removeBtns = this.dropdown.querySelectorAll('.btn-remove-item');
        removeBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const idx = parseInt(btn.getAttribute('data-idx'));
                this.removeHistoryItem(idx);
            });
        });

        // Select item row or tag
        const itemRows = this.dropdown.querySelectorAll('.item-history-row, .item-suggestion-tag');
        itemRows.forEach(row => {
            row.addEventListener('click', (e) => {
                e.stopPropagation();
                const val = row.getAttribute('data-val');
                if (val) {
                    this.input.value = val;
                    this.saveHistory(val);
                    this.hide();

                    if (typeof this.onSelect === 'function') {
                        this.onSelect(val);
                    } else {
                        // Trigger input & change events
                        this.input.dispatchEvent(new Event('input', { bubbles: true }));
                        this.input.dispatchEvent(new Event('change', { bubbles: true }));
                        if (this.input.form) {
                            this.input.form.submit();
                        }
                    }
                }
            });
        });
    }

    bindEvents() {
        this.input.addEventListener('focus', () => {
            this.render();
        });

        this.input.addEventListener('input', () => {
            this.render();
        });

        // Save history on Enter key
        this.input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                const val = this.input.value.trim();
                if (val) {
                    this.saveHistory(val);
                }
                this.hide();
            }
        });

        // Close when clicking outside
        document.addEventListener('click', (e) => {
            if (!this.input.contains(e.target) && !this.dropdown.contains(e.target)) {
                this.hide();
            }
        });
    }

    hide() {
        if (this.dropdown) {
            this.dropdown.classList.add('d-none');
        }
    }

    escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    highlightMatch(text, query) {
        const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const reg = new RegExp(`(${escapedQuery})`, 'gi');
        return this.escapeHtml(text).replace(reg, '<strong class="text-primary">$1</strong>');
    }
}

// Global helper launcher
window.BasaKulaSearchDropdown = BasaKulaSearchDropdown;
