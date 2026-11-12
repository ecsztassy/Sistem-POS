<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSettingRequest;
use App\Models\StoreSetting;

class StoreSettingController extends Controller
{
    public function edit()
    {
        return view('settings.edit', ['store' => StoreSetting::first() ?? new StoreSetting]);
    }

    public function update(StoreSettingRequest $request)
    {
        StoreSetting::updateOrCreate(['id' => 1], $request->validated());

        return back()->with('success', 'Pengaturan toko disimpan.');
    }
}
