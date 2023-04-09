<?php

namespace App\Http\Controllers\Admin;

use Larapen\Admin\app\Http\Controllers\PanelController;
use Illuminate\Http\Request;
use App\Helpers\Date;
use App\Models\MetaTagsUrl;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Validator;

class MetaTagUrlController extends PanelController
{
    //
    public function index()
    {
       $data= [];	
	   return appView('metatag_url.metatag_url_list', $data);
    }
    
     public function ajax_meta_tag_url_list(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input("start");
        $rowperpage = $request->input("length");
        $columnIndex_arr = $request->input('order');
        $columnName_arr = $request->input('columns');
        $order_arr = $request->input('order');
        $search_arr = $request->input('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $OrderbyArr=array(0=>'meta_tags_urls.id', 1=>'meta_tags_urls.url', 2=>'meta_tags_urls.title', 3=>'meta_tags_urls.created_at', 4=>'meta_tags_urls.status');
        $orderby= $OrderbyArr[$columnName];
        // Total records
        $totalRecords = DB::table('meta_tags_urls')
                        ->select(DB::raw('count(*) as allcount'))
                        ->get();        

        $totalRecordswithFilter = DB::table('meta_tags_urls')
                                ->select(DB::raw('count(*) as allcount'))
                                ->where(function ($q) use ($searchValue) {
                                    return $q->where('meta_tags_urls.url', 'like', '%' . $searchValue . '%')
                                            ->orWhere('meta_tags_urls.title', 'like', '%' . $searchValue . '%')
                                            ->orWhere('meta_tags_urls.created_at', 'like', '%' . $searchValue . '%'); 
                                 })
                                ->get();

        // Get records, also we have included search filter as well
        //DB::enableQueryLog();
        $records =  DB::table('meta_tags_urls')
                    ->select('*')
                    ->where(function ($q) use ($searchValue) {
                        return $q->where('meta_tags_urls.url', 'like', '%' . $searchValue . '%')
                                ->orWhere('meta_tags_urls.title', 'like', '%' . $searchValue . '%')
                                ->orWhere('meta_tags_urls.created_at', 'like', '%' . $searchValue . '%'); 
                     })                  
                    ->skip($start)
                    ->take($rowperpage)
                    ->orderBy($orderby, $columnSortOrder)
                    ->get();
        /*$query = DB::getQueryLog();
        dd($query);*/
        
        $data_arr = array();
        $slno=1;
        foreach ($records as $record) {
            $walletDocId= $record->id;
            
            if($record->active==1){
                $status='<div id="status_id_'.$walletDocId.'"><span class="badge badge-info">Active</span></div>';
            } elseif($record->active==0){
                $status='<div id="status_id_'.$walletDocId.'"><span class="badge badge-danger">Deactive</span></div>';
            } 
            
            $action= '<a href="'.admin_url('/meta_tag_url/edit/'.$walletDocId).'" class="btn btn-xs btn-primary"><i class="far fa-edit"></i> Edit</a> <a href="#" class="btn btn-xs btn-danger deletetag_'.$walletDocId.' clckdelete_metatag" data-delete="'.$walletDocId.'"><i class="far fa-trash-alt"></i> Delete</a>';
            
            $data_arr[] = array(
                "<input type='checkbox' class='deletetag_".$walletDocId." deletetag_chkbox' value='".$walletDocId."'/>",
                $record->url,
                $record->title,
                $record->created_at,
                $status,                
                $action,
            );
            $slno++;
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords[0]->allcount,
            "iTotalDisplayRecords" => $totalRecordswithFilter[0]->allcount,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }
    
    public function create()
    {
        $data= [];	
		return appView('metatag_url.create_meta_tag_url', $data);
    }
    
    public function insert(Request $request)
    {
        $data= [];
        $this->validate($request, [
          'url' => 'required',
          'title' => 'required',
          'description' => 'required',
          'keywords' => 'required'
       ]);
        $url = $request->input('url');
        $title = $request->input('title'); 
        $description = $request->input('description'); 
        $keywords = $request->input('keywords'); 
        $active = $request->input('active');
        
        $obj = new MetaTagsUrl;
        $obj->url = $url;
        $obj->title = $title;
        $obj->description = $description;
        $obj->keywords = $keywords;
        $obj->active = $active;
        $obj->save();

        $request->session()->flash('success_message', 'Successfully saved!');
        return redirect()->back();
    }
    
    public function edit_meta_tag_url($editid)
    {   
        //dd($editid);
        $data= [];
        $metaTags = MetaTagsUrl::where('id', $editid)->get();
        $data["metaDataDetails"]= $metaTags;
		return appView('metatag_url.metatag_url_edit', $data);
    }
    
    public function update(Request $request)
    {
        $data= [];
        $this->validate($request, [
          'url' => 'required',
          'title' => 'required',
          'description' => 'required',
          'keywords' => 'required',
          'editid' => 'required'
       ]);
        $url = $request->input('url');
        $title = $request->input('title'); 
        $description = $request->input('description'); 
        $keywords = $request->input('keywords'); 
        $active = $request->input('active');
        $editid = $request->input('editid');
        
        $obj = MetaTagsUrl::find($editid);
        $obj->url = $url;
        $obj->title = $title;
        $obj->description = $description;
        $obj->keywords = $keywords;
        $obj->active = $active;
        $obj->save();

        $request->session()->flash('success_message', 'Successfully saved!');
        return redirect()->back();
    }
    
    public function deletemetatag(Request $request)
    {
        $deleteids = $request->input('deleteids');
        if(!empty($deleteids)){
            foreach($deleteids as $deleteid){
                $obj = MetaTagsUrl::find($deleteid);
                $obj->delete();
            }
            echo "success";
        }
    }
    
}
