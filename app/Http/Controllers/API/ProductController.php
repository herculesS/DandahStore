<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Intervention\Image\Facades\Image;
use App\Product;
use Exception;

class ProductController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return new JsonResponse(Product::with('category')->get(), 200);
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 
        $this->validateProduct($request);
        $name = time() . '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
        Image::make($request->image)->save(public_path("images/products/" . $name));
        $request->merge(['image' => $name]);

        Product::create($request->all());
        return new JsonResponse(null, 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $product = Product::find($id)->with('category')->get();
            return new JsonResponse($product, 200);
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * 
     */

    private function validateProduct(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "image" => "required",
            "category_id" => "required|numeric|min:1",
            "quantity" => "required|numeric|min:1"
        ], [
            "name.required" => __("messages.nameRequired"),
            "quantity.required" => __("messages.quantityRequired"),
            "quantity.min" => __("messages.quantityMin")
        ]);
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
        $this->validateProduct($request);
        $product = Product::find($id)->get();
        $currentProductImage = $product[0]->image;
        if ($currentProductImage != $request->image) {
            $name = time() . '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
            Image::make($request->image)->save(public_path("images/products/" . $name));
            $request->merge(['image' => $name]);

            $oldProductImage = public_path("images/products/") . $currentProductImage;
            if (file_exists($oldProductImage)) {
                @unlink($oldProductImage);
            }
        }
        Product::find($id)->update($request->all());
        return new JsonResponse($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $response = Product::find($id)->delete();
            return new JsonResponse($response, 200);
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 500);
        }
    }
}
