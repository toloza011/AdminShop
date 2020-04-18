<?php

namespace App\Http\Controllers;

use App\Categoria;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;



class CategoriaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if(request()->ajax())
        {
            return datatables()->of(Categoria::orderBy('nombre','desc')->get())
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="mostrar edit btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="mostrar delete btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Admin.Categorias.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $rules = array(
            'nombre'    =>  'required',
            'descripcion'     =>  'required|max:250',
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'nombre'        =>  $request->nombre,
            'descripcion'         =>  $request->descripcion,
        );
        Categoria::create($form_data);
        return response()->json(['success' => 'Categoria agregada exitosamente']);
    }


    public function show(Request $request)
    {

    }


    public function edit($id)
    {

        if(request()->ajax())
        {

            $data = Categoria::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }


    public function update(Request $request)
    {
            $rules = array(
                'nombre'    =>  'required',
                'descripcion'     =>  'required|max:250',
            );
            $error = Validator::make($request->all(), $rules);
            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

        $form_data = array(
            'nombre'       =>   $request->nombre,
            'descripcion'        =>   $request->descripcion,
        );
        Categoria::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Categoria actualizada exitosamente']);
    }

    public function destroy($id)
    {
        $data = Categoria::findOrFail($id);
        $data->delete();
    }
}
