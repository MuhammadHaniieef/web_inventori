@extends('layouts.app')

@section('content')
    <style>
        :root {
            --primary-color: #547c90;
            --sec-color: #265166;
            --acc-color: #f6fafd;
            --bg-color: #d0f1e6;
            --pungki: #f1dcd0;
            --meramera: #ca4c44;
            --birusepuh: #1e3745;
            --birupemula: #bacfda;
            --abusepuh: #414a4e;
        }

        .material-symbols-outlined {
            /* font-size: 24px; */
            padding: 0.7rem 0.9rem;
            background: var(--primary-color);
            color: var(--birupemula);
            border-radius: 2.3rem;
            margin-right: 0.5rem;
        }

        @media(max-width:768px) {
            .form-cont {
                background-color: rgba(255, 255, 255, 0.5);
                box-shadow: 0px 10px 30px rgba(30, 55, 69, 0.2);
                border-radius: 24px;
                border-bottom-left-radius: 24px !important;
                border-top-left-radius: 0 !important;
                border-top-right-radius: 0 !important;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .form-control {
                border-radius: 12px;
                padding: 12px 20px;
                border: 1px solid #ddd;
                transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            }

            .form-control:focus {
                border-color: #0c0c0c;
                box-shadow: 0 0 0 3px rgba(37, 117, 252, 0.1);
            }

            .btn-submit {
                background-color: #0c0c0c;
                border: none;
                border-radius: 24px;
                color: #f5f5f5;
                padding: 12px 20px;
                font-size: 16px;
                transition: all 0.3s ease-in-out, transform 0.3s ease-in-out;
            }

            .btn-submit span {
                display: none;
            }

            .btn-submit i {
                margin-left: 0;
                font-size: 20px;
            }

            .btn-submit {
                width: 40px;
                height: 40px;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 0;
                border-radius: 50%;
            }

            .btn-submit:hover {
                background-color: #050505;
            }

            .btn-submit i {
                margin-left: 4px;
                transition: all 0.3s ease-in-out, transform 0.3s ease-in-out;
            }

            .btn-submit:hover i {
                transform: translateX(10px);
            }

            .btn-link {
                color: #0c0c0c;
                text-decoration: none;
                transition: color 0.3s ease-in-out;
            }

            .form-check-input:checked {
                background-color: #0c0c0c;
                border-color: #0c0c0c;
            }

            .form-check-label {
                color: #333;
            }

            .img-container {
                height: 100% !important;
                position: relative;
                overflow: hidden;
                border-radius: 24px;
                border-top-right-radius: 24px !important;
                border-bottom-left-radius: 0 !important;
                border-bottom-right-radius: 0 !important;
            }

            .img-container img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(30, 55, 69, 0.7);
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 20px;
                color: white;
                text-align: center !important;
            }

            .overlay-top {
                padding-top: 10% !important;
            }

            .overlay-bottom {
                display: none;
            }

            .overlay-top h2 {
                font-size: 2rem !important;
                font-weight: bold;
            }

            .overlay-top p {
                font-size: 1rem !important;
                font-weight: lighter;
            }
        }

        .form-cont {
            background-color: rgba(255, 255, 255, 0.5);
            box-shadow: 0px 10px 30px rgba(30, 55, 69, 0.2);
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 20px;
            border: 1px solid #ddd;
            transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #0c0c0c;
            box-shadow: 0 0 0 3px rgba(37, 117, 252, 0.1);
        }

        .btn-submit {
            background-color: #0c0c0c;
            border: none;
            border-radius: 24px;
            color: #f5f5f5;
            padding: 12px 20px;
            font-size: 16px;
            transition: all 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .btn-submit:hover {
            background-color: #050505;
        }

        .btn-submit i {
            margin-left: 4px;
            transition: all 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .btn-submit:hover i {
            transform: rotate(45deg);
        }

        .btn-link {
            color: #0c0c0c;
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        .form-check-input:checked {
            background-color: #0c0c0c;
            border-color: #0c0c0c;
        }

        .form-check-label {
            color: #333;
        }

        .img-container {
            height: 100%;
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(30, 55, 69, 0.7);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
            color: white;
            text-align: right;
        }

        .overlay-top {
            padding-top: 20%;
        }

        .overlay-top h2 {
            font-size: 3rem;
            font-weight: bold;
        }

        .overlay-top p {
            font-size: 1.2rem;
            font-weight: lighter;
        }

        .overlay-bottom h2 {
            font-size: 1.7rem;
            font-weight: bold;
        }

        .overlay-bottom p {
            font-size: 0.9rem;
            font-weight: lighter;
        }

        input::placeholder {
            font-style: italic;
        }

        #pwDiv i {
            opacity: 0;
            transform: translateY(-6px) rotate(0deg);
            transition: all 0.3s ease-in-out;
        }

        #pwDiv:hover i,
        #pwDiv i.active {
            opacity: 1;
            transform: translateY(0) rotate(360deg);
        }
    </style>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        @if (session('success'))
            <div class="my-3 alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="my-3 alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row w-100 d-flex justify-content-center h-75">
            <div class="p-0 col-md-6 col-12" style="z-index: 999;">
                <div class="img-container">
                    <img src="https://www.logility.com/wp-content/uploads/2023/05/Unlocking-the-power-of-Inventory-Control-Techniques-Header-1.png"
                        alt="login-img">
                    <div class="overlay">
                        <div class="overlay-top">
                            <h2>
                                Inventory
                            </h2>

                            <p>Website Inventory Micro Controller</p>

                            <hr>
                        </div>
                        <div class="overlay-bottom">
                            <h2>Chill guy</h2>
                            <p>Contact: +62 876 5432 1098</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 col-md-6 col-12 form-cont text-star"
                style="margin-left: -1%; border-radius: 24px; border-top-left-radius: 0; border-bottom-left-radius: 0;">
                <h2 class="mb-4" style="color: #333;">Form ambil barang di Box {{ $box->code }}</h2>
                <form action="{{ route('boxes.submit', $box->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Peminjam</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        <small class="text-muted fst-italic">Gunakan Kapital di awal, <strong>*Contoh: Muhammad
                                Zaid</strong></small>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="division" class="form-label">Divisi</label>
                        <select name="division" id="division"
                            class="form-control pilih-divisi @error('division') is-invalid @enderror">
                            <option value="" {{ old('division') == '' ? 'selected' : '' }}>--Pilih Divisi--</option>
                            <option value="Micro" {{ old('division') == 'Micro' ? 'selected' : '' }}>Micro</option>
                            <option value="Support" {{ old('division') == 'Support' ? 'selected' : '' }}>Support</option>
                            <option value="Inventory" {{ old('division') == 'Inventory' ? 'selected' : '' }}>Inventory
                            </option>
                            <option value="Programmer" {{ old('division') == 'Programmer' ? 'selected' : '' }}>Programmer
                            </option>
                            <option value="Lain" {{ old('division') == 'Lain' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        <input type="text" id="divisilain"
                            class="form-control d-none mt-3 @error('division') is-invalid @enderror"
                            value="{{ old('division') }}">
                        @error('division')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn-submit w-100"><span>Ajukan</span> <i
                            class="fas fa-rocket"></i></button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.pilih-divisi').forEach(select => {
            select.addEventListener('change', function() {
                let selectedValue = this.value;
                let divisilain = document.getElementById('divisilain');

                if (selectedValue === 'Lain') {
                    divisilain.classList.remove('d-none');
                    divisilain.setAttribute('name', 'division');
                } else {
                    divisilain.classList.add('d-none');
                    divisilain.removeAttribute('name');
                }
            });
        });
    </script>
@endsection
