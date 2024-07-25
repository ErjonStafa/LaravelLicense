<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Activate license</title>

    <style>
        body {
            background: linear-gradient(45deg, #fc466b, #3f5efb);
            height: 100vh;
            font-family: 'Montserrat', sans-serif;
        }

        .container {
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
        }

        form {
            background: rgba(255, 255, 255, 0.3);
            padding: 3em;
            height: 320px;
            border-radius: 20px;
            border-left: 1px solid rgba(255, 255, 255, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            box-shadow: 20px 20px 40px -6px rgba(0, 0, 0, 0.2);
            text-align: center;
            position: relative;
            transition: all 0.2s ease-in-out;
        }

        form p {
            font-weight: 500;
            color: #fff;
            opacity: 0.7;
            font-size: 1.4rem;
            margin-top: 0;
            margin-bottom: 60px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        form a {
            text-decoration: none;
            color: #ddd;
            font-size: 12px;
        }

        form a:hover {
            text-shadow: 2px 2px 6px #00000040;
        }

        form a:active {
            text-shadow: none;
        }

        form input {
            background: transparent;
            min-width: 350px;
            padding: 1rem;
            margin-bottom: 2em;
            border: none;
            border-left: 1px solid rgba(255, 255, 255, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 5000px;
            backdrop-filter: blur(5px);
            box-shadow: 4px 4px 60px rgba(0, 0, 0, 0.2);
            color: #fff;
            font-family: Montserrat, sans-serif;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        form input:hover {
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 4px 4px 60px 8px rgba(0, 0, 0, 0.2);
        }

        form input[type="email"]:focus, form input[type="password"]:focus {
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 4px 4px 60px 8px rgba(0, 0, 0, 0.2);
        }

        form input[type="submit"] {
            margin-top: 10px;
            font-size: 1rem;
        }

        form input[type="submit"]:hover {
            cursor: pointer;
        }

        form input[type="submit"]:active {
            background: rgba(255, 255, 255, 0.2);
        }


        ::placeholder {
            font-family: Montserrat, sans-serif;
            font-weight: 400;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
        }

        .drop {
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            border-left: 1px solid rgba(255, 255, 255, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 10px 10px 60px -8px rgba(0, 0, 0, 0.2);
            position: absolute;
            transition: all 0.2s ease;
        }

        .drop-1 {
            height: 80px;
            width: 80px;
            top: -20px;
            left: -40px;
            z-index: -1;
        }

        .drop-2 {
            height: 80px;
            width: 80px;
            bottom: -30px;
            right: -10px;
        }

        .drop-3 {
            height: 100px;
            width: 100px;
            bottom: 120px;
            right: -50px;
            z-index: -1;
        }

        .drop-4 {
            height: 120px;
            width: 120px;
            top: -60px;
            right: -60px;
        }

        .drop-5 {
            height: 60px;
            width: 60px;
            bottom: 170px;
            left: 90px;
            z-index: -1;
        }

        a, input:focus, select:focus, textarea:focus, button:focus {
            outline: none;
        }

        .error {
            color: red;
        }

        .success {
            color: lightgreen;
        }
    </style>
</head>
<body>
<div class="container">
    <form method="post" action="{{ route('license.activate') }}" style="display: flex; flex-direction: column;">
        @csrf
        <p>Provide license</p>
        <input type="text" name="license" value="{{ old('license') }}" placeholder="License" style="margin: auto">
        @error('license')
            <span class="error">{{ $message }}</span>
        @enderror
        @if(session()->has('error'))
            <span class="error">{{ session()->get('error') }}</span>
        @endif

        @if(session()->has('success'))
            <span class="success">{{ session()->get('success') }}</span>
        @endif

        <input type="submit" value="Activate" style="margin: auto">
    </form>
</div>
</body>
</html>
