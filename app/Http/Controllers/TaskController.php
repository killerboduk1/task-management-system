<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Subtask;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $filter = request()->input('sort');

        if ($filter !== null) {
            Session::put('filter', $filter);
        } else {
            if(Session::get('filter')) {
                Session::put('filter', Session::get('filter'));
            }else{
                Session::put('filter', 'desc');
            }
        }
        return view('task.home', [
            'tasks' => Task::orderBy('id', Session::get('filter'))->paginate(5),
            'sort' => Session::get('filter')
        ]);
    }

    public function addTask()
    {
        return view('task.add');
    }

    public function viewTask($id)
    {
        $task = Task::find($id);
        if($task){
            return view('task.view', [
                'task' => $task
            ]);
        }else{
            return redirect('/home');
        }
    }

    public function editTask($id)
    {
        $task = Task::find($id);
        if($task){
            return view('task.edit', [
                'task' => $task
            ]);
        }else{
            return redirect('/home');
        }
    }

    public function editTaskPost($id, Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:tasks,id,'.$id.'|max:255|min:4',
            'description' => 'required|min:4',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:10048', // Add image validation rules
        ]);

        try {
            $task = Task::find($id);

            if ($request->hasFile('image')) {
                // Delete the previous image if it exists
                if ($task->image) {
                    Storage::disk('public')->delete('images/' . $task->image);
                }

                // Upload the new image
                $imagePath = $request->file('image')->store('images', 'public');
                $task->update(['image' => $imagePath]);
            }

            $task->title = $request->title;
            $task->description = $request->description;
            $task->status = $request->status;
            $task->save();

            Session::flash('alert-success', 'Task updated!');
            return redirect()->back();
        } catch (Exception $e) {
            Session::flash('alert-warning', $e->getMessage());
            return redirect()->back();
        }
    }

    public function addTaskPost(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:tasks|max:255|min:4',
            'description' => 'required|min:4',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:10048', // Add image validation rules
        ]);

        try {
            $imagePath = "";

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
            }

            Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imagePath,
            ]);

            Session::flash('alert-success', 'Task added!');
            return redirect('home');
        } catch (Exception $e) {
            Session::flash('alert-warning', $e->getMessage());
        }
    }

    public function deleteTaskPost(Request $request)
    {
        $validated = $request->validate([
            'delete' => 'required|integer',
        ]);

        try {
            $task = Task::find($request->delete);
            $task->delete();
            Session::flash('alert-success', 'Task deleted!');
            return redirect()->back();
        } catch (Exception $e) {
            Session::flash('alert-warning', $e->getMessage());
        }
    }

    public function viewDeleteTaskPost()
    {
        return view('task.deleted', [
            'tasks' => Task::onlyTrashed()->paginate(5)
        ]);
    }

    public function deleteDeletedTask(Request $request)
    {
        $validated = $request->validate([
            'delete' => 'required|integer',
        ]);

        try {
            $task = Task::onlyTrashed()->find($request->delete);
            $task->forceDelete();
            Session::flash('alert-success', 'Task deleted permanently!');
            return redirect()->back();
        } catch (Exception $e) {
            Session::flash('alert-warning', $e->getMessage());
        }
    }

    public function restoreDeletedTask(Request $request)
    {
        $validated = $request->validate([
            'delete' => 'required|integer',
        ]);

        try {
            $task = Task::onlyTrashed()->find($request->delete);
            $task->restore();
            Session::flash('alert-success', 'Task restored!');
            return redirect()->back();
        } catch (Exception $e) {
            Session::flash('alert-warning', $e->getMessage());
        }
    }

    public function searchTask(Request $request)
    {
        $validated = $request->validate([
            'search' => 'required',
        ]);

        try {

            $task = Task::where('title', 'LIKE', '%'.$request->search.'%')->take(3)->get();
            return $task;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
