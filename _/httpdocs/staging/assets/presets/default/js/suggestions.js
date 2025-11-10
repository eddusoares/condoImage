/**
 * Unified search suggestions engine for desktop header and mobile sidebar.
 * Reuses identical logic by routing different DOM element references
 * (desktop vs mobile) into a single initSearch(config) function.
 *
 * No HTML/CSS changes; selectors are mapped here per requirements.
 */
(function () {
	'use strict';

	/** Normalize string for matching (accent-insensitive, lowercase). */
	function normalize(str) {
		return (str || '')
			.toString()
			.normalize('NFD')
			.replace(/[\u0300-\u036f]/g, '')
			.toLowerCase();
	}

	/** Simple debounce helper (shared across desktop & mobile). */
	function debounce(fn, wait) {
		let t = null;
		return function (...args) {
			if (t) clearTimeout(t);
			t = setTimeout(() => fn.apply(this, args), wait);
		};
	}

	/**
	 * Initialize suggestion behavior for a given input & containers.
	 * config: {
	 *   inputEl,            // <input>
	 *   resultsEl,          // UL where dynamic matches rendered (desktop primary suggestions list)
	 *   suggestionsEl,      // UL of initial/default suggestions (used as baseline & reset)
	 *   resetEl,            // Button that triggers reset (desktop close or mobile close)
	 *   wrapperEl,          // Panel/container (optional; for focus/visibility logic only)
	 *   limitInitial: 6,    // Initial limit for matches (search cap)
	 *   updateSuggestions: true, // Whether to replace suggestions list as user types
	 *   preserveOrder: true,     // Keep original dataset order
	 * }
	 */
	function initSearch(config) {
		const {
			inputEl,
			resultsEl,
			suggestionsEl,
			resetEl,
			wrapperEl,
			limitInitial = 6,
			updateSuggestions = true,
			preserveOrder = true,
			dataScriptId = 'buildings-data', // dataset source (shared)
			templateId = 'headerSuggestionTemplate', // existing template for rendering
		} = config || {};

		if (!inputEl || !resultsEl || !suggestionsEl) return;

		// Capture baseline (initial) suggestions HTML for reset purposes
		const initialSuggestionsHTML = suggestionsEl.innerHTML;

		// Parse dataset once
		const dataset = (function () {
			const scriptTag = document.getElementById(dataScriptId);
			if (!scriptTag) return [];
			try {
				const raw = scriptTag.textContent || '[]';
				const arr = JSON.parse(raw);
				if (!Array.isArray(arr)) return [];
				return arr.map(item => ({
					name: String(item?.name ?? ''),
						// For matching we rely on name only, ordering preserved optionally
					url: String(item?.url ?? '#'),
					normalized: normalize(item?.name ?? ''),
				}));
			} catch (e) {
				console.error('Search dataset parse error:', e);
				return [];
			}
		})();

		const template = document.getElementById(templateId);

		let currentQuery = '';
		let currentMatches = [];

		function getMatches(q) {
			const trimmed = q.trim();
			if (!trimmed) {
				// When empty, we DO NOT auto-trim dataset to first N suggestions list — we keep baseline.
				return [];
			}
			const normalizedQuery = normalize(trimmed);
			let filtered = dataset.filter(item => item.normalized.includes(normalizedQuery));
			// Preserve or re-order (placeholder: currently preserve original order)
			if (!preserveOrder) {
				// Potential future ranking logic could go here.
			}
			return filtered.slice(0, limitInitial);
		}

		function renderList(targetUL, items) {
			if (!targetUL) return;
			// Replace strategy (no diff patching) per requirements
			targetUL.innerHTML = '';
			if (!items.length) {
				// Empty results -> if query empty restore initial suggestions
				if (!currentQuery) {
					targetUL.innerHTML = initialSuggestionsHTML;
				}
				return;
			}
			const frag = document.createDocumentFragment();
			items.forEach(item => {
				let li;
				if (template && template.content) {
					// Clone template structure
						const clone = template.content.cloneNode(true);
					li = clone.querySelector('li');
					const link = clone.querySelector('a[data-role="item-link"]');
					const span = clone.querySelector('[data-role="item-text"]');
					if (link) link.href = item.url;
					if (span) span.textContent = item.name;
					if (!li) {
						// Fallback if template did not contain <li>
						li = document.createElement('li');
						li.appendChild(clone);
					}
				} else {
					// Fallback manual construction (should not occur with existing template)
					li = document.createElement('li');
					const a = document.createElement('a');
					a.href = item.url;
					const i = document.createElement('i');
					i.className = 'las la-arrow-right';
					const text = document.createTextNode(' Explore ' + item.name);
					a.appendChild(i); a.appendChild(text); li.appendChild(a);
				}
				frag.appendChild(li);
			});
			targetUL.appendChild(frag);
		}

		function performSearch() {
			const value = inputEl.value || '';
			currentQuery = value;
			currentMatches = getMatches(value);
			if (updateSuggestions) {
				renderList(suggestionsEl, currentMatches);
			} else {
				renderList(resultsEl, currentMatches);
			}
		}

		const debouncedSearch = debounce(performSearch, 160); // timing aligned with banner fade (160ms)

		function resetAll() {
			inputEl.value = '';
			currentQuery = '';
			currentMatches = [];
			// Restore initial suggestions list
			suggestionsEl.innerHTML = initialSuggestionsHTML;
			// Clear results list if it's distinct
			if (resultsEl !== suggestionsEl) {
				resultsEl.innerHTML = '';
			}
		}

		// EVENTS (same pattern for desktop & mobile)
		inputEl.addEventListener('input', debouncedSearch);
		inputEl.addEventListener('keyup', function (e) {
			// Keyup provided for compatibility; input handles primary logic.
			if (e.key === 'Escape') {
				resetAll();
				inputEl.blur();
			}
		});
		if (resetEl) {
			resetEl.addEventListener('click', function (e) {
				e.preventDefault();
				resetAll();
				inputEl.focus();
			});
		}
		// Optional focus handler to preload suggestions (already present statically)
		inputEl.addEventListener('focus', function () {
			// When focusing with existing text, trigger search immediately (not debounced) for responsiveness.
			if (inputEl.value.trim()) {
				performSearch();
			}
		});

		// Public API (if needed later)
		return { reset: resetAll };
	}

	// DOM Ready mapping for desktop & mobile elements
	document.addEventListener('DOMContentLoaded', function () {
		// DESKTOP selectors
		const desktopInput = document.getElementById('navbarSearchInput');
		const desktopSuggestions = document.getElementById('building-suggestions');
		const desktopResults = desktopSuggestions; // Same container per current markup
		const desktopReset = document.getElementById('navbarSearchClose');
		const desktopWrapper = document.getElementById('navbarSearchPanel');

		initSearch({
			inputEl: desktopInput,
			resultsEl: desktopResults,
			suggestionsEl: desktopSuggestions,
			resetEl: desktopReset,
			wrapperEl: desktopWrapper,
			limitInitial: 6,
			updateSuggestions: true,
			preserveOrder: true,
			dataScriptId: 'buildings-data',
			templateId: 'headerSuggestionTemplate'
		});

		// MOBILE selectors
		const mobileWrapper = document.getElementById('mobileSearchPanel');
		const mobileInput = mobileWrapper ? mobileWrapper.querySelector('.mobile-search-field input[name="search"][data-building-search]') : null;
		const mobileSuggestions = document.getElementById('mobile-building-suggestions');
		const mobileResults = mobileSuggestions; // Same strategy: replace list
		// Use the close button inside mobile search panel as reset (will also close externally); if a dedicated reset appears later, remap here.
		const mobileReset = mobileWrapper ? mobileWrapper.querySelector('.mobile-menu-close[data-action="close"]') : null;

		initSearch({
			inputEl: mobileInput,
			resultsEl: mobileResults,
			suggestionsEl: mobileSuggestions,
			resetEl: mobileReset,
			wrapperEl: mobileWrapper,
			limitInitial: 6,
			updateSuggestions: true,
			preserveOrder: true,
			dataScriptId: 'buildings-data',
			templateId: 'headerSuggestionTemplate'
		});

		// Focus mobile input on opening panel: rely on existing panel open logic adding class; here we observe mutation as a safe hook.
		if (mobileWrapper) {
			const observer = new MutationObserver(() => {
				const isVisible = mobileWrapper.classList.contains('active') || mobileWrapper.style.right === '0px';
				if (isVisible && mobileInput) {
					// Ensure listener already attached (we're in DOMContentLoaded) then focus.
					setTimeout(() => mobileInput.focus(), 30);
				}
			});
			observer.observe(mobileWrapper, { attributes: true, attributeFilter: ['class', 'style'] });
		}
	});
})();

