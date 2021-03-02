<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;



class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $user = \Auth::user();    
        $tasks = Task::all();
        return view("tasks.index",[
                "tasks" => $tasks,

        ]);
            
            
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;
        
        return view("tasks.create", [
            "task" => $task,
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
        $request->validate([
            "status" => "required|max:10",
            "content" => "required|max:255",
            ]);
            
        $user = \Auth::user();
        
        $task = new Task;
        $task->user_id = $user->id;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect("/");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        
        return view("tasks.show", [
            "task" => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = \Auth::user();
        $task = Task::findOrFail($id);
        if($task->user_id == $user->id){
        $task = Task::findOrFail($id);
        
        return view("tasks.edit", [
            "task" => $task,
        ]);
            
        }
        
        else{
            return redirect("/");
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
        
        $request->validate([
            "status" => "required|max:10",
            "content" => "required|max:255",
            ]);
        
        $task = Task::findOrFail($id);
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect("/");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = \Auth::user();
        $task = Task::findOrFail($id);
        if($task->user_id == $user->id){
            $task->delete();
            
        }
        
        
        return redirect("/");
    }
}