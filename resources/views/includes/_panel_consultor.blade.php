<div class="card">
    <div class="card-body">
        <form action="{{route('desempenho')}}" method="GET" id="desempenho" name="form">
        <div class="row">
            <div class="col-lg-2 text-bg-light">
                <h5 class="mt-4">Período</h5>
            </div>
            <div class="col-lg-3">
                <div class="input-group input-group-static my-3">
                    <label>De</label>
                    <input name="rango_fecha_desde" type="date" class="form-control" value="{{request()->get('rango_fecha_desde')}}" id="rango_fecha_desde">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="input-group input-group-static my-3">
                    <label>Até</label>
                    <input name="rango_fecha_hasta" type="date" class="form-control" value="{{request()->get('rango_fecha_hasta')}}" id="rango_fecha_hasta">
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-2 text-bg-light">
                <h5 class="mt-4">Consultores</h5>
            </div>
            <div class="col-lg-3">
                <div class="input-group input-group-static mt-2">
                    <select name="consultores[]" multiple="" class="form-control pb-8" id="list1">
                        @isset($consultores)
                            @foreach ($consultores as $consultor)
                                <option value="{{$consultor}}">{{ $usuarios[$consultor] }}</option>
                            @endforeach
                        @else
                            @foreach ($usuarios as $co_usuario => $no_usuario)
                                <option value="{{ $co_usuario }}">{{ $no_usuario }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
            </div>

            <div class="col-lg-2 justify-space-between text-center">
                <button class="btn btn-dark btn-icon mt-2" type="button" onClick="move(list1,list2)">
                    <div class="d-flex align-items-center">
                        <i class="material-icons" aria-hidden="true">keyboard_double_arrow_right</i>
                    </div>
                </button>
                <div class="clearfix"></div>
                <button class="btn btn-dark btn-icon mt-2" type="button" onClick="move(list2,list1)">
                    <div class="d-flex align-items-center">
                        <i class="material-icons" aria-hidden="true">keyboard_double_arrow_left</i>
                    </div>
                </button>
            </div>

            <div class="col-lg-3">
                <div class="input-group input-group-static mt-2">
                    <select name="consultores_selecionado[]" multiple class="form-control pb-8" id="list2">
                        @isset($consultores_selecionado)
                            @foreach ($consultores_selecionado as $consultor_selecionado)
                                <option value="{{$consultor_selecionado}}">{{ $usuarios[$consultor_selecionado] }}</option>
                            @endforeach
                        @endisset        
                    </select>
                </div>
            </div>

            <div class="col-lg-2 justify-space-between text-center">
                <button class="btn bg-gradient-primary btn-icon mt-2" type="button" id="relatorio">
                    <div class="d-flex align-items-center">
                        <i class="material-icons me-2" aria-hidden="true">fact_check</i>
                        Relatório
                    </div>
                </button>

                <button class="btn bg-gradient-primary btn-icon mt-2" type="button" id="grafico_chart">
                    <div class="d-flex align-items-center">
                        <i class="material-icons me-2" aria-hidden="true">bar_chart</i>
                        Gráfico
                    </div>
                </button>

                <button class="btn bg-gradient-primary btn-icon mt-2" type="button" id="grafico_pizza">
                    <div class="d-flex align-items-center">
                        <i class="material-icons me-2" aria-hidden="true">pie_chart</i>
                        Pizza
                    </div>
                </button>
            </div>
        </div>
        </form>
    </div>
</div>