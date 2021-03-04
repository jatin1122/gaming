@extends('layouts.app')

@section('content')

<div>

    <div class="container">

        <div class="phylo-container">

            <div class="phylo-container__panel" style="color:black;text-align:center">
              <h2>You transaction was successfull</h2>
              <h4>Amount: {{$transaction->amount}}</h4>
              <h4>Name: {{$transaction->name}}</h4>
              <h4>Email: {{$transaction->email}}</h4>
            </div>
        </div>
        <!-- /.login-container__panel -->

    </div>
    <!-- /.container -->
</div>

@endsection
