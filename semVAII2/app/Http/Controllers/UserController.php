<?php

namespace App\Http\Controllers;

use Aginev\Datagrid\Datagrid;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        $user = User::paginate(25);
        $grid = new Datagrid($user, $request->get('f',[]));
        $grid->setColumn('name','Full name')
            ->setColumn('email', 'email address')
        ->setActionColumn(['wrapper' => function($value,$row){
            return '<a href="' . route('user.edit',[$row->id]).'" title="Edit" class="btn btn-sm btn-primary">Edit</a>
            <a href="' . route('user.delete',[$row->id]).'" title="Delete" data-method="DELETE" class="btn btn-sm btn-danger" data-confirm="Are you sure?">Delete</a>';
        }]);
        return view('user.index',['grid'=>$grid]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('user.create',[
            'action'=> route('user.store'),
            'method'=> 'post'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:8|confirmed'
        ]);
        $user = User::create($request->all());
        $user->save();
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(User $user)
    {
        $user->password = "";
        return view('user.edit',[
            'action' => route('user.update', $user->id),
            'method' => 'put',
            'model' => $user
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
           'name'=>'required',
            'email'=>'required|email|unique:users,email,' .$user->id,
            'password'=>'required|min:8|confirmed'
        ]);

        $user->update($request->all());
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index');
    }
}
