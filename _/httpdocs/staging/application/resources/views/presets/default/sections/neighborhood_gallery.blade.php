@php
    $galleryContent = getContent('neighborhood_gallery.content', true);
    $galleryValues = $galleryContent->data_values ?? (object)[];

    $defaultTitle = $defaultTitle ?? 'All neighborhoods';
    $defaultSubheading = $defaultSubheading ?? null;
    $defaultButtonText = $defaultButtonText ?? 'Explore all neighborhoods';
    $defaultButtonLink = $defaultButtonLink ?? baseRoute('neighborhood');
    $defaultSearchAction = $defaultSearchAction ?? baseRoute('neighborhood');

    $replacements = isset($replacements) && is_array($replacements) ? $replacements : [];

    $headingSource = $customTitle ?? ($galleryValues->heading ?? $defaultTitle);
    $subheadingSource = $customSubheading ?? ($galleryValues->subheading ?? $defaultSubheading);
    $buttonTextSource = $customButtonText ?? ($galleryValues->button_text ?? $defaultButtonText);
    $buttonLinkSource = $customButtonLink ?? ($galleryValues->button_link ?? $defaultButtonLink);

    $heading = $headingSource ? strtr($headingSource, $replacements) : null;
    $subheading = $subheadingSource ? strtr($subheadingSource, $replacements) : null;
    $buttonText = $buttonTextSource ? strtr($buttonTextSource, $replacements) : null;
    $buttonLink = $buttonLinkSource ? strtr($buttonLinkSource, $replacements) : '#';

    $resolvedShowMeta = isset($showMeta)
        ? (bool) $showMeta
        : (isset($galleryValues->show_meta) ? (bool) $galleryValues->show_meta : false);

    $resolvedShowMoreButton = isset($showMoreButton)
        ? (bool) $showMoreButton
        : (isset($galleryValues->show_more_button) ? (bool) $galleryValues->show_more_button : false);

    $listingConfig = [
        'type' => 'neighborhoods',
        'heading' => $heading,
        'subheading' => $subheading,
        'button_text' => $buttonText,
        'button_link' => $buttonLink,
        'show_meta' => $resolvedShowMeta,
        'items' => $neighs ?? null,
        'limit' => isset($galleryValues->limit) ? (int) $galleryValues->limit : null,
        'search_action' => $searchAction ?? $defaultSearchAction,
        'show_more_button' => $resolvedShowMoreButton,
        'section_id' => 'neighborhood_gallery_page', // Unique ID for gallery section
        'load_more' => $resolvedShowMoreButton ? [
            'endpoint' => baseRoute('neighborhood'),
            'params' => (object) [],
            'increment' => 3,
            'max_limit' => isset($galleryValues->max_limit) ? (int) $galleryValues->max_limit : 50,
        ] : null,
    ];
@endphp

@include($activeTemplate . 'sections.partials.listing_cards', ['listingConfig' => $listingConfig])
