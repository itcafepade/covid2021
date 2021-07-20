<template>
  <div class="container" ref="contenedorDeGraficos">
    <div class="col-md-12 col-sm-12 col-12">
      <div class="container">
        <div class="row">
          <!-- Visitantes -->
          <div class="col-md-6 col-sm-12 col-12 p-1">
            <div class="row pb-3">
              <div class="col-md-2 col-2 col-sm-2">
                <img src="/imgs/persona.png" alt="" />
              </div>
              <div class="col-md-9 col-9 col-sm-9 col-9 col-sm-9">
                <h6 class="mb-0">Personas visitantes</h6>
                <h2>{{ totalDatos }}</h2>
              </div>
              <div class="col-md-12 pt-2">
                <div class="bg-white rounded-graphic">
                  <canvas
                    ref="graficoVisitantes"
                    width="100%"
                    height="60px"
                  ></canvas>
                </div>
              </div>
            </div>
          </div>
          <!-- Visitantes -->

          <!-- Protocolo completo -->
          <div class="col-md-6 col-sm-12 col-12 p-1">
            <div class="row pb-3">
              <div class="col-md-2 col-2 col-sm-2">
                <img src="/imgs/gel.png" alt="" />
              </div>
              <div class="col-md-9 col-9 col-sm-9">
                <h6 class="mb-0">Protocolo completo</h6>
                <h2>
                  {{ conProtocoloCompleto }} ({{
                    calcularPorcentaje(conProtocoloCompleto)
                  }}%)
                </h2>
              </div>
              <div class="col-md-12 pt-2">
                <div class="bg-white rounded-graphic">
                  <canvas
                    ref="graficoProtocoloCompleto"
                    width="100%"
                    height="60px"
                  ></canvas>
                </div>
              </div>
            </div>
          </div>
          <!-- Protocolo completo -->

          <!-- Con mascarilla -->
          <div class="col-md-6 col-sm-12 col-12 p-1">
            <div class="row pb-3">
              <div class="col-md-2 col-2 col-sm-2">
                <img src="/imgs/mascara.png" alt="" />
              </div>
              <div class="col-md-9 col-9 col-sm-9">
                <h6 class="mb-0">Personas con mascarilla</h6>
                <h2>
                  {{ conMascarilla }} ({{ calcularPorcentaje(conMascarilla) }}%)
                </h2>
              </div>
              <div class="col-md-12 pt-2">
                <div class="bg-white rounded-graphic">
                  <canvas
                    ref="graficoConMascarilla"
                    width="100%"
                    height="60px"
                  ></canvas>
                </div>
              </div>
            </div>
          </div>
          <!-- Con mascarilla -->

          <!-- Sin mascarilla -->
          <div class="col-md-6 col-sm-12 col-12 p-1">
            <div class="row pb-3">
              <div class="col-md-2 col-2 col-sm-2">
                <img src="/imgs/temperatura.png" alt="" />
              </div>
              <div class="col-md-9 col-9 col-sm-9">
                <h6 class="mb-0">Personas con temperatura</h6>
                <h2>
                  {{ conTemperatura }} ({{
                    calcularPorcentaje(conTemperatura)
                  }}%)
                </h2>
              </div>
              <div class="col-md-12 pt-2">
                <div class="bg-white rounded-graphic">
                  <canvas
                    ref="graficoConTemperatura"
                    width="100%"
                    height="60px"
                  ></canvas>
                </div>
              </div>
            </div>
          </div>
          <!-- Sin mascarilla -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Chart, registerables } from "chart.js";
import moment from "moment";

Chart.register(...registerables);

export default {
  data() {
    return {
      graficoVisitantes: null,
      graficoProtocoloCompleto: null,
      graficoConMascarilla: null,
      graficoConTemperatura: null,
    };
  },
  props: {
    totalDatos: 0,
    conProtocoloCompleto: 0,
    conMascarilla: 0,
    sinMascarilla: 0,
    conTemperatura: 0,
    usoDeGel: 0,
    registros: [],
    temperaturaMaxima: 0,
  },
  mounted() {
    this.cargarGrafico(this.$refs.graficoVisitantes, this.graficoVisitantes);
    let datos = {
      completados: this.conProtocoloCompleto,
      totalRegistros: this.registros.length,
      titulo: "Visitantes con protocolo completo",
      tituloPrimerElemento: "Sin completar",
      tituloSegundoElemento: "Completado",
      numeroGrafico: 2,
    };
    this.graficoBarrasHorizontales(
      this.$refs.graficoProtocoloCompleto,
      this.graficoProtocoloCompleto,
      datos
    );

    datos = {
      completados: this.conMascarilla,
      totalRegistros: this.registros.length,
      titulo: "Visitantes con mascarilla",
      tituloPrimerElemento: "Sin mascarilla",
      tituloSegundoElemento: "Con mascarilla",
      numeroGrafico: 3,
    };
    this.graficoBarrasHorizontales(
      this.$refs.graficoConMascarilla,
      this.graficoConMascarilla,
      datos
    );

    datos = {
      completados: this.conTemperatura,
      totalRegistros: this.registros.length,
      titulo: "Visitantes con temperatura",
      tituloPrimerElemento: "Sin temperatura",
      tituloSegundoElemento: "Con temperatura",
      numeroGrafico: 3,
    };
    this.graficoBarrasHorizontales(
      this.$refs.graficoConTemperatura,
      this.graficoConTemperatura,
      datos
    );
  },
  methods: {
    /**
     * Calcula el porcentaje de los números que reciba y
     * lo formatea a 2 decimales.
     */
    calcularPorcentaje(numero = 0) {
      return ((numero / this.totalDatos) * 100).toFixed(2);
    },
    /**
     * Crea un nuevo elemento del gráfico a partir de los registros.
     */
    cargarGrafico(graficoCanvas, canvas) {
      const DATA_COUNT = this.registros.length;
      const labels = [];
      let temperaturasMaximas = [];
      let datapoints = [];
      let j = 1;

      this.fechaInicio = moment(new Date(this.registros[0].created_at)).format(
        "DD/MM/YYYY"
      );
      this.fechaFinal = moment(
        new Date(this.registros[this.registros.length - 1].created_at)
      ).format("DD/MM/YYYY");

      for (let i = 0; i < DATA_COUNT; ++i) {
        labels.push(j.toString());
        temperaturasMaximas.push(this.temperaturaMaxima);
        datapoints.push(this.registros[i].temperatura);
        j++;
      }

      const data = {
        labels: labels,
        datasets: [
          {
            label: "Temp. Máxima",
            data: temperaturasMaximas,
            borderColor: "#FF6384",
            fill: false,
            cubicInterpolationMode: "monotone",
            tension: 0.4,
          },
          {
            label: "Temp. Visitante",
            data: datapoints,
            borderColor: "#36A2EB",
            fill: false,
            tension: 0.4,
          },
        ],
      };

      //Destruyendo canvas para reutilizarlo.
      if (canvas != null) {
        canvas.destroy();
        canvas = null;
      }

      const grafico = graficoCanvas.getContext("2d");
      graficoCanvas = new Chart(grafico, {
        type: "line",
        data: data,
        options: {
          responsive: true,
          plugins: {
            title: {
              display: true,
              text: [
                `Temperatura visitantes`,
                ` Desde: ${this.fechaInicio} Hasta: ${this.fechaFinal}`,
              ],
            },
          },
          interaction: {
            intersect: false,
          },
          scales: {
            x: {
              display: true,
              title: {
                display: true,
              },
            },
            y: {
              display: true,
              title: {
                display: true,
                text: "Visitantes",
              },
              suggestedMin: 30,
              suggestedMax: 42,
            },
          },
        },
      });
    },
    graficoBarrasHorizontales(graficoCanvas, canvas, datos) {
      const totalPrimerElemento = datos.totalRegistros - datos.completados;
      const totalSegundoElemento = datos.completados;

      const data = {
        labels: ["Visitantes"],
        datasets: [
          {
            label: datos.tituloPrimerElemento,
            data: [totalPrimerElemento],
            borderColor: "#FF6384",
          },
          {
            label: datos.tituloSegundoElemento,
            data: [totalSegundoElemento],
            borderColor: "#36A2EB",
          },
        ],
      };

      const config = {
        type: "bar",
        data: data,
        options: {
          indexAxis: "y",
          // Elements options apply to all of the options unless overridden in a dataset
          // In this case, we are setting the border of each horizontal bar to be 2px wide
          elements: {
            bar: {
              borderWidth: 2,
            },
          },
          responsive: true,
          plugins: {
            legend: {
              position: "top",
            },
            title: {
              display: true,
              text: datos.titulo,
            },
          },
        },
      };

      //Destrui gráfico para actualizarlo
      if (canvas != null) {
        graficoCanvas.destroy();
        canvas = null;
      }

      const grafico = graficoCanvas.getContext("2d");
      graficoCanvas = new Chart(grafico, config);
    },
  },
};
</script>
