<template>
  <div class="container-fluid">
    <div class="row overflow-hidden">
      <div class="landing bg-dark-blue">
        <div class="col-md-12 col-sm-12">
          <h2 class="text-center mt-3">
            Resumen general de visistantes <br />
            ITCA-FEPADE
          </h2>
        </div>
        <div class="col-md-12 col-sm-12 mb-3">
          <a href="#" class="btn btn-primary ml-5">Filtrar</a>
        </div>
        <div class="img-covid overflow-hidden">
          <img src="/imgs/covid.svg" class="img-fondo" />
        </div>
        <div class="row">
          <div class="col-md-5 col-sm-12 pr-0">
            <div class="container">
              <informacion />
            </div>
          </div>

          <div class="col-md-6 col-sm-12 col-12 pl-0" style="height: 300px">
            <div class="container-fluid bg-white rounded">
              <canvas ref="myChart" width="100%" height="60"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="svg">
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
  </div>
</template>

  <script>
import { Chart, registerables } from "chart.js";
import informacion from "./Informacion.vue";

const DATA_COUNT = 6;
const labels = [];
for (let i = 0; i < DATA_COUNT; ++i) {
  labels.push(i.toString());
}
const datapoints = [32, 33.5, 34, 35, 36, 33];
const data = {
  labels: labels,
  datasets: [
    {
      label: "Temp. Máxima",
      data: [37.5, 37.5, 37.5, 37.5, 37.5, 37.5],
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

Chart.register(...registerables);

export default {
  components: { informacion },
  mounted() {
    const grafico = this.$refs.myChart.getContext("2d");
    new Chart(grafico, {
      type: "line",
      data: data,
      options: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: "Chart.js Line Chart - Cubic interpolation mode",
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
};
</script>
