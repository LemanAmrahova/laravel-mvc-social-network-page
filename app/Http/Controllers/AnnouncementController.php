<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Announcement;
use  App\Models\Company;

class AnnouncementController extends Controller
{
    public function create()
    {
        $companies = Company::all();
        return view('addannouncement', compact('companies'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|max:255',
        ]);

        $announcement = new Announcement($validatedData);
        $announcement->save();

        return redirect()->route('announcements')->with('success', 'Announcement created successfully!');
    }

    public function index(){
        $announcements = Announcement::with('company', 'appeals')->get();
        return view('announcements', compact('announcements'));
    }


}
