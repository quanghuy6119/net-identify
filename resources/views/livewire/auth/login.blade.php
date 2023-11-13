<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto mt-5">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ Session::get('success') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form wire:submit.prevent="authenticate">
                <div class="card-body text-center py-4 p-sm-5">
                    <img src="{{ asset('static/illustrations/undraw_sign_in_e6hj.svg') }}" height="220" class="mb-n2"
                        alt="">
                    <h1 class="mt-5 md-5">Welcome to NET!</h1>
                    <p class="text-muted">
                        Start your adventure with NET and make your work great again.
                        Utilizing a versatile toolset with multiple convenient features significantly facilitates
                        the
                        management tasks, making them notably more effortless.</p>
                </div>
                <p class="display-6 text-center">Login Here</p>
                <hr class="bg-white" />
                @if ($error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ $error }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" wire:model="email" />
                    @error('email')
                        <p class="pt-2 px-1 text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" wire:model="password" />
                    @error('password')
                        <p class="pt-2 px-1 text-danger">{{ str_replace('password', 'password', $message) }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-dark btn-block" />
                </div>
            </form>
        </div>
    </div>
</div>
