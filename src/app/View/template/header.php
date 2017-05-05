<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <base href="<?=URL_BASE?>">
        <meta charset="UTF-8">
        <title>Fichas</title>
        <link rel="stylesheet" href="public/css/bootstrap.min.css">
        <link rel="stylesheet" href="public/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Arimo" rel="stylesheet">
        <style type="text/css">
            html {
                position: relative;
                min-height: 100%;
            }
            body{
                font-family: 'Arimo', sans-serif;
                /* Margin bottom by footer height */
                margin-bottom: 60px;
            }
            .footer {
                position: absolute;
                bottom: 0;
                width: 100%;
                /* Set the fixed height of the footer here */
                height: 60px;
                background-color: #f5f5f5;
                border-top: 1px solid #ddd;
            }
            .footer > .container-fluid {
                padding-right: 15px;
                padding-left: 15px;
            }
            .container-fluid .text-muted {
                margin: 10px 0;
            }
            .ficha-table {
                font-size: 16pt;
                font-weight: bold;
                margin-top: -10px;
            }
            .alert-error-form {
                font-size: 10pt;
                color: red;
                display: none;
            }
        </style>
    </head>
    <body>