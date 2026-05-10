<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotline;
use Illuminate\Http\Request;

class HotlineController extends Controller
{
    public function index()
    {
        $hotlines = Hotline::orderBy('sort_order')->get();
        return view('admin.hotlines.index', compact('hotlines'));
    }

    public function create()
    {
        return view('admin.hotlines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:20',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer',
        ]);
        Hotline::create($validated);
        return redirect()->route('admin.hotlines.index')->with('success', 'Hotline created successfully.');
    }

    public function edit(Hotline $hotline)
    {
        return view('admin.hotlines.edit', compact('hotline'));
    }

    public function update(Request $request, Hotline $hotline)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:20',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer',
        ]);
        $hotline->update($validated);
        return redirect()->route('admin.hotlines.index')->with('success', 'Hotline updated.');
    }

    public function destroy(Hotline $hotline)
    {
        $hotline->delete();
        return redirect()->route('admin.hotlines.index')->with('success', 'Hotline deleted.');
    }
}