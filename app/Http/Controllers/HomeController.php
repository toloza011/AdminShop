<?php

namespace App\Http\Controllers;
use App\Producto;
use App\Categoria;
use App\User;
use App\Pedido;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function home()
    {
        $productos=Producto::paginate(10);
        $usuarios=User::paginate(10);
        $categorias=Categoria::paginate(10);
        $pedidos=Pedido::paginate(10);

        return view('home',compact('pedidos','productos','usuarios','categorias'));
    }
}
