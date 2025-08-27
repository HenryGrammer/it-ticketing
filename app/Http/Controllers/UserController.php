<?php

namespace App\Http\Controllers;

use App\Company;
use App\Department;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.users');
    }
    public function list()
    {
        try {
            $users = User::with('company','department')->orderBy('id','desc')->get();

            $departments = Department::whereNull('status')->get()->map(function($item,$key) {
                return [
                    'id' => $item->id,
                    'name' => $item->code.' '.$item->name
                ];
            });

            $companies = Company::whereNull('status')->get()->map(function($item,$key) {
                return [
                    'id' =>  $item->id,
                    'name' => $item->name
                ];
            });
            
            return response()->json([
                'status' => 201,
                'message' => 'success',
                'data' => $users,
                'departments' => $departments,
                'companies' => $companies
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => 'error',
                'error' => $th->getMessage()
            ]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'email|unique:users,email'
            ]);

            $users = new User;
            $users->name = $request->name;
            $users->email = $request->email;
            $users->department_id = $request->department;
            $users->company_id = $request->company;
            $users->password = bcrypt('abc123');
            $users->save();

            return response()->json([
                'status' => 200,
                'message' => 'Successfully Saved'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => 'Failed to save the data',
                'error' => $th->getMessage()
            ]);
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
        try {
            $users = User::findOrFail($id);

            return response()->json([
                'status' => 200,
                'data' => $users
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'error' => $th->getMessage(),
                'message' => 'Failed to fetch data'
            ]);
        }

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
        try {
            $this->validate($request, [
                'email' => 'email|unique:users,email,'.$id
            ]);

            $users = User::findOrFail($id);
            $users->name = $request->name;
            $users->email = $request->email;
            $users->department_id = $request->department;
            $users->company_id = $request->company;
            $users->save();

            return response()->json([
                'status' => 200,
                'message' => 'Successfully Updated'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => 'Failed to update the data',
                'error' => $th->getMessage()
            ]);
        }
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

    public function deactivate($id)
    {
        try {
            $users = User::findOrFail($id);
            $users->status = 'Inactive';
            $users->save();

            return response()->json([
                'status' => 200,
                'message' => 'Successfully Deactivated'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => 'Failed to deactivate the data',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function activate($id)
    {
        try {
            $users = User::findOrFail($id);
            $users->status = null;
            $users->save();

            return response()->json([
                'status' => 200,
                'message' => 'Successfully Activated'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 400,
                'message' => 'Failed to activate the data',
                'error' => $th->getMessage()
            ]);
        }
    }
}
