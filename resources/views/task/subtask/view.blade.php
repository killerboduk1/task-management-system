@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header page-title-centered">
                {{ __('Viewing Sub-Task') }}
                <a href="{{ route('viewTask', [ 'id' => $task->task_id ]) }}" class="text-decoration-none text-light">
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

                          Status: <span class="badge text-bg-{{ $status }}">{{ $task->status }}</span>
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

                          </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
