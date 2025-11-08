@php
	$sectionContent = getContent('list_neighborhood_buildings.content', true);
	$sectionValues = $sectionContent->data_values ?? (object) [];

	$activeNeighborhood = isset($neighborhood) && $neighborhood instanceof App\Models\Neighborhood
		? $neighborhood
		: null;

	$type = 'buildings';
	$defaultTitle = $defaultTitle ?? 'All buildings';
	$defaultSubheading = $defaultSubheading ?? null;
	$defaultButtonText = $defaultButtonText ?? 'Explore all buildings';
	$defaultButtonLink = $defaultButtonLink ?? route('condo.building');
	$defaultSearchAction = $defaultSearchAction ?? route('search.building');

	$initialLimit = 6;
	$maxLimit = 9;

	$replacements = isset($replacements) && is_array($replacements) ? $replacements : [];
	if ($activeNeighborhood) {
		$replacements = array_merge(['{neighborhood}' => $activeNeighborhood->name], $replacements);
	}

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

	$itemsSource = isset($items) ? $items : ($activeNeighborhood ? $activeNeighborhood->buildings : collect());
	$itemsCollection = $itemsSource instanceof Illuminate\Support\Collection
		? $itemsSource
		: collect($itemsSource ?? []);

	$filteredItems = $itemsCollection->filter(function ($building) {
		return $building && (int) ($building->status ?? 0) === 1;
	})->values();

	$initialItems = $filteredItems->take($initialLimit);

	$loadMoreEndpoint = $activeNeighborhood
		? route('neighborhood.buildings', ['neighborhood' => $activeNeighborhood->id])
		: null;

	$listingConfig = [
		'type' => $type,
		'heading' => $heading,
		'subheading' => $subheading,
		'button_text' => $buttonText,
		'button_link' => $buttonLink,
		'show_meta' => $resolvedShowMeta,
		'items' => $initialItems,
		'limit' => $initialLimit,
		'search_action' => $searchAction ?? $defaultSearchAction,
		'show_more_button' => $resolvedShowMoreButton,
		'section_id' => 'list_neighborhood_buildings_' . ($activeNeighborhood ? $activeNeighborhood->id : 'general'), // Unique ID per neighborhood
		'load_more' => $resolvedShowMoreButton && $loadMoreEndpoint ? [
			'endpoint' => $loadMoreEndpoint,
			'params' => (object) [],
			'increment' => 3,
			'max_limit' => $maxLimit,
		] : null,
	];
@endphp

@include($activeTemplate . 'sections.partials.listing_cards', ['listingConfig' => $listingConfig])
