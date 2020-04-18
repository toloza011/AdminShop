<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if(request()->ajax())
        {
            return datatables()->of(User::orderBy('nombre','desc')->get())
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Admin.User.index');
    }


    public function store(Request $request)
    {
        $rules = array(
            'nombre'    =>  'required',
            'apellido'     =>  'required',
            'password'     =>  'max:16|min:8|alpha_num',
            'fecha_nac'     =>  'required|date',
            'email'     =>  'required|email',
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'nombre'        =>  $request->nombre,
            'apellido'        =>  $request->apellido,
            'fecha_nac'        =>  $request->fecha_nac,
            'email'         =>  $request->email,
            'password' => '1234',
        );
        User::create($form_data);
        return response()->json(['success' => 'Usuario agregado exitosamente']);
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
        if(request()->ajax())
        {
            $data = User::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = array(
            'nombre'    =>  'required',
            'apellido'     =>  'required',
            'fecha_nac'     =>  'required|date',
            'email'     =>  'required|email|email',
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
        'nombre'       =>   $request->nombre,
        'apellido'        =>   $request->apellido,
        'fecha_nac'        =>   $request->fecha_nac,
        'email'        =>   $request->email,
      );
      User::whereId($request->hidden_id)->update($form_data);

    return response()->json(['success' => 'Usuario actualizado exitosamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'Usuario eliminado exitosamente']);

    }
}
