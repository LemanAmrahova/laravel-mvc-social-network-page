<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appeal;
use App\Models\Announcement;

class AppealController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index'); 
    }

    

    public function create($announcement_id)
    {
        $announcement = Announcement::findOrFail($announcement_id);
        return view('appeals', compact('announcement'));
    }

    public function store(Request $request)
    {
        $appeal = new Appeal();

        $appeal->user_id = auth()->user()->id; 
        $appeal->announcement_id = $request->input('announcement_id');

        $user = auth()->user();

        $announcementId = $request->input('announcement_id');

        $announcement = Announcement::find($announcementId);

        if ($user->id === $announcement->user_id) {
            return redirect()->back()->with('error', 'You cannot appeal your own announcement.');
        }

        $appeal->save();

        return redirect()->route('announcements')->with('success', 'Appeal created successfully!');
    }

    public function index($announcement_id)
    {
        $announcement = Announcement::findOrFail($announcement_id);
        $appeals = $announcement->appeals;

        return view('appeals', compact('announcement', 'appeals'));
    }

    public function accept($id)
    {
        $appeal = Appeal::findOrFail($id);
    
        $this->authorize('accept', $appeal);
    
    }
    
    public function decline($id)
    {
        $appeal = Appeal::findOrFail($id);
    
        $this->authorize('decline', $appeal);
    
    }
    

}
