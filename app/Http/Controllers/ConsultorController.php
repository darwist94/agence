<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\CaoUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultorController extends Controller
{
    public function index(Request $request)
    {
        return view('index');
    }

    public function desempenho(Request $request)
    {
        $usuarios = CaoUsuario::join('permissao_sistema', 'permissao_sistema.co_usuario', '=', 'cao_usuario.co_usuario')
            ->where('permissao_sistema.co_sistema', 1)
            ->where('permissao_sistema.in_ativo', 'S')
            ->whereIn('permissao_sistema.co_tipo_usuario', [0, 1, 2])
            ->pluck('cao_usuario.no_usuario', 'cao_usuario.co_usuario')
            ->toArray();

        $consultores_selecionado = null;
        $consultores = null;

        /**
         * guardamos ambas listas de consultores para mantener las cajas como se encontraban
         * iniciamos aqui consultores con un array vacio para en caso de que esten todos en la caja de seleccion
        */
        if ( $request->has('consultores_selecionado') ) {
            $consultores_selecionado = $request->consultores_selecionado;
            $consultores = [];
        }
    
        if ( $request->has('consultores') ) {
            $consultores = $request->consultores;
        }

        $receitas = [];
        if ( $request->has('consultores_selecionado') ) {
            
            $receitas = $this->receitas($request->consultores_selecionado, $request->rango_fecha_desde, $request->rango_fecha_hasta);
        
        }

        return view('con_desempenho', compact('usuarios', 'consultores', 'consultores_selecionado', 'receitas'));
    }

    protected function receitas(array $consultores, $fecha_inicio, $fecha_final)
    {   
        $receitas = collect([]);

        foreach ($consultores as $consultor) {

            $consultor_selecionado = CaoUsuario::leftjoin('cao_salario', 'cao_salario.co_usuario', '=', 'cao_usuario.co_usuario')
                ->where('cao_usuario.co_usuario', $consultor)
                ->select(
                    'cao_usuario.no_usuario', 
                    'cao_usuario.co_usuario',
                    'cao_salario.brut_salario as custo_fixo'
                )
                ->first();

            $faturas = DB::table('cao_os')
            ->join('cao_fatura', 'cao_fatura.co_os', '=', 'cao_os.co_os')
            ->where('cao_os.co_usuario', $consultor)
            ->where(function($query) use ($fecha_inicio, $fecha_final){
                if ($fecha_inicio != '' && $fecha_final != '') {
                    $query->whereBetween("cao_fatura.data_emissao", [$fecha_inicio, $fecha_final]);
                }
            })
            ->select(
                'cao_fatura.data_emissao',
                //'cao_fatura.valor',
                //'cao_fatura.total_imp_inc'
                DB::raw('SUM(cao_fatura.valor) as total_valor'),
                DB::raw('SUM((cao_fatura.total_imp_inc/100)*cao_fatura.valor) as total_imp'),
                DB::raw('SUM(cao_fatura.valor-((cao_fatura.total_imp_inc/100)*cao_fatura.valor)) as total_receita'),
                DB::raw('SUM((cao_fatura.valor-(cao_fatura.valor*(cao_fatura.total_imp_inc/100)))*(cao_fatura.comissao_cn/100)) as total_comissao')
            )
            ->groupBy('cao_fatura.data_emissao')
            ->get()
            ->toArray();

            $consultor_selecionado->faturas = $faturas;

            $receitas->push($consultor_selecionado);
        }

        //dd($receitas);

        return $receitas;
    }

    public function graficaLineBar(Request $request)
    {
        $receitas = $this->receitas($request->consultores_selecionado, $request->rango_fecha_desde, $request->rango_fecha_hasta);

        $fecha_desde = Carbon::parse($request->rango_fecha_desde);
        $fecha_hasta = Carbon::parse($request->rango_fecha_hasta);

        $labels = array($fecha_desde->format('d/m/Y'));

        //etiquetas del eje x que serian las fechas del rango 
        do {
            
            array_push($labels, $fecha_desde->addDay()->format('d/m/Y'));

        } while ($fecha_desde->format('d/m/Y') != $fecha_hasta->format('d/m/Y'));
        
        //sumamos todos los custos fixo para sacar el promedio
        $custo_fixo = 0;
        $promedio_custo_fixo = 0;
        $total_rows = 0;

        foreach($receitas as $receita){
            if( !is_null($receita->custo_fixo) ){
                $custo_fixo += $receita->custo_fixo;
            }

            if ( count($receita->faturas) > $total_rows ) {
                $total_rows = count($receita->faturas);
            }
        }

        //promedio custo fixo
        $promedio_custo_fixo = $custo_fixo / $receitas->count();

        //$promedio_custo_fixo = number_format($promedio_custo_fixo, 2, ",", ".");

        $dataset_line = array("type" => "line", "label" => "Custo Fixo Médio", "backgroundColor" => array('rgba(255, 99, 132, 0.2)'), "borderColor" => array('rgb(255, 99, 132)'), "data" => array());
        
        $datasets = array();
        $dataset_bar = array();

        for( $i = 0; $i < $receitas->count(); $i++ ){

            $dataset_bar = array(
                "type" => "bar", 
                "label" => $receitas[$i]->no_usuario,
                "backgroundColor" => array('rgba('.rand(0, 255).', '.rand(0, 255).', '.rand(0, 255).', 0.5)'),
                "data" => array());

            array_push($datasets, $dataset_bar);

            for ($j = 0; $j < $total_rows; $j++) {

                if( !empty($receitas[$i]->faturas) && isset($receitas[$i]->faturas[$j]) ){
                    $valor = $receitas[$i]->faturas[$j]->total_receita;
                }else{
                    $valor = 0;
                }

                array_push($datasets[$i]["data"], $valor);
            }

        }

        array_push($datasets, $dataset_line);
        
        for ($j = 0; $j < $total_rows; $j++) {

            array_push($datasets[array_key_last($datasets)]["data"], $promedio_custo_fixo);
        }

        //dd($datasets);

        $data = array("datasets" => $datasets, "labels" => $labels);

        return response()->json(["data" => $data, "success" => true]);
    }

    public function graficaPizza(Request $request)
    {
        $receitas = $this->receitas($request->consultores_selecionado, $request->rango_fecha_desde, $request->rango_fecha_hasta);

        $labels = array();
        $colors = array();
        $consultores = array();
        $consultores_porcentajes = array();
        $total_receitas = 0;

        foreach($receitas as $receita){
            $fatura_total = 0;
            array_push($labels, $receita->no_usuario);
            array_push($colors, 'rgba('.rand(0, 255).', '.rand(0, 255).', '.rand(0, 255).')');

            foreach ($receita->faturas as $fatura) {
                $fatura_total += $fatura->total_receita;
            }

            array_push($consultores, $fatura_total);
        }

        $total_receitas = array_sum($consultores);
        
        foreach( $consultores as $consultor ){

            $porcentaje = ($consultor/$total_receitas)*100;

            array_push($consultores_porcentajes, $porcentaje);
            
        }

        $datasets = array(
            "label" => "Participacao na receitas", 
            "data" => $consultores_porcentajes, 
            "backgroundColor" => $colors,
            "hoverOffset" => 4
        );
        
        $data = array("datasets" => array($datasets), "labels" => $labels);

        
        return response()->json(["data" => $data, "success" => true]);
    }
}
