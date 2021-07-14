<template>
  <div class="container-fluid p-0">
    <div class="landing bg-dark-blue">
      <!-- Encabezado -->
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <h2 class="text-center mt-3">
              Resumen general de visistantes <br />
              ITCA-FEPADE
            </h2>
          </div>
          <!-- Button trigger modal -->

          <div class="col-md-12 col-sm-12 mb-3 pr-0">
            <a
              href="#"
              class="btn btn-primary ml-5"
              data-toggle="modal"
              title="Filtrar"
              data-target="#modalFiltro"
              ><i class="bi bi-funnel"></i> Filtrar</a
            >
          </div>
        </div>
      </div>
      <!-- Encabezado -->
      <!-- Datos -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-xl-4 offset-xl-1 col-lg-5 col-md-5 col-sm-12 pr-0">
            <informacion />
          </div>
          <div class="col-xl-5 col-lg-7 col-md-7 col-sm-12 col-12">
            <div class="bg-white rounded-graphic">
              <canvas ref="myChart" width="100%"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="container mb-1">
        <div class="row">
          <div class="img-covid">
            <img src="/imgs/covid.svg" />
          </div>
        </div>
      </div>
      <!-- Datos -->
      <!-- SVG -->
      <!-- <div class="container-fluid d-none d-sm-none d-md-block">
        <div class="row">
          <div class="svg mr-0">
            <svg
              height="100%"
              width="100%"
              id="svg"
              viewBox="0 0 1440 400"
              xmlns="http://www.w3.org/2000/svg"
              class="transition duration-300 ease-in-out delay-150"
            >
              <path
                d="M 0,400 C 0,400 0,200 0,200 C 124.35714285714286,171 248.71428571428572,142 356,141 C 463.2857142857143,140 553.5000000000001,166.99999999999997 669,193 C 784.4999999999999,219.00000000000003 925.2857142857142,244.00000000000003 1058,245 C 1190.7142857142858,245.99999999999997 1315.357142857143,223 1440,200 C 1440,200 1440,400 1440,400 Z"
                stroke="none"
                stroke-width="0"
                fill="#212529ff"
                class="transition-all duration-300 ease-in-out delay-150"
                transform="rotate(-180 720 200)"
              ></path>
            </svg>
          </div>
        </div>
      </div> -->
      <!-- SVG -->
    </div>
    <!-- Galería -->
    <div class="container-fluid bg-white">
      <div class="container">
        <div class="row">
          <div class="col-md-5 offset-md-1 pt-4 pb-4">
            <h2 class="text-darkblue">
              Fotografías registradas sin mascarilla
            </h2>
            <h5 class="text-darkblue">
              Estas fotografías son personas que no llevaban mascarilla o
              aquellas en las que el algoritmo no fue capaz de detectarla.
            </h5>
          </div>
          <div class="col-md-6">
            <div class="container">
              <div class="row pb-4">
                <div class="col-md-3 col-sm-4 col-4 pt-4">
                  <img
                    src="https://cdn.vuetifyjs.com/images/john.jpg"
                    class="img-fluid rounded-circle"
                  />
                </div>
                <div class="col-md-3 col-sm-4 col-4 pt-4">
                  <img
                    src="https://cdn.vuetifyjs.com/images/john.jpg"
                    class="img-fluid rounded-circle"
                  />
                </div>
                <div class="col-md-3 col-sm-4 col-4 pt-4">
                  <img
                    src="https://cdn.vuetifyjs.com/images/john.jpg"
                    class="img-fluid rounded-circle"
                  />
                </div>
                <div class="col-md-3 col-sm-4 col-4 pt-4">
                  <img
                    src="https://cdn.vuetifyjs.com/images/john.jpg"
                    class="img-fluid rounded-circle"
                  />
                </div>
                <div class="col-md-3 col-sm-4 col-4 pt-4">
                  <img
                    src="https://cdn.vuetifyjs.com/images/john.jpg"
                    class="img-fluid rounded-circle"
                  />
                </div>
                <div class="col-md-3 col-sm-4 col-4 pt-4">
                  <img
                    src="https://cdn.vuetifyjs.com/images/john.jpg"
                    class="img-fluid rounded-circle"
                  />
                </div>
                <div class="col-md-3 col-sm-4 col-4 pt-4">
                  <img
                    src="https://cdn.vuetifyjs.com/images/john.jpg"
                    class="img-fluid rounded-circle"
                  />
                </div>
                <div class="col-md-3 col-sm-4 col-4 pt-4">
                  <img
                    src="https://cdn.vuetifyjs.com/images/john.jpg"
                    class="img-fluid rounded-circle"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Galería -->

    <!-- Modal -->
    <div class="modal fade" id="modalFiltro">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-darkblue" id="staticBackdropLabel">
              Filtrar
            </h5>
            <button
              type="button"
              class="close text-darkblue"
              data-dismiss="modal"
              aria-label="Close"
            >
              <i class="bi bi-x-lg"></i>
            </button>
          </div>
          <div class="modal-body">
            <h5 class="lead mb-0 text-darkblue">Inicio</h5>
            <input type="date" class="form-control mb-3" id="filterStartDate" />
            <input type="time" class="form-control mb-3" id="filterStartTime" />
            <h5 class="lead mb-0 text-darkblue">Final</h5>
            <input type="date" class="form-control mb-3" id="filterEndDate" />
            <input type="time" class="form-control mb-3" id="filterEndTime" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning" id="cleanFilter">
              Limpiar
            </button>
            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button> -->
            <button type="button" class="btn btn-primary" id="filter">
              Filtrar
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
  </div>
</template>

  <script>
import { Chart, registerables } from "chart.js";
import informacion from "./Informacion.vue";
import axios from "axios";

Chart.register(...registerables);

export default {
  components: { informacion },
  data() {
    return {
      temperaturaMaxima: "",
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    async init() {
      await this.obtenerAjustes();
      this.cargarGrafico();
    },
    async obtenerAjustes() {
      try {
        const res = await axios.get("api/ajustes");
        this.temperaturaMaxima = res.data.ajustes.temperatura;
      } catch (error) {
        alerta.mensaje("Error al obtener el valor de la temperatura.", "error");
      }
    },
    cargarGrafico() {
      const DATA_COUNT = 6;
      const labels = [];
      const temperaturasMaximas = [];
      for (let i = 0; i < DATA_COUNT; ++i) {
        labels.push(i.toString());
        console.log(this.temperaturaMaxima);
        temperaturasMaximas.push(this.temperaturaMaxima);
      }
      const datapoints = [32, 33.5, 34, 35, 36, 33];
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

      const grafico = this.$refs.myChart.getContext("2d");
      new Chart(grafico, {
        type: "line",
        data: data,
        options: {
          responsive: true,
          plugins: {
            title: {
              display: true,
              text: "Temperatura visitantes a ITCA-FEPADE",
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
                text: "Value",
              },
              suggestedMin: 30,
              suggestedMax: 42,
            },
          },
        },
      });
    },
  },
};
</script>
