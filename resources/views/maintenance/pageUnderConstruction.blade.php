<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Under Construction</title>
    <link href='//use.fontawesome.com/releases/v5.12.1/css/all.css' rel='stylesheet'/>
    <style>
        @font-face {
            font-family: 'Work Sans';
            font-style: normal;
            font-weight: 300;
            src: local('Work Sans Light'), local('WorkSans-Light'), url(https://fonts.gstatic.com/s/worksans/v2/FD_Udbezj8EHXbdsqLUpl3hCUOGz7vYGh680lGh-uXM.woff) format('woff')
        }
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }
        html,body {
            font-size: 12px;
            overflow: hidden;
            text-align: center;
            font-family: 'Work Sans', sans-serif;
            line-height:1.4;
            overflow: hidden;
            width: 100%;
        }
        .under,html,body {
            height: 100vh;
        }
        @keyframes charge {
            from {transform: translateY(2rem);opacity: 0}
            to {transform: translateY(0);opacity: 1}
        }
        @keyframes wave {
            from {transform: rotate(0deg);}
            to {transform: rotate(360deg);}
        }
        .under__content {
            color: #fff;
            font-weight: 300;
            padding: 0 2rem
        }
        .under__content,
        .under__footer {
            width: 100%;
            position: relative;
            z-index: 100;
        }
        .under,
        .under__content,
        .under__footer {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .under,
        .under__content {
            flex-direction: column;
        }
        .under__footer,
        .under__text,
        .under__title {
            animation: charge .5s both;
        }
        .under__footer {
            flex-wrap: wrap;
            max-width: 600px;
            opacity: 0;
            animation-delay: .5s;
        }
        .under__subtitle,
        .under__title {
            margin: 0;
        }
        .under__footer a {
            font-size: 20px;
            color: #fff;
            padding: 14px;
            background-color: rgba(0, 0, 0, .5);
            margin: 2px;
            border-radius: 3px;
            width: 51px;
            transition: background .3s;
        }
        .under__footer a:active,
        .under__footer a:focus,
        .under__footer a:hover {
            text-decoration: none
        }
        .under__footer a:hover {
            background-color: rgba(0, 0, 0, .9)
        }
        .under__subtitle,
        .under__text,
        .under__title {
            backface-visibility: hidden
        }
        .under__title {
            font-size: 2.4rem;
            font-weight: 300;
        }
        .under__text {
            max-width: 50rem;
            font-weight: 300;
            padding: 2rem 0;
            font-size: 1.3rem;
            color: rgba(255, 255, 255, .8);
            animation-delay: .3s;
        }
        @media (min-width: 768px) {
            html {
                font-size: 14px;
            }
            .under__title {
                font-size: 3.4rem;
            }
            .under__text {
                font-size: 1.5rem;
            }
        }

        /*
        => Wave: https://codepen.io/zkreations/pen/VGWzYv
        */
        .wave {
            opacity: .6;
            position: absolute;
            bottom: 40%;
            left: 50%;
            width: 6000px;
            height: 6000px;
            background: #000;
            margin-left: -3000px;
            transform-origin: 50% 48%;
            border-radius: 46%;
            animation: wave 12s infinite linear;
            pointer-events: none;
        }
        .wave2 {
            animation: wave 28s infinite linear;
            opacity: .3;
        }
        .wave3 {
            animation: wave 20s infinite linear;
            opacity: .1;
        }

        /*
        => Personalizar
        */
        /* Wave
        --------------------------------------------*/
        .wave {
            background: #000; /*color de fondo*/
        }
        /* Under
        --------------------------------------------*/
        .under {
            background-color: #061c2d;
        }

        body {
            font-size: 16px;
            font-family: "Helvetica", "Arial", sans-serif;
            text-align: center;
            background-color: #f8faff;
        }

        .bubbly-button {
            font-family: "Helvetica", "Arial", sans-serif;
            display: inline-block;
            font-size: 1em;
            padding: 1em 2em;
            margin-top: 100px;
            margin-bottom: 60px;
            -webkit-appearance: none;
            appearance: none;
            background-color: #ff0081;
            color: #fff;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            position: relative;
            transition: transform ease-in 0.1s, box-shadow ease-in 0.25s;
            box-shadow: 0 2px 25px rgba(255, 0, 130, 0.5);
        }
        .bubbly-button:focus {
            outline: 0;
        }
        .bubbly-button:before, .bubbly-button:after {
            position: absolute;
            content: "";
            display: block;
            width: 140%;
            height: 100%;
            left: -20%;
            z-index: -1000;
            transition: all ease-in-out 0.5s;
            background-repeat: no-repeat;
        }
        .bubbly-button:before {
            display: none;
            top: -75%;
            background-image: radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, transparent 20%, #ff0081 20%, transparent 30%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, transparent 10%, #ff0081 15%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%);
            background-size: 10% 10%, 20% 20%, 15% 15%, 20% 20%, 18% 18%, 10% 10%, 15% 15%, 10% 10%, 18% 18%;
        }
        .bubbly-button:after {
            display: none;
            bottom: -75%;
            background-image: radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, transparent 10%, #ff0081 15%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%), radial-gradient(circle, #ff0081 20%, transparent 20%);
            background-size: 15% 15%, 20% 20%, 18% 18%, 20% 20%, 15% 15%, 10% 10%, 20% 20%;
        }
        .bubbly-button:active {
            transform: scale(0.9);
            background-color: #e60074;
            box-shadow: 0 2px 25px rgba(255, 0, 130, 0.2);
        }
        .bubbly-button.animate:before {
            display: block;
            animation: topBubbles ease-in-out 0.75s forwards;
        }
        .bubbly-button.animate:after {
            display: block;
            animation: bottomBubbles ease-in-out 0.75s forwards;
        }

        @keyframes topBubbles {
            0% {
                background-position: 5% 90%, 10% 90%, 10% 90%, 15% 90%, 25% 90%, 25% 90%, 40% 90%, 55% 90%, 70% 90%;
            }
            50% {
                background-position: 0% 80%, 0% 20%, 10% 40%, 20% 0%, 30% 30%, 22% 50%, 50% 50%, 65% 20%, 90% 30%;
            }
            100% {
                background-position: 0% 70%, 0% 10%, 10% 30%, 20% -10%, 30% 20%, 22% 40%, 50% 40%, 65% 10%, 90% 20%;
                background-size: 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%;
            }
        }
        @keyframes bottomBubbles {
            0% {
                background-position: 10% -10%, 30% 10%, 55% -10%, 70% -10%, 85% -10%, 70% -10%, 70% 0%;
            }
            50% {
                background-position: 0% 80%, 20% 80%, 45% 60%, 60% 100%, 75% 70%, 95% 60%, 105% 0%;
            }
            100% {
                background-position: 0% 90%, 20% 90%, 45% 70%, 60% 110%, 75% 80%, 95% 70%, 110% 10%;
                background-size: 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%;
            }
        }
    </style>
</head>
<body>
<div class='under'>
    <header class='under__content'>
        <h1 class='under__title'>Page is under construction :(</h1>
        <div class='under__text'>Situs ruangcoder.com sedang dalam tahap perbaikan, silahkan ikuti sosial media ruangcoder untuk mendapatkan info terkini, tentang kenapa website ini tidak bisa di akses.</div>
        <button class="bubbly-button">
            <a href='/' style="text-decoration: none; color: #333">
                Visit Homepage
            </a>
        </button>
    </header>
    <footer class='under__footer'>
        <a href='/' target='_blank'>
            <i class='fab fa-facebook-f'></i>
        </a>
        <a href='/' target='_blank'>
            <i class='fab fa-twitter'></i>
        </a>
        <a href='/' target='_blank'>
            <i class='fab fa-github'></i>
        </a>
        <a href='/' target='_blank'>
            <i class='fab fa-instagram'></i>
        </a>
        <a href='/' target='_blank'>
            <i class='fab fa-youtube'></i>
        </a>
    </footer>
    <div class='wave'></div>
    <div class='wave wave2'></div>
    <div class='wave wave3'></div>
</div>
</body>
</html>
