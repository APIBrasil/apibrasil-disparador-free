@extends('layouts.layout')

@section('title', 'Página Inicial')

@section('content')
    <h1 class="app-page-title">Dashboard</h1>
    
    <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
        <div class="inner">
            <div class="app-card-body">
                <h4>Welcome, developer!</h4>
            </div><!--//app-card-body-->
        </div><!--//inner-->
    </div><!--//app-card-->
        
    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Mensagens</h4>
                    <div class="stats-figure">12.628</div>
                    <div class="stats-meta text-success">
                        <i class="fas fa-arrow-up"></i> Enviadas
                    </div>
                </div><!--//app-card-body-->
                <a class="app-card-link-mask" href="#"></a>
            </div><!--//app-card-->
        </div><!--//col-->
        
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Conexões</h4>
                    <div class="stats-figure">11</div>
                    <div class="stats-meta text-success">
                        <i class="fas fa-arrow-up"></i> Ativas
                    </div>
                </div><!--//app-card-body-->
                <a class="app-card-link-mask" href="#"></a>
            </div><!--//app-card-->
        </div><!--//col-->
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Contatos</h4>
                    <div class="stats-figure">2306</div>
                    <div class="stats-meta text-success">
                        <i class="fas fa-user-plus"></i> Novos
                    </div>
                    </div><!--//app-card-body-->
                <a class="app-card-link-mask" href="#"></a>
            </div><!--//app-card-->
        </div><!--//col-->
        <div class="col-6 col-lg-3">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Desconexões</h4>
                    <div class="stats-figure">6</div>
                    <div class="stats-meta text-danger">
                        <i class="fas fa-arrow-down"></i> Offline
                    </div>
                </div><!--//app-card-body-->
                <a class="app-card-link-mask" href="#"></a>
            </div><!--//app-card-->
        </div><!--//col-->
    </div><!--//row-->
    {{-- <div class="row g-4 mb-4">
        <div class="col-12 col-lg-6">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Line Chart Example</h4>
                        </div><!--//col-->
                        <div class="col-auto">
                            <div class="card-header-action">
                                <a href="charts.html">More charts</a>
                            </div><!--//card-header-actions-->
                        </div><!--//col-->
                    </div><!--//row-->
                </div><!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">
                    <div class="mb-3 d-flex">   
                        <select class="form-select form-select-sm ms-auto d-inline-flex w-auto">
                            <option value="1" selected>This week</option>
                            <option value="2">Today</option>
                            <option value="3">This Month</option>
                            <option value="3">This Year</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="canvas-linechart" ></canvas>
                    </div>
                </div><!--//app-card-body-->
            </div><!--//app-card-->
        </div><!--//col-->
        <div class="col-12 col-lg-6">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Bar Chart Example</h4>
                        </div><!--//col-->
                        <div class="col-auto">
                            <div class="card-header-action">
                                <a href="charts.html">More charts</a>
                            </div><!--//card-header-actions-->
                        </div><!--//col-->
                    </div><!--//row-->
                </div><!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">
                    <div class="mb-3 d-flex">   
                        <select class="form-select form-select-sm ms-auto d-inline-flex w-auto">
                            <option value="1" selected>This week</option>
                            <option value="2">Today</option>
                            <option value="3">This Month</option>
                            <option value="3">This Year</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="canvas-barchart" ></canvas>
                    </div>
                </div><!--//app-card-body-->
            </div><!--//app-card-->
        </div><!--//col-->
        
    </div><!--//row--> --}}

    @section('scripts')
    
    <!-- Charts JS -->
    <script src="assets/plugins/chart.js/chart.min.js"></script> 
    <script src="assets/js/index-charts.js"></script> 
    
    @endsection

@endsection