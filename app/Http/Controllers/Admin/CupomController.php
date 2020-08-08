<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\CouponIten;
use App\Models\Product;
class CupomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cupom.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cupom.create');
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
    public function returnList(Request $request){
        $cupom = Coupon::all();

        return datatables()->of($cupom)->addColumn('price', function($data){
            $items = CouponIten::where('cupom_id', $data->id)->get();
            $price = 0;
            foreach($items as $item){
    
              $price += ($item->price * $item->quantidade);
            }
            return "R$" . number_format($price,2,'.',',');
         })
         ->addColumn('date', function($data){
             $explodeSpace = explode(' ',$data->created_at);
             $explodeData = explode('-',$explodeSpace[0]);
             $explodePoint = explode(':', $explodeSpace[1]);
            return \Carbon\Carbon::createFromDate($explodeData[0], $explodeData[1],$explodeData[2], $explodePoint[0],$explodePoint[1],$explodePoint[2])->locale('pt-BR')->isoFormat('dddd, MMMM Do YYYY, h:mm');
         })
         ->addColumn('actions', function($data){
            return '<a class="btn btn-sucess" href="'.route('imprimir.post', ['id' => $data->id]).'" target="_blank">Imprimir</a>';
        })
         ->rawColumns(['actions'])->make();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $nota = new Coupon;
        $nota->cliente = $request->nome;
        $nota->cpf = $request->cpf;
        $nota->endereco = $request->endereco;
        $nota->save();
        $itens = json_decode($request->json);
        foreach($itens as $item){
            $product = Product::find($item->id);
            $notaIten = new CouponIten;
            $notaIten->cupom_id = $nota->id;
            $notaIten->product_id = $item->id;
            $notaIten->description = $item->info;
            $notaIten->quantidade = $item->quantidade;
           
            if($this->tofloat($item->price) != $this->tofloat($product->price)){
                $notaIten->price = $this->tofloat($item->price);
            }else{
                $notaIten->price =  $this->tofloat($product->price);
            }
            $notaIten->save();

        }

        return redirect()->route('imprimir.post', ['id' => $nota->id]);
    }

    public function imprimir(Request $request){
        
        $nota = Coupon::find($request->id);
        $itens = CouponIten::where('cupom_id',$request->id)->get();
        $products = [];
        foreach($itens as $item){
            $product = Product::find($item->product_id);
            $product->itemDescription = $item->description;
            $product->quantidade = $item->quantidade;
            $product->priceEdit = $item->price;
            array_push($products, $product->toArray());
        }
        return view('nota.imprimir', compact('nota','products'));
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
