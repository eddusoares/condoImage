@php
    $categoryContent = getContent('category.content', true);
    $categoryValues = $categoryContent->data_values ?? (object)[];

    $type = $type ?? ($categoryValues->type ?? 'buildings');
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

    $headingSource = $customTitle ?? ($categoryValues->heading ?? $defaultTitle);
    $subheadingSource = $customSubheading ?? ($categoryValues->subheading ?? $defaultSubheading);
    $buttonTextSource = $customButtonText ?? ($categoryValues->button_text ?? $defaultButtonText);
    $buttonLinkSource = $customButtonLink ?? ($categoryValues->button_link ?? $defaultButtonLink);

    $heading = $headingSource ? strtr($headingSource, $replacements) : null;
    $subheading = $subheadingSource ? strtr($subheadingSource, $replacements) : null;
    $buttonText = $buttonTextSource ? strtr($buttonTextSource, $replacements) : null;
    $buttonLink = $buttonLinkSource ? strtr($buttonLinkSource, $replacements) : '#';

    $resolvedShowMeta = isset($showMeta)
        ? (bool) $showMeta
        : (isset($categoryValues->show_meta) ? (bool) $categoryValues->show_meta : false);

    $resolvedShowMoreButton = isset($showMoreButton)
        ? (bool) $showMoreButton
        : (isset($categoryValues->show_more_button) ? (bool) $categoryValues->show_more_button : false);

    $loadMoreEndpoint = $type === 'buildings' ? route('condo.building') : route('neighborhood');

    $listingConfig = [
        'type' => $type,
        'heading' => $heading,
        'subheading' => $subheading,
        'button_text' => $buttonText,
        'button_link' => $buttonLink,
        'show_meta' => $resolvedShowMeta,
        'items' => isset($items) ? $items : ($buildingsData ?? null),
        'limit' => isset($categoryValues->limit) ? (int) $categoryValues->limit : null,
        'search_action' => $searchAction ?? $defaultSearchAction,
        'show_more_button' => $resolvedShowMoreButton,
        'section_id' => 'category_home', // Unique ID for Home page category section
        'load_more' => $resolvedShowMoreButton ? [
            'endpoint' => $loadMoreEndpoint,
            'params' => (object) [],
            'increment' => 3,
            'max_limit' => 50,
        ] : null,
    ];
@endphp

@include($activeTemplate . 'sections.partials.listing_cards', ['listingConfig' => $listingConfig])
