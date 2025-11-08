
<?php $__env->startSection('content'); ?>

    <?php
        $slides = $buildings->take(10);
        $allNeighborhoods = $allNeighborhoods ?? collect();
    ?>

    <?php if($slides->count()): ?>
        <section id="condoHeroCarousel" class="banner-section-two carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
            <div class="carousel-indicators" id="condoHeroIndicators">
                <?php for($i = 0; $i < 4; $i++): ?>
                    <button type="button" class="<?php echo e($i === 0 ? 'active' : ''); ?>" data-virtual-index="<?php echo e($i); ?>"
                        aria-current="<?php echo e($i === 0 ? 'true' : 'false'); ?>" aria-label="Indicator <?php echo e($i + 1); ?>"></button>
                <?php endfor; ?>
            </div>

            <div class="carousel-inner">
                <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $itemUrl = route('condo.building.details', building_route_params($item));
                    ?>
                    <div class="carousel-item <?php echo e($loop->first ? 'active' : ''); ?>"
                        data-condo-name="<?php echo e(__($item->name)); ?>"
                        data-condo-url="<?php echo e($itemUrl); ?>">
                        <div class="banner-thumb bg-img bg-overlay py-120" data-background="<?php echo e(getImage(getFilePath('building') . '/' . $item->image)); ?>"></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="hero-static-content">
                <div class="neigh-hero__content">
                    <div class="neigh-hero__breadcrumb">
                        <a href="<?php echo e(route('home')); ?>" class="breadcrumb-home">Home</a>
                        <span class="breadcrumb-pipe"></span>
                        <span class="breadcrumb-current">Condo building</span>
                    </div>
                    <div class="neigh-hero__featured">Featured</div>
                    <h1 class="neigh-hero__title" id="condoHeroTitle"></h1>
                    <a href="#" class="neigh-hero__btn" id="condoHeroBtn">
                        <span class="btn-text" id="condoHeroBtnText"></span>
                        <div class="btn-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 15 14" fill="none" class="arrow-svg">
                                <path d="M12.5 2L1.5 13" stroke="#414145" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M6.5 1H12.5C12.9714 1 13.2071 1 13.3536 1.14645C13.5 1.29289 13.5 1.5286 13.5 2V8" stroke="#414145" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#condoHeroCarousel" data-bs-slide="prev" aria-label="Previous">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#condoHeroCarousel" data-bs-slide="next" aria-label="Next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </section>
    <?php endif; ?>

    <?php if(isset($sections) && $sections && $sections->secs): ?>
        <?php $__currentLoopData = json_decode($sections->secs); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sectionIndex => $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div id="<?php echo e($sec); ?>" data-section="<?php echo e($sec); ?>" data-index="<?php echo e($sectionIndex + 1); ?>">
                <?php echo $__env->make($activeTemplate . 'sections.' . $sec, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div id="category" data-section="category" data-index="1" class="neigh-page">
            <!-- All Buildings -->
            <?php echo $__env->make($activeTemplate . 'sections.category', [
                'type' => 'buildings',
                'showMeta' => true,
                'defaultTitle' => 'All condo buildings',
                'defaultButtonText' => 'Explore all buildings',
                'defaultButtonLink' => route('condo.building'),
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <!-- How it works -->
        <div id="work_process" data-section="work_process" data-index="2">
            <?php echo $__env->make('presets.default.sections.work_process', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <!-- Visual compilation CTA -->
        <div id="visual_compilation" data-section="visual_compilation" data-index="3">
            <?php echo $__env->make('presets.default.sections.visual_compilation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const carouselEl = document.querySelector('#condoHeroCarousel');
            if (!carouselEl) return;
            const indicators = Array.from(document.querySelectorAll('#condoHeroIndicators button'));
            const slides = carouselEl.querySelectorAll('.carousel-item');
            const titleEl = document.getElementById('condoHeroTitle');
            const btnEl = document.getElementById('condoHeroBtn');
            const btnTextEl = document.getElementById('condoHeroBtnText');

            function applyFromSlide(index) {
                const active = slides[index];
                if (!active) return;
                const name = active.getAttribute('data-condo-name') || '';
                const url = active.getAttribute('data-condo-url') || '#';
                titleEl.textContent = name;
                btnEl.setAttribute('href', url);
                btnTextEl.textContent = `See "${name}"`;
                const activeDot = index % 4;
                indicators.forEach((btn, i) => {
                    const isActive = i === activeDot;
                    btn.classList.toggle('active', isActive);
                    btn.setAttribute('aria-current', isActive ? 'true' : 'false');
                });
            }

            applyFromSlide(0);
            const bsCarousel = bootstrap.Carousel.getOrCreateInstance(carouselEl);
            carouselEl.addEventListener('slid.bs.carousel', function (evt) {
                const index = evt.to ?? Array.from(slides).indexOf(carouselEl.querySelector('.carousel-item.active'));
                applyFromSlide(index);
            });
        });
    </script>

    <!-- Section Anchor Navigation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Section anchor navigation system
            function findSectionByHash(hash) {
                if (!hash) return null;
                
                // Remove # and normalize
                const target = hash.substring(1).trim().toLowerCase();
                if (!target) return null;
                
                // Priority 1: Try exact section name match
                let element = document.getElementById(target);
                if (element) return element;
                
                // Priority 2: Try data-section attribute match
                element = document.querySelector(`[data-section="${target}"]`);
                if (element) return element;
                
                // Priority 3: If it's a number, try section-{number} format
                if (/^\d+$/.test(target)) {
                    element = document.getElementById(`section-${target}`);
                    if (element) return element;
                    
                    // Try by data-index
                    element = document.querySelector(`[data-index="${target}"]`);
                    if (element) return element;
                }
                
                return null;
            }
            
            function scrollToSection(element) {
                if (!element) return;
                
                // Calculate header offset (adjust as needed)
                const headerHeight = 80;
                const elementTop = element.getBoundingClientRect().top + window.pageYOffset;
                const offsetTop = elementTop - headerHeight;
                
                // Smooth scroll to section
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
                
            }
            
            function navigateToHash(hash) {
                if (!hash) return;
                let attempts = 0;
                const maxAttempts = 20;
                function tryScroll() {
                    const element = findSectionByHash(hash);
                    if (element) {
                        scrollToSection(element);
                        return;
                    }
                    attempts++;
                    if (attempts < maxAttempts) setTimeout(tryScroll, 100);
                }
                tryScroll();
            }

            function handleAnchorNavigation() {
                const hash = window.location.hash;
                if (hash) navigateToHash(hash);
            }
            
            // Handle initial load
            handleAnchorNavigation();
            
            // Handle hash changes
            window.addEventListener('hashchange', handleAnchorNavigation);
            
            // Handle dynamic content loading
            document.addEventListener('contentLoaded', handleAnchorNavigation);

            // Reprocess clicks on same-hash links
            document.addEventListener('click', function (e) {
                const link = e.target.closest('a[href*="#"]');
                if (!link) return;
                const url = new URL(link.getAttribute('href'), window.location.origin);
                if (url.pathname !== window.location.pathname) return;
                if (!url.hash) return;
                if (url.hash === window.location.hash) {
                    e.preventDefault();
                    navigateToHash(url.hash);
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/presets/default/building/condo_building.blade.php ENDPATH**/ ?>