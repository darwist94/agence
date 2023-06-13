<div class="card mt-4" id="receitas">
    <div class="card-body">
        @foreach( $receitas as $receita )
            <div class="row">
                <div class="col-12 text-bg-light mt-4">
                    <h5 class="mt-4">{{$receita->no_usuario}}</h5>
                </div>
                <div class="col-12">
                    <div class="table-responsive mt-4">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Período</th>
                                    <th class="text-center">Receita Líquida</th>
                                    <th class="text-center">Custo Fixo</th>
                                    <th class="text-center">Comissão</th>
                                    <th class="text-center">Lucro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $saldo_receita = 0;
                                    $saldo_custo_fixo = 0;
                                    $saldo_comissao = 0;
                                    $saldo_lucro = 0;
                                @endphp
                                @forelse ($receita->faturas as $fatura)
                                    <tr>
                                        <td>
                                            {{ date("d/m/Y", strtotime($fatura->data_emissao))}}
                                        </td>

                                        <td class="text-center">
                                            R$ {{number_format($fatura->total_receita, 2, ",", ".")}}
                                            @php
                                                $saldo_receita += $fatura->total_receita;
                                            @endphp
                                        </td>

                                        <td class="text-center">
                                            R$ {{number_format($receita->custo_fixo, 2, ",", ".")}}
                                             @php
                                                $saldo_custo_fixo += $receita->custo_fixo;
                                            @endphp
                                        </td>

                                        <td class="text-center">
                                            R$ {{number_format($fatura->total_comissao, 2, ",", ".")}}
                                            @php
                                                $saldo_comissao += $fatura->total_comissao;
                                            @endphp
                                        </td>

                                        <td class="text-center">
                                            @php
                                                $lucro = $fatura->total_receita - ($receita->custo_fixo+$fatura->total_comissao);
                                                $saldo_lucro += $lucro;
                                            @endphp
                                            <span class="{{ ($lucro < 0) ? 'text-danger' : '' }}">
                                                R$ {{number_format($lucro, 2, ",", ".")}}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            não tem relatórios
                                        </td>
                                    </tr>
                                @endforelse
                                
                                @if( !empty($receita->faturas) )
                                    <tr class="text-bg-light">
                                        <td>
                                            SALDO
                                        </td>

                                        <td class="text-center">
                                            R$ {{number_format($saldo_receita, 2, ",", ".")}}
                                        </td>

                                        <td class="text-center">
                                            R$ {{number_format($saldo_custo_fixo, 2, ",", ".")}}
                                        </td>

                                        <td class="text-center">
                                            R$ {{number_format($saldo_comissao, 2, ",", ".")}}
                                        </td>

                                        <td class="text-center">
                                            <span class="{{ ($saldo_lucro < 0) ? 'text-danger' : 'text-info' }}">
                                                    R$ {{number_format($saldo_lucro, 2, ",", ".")}}
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>    
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>