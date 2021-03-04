<div class="dashboard-header">
    <h1 class="dashboard-header__profile">
        <div class="dashboard-header__image">
            <img width="80" height="80" src="{{ Auth::user()->profile_image ? Storage::url(Auth::user()->profile_image) : '/images/default.jpg' }}" alt="Placeholder">
        </div>
        <!-- /.dashboard-header__image -->
        <div class="dashboard-header__welcome">
            Hi, {{ Auth::user()->username ?? Auth::user()->name }}!
        </div>
        <!-- /.dashboard-header__welcome -->
        <div class="dashboard-header__balance">
            Balance: <strong>{{ currency(Auth::user()->getBalance()) }}</strong>
        </div>
        <!-- /.dashboard-header__balance -->
    </h1>


    @if (session('success'))
        <div class="tac">
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        </div>
        <!-- /.tac -->        

    @endif
    @if (session('error'))
        <div class="tac">
            <div class="alert alert-error" role="alert">
                {{ session('error') }}
            </div>
        </div>
        <!-- /.tac -->
    @endif

    {{-- <a class="btn btn-primary" href="geniegaming://reward?id=e5852a3f-7479-4c89-b6e7-807f44ef647e">Back to Game...</a> --}}
    
</div>
<!-- /.dashboard-header -->