@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header page-title-centered bg-danger">
                <div class="col-lg-9 text-white">{{ __('Deleted Task List') }}</div>
                <a href="{{ route('home') }}" class="text-decoration-none text-light">
                    <button class="btn btn-sm btn-success float-end"> Home </button>
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
                                <td class="text-center d-flex justify-content-center" style="gap: 10px;">
                                    <form action="{{ route('deleteDeletedTask') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="delete" value="{{ $task->id }}">
                                        <button type="submit" class="btn btn-danger btn-action" data-toggle="tooltip" >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('restoreDeletedTask') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="delete" value="{{ $task->id }}">
                                        <button type="submit" class="btn btn-success btn-action" data-toggle="tooltip" >
                                            Restore
                                        </button>
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
