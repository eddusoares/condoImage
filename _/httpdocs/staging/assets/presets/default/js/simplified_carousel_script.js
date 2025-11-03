// Delegates top categories carousel initialization to the shared function declared in the Blade section.
(function () {
  function boot() {
    if (typeof window.initTopCategoriesCarousels === 'function') {
      window.initTopCategoriesCarousels();
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
