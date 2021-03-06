<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kennel;
use Auth;
use App\User;
use App\Traits\UserActivityLog;

class KennelController extends Controller
{
    use UserActivityLog;
    public $module_name = "kennel";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
         $this->middleware('permission:kennel-list');
         $this->middleware('permission:kennel-create', ['only' => ['create','store']]);
         $this->middleware('permission:kennel-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:kennel-delete', ['only' => ['update_status']]);
    }

    public function index()
    {
        $user = Auth()->user();
        $kennels = Kennel::where('is_deleted','=','0')->orderBy('id', 'DESC')->paginate('50');
        $this->saveActivity('Kennel List',$this->module_name);

        return view('kennels.index',compact('kennels','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $owners = User::select('id','first_name','email','membership_no')
                        ->where('status','=','Active')
                        ->get();
        return view('kennels.create',compact('user','owners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'kennel_name' => 'required',
            'owner_id' => 'required'
        ]);

        $owner_ID = $request->owner_id;

        if($owner_ID != 0){

            Kennel::create($request->all());
            $this->saveActivity('Kennel Save',$this->module_name,"Create new record  ".$request->input('kennel_name')." ");

            return redirect()->route('Kennels.index')
                        ->with('success','Record Created.');

        }

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
        $user = Auth::user();
        $kennel = Kennel::findorFail($id);
        $owners = User::select('id','first_name','email','membership_no')
                        ->where('status','=','Active')
                        ->get();
        return view('kennels.edit',compact('kennel','user','owners'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kennel = Kennel::findOrFail($id);
        $kennel->update($request->all());

        $this->saveActivity('Update Record',$this->module_name);
        return redirect()->route('Kennels.index')
            ->with('success','Record Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $kennel = Kennel::findOrFail($id);
        // $kennel->delete();
        // return redirect()->route('Kennels.index')
        //     ->with('danger','Record Removed');
    }
    public function update_status($id)
    {
      $kennel = Kennel::findOrFail($id);
      $kennel->is_deleted = 1;
      $kennel->update();
      $this->saveActivity('Kennel Delete',$this->module_name);
    }
}
