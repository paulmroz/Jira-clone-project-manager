@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Zweryfikuj swój adres e-mail</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Na twój adres e-mail został wysłany nowy link weryfikacyjny
                        </div>
                    @endif


                        Zanim przejdziesz dalej, sprawdź swoją wiadomość e-mail, aby otrzymać link weryfikacyjny.
                        Na Twój adres e-mail został wysłany nowy link weryfikacyjny".

                        Jeśli nie otrzymałeś e-maila,
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                            Kliknij tutaj, aby wysłać jeszcze raz
                        </button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
