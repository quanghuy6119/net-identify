<div class="container" id="container">
    <div class="row">
        <div class="col-md-6 mx-auto mt-5">
            <div class="card card-login-form">
                <div class="card-header">
                    <h3 class="card-title">Choose your account</h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="user-selected">
                                @foreach ($users as $user)
                                    <div class="row align-items-center">
                                        <span class="col-2 avatar"
                                            style="background-image: url(./static/avatars/000m.jpg)">
                                            <span class="badge bg-red"></span></span>
                                        <div class="col-8 text-truncate mx-2">
                                            <span
                                                class="text-reset d-block text-truncate">{{ $user->getEmail() }}</span>
                                            <span class="text-muted text-truncate mt-n1">{{ $user->getName() }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
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
