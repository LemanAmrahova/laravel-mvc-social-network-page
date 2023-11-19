<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AnnouncementController extends Controller
{
    public function create()
    {
        $companies = auth()->user()->companies;
        return view('Announcement.addannouncement', compact('companies'));
    }

    public function store(StoreAnnouncementRequest $request)
    {
        $announcement = new Announcement($request->validated());
        $announcement->save();

        return redirect()->route('announcements.index')->with('success', 'Announcement created successfully!');
    }

    public function index(){
        $announcements = Announcement::with('company', 'appeals')->get();
        return view('Announcement.announcements', compact('announcements'));
    }


}
