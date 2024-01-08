@extends('layouts.template')
<style>
    body {
        background: #FAFAFA;
    }

    .order-card {
        color: #fff;
    }

    .bg-c-blue {
        background: linear-gradient(45deg, blue, blue);
    }

    .bg-c-green {
        background: linear-gradient(45deg, blue, blue);
    }

    .bg-c-yellow {
        background: linear-gradient(45deg, blue, blue);
    }

    .bg-c-pink {
        background: linear-gradient(45deg, blue, blue);
    }


    .card {
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
        box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
        border: none;
        margin-bottom: 30px;
        -webkit-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    .card .card-block {
        padding: 25px;
    }

    .order-card i {
        font-size: 26px;
    }

    .f-left {
        float: left;
    }

    .f-right {
        float: right;
    }
</style>
<div class="jumbotron ">
    @section('content')
        @if (Session::get('couldntAccess'))
            <div class="alert alert-danger">{{ Session::get('couldntAccess') }}</div>
        @endif
        <h1 class="display-4">
            Selamat Datang, {{ Auth::user()->name }}!
        </h1>
        <hr class="my-4">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <div class="container">
            {{-- <h1>Dashboard</h1>
      <a href="{{route ('home.page')}}">home</a>
      <br><br>
      <br> --}}

            @if (Auth::check())
                @if (Auth::user()->role == 'staff')
                    <div class="container" style="padding-left: 80px;">

                        <div class="row" style="gap: 25px; margin-top:5%; ">

                            <div class="col-8"
                                style="border: 1px solid white;  padding:15px; height:150px; background-color:aliceblue; border-radius:10px">
                                <h5 style="color: black">Surat keluar</h5>
                                <p>{{ App\Models\Letter::count() }}</p>
                            </div>

                            <div class="col-3"
                                style="border: 1px solid white;  padding:15px; height:150px; background-color:aliceblue; border-radius:10px;">
                                <h5 style="color: black">Klasifikasi Surat</h5>
                                <p>{{ App\Models\LetterType::count() }}</p>
                            </div>
                        </div>


                        <div class="row" style="gap: 25px; margin-top: 20px;">


                            <div class="col-3"
                                style="border: 1px solid white;  padding:15px; height:150px; background-color:aliceblue; border-radius:10px;">
                                <h5 style="color: black">Staff Tata Usaha</h5>
                                <p>{{ App\Models\User::where('role', 'staff')->count() }}</p>
                            </div>


                            <div class="col-8"
                                style="border: 1px solid white;  padding:15px; height:150px; background-color:aliceblue; border-radius:10px; margin-bottom:180px;">
                                <h5 style="color: black">Guru</h5>
                                <p>{{ App\Models\User::where('role', 'guru')->count() }}</p>
                            </div>

                        </div>

                    </div>
                @else
                <div class="container" style="padding-left: 80px;">

                    <div class="row" style="gap: 25px; margin-top:5%; ">

                        <div class="col-3"
                            style="border: 1px solid white;  padding:15px; height:150px; background-color:aliceblue; border-radius:10px">
                            <h5 style="color: black">Surat Masuk</h5>
                            <p>{{ App\Models\Letter::count() }}</p>
                        </div>
                    </div>
                </div>
                @endif
            @endif
        </div>
    @endsection
