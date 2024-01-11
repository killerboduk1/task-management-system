<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Subtask;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SubTaskController extends Controller
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

    public function addSubTask($id)
    {
        $task = Task::find($id);
        if($task){
            return view('task.subtask.add', [
                'task' => $task
            ]);
        }else{
            return redirect('/home');
        }
    }

    public function addSubTaskPost(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:tasks|max:255|min:4',
            'description' => 'required|min:4',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:10048', // Add image validation rules
            'parent' => 'required|integer'
        ]);

        try {
            $imagePath = "";

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
            }

            Subtask::create([
                'task_id' => $request->parent,
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imagePath,
            ]);

            Session::flash('alert-success', 'Sub Task added!');
            return redirect()->route('viewTask', ['id' => $request->parent]);
        } catch (Exception $e) {
            Session::flash('alert-warning', $e->getMessage());
            return redirect()->back();
        }
    }

    public function viewSubTask($subTaskId)
    {
        $task = Subtask::find($subTaskId);
        if($task){
            return view('task.subtask.view', [
                'task' => $task
            ]);
        }else{
            return redirect('/home');
        }
    }

    public function editSubTask($id)
    {
        $task = Subtask::find($id);
        if($task){
            return view('task.subtask.edit', [
                'task' => $task
            ]);
        }else{
            return redirect('/home');
        }
    }

    public function editSubTaskPost($id, Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:tasks,id,'.$id.'|max:255|min:4',
            'description' => 'required|min:4',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:10048', // Add image validation rules
        ]);

        try {
            $task = Subtask::find($id);

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

    public function deleteSubTaskPost(Request $request)
    {
        $validated = $request->validate([
            'delete' => 'required',
        ]);

        try {
            $task = Subtask::find($request->delete);

            $task->delete();

            Session::flash('alert-success', 'Sub Task deleted!');
            return redirect()->back();
        } catch (Exception $e) {
            Session::flash('alert-warning', $e->getMessage());
            return redirect()->back();
        }
    }
}
