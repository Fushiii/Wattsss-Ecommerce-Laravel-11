<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <title>Watts</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            width: 800px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: row;
        }
        .login-left {
            padding: 30px;
            flex: 1;
        }
        .login-right {
            flex: 1;
            background: #0b0c29;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .login-header {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .login-form {
            display: flex;
            flex-direction: column;
        }
        .login-form input {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .login-form button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #23243e;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-form button:hover {
            background-color: #f9bf29;
        }
        .login-form .checkbox {
            display: flex;
            align-items: center;
        }
        .login-form .checkbox input {
            margin-right: 10px;
        }
        .login-form .forgot-password {
            text-align: right;
            margin-top: 10px;
        }
        .login-form .forgot-password a{
            text-decoration:none;
            color:#23243e;
        }
        .welcome {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .signup {
            margin-top: 20px;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            background-color: #23243e;
            color: white;
            transition: background-color 0.3s;
        }
        .signup:hover {
            background-color: #f9bf29;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <div class="login-header">Login</div>
            <form class="login-form" method="POST" action="{{ route('account.authenticate') }}">
                @csrf
                <input type="email" class="form-control @error('email') is-invalid @enderror " name="email" id="email" placeholder="Email" required autofocus>
                @error('email')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
                <input type="password" class="form-control @error('password') is-invalid @enderror " name="password" id="password" placeholder="Password" required>
                @error('password')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
                <div class="checkbox">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember Me</label>
                </div>
                
                <button type="submit">Login</button>
                <div class="forgot-password">
                    <a href="#">Forgot Password?</a>
                </div>
            </form>
        </div>
        <div class="login-right">
            <div class="welcome">Welcome to Wattss!</div>
            <div>Don't have an account?</div>
            <a class="signup" href="{{ route('account.register') }}">Sign Up</a>
        </div>
    </div>
</body>
</html>
