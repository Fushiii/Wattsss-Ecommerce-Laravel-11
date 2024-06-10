<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <title>Watts - Register</title>
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
        .register-container {
            width: 800px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: row;
        }
        .register-left {
            padding: 30px;
            flex: 1;
        }
        .register-right {
            flex: 1;
            background: #0b0c29;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .register-header {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .register-form {
            display: flex;
            flex-direction: column;
        }
        .register-form input {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .register-form button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #23243e;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .register-form button:hover {
            background-color: #f9bf29;
        }
        .welcome {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .login-link {
            margin-top: 20px;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            background-color: #23243e;
            color: white;
            transition: background-color 0.3s;
        }
        .login-link:hover {
            background-color: #f9bf29;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-left">
            <div class="register-header">Register</div>
            <form class="register-form" method="POST" action="{{ route('account.processRegister') }}">
                @csrf
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" required autofocus>
                @error('name')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" required>
                @error('email')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" required>
                @error('password')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                <button type="submit">Register</button>
            </form>
        </div>
        <div class="register-right">
            <div class="welcome">Welcome to Wattss!</div>
            <div>Already have an account?</div>
            <a class="login-link" href="{{ route('login') }}">Login</a>
        </div>
    </div>
</body>
</html>
