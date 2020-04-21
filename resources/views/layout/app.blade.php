<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                display: flex;
                justify-content: center;
            }
            .content {
            }

            .title {
                font-size: 84px;
                color: chocolate;
                text-align: center;
            }

            .title > p{
                margin-top: 0;
                font-size: 20px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .link-btn {
                color: #636b6f;
                padding: 1.5rem;
                font-size: 14px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                border: .1rem solid black;
                border-radius: 5rem;
            }

            .link-btn:hover {
                color: white;
            }
            a {
                color: #636b6f;
                text-decoration: none;
            }
            a:hover {
                text-decoration: none;
            }

            .link-btn:hover {
                background-color: chocolate;
            }

            .m-b-md {
                margin-top: 10rem;
                margin-bottom: 60px;
            }

            #form{
                margin: 3rem 1rem 0 1rem;
            }

            #text-area {
                padding: 1rem;
                border: .1rem solid chocolate;
            }

            .submit-btn {
                height: 3rem;
                width: 4.5rem;
                border-radius: .1rem;
                border: 0;
                background-color: chocolate;
            }

            .footer {
                margin-top: 10rem;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                @yield('home')
            </div>
        </div>
    </body>

    <script>
        // setInterval(() => {
        //     fetch('https://frozen-basin-63569.herokuapp.com/news')
        //     .then(res => console.log('Message sent'))
        // }, 1*60*60*1000);
        
        // setInterval(() => {
        //     fetch('https://frozen-basin-63569.herokuapp.com/updates')
        //     .then(res => console.log('Message sent'))
        // }, 4*60*60*1000);
    </script>
</html>
