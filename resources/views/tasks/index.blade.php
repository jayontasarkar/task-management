@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col">
            <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
                <div class="card-body py-4 px-4 px-md-5">

                    <div class="d-flex justify-content-between">
                        <p class="h3 mt-3 mb-4 pb-3 text-primary">
                            <i class="fa-solid fa-diagram-project"></i>
                            <u>{{ $project->name }}</u>
                        </p>
                        <switch-project project="{{ $project->id }}" :projects="{{ json_encode($projects) }}" />
                    </div>

                    {{-- Task List Component Here --}}
                    <task-management project="{{ Request::route('project') }}" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
