<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;

class AdminEnquiryController extends Controller
{
    /**
     * Display a listing of all enquiries.
     */
    public function index()
    {
        $enquiries = Enquiry::with('property')->latest()->paginate(15);
        
        return view('admin.enquiries.index', compact('enquiries'));
    }
}
