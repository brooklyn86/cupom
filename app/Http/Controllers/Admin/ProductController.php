<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.list');

    }

    public function edit(Request $request)
    {
        $product = Product::find($request->id);
        if($product)
            return view('products.edit',compact('product'));
        return redirect()->back();

    }

    public function returnProductList(Request $request){
        $product = Product::all();
        return datatables()->of($product)->addColumn('price', function($data){
           
            return "R$ ".number_format($data->price,2,'.',',');
         })->addColumn('actions', function($data){
            return '<a class="btn btn-sucess" href="'.route('product.edit', ['id' => $data->id]).'" target="_blank">Editar</a>';
        })
         ->rawColumns(['actions'])->make();
    }

    
    public function autocompleteproduct(Request $request){
        $query = $request->all();
        $products = Product::where('nome', 'like','%'. $query['query'].'%')->get();
        $aux = 0;
        if ($products) {
            $suggestions = array();
            foreach ($products as $key) {
                $suggestions[$aux]['dados'] = $key;
                $suggestions[$aux]['value'] = $key->nome;
                $suggestions[$aux]['data'] = $key->id;
                $aux++;
            }
            $response = array(
                'suggestions' => $suggestions
            );
            return json_encode($response);
        }
        return ['suggestions' => $obj];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }
    function tofloat($num) {
        $dotPos = strrpos($num, '.');
        $commaPos = strrpos($num, ',');
        $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
            ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
      
        if (!$sep) {
            return floatval(preg_replace("/[^0-9]/", "", $num));
        }
    
        return floatval(
            preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
            preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
        );
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;
        $product->nome = $request->name;
        $product->price = $this->tofloat($request->price);
        $product->description = $request->description;
        $response = $product->save();
        if($response)
            return redirect()->back()->with('success', 'Cadastrado');
        return redirect()->back()->with('error', 'Falha ao atualizar');
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       
        $product = Product::find($request->id);
        if($product){
            $product->nome = $request->name;
            $product->price = $this->tofloat($request->price);
            $product->description = $request->description;
            $response = $product->save();
            if($response)
                return redirect()->back()->with('success', 'Atualizado');
            return redirect()->back()->with('error', 'Falha ao atualizar');

        }
        return redirect()->back()->with('error', 'Falha ao atualizar');
            

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
