
<?php $__env->startSection('content'); ?>

    <?php
        // Build slides from neighborhoods (limit for performance)
        $slides = $neighborhoods->take(10);
    ?>

    <?php if($slides->count()): ?>
        <section id="neighHeroCarousel" class="banner-section-two carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
            <!-- Indicators (4 fixed dots, active cycles) -->
            <div class="carousel-indicators" id="neighHeroIndicators">
                <?php for($i = 0; $i < 4; $i++): ?>
                    <button type="button" class="<?php echo e($i === 0 ? 'active' : ''); ?>" data-virtual-index="<?php echo e($i); ?>"
                        aria-current="<?php echo e($i === 0 ? 'true' : 'false'); ?>" aria-label="Indicator <?php echo e($i + 1); ?>"></button>
                <?php endfor; ?>
            </div>

            <!-- Slides (background images only) -->
            <div class="carousel-inner">
                <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $itemUrl = route('neighborhood.details', [
                            'county' => slug($item->county->name),
                            'slug' => slug($item->name),
                            'id' => $item->id,
                        ]);
                    ?>
                    <div class="carousel-item <?php echo e($loop->first ? 'active' : ''); ?>"
                        data-neigh-name="<?php echo e(__($item->name)); ?>"
                        data-neigh-url="<?php echo e($itemUrl); ?>">
                        <div class="banner-thumb bg-img bg-overlay py-120" data-background="<?php echo e(getImage(getFilePath('neighborhood') . '/' . $item->image)); ?>"></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Static overlay content that updates per slide -->
            <div class="hero-static-content">
                <div class="neigh-hero__content">
                    <div class="neigh-hero__breadcrumb">
                        <a href="<?php echo e(route('home')); ?>" class="breadcrumb-home">Home</a>
                        <span class="breadcrumb-pipe"></span>
                        <span class="breadcrumb-current">Neighborhood listing</span>
                    </div>
                    <div class="neigh-hero__featured">Featured</div>
                    <h1 class="neigh-hero__title" id="neighHeroTitle"></h1>
                    <a href="#" class="neigh-hero__btn" id="neighHeroBtn">
                        <span class="btn-text" id="neighHeroBtnText"></span>
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
            <button class="carousel-control-prev" type="button" data-bs-target="#neighHeroCarousel" data-bs-slide="prev" aria-label="Previous">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#neighHeroCarousel" data-bs-slide="next" aria-label="Next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </section>
    <?php endif; ?>

    <?php if(isset($sections) && $sections && $sections->secs): ?>
        <?php $__currentLoopData = json_decode($sections->secs); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make($activeTemplate . 'sections.' . $sec, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div class="neigh-page">
            <!-- All Neighborhoods -->
            <?php echo $__env->make('presets.default.sections.neighborhood_gallery', [
                'showMeta' => true,
                'defaultTitle' => 'All Neighborhoods',
                'defaultButtonText' => 'Explore all neighborhoods',
                'defaultButtonLink' => route('neighborhood'),
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <!-- How it works -->
        <?php echo $__env->make('presets.default.sections.work_process', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Visual compilation CTA -->
        <?php echo $__env->make('presets.default.sections.visual_compilation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const carouselEl = document.querySelector('#neighHeroCarousel');
            if (!carouselEl) return;
            const indicators = Array.from(document.querySelectorAll('#neighHeroIndicators button'));
            const slides = carouselEl.querySelectorAll('.carousel-item');
            const titleEl = document.getElementById('neighHeroTitle');
            const btnEl = document.getElementById('neighHeroBtn');
            const btnTextEl = document.getElementById('neighHeroBtnText');

            function applyFromSlide(index) {
                const active = slides[index];
                if (!active) return;
                const name = active.getAttribute('data-neigh-name') || '';
                const url = active.getAttribute('data-neigh-url') || '#';
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

            // Initialize with first slide
            applyFromSlide(0);

            // Bootstrap carousel instance
            const bsCarousel = bootstrap.Carousel.getOrCreateInstance(carouselEl);

            carouselEl.addEventListener('slid.bs.carousel', function (evt) {
                const index = evt.to ?? Array.from(slides).indexOf(carouselEl.querySelector('.carousel-item.active'));
                applyFromSlide(index);
            });
        });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/presets/default/neighborhood/neighborhood.blade.php ENDPATH**/ ?>