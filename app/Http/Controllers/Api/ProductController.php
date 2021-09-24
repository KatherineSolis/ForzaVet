<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Laravue\JsonResponse;
use App\Laravue\Models\Product;
use App\Laravue\Models\Supplier;
use App\Laravue\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $searchParams = $request->all();
        $name = Arr::get($searchParams, 'name', '');

        $products = Product::all()->toArray();

        $suppliers = Supplier::where('status', '=', '1')
            ->get()
            ->toArray();
        $category = Category::where('status', '=', '1')
            ->get()
            ->toArray();

        if (!empty($name)) {
            $products = Product::where('first_name', 'LIKE', '%' . $name . '%')
                ->OrWhere('last_name', 'LIKE', '%' . $name . '%')
                ->get()
                ->toArray();
        }
        return response()->json(new JsonResponse(['items' => $products, 'total' => count($products), 'suppliers' => $suppliers, 'category' => $category]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd(DIRECTORY_SEPARATOR);
        $file = $request->image;
        $a = DIRECTORY_SEPARATOR;
        $b =  '/';
        $file = str_replace($a, $b, $file);

        //dd($request);
        $products = new Product([
            'suppliers_id' => $request->suppliers_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'buy_price' => $request->buy_price,
            'sale_price' => $request->sale_price,
            'units' => $request->units,
            'stock' => $request->stock,
            'expiry_date' => $request->expiry_date,
            'image' => $request->image,
        ]);

        $products->save();
        $data = ['id' => $products->toArray()['id']];

        return response()->json(new JsonResponse(['items' => $data, 'total' => 15]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $supplier = Product::where('id', $id)
            ->update([
                'document_type' => $request->document_type,
                'document_number' => $request->document_number,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'direction' => $request->direction,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => $request->status,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
