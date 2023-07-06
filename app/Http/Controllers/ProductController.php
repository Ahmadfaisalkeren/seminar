<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // 'image' => 'required|image|mimes: jpg, jpeg, png, svg|max:3000'
            'image' => 'required',
            'image.*' => 'mimes:png,jpg,jpeg,svg|max:10000',
        ]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('images/product'), $imageName);
        $imagePath = '/images/product/' . $imageName;

        Product::create([
            'name' => $request->name,
            'image' => $imagePath,
        ]);

        return response()->json(['success' => 'Record created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function shower()
    {
       $seminar = Seminar::all();

       return view('admin.product.index', compact('seminar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable',
            'image' => 'nullable|mimes:png,jpg,svg,jpeg|max:3000',
        ]);

        $product = Product::find($id);
        $product->name = $request->get('name');

        if ($request->hasFile('image')) {
            if (File::exists($product->image)) {
                File::delete($product->image);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('images/product'), $imageName);
            $imagePath = 'images/product/' . $imageName;

            $product->image = $imagePath;
        }

        $product->save();

        return response()->json(['success' => 'Product updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Product::find($id)->delete();

        return response()->json(['success' => 'Record deleted successfully.']);
    }
}
