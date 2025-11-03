@php
    $galleryContent = getContent('neighborhood_gallery.content', true);
    $galleryValues = $galleryContent->data_values ?? (object)[];

    $defaultTitle = $defaultTitle ?? 'All neighborhoods';
    $defaultSubheading = $defaultSubheading ?? null;
    $defaultButtonText = $defaultButtonText ?? 'Explore all neighborhoods';
    $defaultButtonLink = $defaultButtonLink ?? route('neighborhood');
    $defaultSearchAction = $defaultSearchAction ?? route('neighborhood');

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
    ];
@endphp

@include($activeTemplate . 'sections.partials.listing_cards', ['listingConfig' => $listingConfig])
