
<?php $__env->startSection('content'); ?>

    <?php
        $slides = $neighborhood->buildings->take(10);
        $neighborhoodUrl = route('neighborhood.details', ['county' => slug($neighborhood->county->name), 'slug' => slug($neighborhood->name), 'id' => $neighborhood->id]);
    ?>

    <!-- Hero Neighborhood (carousel like other pages) -->
    <section id="neighDetailsHeroCarousel" class="banner-section-two carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
        <!-- Indicators -->
        <div class="carousel-indicators" id="neighDetailsHeroIndicators">
            <?php for($i = 0; $i < $slides->count(); $i++): ?>
                <button type="button" class="<?php echo e($i === 0 ? 'active' : ''); ?>" data-bs-target="#neighDetailsHeroCarousel" data-bs-slide-to="<?php echo e($i); ?>"
                    aria-current="<?php echo e($i === 0 ? 'true' : 'false'); ?>" aria-label="Slide <?php echo e($i + 1); ?>"></button>
            <?php endfor; ?>
        </div>

        <div class="carousel-inner">
            <?php if($slides->count()): ?>
                <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="carousel-item <?php echo e($loop->first ? 'active' : ''); ?>" data-building-name="<?php echo e(__($item->name)); ?>" data-building-url="<?php echo e(route('condo.building.details', building_route_params($item))); ?>">
                        <div class="banner-thumb bg-img bg-overlay py-120" data-background="<?php echo e(getImage(getFilePath('building') . '/' . $item->image)); ?>"></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <!-- Fallback: duplicate neighborhood image to enable carousel -->
                <?php for($i=0;$i<2;$i++): ?>
                    <div class="carousel-item <?php echo e($i===0 ? 'active' : ''); ?>">
                        <div class="banner-thumb bg-img bg-overlay py-120" data-background="<?php echo e(getImage(getFilePath('neighborhood') . '/' . $neighborhood->image)); ?>"></div>
                    </div>
                <?php endfor; ?>
            <?php endif; ?>
        </div>

        <!-- Static overlay content -->
        <div class="hero-static-content">
            <div class="neigh-hero__content">
                <div class="neigh-hero__breadcrumb">
                    <a href="<?php echo e(route('home')); ?>" class="breadcrumb-home">Home</a>
                    <span class="breadcrumb-pipe"></span>
                    <!-- <a href="<?php echo e(route('county', ['slug' => slug($neighborhood->county->name), 'id' => $neighborhood->county->id])); ?>" class="breadcrumb-county"><?php echo e($neighborhood->county->name); ?></a>
                    <span class="breadcrumb-pipe"></span> -->
                    <a href="<?php echo e(route('neighborhood')); ?>" class="breadcrumb-section">Neighborhood</a>
                    <span class="breadcrumb-pipe"></span>
                    <span class="breadcrumb-current"><?php echo e($neighborhood->name); ?></span>
                </div>
                <div class="neigh-hero__featured">Featured</div>
                <h1 class="neigh-hero__title" id="dynamic-title"><?php echo e(__($slides->first()->name ?? $neighborhood->name)); ?></h1>
                <a href="<?php echo e($slides->first() ? route('condo.building.details', building_route_params($slides->first())) : $neighborhoodUrl); ?>" class="neigh-hero__btn" id="dynamic-btn">
                    <span class="btn-text">See "<span id="dynamic-btn-text"><?php echo e(__($slides->first()->name ?? $neighborhood->name)); ?></span>"</span>
                    <div class="btn-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 15 14" fill="none" class="arrow-svg">
                            <path d="M12.5 2L1.5 13" stroke="#414145" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M6.5 1H12.5C12.9714 1 13.2071 1 13.3536 1.14645C13.5 1.29289 13.5 1.5286 13.5 2V8" stroke="#414145" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </a>
            </div>
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#neighDetailsHeroCarousel" data-bs-slide="prev" aria-label="Previous">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#neighDetailsHeroCarousel" data-bs-slide="next" aria-label="Next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </section>

    <?php if(isset($sections) && $sections && $sections->secs): ?>
        <?php $__currentLoopData = json_decode($sections->secs); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sectionIndex => $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div id="<?php echo e($sec); ?>" data-section="<?php echo e($sec); ?>" data-index="<?php echo e($sectionIndex + 1); ?>">
                <?php echo $__env->make($activeTemplate . 'sections.' . $sec, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div id="category" data-section="category" data-index="1" class="neigh-page">
            <!-- All Buildings in [Neighborhood Name] -->
            <?php echo $__env->make($activeTemplate . 'sections.category', [
                'type' => 'buildings',
                'showMeta' => true,
                'buildingsData' => $neighborhood->buildings,
                'defaultTitle' => 'All buildings in :neighborhood',
                'defaultButtonText' => 'Explore all buildings',
                'defaultButtonLink' => route('condo.building'),
                'replacements' => [
                    ':neighborhood' => $neighborhood->name,
                    ':county' => $neighborhood->county->name,
                ],
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <!-- Visual compilation CTA -->
        <div id="visual_compilation" data-section="visual_compilation" data-index="2">
            <?php echo $__env->make('presets.default.sections.visual_compilation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('neighDetailsHeroCarousel');
    const dynamicTitle = document.getElementById('dynamic-title');
    const dynamicBtnText = document.getElementById('dynamic-btn-text');
    const dynamicBtn = document.getElementById('dynamic-btn');

    function updateOverlay() {
        const activeItem = carousel.querySelector('.carousel-item.active');
        if (activeItem && activeItem.dataset.buildingName) {
            dynamicTitle.textContent = activeItem.dataset.buildingName;
            dynamicBtnText.textContent = activeItem.dataset.buildingName;
            dynamicBtn.href = activeItem.dataset.buildingUrl;
        }
    }

    // Update on slide change
    carousel.addEventListener('slid.bs.carousel', updateOverlay);

    // Initial update
    updateOverlay();
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
        
        // Add highlight effect
        // element.style.transition = 'box-shadow 0.3s ease';
        // element.style.boxShadow = '0 0 20px rgba(0, 123, 255, 0.3)';
        
        // setTimeout(() => {
        //     element.style.boxShadow = '';
        // }, 2000);
    }
    
    function handleAnchorNavigation() {
        const hash = window.location.hash;
        if (hash) {
            // Wait for potential dynamic content
            let attempts = 0;
            const maxAttempts = 20; // 2 seconds max
            
            function tryScroll() {
                const element = findSectionByHash(hash);
                if (element) {
                    scrollToSection(element);
                    return;
                }
                
                attempts++;
                if (attempts < maxAttempts) {
                    setTimeout(tryScroll, 100);
                }
            }
            
            tryScroll();
        }
    }
    
    // Handle initial load
    handleAnchorNavigation();
    
    // Handle hash changes
    window.addEventListener('hashchange', handleAnchorNavigation);
    
    // Handle dynamic content loading
    document.addEventListener('contentLoaded', handleAnchorNavigation);
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/presets/default/neighborhood/neighborhood_details.blade.php ENDPATH**/ ?>