@extends('layouts.app')

@section('content')
    <style>
        body {
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .register-container {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
        }

        .register-container h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .register-container p {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 2rem;
        }

        .register-container img {
            width: 200px;
            height: auto;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .register-container a {
            display: inline-block;
            background-color: #2575fc;
            color: white;
            padding: 10px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
    </style>

    <div class="register-container">
        <h1>Mau Register?</h1>
        <p>Gabolee wkwk, bilang atmin aja dek, 'bang bikinin akun bang'</p>
        <img src="https://media.tenor.com/5_-g2NCrD8QAAAAM/tonged-out.gif" alt="Ledek GIF">
        <p>Wleee!</p>
    </div>
@endsection
