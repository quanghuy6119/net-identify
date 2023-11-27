<div class="container" id="container">
    <div class="row">
        <div class="col-md-6 mx-auto mt-5">
            <div class="card card-login-form">
                <form wire:submit.prevent="authenticate">
                    <div class="card-body text-center py-4 p-sm-5">
                        <img src="{{ asset('static/illustrations/undraw_sign_in_e6hj.svg') }}" height="220"
                            class="mb-n2" alt="">
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

    <script>
        var total = 30;
        var warp = document.getElementById("container"),
            w = window.innerWidth,
            h = window.innerHeight;

        for (i = 0; i < total; i++) {
            var Div = document.createElement('div');
            TweenLite.set(Div, {
                attr: {
                    class: 'dot'
                },
                x: R(0, w),
                y: R(-100, -100),
                z: R(-100, 50)
            });
            warp.appendChild(Div);
            animm(Div);
        }

        function animm(elm) {
            TweenMax.to(elm, R(6, 15), {
                y: h + 100,
                ease: Linear.easeNone,
                repeat: -1,
                delay: -15
            });
            TweenMax.to(elm, R(4, 8), {
                x: '+=100',
                rotationZ: R(0, 180),
                repeat: -1,
                yoyo: true,
                ease: Sine.easeInOut
            });
            TweenMax.to(elm, R(2, 8), {
                rotationX: R(0, 360),
                rotationY: R(0, 360),
                repeat: -1,
                yoyo: true,
                ease: Sine.easeInOut,
                delay: -5
            });
        };

        function R(min, max) {
            return min + Math.random() * (max - min)
        };
    </script>
</div>
