<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Language</title>
    <style>
        /* Reset some default styling */
        body, h1, a {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 300px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .language-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .language-btn {
            display: inline-block;
            padding: 15px 25px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .language-btn:hover {
            background-color: #0056b3;
        }

        .language-btn:active {
            background-color: #004085;
        }

    </style>
</head>
{{--{{dd(Session::all())}}--}}
<body>

<div class="container">

    <h1>Select Your Language : <?php echo __('message.welcome');?></h1>
    <div class="language-buttons">
        <a href="{{ route('language.switch', ['locale' => 'en']) }}" class="language-btn">🇺🇸 English</a>
        <a href="{{ route('language.switch', ['locale' => 'th']) }}" class="language-btn">🇹🇭 ไทย</a>
        <a href="{{ route('language.switch', ['locale' => 'mm']) }}" class="language-btn">🇲🇲 မြန်မာ</a>
    </div>
</div>
</body>
</html>
