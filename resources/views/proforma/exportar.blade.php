@extends('layouts.app')

@section('cabecera')
    Exportar proformas
@endsection

@section('scripts')
<link href="{{asset('assets/datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset("assets/datepicker/js/bootstrap-datepicker.js")}}"></script>
<script src='{{ asset("assets/datepicker/locales/bootstrap-datepicker.es.min.js") }}'></script>
<script>
    $(document).ready(function() {
        $('input.date-picker').datepicker({
            language: "es",
            orientation: "bottom auto",
            format: 'dd-mm-yyyy',
            autoclose: true
        });
    });
</script>
@endsection

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
	<li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
	<li class="breadcrumb-item active">Exportar proformas</li>
  </ol>
@endsection

@section('cuerpo')
    <div class="card card-default">
        <div class="card-body">
            <p>El sistema generará un archivo Excel con las proformas de acuerdo a los filtros seleccionados</p>
            <form method="POST" target="_blank" action="{{route('proformas.exportar.generar-archivo')}}">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 offset-sm-2 col-form-label">F. emisión desde</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control date-picker" name="fechaEmisionDesde"
                            value="{{ date('d-m-Y') }}">
                    </div>
                    <label class="col-sm-2 col-form-label">F. emisión hasta</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control date-picker" name="fechaEmisionHasta"
                            value="{{ date('d-m-Y') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 offset-sm-2 col-form-label">Incuye Windows</label>
                    <div class="col-sm-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="windows" id="rdWindowsSi"
                                value="1" checked>
                            <label class="form-check-label" for="rdWindowsSi">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="windows" id="rdWindowsNo"
                                value="0">
                            <label class="form-check-label" for="rdWindowsNo">No</label>
                        </div>
                    </div>
                    <label class="col-sm-2 col-form-label">Incuye Office</label>
                    <div class="col-sm-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="office" id="rdOfficeSi"
                                value="1" checked>
                            <label class="form-check-label" for="rdOfficeSi">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="office" id="rdOfficeNo"
                                value="0">
                            <label class="form-check-label" for="rdOfficeNo">No</label>
                        </div>
                    </div>
                </div>
				<div class="form-group row">
					<div class="col-sm-2 offset-sm-6">
						<button type="submit" class="btn btn-primary">Exportar</button>
					</div>
				</div>
            </form>
        </div>
    </div>
@endsection
