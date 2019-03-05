<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <style>

            @import url('https://fonts.googleapis.com/css?family=Roboto+Slab');
            /* <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet"> */

            @import url('https://fonts.googleapis.com/css?family=Oswald');
            /* <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet"> */

            @import url('https://fonts.googleapis.com/css?family=Courgette');
            /* <link href="https://fonts.googleapis.com/css?family=Courgette" rel="stylesheet"> */

            body {
                background-color: #f2f2f2;
            }
            h1 {
                font-family: 'Oswald', sans-serif;
                letter-spacing: 1.2px;
                
                position: fixed;
                left: 0;
                top: 0;
                width: 99.5%;
                text-align: center;
                font-size: 20px;
                background-color: #990000;
                padding: 25px 0;
                margin: 0;
                color: white;
                text-transform: uppercase;
                border: 3px solid black;
            }
            .texto-email {
                font-family: 'Roboto Slab', serif;

                margin: 120px 30px;
                text-align: justify;
                font-size: 17px;
            }
            .texto-email p {
                margin-bottom: 15px;
            }
            footer {
                font-family: 'Courgette', cursive;

                position: fixed;
                left: 0;
                bottom: 0;
                width: 100%;
            }
            footer p {
                font-size: 18px;
                background-color: #990000;
                padding: 25px;
                margin: 0;
                color: white;
                border: 3px solid black;
            }

            @media only screen and (max-width: 550px) {
                h1 {
                    font-size: 18px;
                    width: 98.5%;   
                }
                .texto-email {
                    font-size: 14px;
                }
                footer p {
                    font-size: 16px;
                }
            }
        </style>
    </head>
    <body>

        <h1>Informações para a recuperação da sua senha</h1>
        <div class='texto-email'>
            <p style='margin-bottom: 15px;'>Olá " . $usuario['Primeiro_Nome'] . ", tudo bem?</p>
            <p>Recebemos uma requisição de recuperação de senha. O link para recuperar sua senha está logo abaixo. Se você não fez essa requisição, ignore este e-email.</p>
            <p style='margin-bottom: 15px;'>Aqui está o link de recuperação da senha:<br><a href='" . $url ."'>" . $url ."</a></p>
        </div>

        <footer>
            <p>Pietro Zuntini Bonfim &copy;</p>
        </footer>
    </body>
</html>