<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Producto;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;
use DB;


class ProductoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $categorias=DB::select('select * from categorias', [1]);
        $id=$categorias[0]->id;

        if(request()->ajax())
        {
            $categorias=DB::select('select * from categorias', [1]);

            return datatables()->of(Producto::orderBy('nombre','desc')->get())

                    ->addColumn('action', function($data){

                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="mostrar edit btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="mostrar delete btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>';
                        return $button;
                    })
                    ->editColumn('estado',function($data){
                        $nomestado=DB::select("SELECT DISTINCT estados.id,estados.nombre
                         from estados where $data->estado=estados.id ");
                        if($nomestado[0]->id==$data->estado){
                            $estado=$nomestado[0]->nombre;
                            return  $estado;
                        }
                    })
                    ->editColumn('categoria',function($data){
                        $nomcategory=DB::select("SELECT DISTINCT categorias.id,categorias.nombre from categorias,productos where $data->categoria=categorias.id ");
                        if($nomcategory[0]->id==$data->categoria){
                            $categoria=$nomcategory[0]->nombre;
                            return  $categoria;
                        }
                    })

                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Admin.Productos.index',compact('categorias'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $rules = array(
            'nombre'    =>  'required',
            'stock'     =>  'required|numeric|max:999999|min:1',
            'categoria' =>   'required',
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'nombre'        =>  $request->nombre,
            'stock'         =>  $request->stock,
            'categoria'    =>   $request->categoria,
        );
        Producto::create($form_data);
        return response()->json(['success' => 'Producto agregado exitosamente']);
    }


    public function show(Request $request)
    {

    }


    public function edit($id)
    {

        if(request()->ajax())
        {

            $data = Producto::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }


    public function update(Request $request)
    {
            $rules = array(
                'nombre'    =>  'required',
                'stock'     =>  'required|numeric|max:999999|min:0',
                'categoria'    => 'required',
            );
            $error = Validator::make($request->all(), $rules);
            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
        if($request->stock==0){
           $request->estado=1;
        }else{
            $request->estado=2;
        }
        dd($request->nombre);
        $form_data = array(
            'nombre'       =>   $request->nombre,
            'stock'        =>   $request->stock,
            'estado'       =>   $request->estado,
            'categoria'    => $request->categoria,
        );
        Producto::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Producto actualizado exitosamente']);
    }

    public function destroy($id)
    {
        $data = Producto::findOrFail($id);
        $data->delete();
    }
}
