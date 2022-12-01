<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index()
    {
        return response(FAQ::all());
    }

    public function store(Request $request)
    {
        return response(FAQ::query()->create([
            'title' => $request->get('title'),
            'description' => $request->get('description')
        ]));
    }

    public function update(Request $request, FAQ $FAQ)
    {
        return response($FAQ->update([
            'title' => $request->get('title'),
            'description' => $request->get('description')
        ]));
    }

    public function destroy(FAQ $FAQ)
    {
        return response($FAQ->delete());
    }
}
