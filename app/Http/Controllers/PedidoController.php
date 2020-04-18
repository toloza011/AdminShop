<?php

namespace App\Http\Controllers;

use App\Pedido;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Validator;
use App\Producto;
use Yajra\DataTables\DataTables;
use DB;


class PedidoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $estados=DB::select("select * from estados where estados.id=3 or estados.id=4", [1]);
        $id=$estados[0]->id;
        $productos=Producto::all();
        $x=$request->nombre;
        if(request()->ajax())
        {
            return datatables()->of(Pedido::orderBy('nombre','desc')->get())
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" style="font-size:15px;" class="mostrar edit btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" style="font-size:15px;" class="mostrar delete btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>';
                        return $button;
                    })
                    ->editColumn('nombre',function($data){
                        $nomestado=DB::select("SELECT DISTINCT productos.id,productos.nombre
                        from pedidos,productos where $data->id_producto=productos.id ");
                      if($nomestado[0]->id==$data->id_producto){
                        $nom=$nomestado[0]->nombre;
                        return $nom;
                      }

                    })
                    ->editColumn('estado',function($data){
                        $nomestado=DB::select("SELECT DISTINCT estados.id,estados.nombre
                         from estados,productos where $data->estado=estados.id ");
                        if($nomestado[0]->id==$data->estado){
                            $estado=$nomestado[0]->nombre;
                            return  $estado;
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Admin.Pedidos.index',compact('estados','productos'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $date=date('d-m-Y');
        $rules = array(
            'nombre'    =>  'required',
            'entrega'     =>  'required|date|after_or_equal:'.$date.'',
            'estado'     =>'required'
       );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $nombre=DB::select("SELECT productos.nombre
         from productos where $request->nombre=productos.id");
         $nom=$nombre[0]->nombre;
        $form_data = array(
            'nombre'  => $nom,
            'id_producto'        =>  $request->nombre,
            'entrega'         =>  $request->entrega,
            'estado'      => $request->estado,
         );
        Pedido::create($form_data);
        return response()->json(['success' => 'Producto agregado exitosamente']);
    }


    public function show(Request $request)
    {

    }


    public function edit($id)
    {

        if(request()->ajax())
        {

            $data = Pedido::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }


    public function update(Request $request)
    {
            $date=date('d-m-Y');
            $rules = array(
                'nombre'    =>  'required',
                'entrega'     =>  'required|date|after_or_equal:'.$date.'',
                'estado'      =>   'required',
            );
            $error = Validator::make($request->all(), $rules);
            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

        $form_data = array(
            'nombre'  => $request->nombre,
            'id_producto'       =>   $request->nombre,
            'entrega'        =>   $request->entrega,
            'estado'      => $request->estado,

        );
        Pedido::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Pedido actualizado exitosamente']);
    }

    public function destroy($id)
    {
        $data = Pedido::findOrFail($id);
        $data->delete();
    }
}
