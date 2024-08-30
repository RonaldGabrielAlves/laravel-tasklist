<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TasksController extends Controller
{
    public function index(Request $request){
        $query = Task::where('user_id', Auth::id());

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('task', 'like', '%' . $search . '%')
                ->orWhere('edited_at', 'like', '%' . $search . '%')
                ->orWhere('deadline', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        $tasks = $query->paginate(10);
        return view('tasks.tasks', ['tasks' => $tasks]);
    }
    public function create(){
        return view('tasks.create_edit');
    }
    public function store(Request $request){
        //dd($request);
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['edited_at'] = now();
        Task::create($data);
        return redirect()->route('tasks-index');
    }
    public function edit($id){
        $task = Task::where('id',$id)->first();
        if($task){
            return view('tasks.create_edit', ['task' => $task]);
        }
        else{
            return redirect()->route('tasks-index');
        }
    }
    public function update(Request $request, $id){
        $data = [
            'task' => $request->task,
            'status' => $request->status,
            'deadline' => $request->deadline,
            'edited_at' => now(),
        ];
        Task::where('id',$id)->update($data);
        return redirect()->route('tasks-index');
    }
    public function complete($id){
        $task = Task::where('id', $id)->first();
        if ($task) {
            $task->status = 1;
            $task->save();
            return response()->json(['success' => true, 'message' => 'Tarefa concluída com sucesso.']);
        }
        return response()->json(['success' => false, 'message' => 'Erro ao completar a tarefa.'], 500);
    }
    public function destroy($id){
        Task::where('id',$id)->delete();
        return redirect()->route('tasks-index');
    }
}
