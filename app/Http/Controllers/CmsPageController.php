<?php

namespace App\Http\Controllers;

use App\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CmsPageController extends Controller
{
    public function allCmsPages() {
        
        
        $objCMS = CmsPage::Where('title_english', 'like', '%' . Input::get('filter') . '%') 
        
        ->orwhere('page_html_content', 'like', '%' . Input::get('filter') . '%')
        ->orwhere('slug', 'like', '%' . Input::get('filter') . '%')
        ->paginate(50);
      
        return $objCMS;
    }


    public function getPageSlug($pageSlug) {
        return CmsPage::Where('slug', '=', $pageSlug)->get();
    }

    public function addNewCmsPage(Request $request) {

        $req = $request->data;
        $keyword_array = array();
        $cms_pages = new CmsPage;

        try {           
            $cms_pages->title_english = $req['title_english'];
            $cms_pages->slug = $req['slug'];
            $cms_pages->page_html_content = $req['page_html_content'];
            $cms_pages->save();
            
            $ResponseCode = 1;
            $ResponseMessage = __('CMS updated successfully');
            $param = 'matches';
            $values = new \stdClass();

            return response()->json(['ResponseHeader' => ['ResponseCode' => 1, 'ResponseMessage' => 'CMS updated successfully']], 200);


        } catch(\Exception $e) {
            
            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => $e->getMessage(),]
                ], 200);

        }

    }

    public function editCmsPageByPageID($id) {

        try{

            $objPage = CmsPage::findOrFail($id);
            
            return  $objPage;

        } catch(\Exception $e) {

            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => $e->getMessage(),
                ]
                    ], 200);
         }

    }

    public function updateCmsPage(Request $request) {
        
        $req = $request->data;
        $keyword_array = array();
        $cms_pages = CmsPage::find($req['Id']);
        
        try {
            
            $cms_pages->title_english = $req['title_english'];
            $cms_pages->slug = $req['slug'];
            $cms_pages->page_html_content = $req['page_html_content'];
            
            $cms_pages->save();

            return response()->json([
                       'ResponseHeader' => [
                           'ResponseCode' => 1,
                           'ResponseMessage' => 'CMS page updated successfully',
                       ]
                    ], 200);

        } catch(\Exception $e) {

            return response()->json([
                'ResponseHeader' => [
                    'ResponseCode' => 0,
                    'ResponseMessage' => $e->getMessage(),
                ]
            ], 200);
         
        }
    }

    public function deleteCmsPageByID($id) {

        $cms = CmsPage::findOrFail($id);
        $cms->delete();
    
        return $cms = CmsPage::all();
    
    }
}
