<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessRequest;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function businessesList() {
        $model = resolve('App\ViewModels\Business\BusinessesListModel');
        $model->load();
        $businesses = $model->getbusinesses();
        return view('admin.business.businessesList', compact('businesses'));
    }

    public function getBusinessData(Request $request){
        $model = resolve('App\ViewModels\Business\BusinessesListModel');
        $businesses = $model->getbusinessesItems($request);
        return response()->json($businesses);
    }

    public function deleteBusiness(Request $request) {
        $model = resolve('App\ViewModels\Business\DeleteBusinessModel');
        $model->load($request->id);
        return redirect()->route('businesses-List');
    }

    public function archiveBusiness($id) {
        $model = resolve('App\ViewModels\Business\ArchiveBusinessModel');
        $model->load($id);
        return redirect()->back();
    }

    public function unarchiveBusiness($id) {
        $model = resolve('App\ViewModels\Business\UnarchiveBusinessModel');
        $model->load($id);
        return redirect()->back();
    }

    public function editBusiness($id) {
        $model = resolve('App\ViewModels\Business\EditBusinessModel');
        $business = $model->load($id);
        return view('admin.business.editBusiness', compact('business'));
    }

    public function updateBusiness($id, BusinessRequest $request) {
        $model = resolve('App\ViewModels\Business\UpdateBusinessModel');
        $model->load($id, $request);
        return redirect()->route('businesses-List');
    }

    public function searchBusiness(Request $request) {
        $request->validate([
            'query'=>'required'
        ]);

        $search_text = $request->input('query');
        $model = resolve('App\ViewModels\Business\SearchBusinessModel');
        $searchBusinesses = $model->load($search_text);
        return view('admin.business.searchResult',compact('searchBusinesses'));
    }
}
