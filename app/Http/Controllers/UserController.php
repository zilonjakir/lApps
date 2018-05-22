<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use commonHelper;
use App\Library\Services\DemoOne;
use DB;
use URL;
use App\User;

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
        //commonHelper::debug($users,1);
        //return view('pages.userlist')->with('users',$users);
        return view('pages.userlist');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=NULL)
    {
        //commonHelper::debug($id,1);
        $data['title'] = 'User Manage';
        if($id)
        {
            $data['userInfo'] = User::where('id',$id)
                    ->get()->first();
//            commonHelper::debug($data['userInfo']->all(),1);
        }
        return view('pages.usermanage',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = $request->except('_token','id');
        $id = $request->only('id');
//        commonHelper::debug($id['id'],1);
        if($id['id'])
        {
            User::where('id',$id)->update($post);
            return redirect('adduser/'.$id['id'])->with('success', 'Information has been Updated');
        }
        else
        {
            DB::table('users')->insert($post);
            return redirect('adduser')->with('success', 'Information has been added');
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
        User::where('id',$id)->delete();
        return redirect('userlist')->with('success', 'Information has been Deleted');
    }
    
    public function getServerUserList(Request $request)
    {        
        $sql = "select id,name,email from users";
        $where = '1';
        $data['sql'] = $sql;
        $data['where'] = $where;
        $field = ['id','name','email'];
        $search = ['users.name','users.email'];
        $id = 'id';
        $table_data = commonHelper::generateDataTables($data,$field,$search,$id);
        //commonHelper::debug($table_data['data'][0],1);
        foreach ($table_data['data'] as $key=> $data){
            $action = '<a href="'.URL::to('adduser/'.$data[0]).'"><i class="fa fa-pencil"></i></a> ';
            $action .= '<a style="color:red;" href="'.URL::to('deleteUser/'.$data[0]).'"><i class="fa fa-remove"></i></a>';
            $table_data['data'][$key][0] = !empty($data[1]) ? $data[1] : '';
            $table_data['data'][$key][1] = !empty($data[2]) ? $data[2] : '';
            $table_data['data'][$key][2] = $action;
        }
        echo json_encode($table_data);
    }
    
//    public function testService(DemoOne $customServiceInstance)
//    {
//        echo $customServiceInstance->doSomethingUseful();
//    }
}
