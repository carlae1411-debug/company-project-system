<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | WDC Project Directory</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >
    <link rel="icon" type="image/svg+xml" href="{{ asset('public/image/favicon.svg') }}">
    <link
        rel="stylesheet"
        href="{{ asset('css/auth.css') }}"
    >
</head>

<body>

    <div class="auth-page">

        <div class="auth-container">

            {{-- LEFT SIDE --}}
            <div class="auth-brand">

                <div class="brand-content">

                    <div class="brand-icon">
                        <i class="fa-solid fa-building"></i>
                    </div>

                    <h1>WDC Project Directory</h1>

                    <p>
                        Manage projects, users, and company records
                        in one secure workspace.
                    </p>

                    <div class="brand-features">

                        <div class="brand-feature">
                            <i class="fa-solid fa-folder-tree"></i>
                            <span>Project Management</span>
                        </div>

                        <div class="brand-feature">
                            <i class="fa-solid fa-users"></i>
                            <span>User Management</span>
                        </div>

                        <div class="brand-feature">
                            <i class="fa-solid fa-box-archive"></i>
                            <span>Archive & History</span>
                        </div>

                    </div>

                </div>

            </div>


            {{-- RIGHT SIDE --}}
            <div class="auth-form-section">

                <div class="auth-form-wrapper">

                    <div class="mobile-brand-icon">
                        <i class="fa-solid fa-building"></i>
                    </div>

                    <div class="auth-header">

                        <h2>Welcome back</h2>

                        <p>
                            Sign in to your company account
                        </p>

                    </div>


                    {{-- SUCCESS MESSAGE --}}
                    @if(session('success'))

                        <div class="auth-alert auth-alert-success">

                            <i class="fa-solid fa-circle-check"></i>

                            <span>
                                {{ session('success') }}
                            </span>

                        </div>

                    @endif


                    {{-- VALIDATION ERRORS --}}
                    @if($errors->any())

                        <div class="auth-alert auth-alert-error">

                            <i class="fa-solid fa-circle-exclamation"></i>

                            <div>

                                @foreach($errors->all() as $error)

                                    <div>{{ $error }}</div>

                                @endforeach

                            </div>

                        </div>

                    @endif


                    {{-- LOGIN FORM --}}
                    <form
                        action="{{ route('login') }}"
                        method="POST"
                        class="auth-form"
                    >

                        @csrf


                        {{-- EMAIL --}}
                        <div class="form-group">

                            <label for="email">
                                Email Address
                            </label>

                            <div class="input-wrapper">

                                <i class="fa-regular fa-envelope"></i>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="Enter your email"
                                    autocomplete="email"
                                    required
                                    autofocus
                                >

                            </div>

                        </div>


                        {{-- PASSWORD --}}
                        <div class="form-group">

                            <div class="form-label-row">

                                <label for="password">
                                    Password
                                </label>

                            </div>

                            <div class="input-wrapper">

                                <i class="fa-solid fa-lock"></i>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Enter your password"
                                    autocomplete="current-password"
                                    required
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    onclick="togglePassword()"
                                    aria-label="Show password"
                                >
                                    <i
                                        id="password-icon"
                                        class="fa-regular fa-eye"
                                    ></i>
                                </button>

                            </div>

                        </div>


                        {{-- REMEMBER --}}
                        <div class="remember-row">

                            <label class="remember-label">

                                <input
                                    type="checkbox"
                                    name="remember"
                                    value="1"
                                >

                                <span>
                                    Remember me
                                </span>

                            </label>

                        </div>


                        {{-- LOGIN BUTTON --}}
                        <button
                            type="submit"
                            class="login-button"
                        >

                            <span>Sign In</span>

                            <i class="fa-solid fa-arrow-right"></i>

                        </button>

                    </form>


                    <div class="auth-footer">

                        <p>
                            WDC Project Directory
                        </p>

                        <span>
                            Secure access for authorized users
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <script>

        function togglePassword() {

            const passwordInput =
                document.getElementById('password');

            const passwordIcon =
                document.getElementById('password-icon');

            if (passwordInput.type === 'password') {

                passwordInput.type = 'text';

                passwordIcon.classList.remove(
                    'fa-eye'
                );

                passwordIcon.classList.add(
                    'fa-eye-slash'
                );

            } else {

                passwordInput.type = 'password';

                passwordIcon.classList.remove(
                    'fa-eye-slash'
                );

                passwordIcon.classList.add(
                    'fa-eye'
                );

            }

        }

    </script>

</body>
</html>