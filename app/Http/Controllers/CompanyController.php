<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;

class CompanyController extends Controller
{
    public function show(){
        return view('addcompany');
    }

    public function store(Request $request){

        $company = new Company([
            'name' => $request->input('name'),
            'user_id' => auth()->id(),
        ]);

        $company->save();

        return redirect()->route('companies')->with('success', 'Company created successfully!');

    }

    public function index(){
        $companies = Company::all();
        return view('companies', compact('companies'));
    }


}
