<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CompanyController extends Controller
{
    public function create(){
        return view('Company.addcompany');
    }

    public function store(StoreCompanyRequest $request){

        $company = new Company([
            'name' => $request->input('name'),
            'user_id' => auth()->id(),
        ]);

        $company->save();

        return redirect()->route('companies.index')->with('success', 'Company created successfully!');

    }

    public function index(){
        $companies = Company::all();
        return view('Company.companies', compact('companies'));
    }


}
