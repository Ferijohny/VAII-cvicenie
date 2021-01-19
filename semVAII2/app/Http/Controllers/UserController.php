<?php

namespace App\Http\Controllers;

use Aginev\Datagrid\Datagrid;
use App\Models\Cottage;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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

        return view('user.index');
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
        $posts = Cottage::where('owner',$user->email)->get();
        $tabula = DB::table('table_reservations')->where('customer_id',$user->id);
        $tabula->delete();
        if(count($posts)>0){
            foreach ($posts as $post)
            {
                if($post->image!=''){
                    File::delete(public_path("$post->image"));
                }
                $post->delete();
            }
        }

        $user->delete();
        return redirect()->route('user.index');
    }

    public function insertions(){
        $tabula = DB::table('users')
            ->select('users.name as customer','users.email','cottage.name')
            ->join('table_reservations','table_reservations.customer_id', '=','users.id')
            ->join('cottage','cottage.id','=','table_reservations.cottage_id')
            ->get();



        $table = DB::table('cottage')->where('owner',Auth::user()->email)->get();
        return view('user.insertions')->with('table',$table)->with('customers',$tabula);
    }






    function action(Request $request)
    {
        if($request->ajax())
        {
            $output='';
            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('users')
                    ->where('name', 'like', '%'.$query.'%')
                    ->orWhere('email', 'like', '%'.$query.'%')
                    ->get();
            }
            else{
                $data = DB::table('users')
                    ->orderBy('id', 'asc')
                    ->get();
            }
            $total_row = $data->count();
            if($total_row>0){
                foreach ($data as $row)
                {
                    if(Auth::user()->email == $row->email or Auth::user()->name == 'admin'){
                        $output .= '
                    <tr>
                        <td>
                            '.$row->name.'
                        </td>
                        <td>
                            '.$row->email.'
                        </td>
                        <td>
                            <a href="' . route('user.edit',[$row->id]).'" title="Edit" class="btn btn-sm btn-primary">Edit</a>
                            <a href="' . route('user.delete',[$row->id]).'" title="Delete" data-method="DELETE" class="btn btn-sm btn-danger" data-confirm="Are you sure?">Delete</a>
                        </td>

                    </tr>';
                    } else
                    {
                        $output .= '
                    <tr>
                        <td>
                            '.$row->name.'
                        </td>
                        <td>
                            '.$row->email.'
                        </td>
                        <td>

                        </td>

                        </tr>';
                    }
                }
            }
            else {
                $output = '
                <tr>
                    <td align="center" colspan="5">No such user found</td>
                </tr>';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row
            );

            echo json_encode($data);
        }
    }
}
