<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Http\Requests\TableRequest;
use App\Models\Category;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        return view('items.index');
    }

    public function data(TableRequest $request)
    {
        $data = $request->validated();
        $query = Item::with('category');
        $count = Item::count();
        $search = $data['search']['value'] ?? '';
        if ($search !== '') {
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('item_code', 'like', "%{$search}%"));
        }
        $filtered = $query->count();

        return response()->json(['draw' => (int) ($data['draw'] ?? 0), 'recordsTotal' => $count, 'recordsFiltered' => $filtered, 'data' => $query->orderByDesc('id')->skip($data['start'] ?? 0)->take($data['length'] ?? 10)->get()->map(fn ($item) => ['id' => $item->id, 'item_code' => $item->item_code, 'name' => $item->name, 'category' => $item->category?->name, 'buy_price' => $item->buy_price, 'sell_price' => $item->sell_price, 'stock' => $item->stock, 'unit' => $item->unit])]);
    }

    public function create()
    {
        return view('items.form', ['item' => new Item, 'categories' => Category::orderBy('name')->get()]);
    }

    public function store(ItemRequest $request)
    {
        Item::create($request->validated());

        return to_route('items.index')->with('success', 'Barang ditambahkan.');
    }

    public function edit(Item $item)
    {
        return view('items.form', ['item' => $item, 'categories' => Category::orderBy('name')->get()]);
    }

    public function update(ItemRequest $request, Item $item)
    {
        $item->update($request->validated());

        return to_route('items.index')->with('success', 'Barang diperbarui.');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return to_route('items.index')->with('success', 'Barang diarsipkan.');
    }
}
