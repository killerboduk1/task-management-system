@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="row p-3">
                    <div class="col-lg-10">
                        <div class="mb-3">
                            <label for="task-search" class="form-label">Search Task</label>
                            <input type="email" class="form-control" id="task-search" placeholder="search for task">
                            <ul class="list-group" style="display: none" id="task-search-result"></ul>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <label for="sort-task" class="form-label">Search Task</label>
                        <select class="form-select" aria-label="Default select example" id="sort-task">
                            <option value="desc" @if($sort == "desc") selected @endif>DESC</option>
                            <option value="asc" @if($sort == "asc") selected @endif>ASC</option>
                          </select>
                    </div>
                </div>
                <div class="card-header page-title-centered">
                <div class="col-lg-9">{{ __('Task List') }}</div>
                <a href="{{ route('addTask') }}" class="text-decoration-none text-light">
                    <button class="btn btn-sm btn-primary float-end"> Add New </button>
                </a>
                <a href="{{ route('viewDeleteTaskPost') }}" class="text-decoration-none text-light">
                    <button class="btn btn-sm btn-warning float-end"> Deleted Task </button>
                </a>
                </div>

                <div class="card-body p-0 overflow-x-auto">

                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))
                            <div class="alert alert-{{ $msg }}" role="alert">
                                {{ Session::get('alert-' . $msg) }}
                            </div>
                        @endif
                    @endforeach

                        <table class="table table-striped p-0 m-0">
                            <tbody>
                            <tr>
                            <th>Task Name</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Data</th>
                            <th class="text-center">Action</th>
                            </tr>
                            @foreach ($tasks as $task)
                            <tr>
                                <td class="vertical-align">{{ $task->title }}</td>
                                <td class="align-middle">
                                    @if ($task->status == "Todo")
                                        @php
                                            $status = "secondary";
                                        @endphp
                                    @elseif ($task->status == "In Progress")
                                        @php
                                            $status = "warning";
                                        @endphp
                                    @elseif ($task->status == "Completed")
                                        @php
                                            $status = "success";
                                        @endphp
                                    @endif
                                    <span class="badge rounded-pill text-bg-{{ $status }}">{{ $task->status }}</span>
                                </td>
                                <td class="vertical-align">{{Str::limit($task->description, 20, $end='.......')}}</td>
                                <td class="vertical-align">{{ date_format($task->created_at,"M, d Y") }}</td>
                                <td class="text-center d-flex justify-content-center" style="gap: 10px;">
                                    <a href="{{ route('viewTask', [ 'id' => $task->id ]) }}" class="btn btn-success btn-action mr-1" data-toggle="tooltip" data-original-title="view"><i class="fas fa-regular fa-eye"></i></a>
                                    <a href="{{ route('editTask', [ 'id' => $task->id ]) }}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                    <form action="{{ route('deleteTaskPost') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="delete" value="{{ $task->id }}">
                                        <button type="submit" class="btn btn-danger btn-action" data-toggle="tooltip" data-confirm="Are You Sure You Want To Move This To Deleted Page?" data-confirm-yes="alert('Deleted')" data-original-title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($tasks->haspages())
                        <div class="d-flex justify-content-center mt-3 w-100">
                            {{ $tasks->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
