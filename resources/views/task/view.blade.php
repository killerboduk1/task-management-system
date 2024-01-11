@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header page-title-centered">
                {{ __('Viewing Task') }}
                <a href="{{ route('home') }}" class="text-decoration-none text-light">
                    <button class="btn btn-sm btn-success float-end"> Back </button>
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

                    <div class="col-lg-7 m-auto mt-5 mb-5 text-end" >

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

                          <div class="m-1">Status: <span class="badge text-bg-{{ $status }}">{{ $task->status }}</span></div>
                          <div class="card">
                            @if($task->image)
                            <img src="{{ url('storage/'.$task->image) }}" class="card-img-top" alt="Task Image">
                            @endif
                            <div class="card-body text-start">
                              <h5 class="card-title p-0 m-0">{{ $task->title }}</h5>
                            </div>
                            <div class="card-body text-start pt-0 mt-0">
                                {{ $task->description }}
                            </div>
                            <a href="{{ route('addSubTask', [ 'id' => $task->id ]) }}" class="text-decoration-none m-1">
                                <button class="btn btn-sm btn-warning float-end"> Add sub-task </button>
                            </a>
                            @if($task->subtask->count() > 0)
                                <h5 class="text-start p-3">Sub-Task:</h5>
                            @endif
                            <ul class="list-group list-group-flush">
                                @foreach ($task->subtask as $subtask )
                                @if ($subtask->status == "Todo")
                                @php
                                    $subStatus = "secondary";
                                @endphp
                                @elseif ($subtask->status == "In Progress")
                                    @php
                                        $subStatus = "warning";
                                    @endphp
                                @elseif ($subtask->status == "Completed")
                                    @php
                                        $subStatus = "success";
                                    @endphp
                                @endif
                                    <li class="list-group-item ">
                                        <div class="col-lg-8 text-start ">
                                            <h5> {{ $subtask->title }}</h5>
                                            {{ $subtask->description }}
                                        </div>
                                        <div>Status: <span class="badge text-bg-{{ $subStatus }}">{{ $subtask->status }}</span></div>
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('viewSubTask', [ 'subtaskId' => $subtask->id ]) }}" class="text-decoration-none">
                                                <span class="badge text-bg-warning">view</span>
                                            </a>
                                            <a href="{{ route('editSubTask', [ 'subtaskId' => $subtask->id ]) }}" class="text-decoration-none">
                                                <span class="badge text-bg-warning">edit</span>
                                            </a>
                                            <form action="{{ route('deleteSubTaskPost') }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="delete" value="{{ $subtask->id }}">
                                                <button type="submit" class="badge text-bg-danger border-0" >delete</button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                          </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
