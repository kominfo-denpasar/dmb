<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        $this->user = $this->getUser();
            
        if(!$this->user->hasRole('admin')) return redirect()->route('home-psikolog');
        else return view('backend/home');
    }

    /**
	 * Tampilkan profil. 
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function profil()
	{
		return view('backend/profil'); 
	}
}
