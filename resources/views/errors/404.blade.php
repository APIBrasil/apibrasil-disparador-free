@extends('layouts.layout')

@section('title', 'Disparos')

@section('content')
    
    <div class="row">
        <div class="col-12 col-md-11 col-lg-7 col-xl-6 mx-auto">
            <div class="app-card p-5 text-center shadow-sm">
                <h1 class="page-title mb-4">404<br><span class="font-weight-light">Page Not Found</span></h1>
                <div class="mb-4">
                    Desculpe, a página que você está procurando não foi encontrada.<br />
                    Por favor, verifique o URL no seu navegador e tente novamente.
                </div>
                <a class="btn app-btn-primary" href="/">Voltar para a dashboard</a>
            </div>
        </div><!--//col-->
    </div><!--//row-->
    
@endsection
