@extends("layout.master")
@section("contenedor")
<div class="card card-frame">
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#consultor-tab-pane" type="button" role="tab" aria-controls="consultor-tab-pane" aria-selected="true">Por Consultor</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#cliente-tab-pane" type="button" role="tab" aria-controls="cliente-tab-pane" aria-selected="false">Por Cliente</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="consultor-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                @include('includes._panel_consultor')
                @include('includes._panel_receitas')
                @include('includes._panel_grafico')
                @include('includes._panel_pizza')
            </div>
            <div class="tab-pane fade" id="cliente-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    const buttonRelatorio = document.getElementById("relatorio")
    const buttonPizza = document.getElementById("pizza")
    
    buttonRelatorio.addEventListener("click", (event) => {
        
        const form = document.getElementById("desempenho")

        selecionar_tudo("list1")
        selecionar_tudo("list2")
    
        form.submit()

    })

    const buttonGrafico = document.getElementById("grafico_chart")
    let mixedChart;

    buttonGrafico.addEventListener("click", async (event) => {

        const form = document.getElementById("desempenho")
        const receitas = document.getElementById("receitas")
        //para seleccionar todos los del box derecho para enviar datos
        selecionar_tudo("list1")
        selecionar_tudo("list2")
        
        route = "{{ route('graph_linebar') }}"

        let formData = new FormData(document.getElementById("desempenho"));

        let json = {
            rango_fecha_desde: formData.get('rango_fecha_desde'),
            rango_fecha_hasta: formData.get('rango_fecha_hasta'),
            consultores_selecionado: formData.getAll('consultores_selecionado[]')
        }

        const request = await fetch(route, {
            method: 'POST',
            body: JSON.stringify(json),
            headers :{
                'X-Requested-With': 'XMLHttpRequest',
                "Content-type": "application/json",
                'X-CSRF-TOKEN': document.querySelector('meta[name="token"]').getAttribute('content')
            }
        })

        selecionar_tudo("list1", false)
        selecionar_tudo("list2", false)

        const response = await request.json()
        
        if( response.success ){
            let data = response.data

            //toco parsear sl string apra que lo tomará la grafica
            for (let i = 0;  i < data.datasets.length; i++) {
                for (let j = 0; j < data.datasets[i].data.length; j++) {
                    
                    data.datasets[i].data[j] = Number.parseFloat(data.datasets[i].data[j]);
                }
            }
            
            const ctx = document.getElementById('graph').getContext('2d');
            
            if (mixedChart) {
                mixedChart.destroy();
            }

            mixedChart = new Chart(ctx, {
                data: data
            });
            
            receitas.style.display = 'none'
        }

    })

    const buttonGraficoPizza = document.getElementById("grafico_pizza")
    let pieChart;

    buttonGraficoPizza.addEventListener("click", async (event) => {

        const form = document.getElementById("desempenho")
        const receitas = document.getElementById("receitas")
        //para seleccionar todos los del box derecho para enviar datos
        selecionar_tudo("list1")
        selecionar_tudo("list2")
        
        route = "{{ route('graph_pizza') }}"

        let formData = new FormData(document.getElementById("desempenho"));

        let json = {
            rango_fecha_desde: formData.get('rango_fecha_desde'),
            rango_fecha_hasta: formData.get('rango_fecha_hasta'),
            consultores_selecionado: formData.getAll('consultores_selecionado[]')
        }

        const request = await fetch(route, {
            method: 'POST',
            body: JSON.stringify(json),
            headers :{
                'X-Requested-With': 'XMLHttpRequest',
                "Content-type": "application/json",
                'X-CSRF-TOKEN': document.querySelector('meta[name="token"]').getAttribute('content')
            }
        })

        selecionar_tudo("list1", false)
        selecionar_tudo("list2", false)

        const response = await request.json()
        
        if( response.success ){
            let data = response.data
            //
            const ctx = document.getElementById('graph_pizza').getContext('2d');
            
            if (pieChart) {
                pieChart.destroy();
            }

            pieChart = new Chart(ctx, {
                plugins: [ChartDataLabels],
                type: 'pie',
                data: data,
                options: {
                    plugins: {
                        datalabels: {
                            /* anchor puede ser "start", "center" o "end" */
                            anchor: "center",
                            /* Podemos modificar el texto a mostrar */
                            formatter: (dato) => dato.toFixed(2) + "%",
                            /* Color del texto */
                            color: "black",
                            /* Formato de la fuente */
                            font: {
                            family: '"Times New Roman", Times, serif',
                            size: "14",
                            weight: "bold",
                            },
                            /* Formato de la caja contenedora */
                            //padding: "4",
                            //borderWidth: 2,
                            //borderColor: "darkblue",
                            //borderRadius: 8,
                            //backgroundColor: "lightblue"
                        }
                    }
                }
            });


            receitas.style.display = 'none'
        }

    })

    function selecionar_tudo(select_id, selected = true) {
        
        let select = document.getElementById(select_id);

        for (var i = 0; i < select.options.length; i++) {
            select.options[i].selected = selected;
        }
    }

    function move(fbox, tbox) {
        
        var arrFbox = new Array();
        var arrTbox = new Array();
        var arrLookup = new Array();
        var i;
        for (i = 0; i < tbox.options.length; i++) {
        arrLookup[tbox.options[i].text] = tbox.options[i].value;
        arrTbox[i] = tbox.options[i].text;
        }
        var fLength = 0;
        var tLength = arrTbox.length;
        for(i = 0; i < fbox.options.length; i++) {
        arrLookup[fbox.options[i].text] = fbox.options[i].value;
        if (fbox.options[i].selected && fbox.options[i].value != "") {
        arrTbox[tLength] = fbox.options[i].text;
        tLength++;
        }
        else {
        arrFbox[fLength] = fbox.options[i].text;
        fLength++;
        }
        }
        arrFbox.sort();
        arrTbox.sort();
        fbox.length = 0;
        tbox.length = 0;
        var c;
        for(c = 0; c < arrFbox.length; c++) {
        var no = new Option();
        no.value = arrLookup[arrFbox[c]];
        no.text = arrFbox[c];
        fbox[c] = no;
        }
        for(c = 0; c < arrTbox.length; c++) {
        var no = new Option();
        no.value = arrLookup[arrTbox[c]];
        no.text = arrTbox[c];
        tbox[c] = no;
        }
    }
    //  fim de selection box -->
</script>
@stop