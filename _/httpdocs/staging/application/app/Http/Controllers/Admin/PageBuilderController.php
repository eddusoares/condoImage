<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Frontend;

class PageBuilderController extends Controller
{
    protected array $defaultPages = [
        ['name' => 'Home', 'slug' => '/', 'is_default' => 1],
        ['name' => 'FAQ', 'slug' => 'faq', 'is_default' => 1],
        ['name' => 'Contact', 'slug' => 'contact', 'is_default' => 1],
        ['name' => 'Neighborhood', 'slug' => 'neighborhood', 'is_default' => 1],
        ['name' => 'Neighborhood Details', 'slug' => 'neighborhood-details', 'is_default' => 1],
        ['name' => 'Condo Building', 'slug' => 'condo-building', 'is_default' => 1],
    ];

    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function managePages()
    {
        $this->ensureDefaultPages();
        $key = 'policy_pages';
        $section = @getPageSections()->$key;
        if (!$section) {
            return abort(404);
        }
        $content = Frontend::where('data_keys', $key . '.content')->orderBy('id','desc')->first();
        $elements = Frontend::where('data_keys', $key . '.element')->orderBy('id')->orderBy('id','desc')->get();
        $pdata = Page::where('tempname',$this->activeTemplate)->get();
        $pageTitle = '';
        return view('admin.frontend.builder.pages', compact('section', 'content', 'elements', 'key','pageTitle','pdata'));
    }

    public function managePagesSave(Request $request){

        $request->validate([
            'name' => 'required|min:3|string|max:40',
            'slug' => 'required|min:3|string|max:40',
        ]);

        $exist = Page::where('tempname', $this->activeTemplate)->where('slug', slug($request->slug))->count();
        if($exist != 0){
            $notify[] = ['error', 'This page already exists on your current template. Please change the slug.'];
            return back()->withNotify($notify);
        }
        $page = new Page();
        $page->tempname = $this->activeTemplate;
        $page->name = $request->name;
        $page->slug = slug($request->slug);
        $page->save();
        $notify[] = ['success', 'New page has been added successfully'];
        return back()->withNotify($notify);

    }

    public function managePagesUpdate(Request $request){

        $page = Page::where('id',$request->id)->firstOrFail();
        $request->validate([
            'name' => 'required|min:3|string|max:40',
            'slug' => 'required|min:3|string|max:40'
        ]);

        $slug = slug($request->slug);

        $exist = Page::where('tempname', $this->activeTemplate)->where('slug',$slug)->first();
        if(($exist) && $exist->slug != $page->slug){
            $notify[] = ['error', 'This page already exist on your current template. please change the slug.'];
            return back()->withNotify($notify);
        }

        $page->name = $request->name;
        $page->slug = slug($request->slug);
        $page->save();

        $notify[] = ['success', 'Page has been updated successfully'];
        return back()->withNotify($notify);

    }

    public function managePagesDelete($id){
        $page = Page::where('id',$id)->firstOrFail();
        $page->delete();
        $notify[] = ['success', 'Page has been deleted successfully'];
        return back()->withNotify($notify);
    }

    protected function ensureDefaultPages(): void
    {
        foreach ($this->defaultPages as $pageData) {
            Page::firstOrCreate(
                [
                    'tempname' => $this->activeTemplate,
                    'slug' => $pageData['slug'],
                ],
                [
                    'name'       => $pageData['name'],
                    'is_default' => $pageData['is_default'] ?? 0,
                ]
            );
        }
    }



    public function manageSection($id)
    {
        $pdata = Page::findOrFail($id);
        $pageTitle = 'Manage '.$pdata->name.' Page';
        $sections =  getPageSections(true);
        return view('admin.frontend.builder.index', compact('pageTitle','pdata','sections'));
    }



    public function manageSectionUpdate($id, Request $request)
    {
        $request->validate([
            'secs' => 'nullable|array',
        ]);

        $page = Page::findOrFail($id);
        if (!$request->secs) {
            $page->secs = null;
        }else{
            $page->secs = json_encode($request->secs);
        }
        $page->save();
        $notify[] = ['success', 'Page sections has been updated successfully'];
        return back()->withNotify($notify);
    }
}
