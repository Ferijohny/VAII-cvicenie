<?php

namespace App\Http\Controllers;

use App\Models\Cottage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CottageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cottage = Cottage::all();
        return view('homepage')->with('cottage',$cottage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cottage.create',[
            'action'=> route('cottage.store'),
            'method'=> 'post'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cottage = new Cottage();

        if($request->hasFile('file')){
            $image=$request->file('file');
            $image_name= 'img_cottage/'. time() . '.' . $image->extension();
            $image->move(public_path('img_cottage'),$image_name);
            $cottage->image = $image_name;
        }



        $cottage->name = $request->name;
        $cottage->desc = $request->desc;
        $cottage->locality = $request->locality;
        $cottage->num_ppl = $request->num_ppl;
        $cottage->owner = Auth::user()->email;



        $cottage->save();
        return redirect()->route('homepage')->with('cottage_message', 'cottage was successfully added');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cottage = Cottage::find($id);
        return view('cottage.cottage')->with('cottage',$cottage);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cottage $cottage)
    {
        return view('cottage.edit',[
            'action' => route('cottage.update', $cottage->id),
            'method' => 'put',
            'model' => $cottage
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cottage $cottage)
    {
        $image_name='';
        if($request->hasFile('file')){
            $image=$request->file('file');
            $image_name= 'img_cottage/'. time() . '.' . $image->extension();
            $image->move(public_path('img_cottage'),$image_name);
            if($cottage->image!=''){
                File::delete(public_path("$cottage->image"));
            }
        } else
        {
            File::delete(public_path("$cottage->image"));
        }

        $cottage->update([
            'name' => $request->name,
            'desc' => $request->desc,
            'locality' => $request->locality,
            'num_ppl' => $request->num_ppl,
            'image' => $image_name
        ]);
        return redirect()->route('homepage')->with('cottage_message', 'cottage was edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cottage $cottage)
    {
        if($cottage->image!=''){
            File::delete(public_path("$cottage->image"));
        }
        $cottage->delete();
        return redirect()->route('homepage')->with('cottage_message', 'cottage was successfully removed');;
    }


}
