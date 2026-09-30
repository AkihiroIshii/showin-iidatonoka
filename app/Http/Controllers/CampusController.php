<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Campus;

class CampusController extends Controller
{
    public function edit() {
        // 塾長の校舎（campus）を取得してビューに渡す。
        // $campus_id = Auth::user()->campus_id;
        $campus = Campus::query()
            ->where('id', Auth::user()->campus_id)
            ->first();
        return view('campus.edit', compact('campus'));
    }

    public function update(Request $request, Campus $campus) {
        $validated = $request->validate([
            'setting_code' => 'required',
        ]);
        $campus->update($validated);
        $request->session()->flash('message', '更新しました');
        return back();
    }
}
