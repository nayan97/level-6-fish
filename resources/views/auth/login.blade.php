<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Login - Pos admin template</title>



    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('backend/arot.png') }}">


    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">



</head>

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">
                    <div class="login-userset">
                        <div  class="login-logo">
                            <img style="border-radius:10%" src="{{ asset('backend/arot.png') }}" alt="img">
                        </div>
                        <div class="login-userheading">
                            <h3>Sign In</h3>
                            <h4>Please login to your account</h4>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-login">
                                <label>Email</label>
                                <div class="form-addons">
                                    <input type="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <img src="assets/img/icons/mail.svg" alt="img">


                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>


                            </div>



                            <div class="form-login">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input id="password" type="password"
                                        class="pass-input @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">
                                    <span class="fas toggle-password fa-eye-slash"></span>


                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>

                            </div>


                            <div class="form-login">
                                <button type="submit" class="btn btn-login">Sign In</button>
                            </div>



                            <!-- Demo Credentials Table -->
                            <div class="mt-4">
                                <h5 class="text-center mb-2">Click for Login</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Role</th>
                                                <th>Email</th>
                                                <th>Password</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="login-shortcut bg-blue-100" data-email="admin@gmail.com"
                                                data-password="12345678" style="cursor: pointer;">
                                                <td>Admin</td>
                                                <td>admin@gmail.com</td>
                                                <td>12345678</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>



                        </form>



                    </div>
                </div>
                <div class="login-img">
                    <img src="{{ asset('assets/img/img-02.jpg') }}" alt="img">
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('assets/js/feather.min.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>


    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        document.querySelectorAll('.login-shortcut').forEach(item => {
            item.addEventListener('click', function() {
                // Get values from data attributes of the row
                const email = this.getAttribute('data-email');
                const password = this.getAttribute('data-password');

                // Fill inputs
                document.getElementById('email').value = email;
                document.getElementById('password').value = password;

                // Auto submit form
                // Since the table is INSIDE the form, we find the parent form
                this.closest('form').submit();
            });
        });
    </script>


</body>

</html>
