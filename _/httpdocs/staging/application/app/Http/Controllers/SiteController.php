<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\File;
use App\Models\Page;
use App\Models\County;
use App\Models\Building;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Subscriber;
use App\Models\Neighborhood;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use App\Models\ListingUnit;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request as RequestFacade;

class SiteController extends Controller
{
    public function index()
    {

        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }
        $pageTitle = 'Home';
        $breadcrumbs = [
            ['title' => $pageTitle, 'url' => '']
        ];
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', '/')->first();

        return view($this->activeTemplate . 'home', compact('pageTitle', 'sections', 'breadcrumbs'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home')],
            ['title' => $pageTitle, 'url' => '']
        ];
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections', 'breadcrumbs'));
    }

    public function contact()
    {
        $pageTitle = "Contact Us";
        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home')],
            ['title' => $pageTitle, 'url' => '']
        ];
        return view($this->activeTemplate . 'contact', compact('pageTitle', 'breadcrumbs'));
    }

    public function county($slug, $id)
    {
        $pageTitle = "cities";
        $allNeighborhoods = Neighborhood::with('buildings', 'county')->where('status', 1)->get();
        $county = County::with('neighborhoods')->where('id', $id)->orderBy('id', 'desc')
            ->first();

        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home')],
            ['title' => $pageTitle, 'url' => ''],
        ];

        $neighborhoods = Neighborhood::with([
            'county',
            'buildings' => function ($q) {
                $q->where('status', 1)->get();
            },
            'buildings.buildingListingUnits.listingImages',
            'buildings.buildingImages'
        ])
            ->where('county_id', $id)
            ->orderBy('id', 'desc')
            ->paginate(getPaginate(20));

        $totalImages = $neighborhoods->sum(
            fn($item) => $item->total_building_images_count + $item->total_listing_images_count,
        );
        $totalBuildings = $neighborhoods->sum(fn($item) => $item->buildings->count());

        return view($this->activeTemplate . 'county.county', compact('pageTitle', 'county', 'neighborhoods', 'breadcrumbs', 'totalImages', 'totalBuildings', 'allNeighborhoods'));
    }

    public function neighborhood()
    {
        if (request()->ajax()) {
            $q = request('q'); // Search parameter
            $limit = request('limit', 6);
            
            $query = Neighborhood::with([
                'county',
                'buildings' => function ($q) {
                    $q->where('status', 1);
                },
                'buildings.buildingListingUnits.listingImages',
                'buildings.buildingImages'
            ])
                ->where('status', 1);
                
            // If search parameter is provided, filter and return all results (ignore limit)
            if ($q) {
                $items = $query->where('name', 'LIKE', "%{$q}%")
                ->orderBy('name', 'asc')
                ->get();
            } else {
                // Normal pagination with limit
                $items = $query->orderBy('name', 'asc')
                              ->take($limit)
                              ->get();
            }
            
            return response()->json($items);
        }

        $pageTitle = "NeighborHood";
        $allNeighborhoods = Neighborhood::with(['county', 'buildings'])->where('status', 1)->get();
        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home')],
            ['title' => $pageTitle, 'url' => ''],
        ];
        $county = County::with('neighborhoods')->orderBy('id', 'desc')
            ->first();
        $neighborhoods = Neighborhood::with([
            'county',
            'buildings' => function ($q) {
                $q->where('status', 1)->get();
            },
            'buildings.buildingListingUnits.listingImages',
            'buildings.buildingImages'
        ])
            ->orderBy('id', 'desc')
            ->paginate(getPaginate(20));

        $totalImages = $neighborhoods->sum(
            fn($item) => $item->total_building_images_count + $item->total_listing_images_count,
        );
        $totalBuildings = $neighborhoods->sum(fn($item) => $item->buildings->count());

        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'neighborhood')->first();
        return view($this->activeTemplate . 'neighborhood.neighborhood', compact('pageTitle', 'county', 'neighborhoods', 'breadcrumbs', 'totalImages', 'totalBuildings', 'allNeighborhoods', 'sections'));
    }

    public function neighborhoodDetails($county, $slug, $id)
    {

        $allNeighborhoods = Neighborhood::with(['county', 'buildings'])->where('status', 1)->get();
        $neighborhood = Neighborhood::with([
            'county',
            'buildings' => function ($query) {
                $query->where('status', 1)
                    ->with([
                        'neighborhood.county',
                        'buildingImages',
                        'buildingListingUnits',
                        'buildingListingUnits.listingImages',
                    ]);
            },
        ])->where('id', $id)->first();


        $pageTitle = $neighborhood->name;

        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home')],
            ['title' => $neighborhood->county->name, 'url' => route('county', ['slug' => slug($neighborhood->county->name), 'id' => $neighborhood->county->id])],
            ['title' => 'Neighborhood', 'url' => route('neighborhood')],
            ['title' => $pageTitle, 'url' => '']
        ];
        $totalBuildingImages = $neighborhood->buildings->sum(fn($building) => $building->buildingImages->count());
        $totalListingImages = $neighborhood->buildings->sum(
            fn($building) => $building->buildingListingUnits->sum(
                fn($unit) => $unit->listingImages->count()
            )
        );

        $totalImages = $totalBuildingImages + $totalListingImages;
        $totalBuildings = $neighborhood->buildings->count();

        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'neighborhood-details')->first();

        return view($this->activeTemplate . 'neighborhood.neighborhood_details', compact('pageTitle', 'neighborhood', 'totalImages', 'totalBuildings', 'breadcrumbs', 'totalListingImages', 'allNeighborhoods', 'sections'));
    }

    public function neighborhoodBuildings(Request $request, Neighborhood $neighborhood)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $q = $request->query('q'); // Search parameter
        $limit = (int) $request->query('limit', 6);
        $limit = max(1, min($limit, 9));

        $query = $neighborhood->buildings()
            ->where('status', 1)
            ->with([
                'neighborhood.county',
                'buildingImages',
                'buildingListingUnits',
                'buildingListingUnits.listingImages',
            ]);
            
        // If search parameter is provided, filter and return all results (ignore limit)
        if ($q) {
            $items = $query->where(function($query) use ($q) {
                $query->where('name', 'LIKE', "%{$q}%")
                      ->orWhere('address', 'LIKE', "%{$q}%");
            })
            ->orderBy('name', 'asc')
            ->get();
        } else {
            // Normal pagination with limit
            $items = $query->orderBy('name', 'asc')
                          ->take($limit)
                          ->get();
        }

        return response()->json($items);
    }
    public function condoBuilding()
    {
        if (request()->ajax()) {
            $q = request('q'); // Search parameter
            $limit = request('limit', 6);
            
            $query = Building::with(['neighborhood', 'neighborhood.county', 'buildingImages', 'buildingListingUnits'])
                ->where('status', 1);
                
            // If search parameter is provided, filter and return all results (ignore limit)
            if ($q) {
                $items = $query->where(function($query) use ($q) {
                    $query->where('name', 'LIKE', "%{$q}%")
                          ->orWhere('address', 'LIKE', "%{$q}%");
                })
                ->orderBy('name', 'asc')
                ->get();
            } else {
                // Normal pagination with limit
                $items = $query->orderBy('name', 'asc')
                              ->take($limit)
                              ->get();
            }
            
            return response()->json($items);
        }

        $pageTitle = 'Condo Building';
        $allNeighborhoods = Neighborhood::with([
            'county',
            'buildings' => function ($query) {
                $query->where('status', 1)
                    ->with(['buildingImages', 'buildingListingUnits']);
            },
        ])->where('status', 1)->get();
        $uniqueNeighborhoodCount = Building::with('neighborhood')
            ->where('status', 1)
            ->get()
            ->pluck('neighborhood.id')
            ->unique()
            ->count();
        $buildings = Building::withCount(['buildingImages', 'buildingListingUnits'])->with(['neighborhood', 'neighborhood.county'])
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());

        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home')],
            ['title' => $pageTitle, 'url' => '']
        ];

        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'condo-building')->first();
        return view($this->activeTemplate . 'building.condo_building', compact('pageTitle', 'allNeighborhoods', 'uniqueNeighborhoodCount', 'buildings', 'breadcrumbs', 'sections'));
    }

    public function condoBuildingDetails($county, $neighborhood, $slug, $id)
    {
        $allNeighborhoods = Neighborhood::with('county', 'buildings')->where('status', 1)->get();
        $building = Building::with([
            'neighborhood.county',
            'buildingImagesCategoryDescriptions',
            'buildingImages.imageCategory',
            'buildingListingUnits.listingImages',
        ])
            ->where('id', $id)
            ->orderBy('id', 'desc')
            ->first();

        $pageTitle = $building->name;
        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home')],
            ['title' => 'Neighborhood', 'url' => route("neighborhood")],
            [
                'title' => $building->neighborhood->name,
                'url' => route("neighborhood.details", ['county' => slug($building->neighborhood->county->name), 'slug' => slug($building->neighborhood->name), 'id' => $building->neighborhood->id])
            ],
            ['title' => $pageTitle, 'url' => '']
        ];

        // group building category image
        $groupedImagesByCategory = $building->buildingImages
            ->filter(fn($img) => $img->imageCategory) // null category exclude
            ->groupBy(fn($img) => $img->imageCategory->id)
            ->map(function ($images) use ($building) {
                $category = $images->first()->imageCategory;
                $categoryId = $category->id;

                // Find description from buildingImagesCategoryDescriptions relation
                $description = $building->buildingImagesCategoryDescriptions
                    ->firstWhere('image_category_id', $categoryId);

                return [
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'image_count' => $images->count(),
                    'first_image' => $images->first()->image,
                    'images' => $images->map(fn($img) => [
                        'image' => $img->image,
                        'storage' => $img->storage,
                    ])->values(),
                    'description' => optional($description)->description,
                ];
            })
            ->values();

        // listing image

        $buildingListingImages = $building->buildingListingUnits->map(function ($unit) use ($building) {
            return [
                'county' => $building->neighborhood->county->name,
                'neighborhood' => $building->neighborhood->name,
                'building' => $building->name,
                'unit_number' => $unit->unit_number,
                'id' => $unit->id,
                'storage' => $unit->storage,
                'first_image' => $unit->image,
                'image_count' => $unit->listingImages->count()
            ];
        });


        // Calculate total number of listing images across all units
        // and get the first available image from the first unit that has at least one image
        $firstUnit = $building->buildingListingUnits->first();

        $listingImageSummary = [
            'totalListingImages' => $building->buildingListingUnits->sum(function ($unit) {
                return $unit->listingImages->count();
            }),
            'firstListingImage' => $firstUnit ? $firstUnit->image : null,
        ];


        return view($this->activeTemplate . 'building.building_details', compact('pageTitle', 'building', 'groupedImagesByCategory', 'buildingListingImages', 'listingImageSummary', 'allNeighborhoods', 'breadcrumbs'));
    }

    public function condoBuildingListingImages($county, $neighborhood, $slug, $unit, $id)
    {
        $allNeighborhoods = Neighborhood::with(['county', 'buildings'])->where('status', 1)->get();
        $listingUnit = ListingUnit::with([
            'building.buildingListingUnits.listingImages',
            'building.buildingImages.imageCategory',
            'building.neighborhood.county',

        ])
            ->where('id', $id)
            ->orderBy('id', 'desc')
            ->first();
        $pageTitle = $listingUnit->unit_number;
        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home')],
            [
                'title' => $listingUnit->building->neighborhood->county->name,
                'url' => route("county", [slug($listingUnit->building->neighborhood->county->name), $listingUnit->building->neighborhood->county->id])
            ],
            [
                'title' => $listingUnit->building->neighborhood->name,
                'url' => route("neighborhood.details", [slug($listingUnit->building->neighborhood->county->name), slug($listingUnit->building->neighborhood->name), $listingUnit->building->neighborhood->id]),
            ],
            [
                'title' => $listingUnit->building->name,
                'url' => route("condo.building.details", [slug($listingUnit->building->neighborhood->county->name), slug($listingUnit->building->neighborhood->name), slug($listingUnit->building->name), slug($listingUnit->unit_number), 'id' => $listingUnit->id])
            ],

            ['title' => $pageTitle, 'url' => '']
        ];


        // group building category image
        $groupedImagesByCategory = $listingUnit->building->buildingImages
            ->filter(fn($img) => $img->imageCategory) // null category exclude
            ->groupBy(fn($img) => $img->imageCategory->id)
            ->map(function ($images) use ($listingUnit) {
                $category = $images->first()->imageCategory;
                $categoryId = $category->id;

                // Find description from buildingImagesCategoryDescriptions relation
                $description = $listingUnit->building->buildingImagesCategoryDescriptions
                    ->firstWhere('image_category_id', $categoryId);

                return [
                    'id' => $listingUnit->building->id,
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'image_count' => $images->count(),
                    'first_image' => $images->first()->image,
                    'images' => $images->map(fn($img) => $img->image)->values(),
                    'description' => optional($description)->description,
                ];
            })
            ->values();


        // Calculate total number of listing images across all units
        // and get the first available image from the first unit that has at least one image


        // listing image

        $building = $listingUnit->building;
        $buildingListingImages = $listingUnit->building->buildingListingUnits->map(function ($unit) use ($building) {

            return [
                'county' => $building->neighborhood->county->name,
                'neighborhood' => $building->neighborhood->name,
                'building' => $building->name,
                'unit_number' => $unit->unit_number,
                'id' => $unit->id,
                'unit_number' => $unit->unit_number,
                'first_image' => $unit->image,
                'image_count' => $unit->listingImages->count(),
            ];
        });


        $listingImageSummary = [
            'totalListingImages' => $listingUnit->listingImages->count()

        ];

        return view($this->activeTemplate . 'building.building_unit_details', compact('pageTitle', 'listingUnit', 'groupedImagesByCategory', 'buildingListingImages', 'listingImageSummary', 'allNeighborhoods', 'breadcrumbs'));
    }

    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }


    public function policyPages($slug, $id)
    {
        $policy = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        $breadcrumbs = [
            ['title' => $pageTitle, 'url' => '']
        ];
        return view($this->activeTemplate . 'policy', compact('policy', 'pageTitle', 'breadcrumbs'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language)
            $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blogDetails($slug, $id)
    {
        $blog = Frontend::where('id', $id)->where('data_keys', 'blog.element')->firstOrFail();
        $pageTitle = $blog->data_values->title;
        return view($this->activeTemplate . 'blog_details', compact('blog', 'pageTitle'));
    }

    public function exploreFiles()
    {
        $pageTitle = 'Explore';
        $activePaginate = 1;
        $files = File::where('status', 1)->latest()->get();
        $explores = $this->makeCollection($files);

        $perPage = 12;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedData = $explores->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $explores = new LengthAwarePaginator($pagedData, $explores->count(), $perPage);

        $explores->withPath(RequestFacade::url());

        return view($this->activeTemplate . 'explore', compact('pageTitle', 'explores', 'activePaginate'));
    }

    public function filesByCategory($id)
    {
        $pageTitle = 'Search Result';
        $activePaginate = 1;
        $files = File::where('status', 1)->where('category_id', $id)->latest()->get();
        $explores = $this->makeCollection($files);
        $perPage = 12;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedData = $explores->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $explores = new LengthAwarePaginator($pagedData, $explores->count(), $perPage);

        $explores->withPath(RequestFacade::url());
        $sections = Page::where('slug', 'explore')->first();
        return view($this->activeTemplate . 'explore', compact('pageTitle', 'explores', 'activePaginate', 'sections'));
    }


    public function searchBuilding(Request $request)
    {
        $request->validate([
            'search' => 'required',
        ], [
            'search.required' => 'Please enter something your desired.',
        ]);

        $query = $request->search;
        $pageTitle = 'Condo Building';

        // Count unique neighborhoods related to buildings
        $uniqueNeighborhoodCount = Building::distinct('neighborhood_id')->count('neighborhood_id');

        // Common query builder
        $buildingQuery = Building::with('neighborhood.county')
            ->withCount(['buildingImages', 'buildingListingUnits'])
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('address', 'LIKE', "%{$query}%");
            })
            ->orderBy('id', 'desc');

        if ($request->ajax()) {
            $buildings = $buildingQuery->get();

            return response()->json([
                'status' => 'success',
                'buildings' => $buildings,
            ]);
        } else {
            $buildings = $buildingQuery->paginate(getPaginate());

            $breadcrumbs = [
                ['title' => 'Home', 'url' => route('home')],
                ['title' => $pageTitle, 'url' => ''],
            ];

            return view($this->activeTemplate . 'building.condo_building', compact(
                'pageTitle',
                'uniqueNeighborhoodCount',
                'buildings',
                'breadcrumbs',
                'query'
            ));
        }
    }


    public function searchByTag($id)
    {
        $pageTitle = 'Search Result';
        $activePaginate = 1;
        $files = File::where('status', 1)->get();
        $files = $files->filter(function ($file) use ($id) {
            return in_array($id, $file->tags);
        });

        $explores = $this->makeCollection($files);

        $perPage = 12;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedData = $explores->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $explores = new LengthAwarePaginator($pagedData, $explores->count(), $perPage);

        $explores->withPath(RequestFacade::url());

        return view($this->activeTemplate . 'explore', compact('pageTitle', 'explores', 'activePaginate'));
    }

    public function fileDetails($id)
    {
        $pageTitle = 'File Detail';
        $file = File::find($id);
        return view($this->activeTemplate . 'file_details', compact('pageTitle', 'file'));
    }

    public function filterByCat(Request $request)
    {
        $givenCats = $request->categories;
        $givenTags = $request->tags;

        if (isset($givenCats) && !isset($givenTags)) {
            $pageTitle = 'Search Result';
            $files = File::whereIn('category_id', $givenCats)->where('status', 1)->get();
            $explores = $this->makeCollection($files);
            return view($this->activeTemplate . 'explore', compact('pageTitle', 'explores'));
        }

        if (!isset($givenCats) && isset($givenTags)) {
            $pageTitle = 'Search Result';
            $files = File::where('status', 1)->get();
            $files = $files->filter(function ($file) use ($givenTags) {
                return $this->arrayContainsTags($file->tags, $givenTags);
            });
            $explores = $this->makeCollection($files);
            return view($this->activeTemplate . 'explore', compact('pageTitle', 'explores'));
        }

        if (isset($givenCats) && isset($givenTags)) {
            $pageTitle = 'Search Result';
            $files = File::whereIn('category_id', $givenCats)->where('status', 1)->get();

            $files2 = $files->filter(function ($file) use ($givenTags) {
                return $this->arrayContainsTags($file->tags, $givenTags);
            });

            $files3 = $files->merge($files2);
            $explores = $this->makeCollection($files3);
            return view($this->activeTemplate . 'explore', compact('pageTitle', 'explores'));
        }
    }

    private function arrayContainsTags($fileTags, $searchTags)
    {
        foreach ($searchTags as $searchTag) {
            if (!in_array($searchTag, $fileTags)) {
                return false;
            }
        }
        return true;
    }

    public function makeCollection($explores)
    {
        $biggerWidth = [];
        $biggerHeight = [];

        foreach ($explores as $item) {
            if ($item->width > $item->height) {
                $biggerWidth[] = $item;
            } else {
                $biggerHeight[] = $item;
            }
        }

        $orderedExplores = [];
        $biggerWidthCount = count($biggerWidth);
        $biggerHeightCount = count($biggerHeight);

        $rowCount = max(ceil($biggerWidthCount / 2), ceil($biggerHeightCount / 2));

        for ($i = 0; $i < $rowCount; $i++) {
            if ($i % 2 === 0) {
                if (isset($biggerWidth[$i])) {
                    $orderedExplores[] = $biggerWidth[$i];
                }

                if (isset($biggerHeight[$i * 2])) {
                    $orderedExplores[] = $biggerHeight[$i * 2];
                }

                if (isset($biggerHeight[$i * 2 + 1])) {
                    $orderedExplores[] = $biggerHeight[$i * 2 + 1];
                }
            } else {
                if (isset($biggerHeight[$i * 2])) {
                    $orderedExplores[] = $biggerHeight[$i * 2];
                }

                if (isset($biggerHeight[$i * 2 + 1])) {
                    $orderedExplores[] = $biggerHeight[$i * 2 + 1];
                }

                if (isset($biggerWidth[$i])) {
                    $orderedExplores[] = $biggerWidth[$i];
                }
            }
        }

        $explores = collect($orderedExplores);

        return $explores;
    }


    public function cookieAccept()
    {
        $general = gs();
        Cookie::queue('gdpr_cookie', $general->site_name, 43200);
        return back();
    }

    public function cookiePolicy()
    {
        $pageTitle = 'Cookie Policy';
        $breadcrumbs = [
            ['title' => $pageTitle, 'url' => '']
        ];
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view($this->activeTemplate . 'cookie', compact('pageTitle', 'cookie', 'breadcrumbs'));
    }


    public function placeholderImage($size = null)
    {
        [$imgWidth, $imgHeight] = array_pad(array_map('intval', explode('x', (string) $size)), 2, 200);

        if ($imgWidth <= 0) {
            $imgWidth = 200;
        }

        if ($imgHeight <= 0) {
            $imgHeight = 200;
        }

        $text = $imgWidth . 'x' . $imgHeight;

        if (!function_exists('imagecreatetruecolor') || !function_exists('imagettfbbox')) {
            $fontSize = $this->calculateSvgFontSize($imgWidth, $imgHeight);
            $svg = "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"$imgWidth\" height=\"$imgHeight\" viewBox=\"0 0 $imgWidth $imgHeight\"><rect width=\"100%\" height=\"100%\" fill=\"#1C232F\"/><text x=\"50%\" y=\"50%\" fill=\"#FFFFFF\" font-family=\"Arial, sans-serif\" font-size=\"$fontSize\" dominant-baseline=\"middle\" text-anchor=\"middle\">$text</text></svg>";
            return response($svg)->header('Content-Type', 'image/svg+xml');
        }

        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 255, 255, 255);
        $bgFill = imagecolorallocate($image, 28, 35, 47);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX = ($imgWidth - $textWidth) / 2;
        $textY = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }


    private function calculateSvgFontSize(int $width, int $height): int
    {
        $base = min($width, $height);
        $size = (int) round($base / 5);
        return max(12, $size);
    }

    public function sendNewsLetter(Request $request)
    {
        $this->validate($request, [
            'newsletter' => 'required|email|unique:subscribers,email',
        ]);
        $subscriber = new Subscriber();
        $subscriber->email = $request->newsletter;
        $subscriber->save();
        $notify[] = ['success', 'You email has been added successfully'];
        return back()->withNotify($notify);
    }
}
