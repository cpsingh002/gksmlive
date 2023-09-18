<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\AttributeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = DB::table('teams')->get();
        return view('team.team', ['attributes' => $attributes]);
    }
    public function addTeam()
    {
        return view('team.add_team');
    }

    public function storeTeam(Request $request)
    {

        // dd($request);
        $validatedData = $request->validate([
            'team_name' => 'required|unique:teams',
            'team_description' => 'required'
        ]);

        $save = new Team;
        
        $save->team_name = $request->team_name;
        $save->team_description = $request->team_description;
        $save->status=1;

        $save->public_id = Str::random(6);


        $save->save();

        return redirect('/teams')->with('status', 'Team added successfully !!');
    }
    

    public function destroyTeam($id)
    {
        $deleted = DB::table('teams')->where('public_id', $id)->delete();
        // $update = DB::table('tbl_attributes')->where('public_id', $id)->limit(1)->update(['status' => 2]);
        if ($deleted) {
            return redirect('/teams')->with('status', 'Team Deleted Successfully!!');
        }
    }

    public function getTeam($id)
    {
        $attribute = DB::table('teams')->where('public_id', $id)->first();
        // dd($production->production_name);
        return view('team.edit_team', ['attribute' => $attribute]);
    }

    public function updateTeam(Request $request)
    {

        //  dd($request);
        // if($request->super_team == 1){
        //     $super=1;
        // }else{
        //     $super=0;
        // }
        $status = DB::table('teams')
            ->where('public_id', $request->attribute_id)
            ->update(['team_name' => $request->team_name, 'team_description' => $request->team_description]);
        return redirect('/teams');
    }

    public function changestatus(Request $request,$status,$id){
        $status = DB::table('teams')
            ->where('public_id', $id)
            ->update(['status' => $status]);
       // $request->session()->flash('message','Attribute status updated');
        return redirect('/teams')->with('status', 'Team status updated!!');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
       public function changesuperteam(Request $request,$status,$id){
        $status = DB::table('teams')
            ->where('public_id', $id)
            ->update(['super_team' => $status]);
       // $request->session()->flash('message','Attribute status updated');
        return redirect('/teams')->with('status', 'Super Team status updated!!');
    }
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function viewTeam(Request $request)
    {
        $teamdata = DB::table('users')->where('team', $request->id)->where('status',1)->get();
        $team = DB::table('teams')->where('public_id', $request->id)->first();
       // dd($status);
        return view('team.view_team', ['teamdata' => $teamdata,'teams'=>$team]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        //
    }
}
