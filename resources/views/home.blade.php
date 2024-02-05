@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col">
            <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
                <div class="card-body py-4 px-4 px-md-5">
                    <project-management />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
