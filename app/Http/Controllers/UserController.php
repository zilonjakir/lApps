<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Helper;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users = DB::table('users')->select('name', 'email as user_email')->get();
        //Helper::debug($users,1);
        //return view('pages.userlist')->with('users',$users);
        return view('pages.userlist');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.usermanage');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Helper::debug($request->except('_token'),1);
        DB::table('users')->insert($request->except('_token'));
        return redirect('adduser')->with('success', 'Information has been added');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function getServerUserList(Request $request)
    {
        //echo 'hello';
        //Helper::debug($request->input('_token'),1);
        $sql = "select * from users";
        $where = '1';
        $data['sql'] = $sql;
        $data['where'] = $where;
        $field = ['name','email'];
        $search = ['users.name','users.email'];
        $id = 'id';
        $table_data = Helper::generateDataTables($data,$field,$search,$id);
        
        foreach ($table_data['data'] as $key=> $data){
            $table_data['data'][$key][0] = !empty($data[1]) ? $data[1] : '';
            $table_data['data'][$key][1] = !empty($data[2]) ? $data[2] : '';
        }
        echo json_encode($table_data);  // send data as json format
    }
}
