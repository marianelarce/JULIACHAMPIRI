<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Http\Requests\ProductoFormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function _construct()
    {

    }
    public function index(Request $request)
    {
        //
        $texto=trim($request->get('texto'));
        $productos=DB::table('producto as a')
        ->join('categoria as c', 'a.id_categoria','=','c.id_categoria')
        ->select('a.id_producto','a.nombre','a.codigo','a.stock','c.categoria as categoria','a.descripcion','a.imagen','a.estado')
        ->where('a.nombre','LIKE','%'.$texto.'%')
        ->orwhere('a.codigo','LIKE','%'.$texto.'%')
        ->orderBy('id_producto','desc')
        ->paginate(10);
        return view('almacen.producto.index',compact('productos','texto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categorias=DB::table('categoria')->where('estatus','=','1')->get();
        return view("almacen.producto.create",["categorias"=>$categorias]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductoFormRequest $request)
    {
        //
        $producto=new Producto;
        $producto->id_categoria=$request->input('id_categoria');
        $producto->codigo=$request->input('codigo');
        $producto->nombre=$request->input('nombre');
        $producto->stock=$request->input('stock');
        $producto->descripcion=$request->input('descripcion');
        $producto->estado='activo';
        if ($request->hasFile("imagen")) {
            $imagen=$request->file('imagen');
            $nombreimagen=Str::slug($request->nombre).".".$imagen->guessExtension();
            $ruta= public_path("imagenes/producto/");
            copy($imagen->getRealPath(),$ruta.$nombreimagen);

            $producto->imagen=$nombreimagen;
        }
        $producto->save();
        return redirect()->route('producto.index');
       

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $producto=Producto::findOrFail($id);
        $categorias=DB::table('categoria')->where('estatus','=','1')->get();
        return view("almacen.producto.edit",["producto"=>$producto,'categorias'=>$categorias]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $producto=Producto::findOrFail($id);
        $producto->id_categoria=$request->input('id_categoria');
        $producto->codigo=$request->input('codigo');
        $producto->nombre=$request->input('nombre');
        $producto->stock=$request->input('stock');
        $producto->descripcion=$request->input('descripcion');
        if ($request->hasFile("imagen")) {
            $imagen=$request->file('imagen');
            $nombreimagen=Str::slug($request->nombre).".".$imagen->guessExtension();
            $ruta= public_path("/imagenes/producto/");
            copy($imagen->getRealPath(),$ruta.$nombreimagen);
            $producto->imagen=$nombreimagen;
        }
        $producto->update();
        return redirect()->route('producto.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $producto=Producto::findOrFail($id);
        $producto->estado='Inactivo';
        $producto->update();
        return redirect()->route('producto.index');
    }
    }

