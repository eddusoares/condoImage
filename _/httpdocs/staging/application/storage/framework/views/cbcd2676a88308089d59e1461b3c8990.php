<?php
    $sectionContent = getContent('list_all_buildings.content', true);
    $sectionValues = $sectionContent->data_values ?? (object)[];

    $type = $type ?? ($sectionValues->type ?? 'buildings');
    $defaultTitle = $defaultTitle
        ?? ($type === 'buildings' ? 'All buildings' : 'All neighborhoods');
    $defaultSubheading = $defaultSubheading ?? null;
    $defaultButtonText = $defaultButtonText
        ?? ($type === 'buildings' ? 'Explore all buildings' : 'Explore all neighborhoods');
    $defaultButtonLink = $defaultButtonLink
        ?? ($type === 'buildings' ? route('condo.building') : route('neighborhood'));
    $defaultSearchAction = $defaultSearchAction
        ?? ($type === 'buildings' ? route('search.building') : route('neighborhood'));

    $replacements = isset($replacements) && is_array($replacements) ? $replacements : [];

    $headingSource = $customTitle ?? ($sectionValues->heading ?? $defaultTitle);
    $subheadingSource = $customSubheading ?? ($sectionValues->subheading ?? $defaultSubheading);
    $buttonTextSource = $customButtonText ?? ($sectionValues->button_text ?? $defaultButtonText);
    $buttonLinkSource = $customButtonLink ?? ($sectionValues->button_link ?? $defaultButtonLink);

    $heading = $headingSource ? strtr($headingSource, $replacements) : null;
    $subheading = $subheadingSource ? strtr($subheadingSource, $replacements) : null;
    $buttonText = $buttonTextSource ? strtr($buttonTextSource, $replacements) : null;
    $buttonLink = $buttonLinkSource ? strtr($buttonLinkSource, $replacements) : '#';

    $resolvedShowMeta = isset($showMeta)
        ? (bool) $showMeta
        : (isset($sectionValues->show_meta) ? (bool) $sectionValues->show_meta : false);

    $resolvedShowMoreButton = isset($showMoreButton)
        ? (bool) $showMoreButton
        : (isset($sectionValues->show_more_button) ? (bool) $sectionValues->show_more_button : false);

    $loadMoreEndpoint = $type === 'buildings' ? route('condo.building') : route('neighborhood');

    $listingConfig = [
        'type' => $type,
        'heading' => $heading,
        'subheading' => $subheading,
        'button_text' => $buttonText,
        'button_link' => $buttonLink,
        'show_meta' => $resolvedShowMeta,
        'items' => isset($items) ? $items : ($buildingsData ?? null),
        'limit' => isset($sectionValues->limit) ? (int) $sectionValues->limit : null,
        'search_action' => $searchAction ?? $defaultSearchAction,
        'show_more_button' => $resolvedShowMoreButton,
        'section_id' => 'list_all_buildings_page', // Unique ID for buildings page section
        'load_more' => $resolvedShowMoreButton ? [
            'endpoint' => $loadMoreEndpoint,
            'params' => (object) [],
            'increment' => 3,
            'max_limit' => 50,
        ] : null,
    ];
?>

<?php echo $__env->make($activeTemplate . 'sections.partials.listing_cards', ['listingConfig' => $listingConfig], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\Users\victo\Desktop\pedro\condoImage\_\httpdocs\staging\application\resources\views/presets/default/sections/list_all_buildings.blade.php ENDPATH**/ ?>