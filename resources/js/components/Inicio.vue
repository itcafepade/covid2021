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
      <div class="container-fluid" v-if="registros.length > 0">
        <div class="row">
          <div class="col-xl-4 offset-xl-1 col-lg-5 col-md-5 col-sm-12 pr-0">
            <informacion
              :totalDatos="totalDatos"
              :conProtocoloCompleto="conProtocoloCompleto"
              :conMascarilla="conMascarilla"
              :sinMascarilla="sinMascarilla"
              :usoDeGel="usoTotalDeGel"
              :conTemperatura="conTemperatura"
              :key="actualizarComponente"
            />
          </div>
          <div class="col-xl-5 col-lg-7 col-md-7 col-sm-12 col-12">
            <div class="bg-white rounded-graphic">
              <canvas ref="myChart" width="100%"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="text-center text-white">
        <div
          class="spinner-border text-light"
          role="status"
          style="width: 5rem; height: 5rem"
        >
          <span class="sr-only">Obteniendo los datos...</span>
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
            <div class="container" v-if="registros.length > 0">
              <div class="row pb-4">
                <div
                  class="col-md-3 col-sm-4 col-4 pt-4"
                  v-for="registro in registros"
                  :key="registro._id"
                >
                  <img :src="registro.foto" class="img-fluid rounded-circle" />
                </div>
              </div>
            </div>
            <div v-else class="text-center pt-3">
              <div
                class="spinner-border"
                role="status"
                style="width: 3rem; height: 3rem"
              >
                <span class="sr-only">Obteniendo los datos...</span>
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
            <input
              type="date"
              class="form-control mb-3"
              v-model="filtroFechaInicio"
            />
            <h5 class="lead mb-0 text-darkblue">Final</h5>
            <input
              type="date"
              class="form-control mb-3"
              v-model="filtroFechaFinal"
            />
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-warning"
              @click="limpiarFiltro()"
            >
              Limpiar
            </button>
            <button
              type="button"
              class="btn btn-primary"
              @click="filtrarPorFecha()"
            >
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
import moment from "moment";
import Alerta from "../libs/alerta";

const alerta = new Alerta();
Chart.register(...registerables);

export default {
  components: { informacion },
  data() {
    return {
      temperaturaMaxima: "",
      registros: [],
      fechaInicio: "",
      fechaFinal: "",
      conProtocoloCompleto: 0,
      conMascarilla: 0,
      sinMascarilla: 0,
      usoTotalDeGel: 0,
      conTemperatura: 0,
      actualizarComponente: 0,
      filtroHoraFinal: "",
      filtroFechaFinal: "",
      filtroHoraInicio: "",
      filtroFechaInicio: "",
      graficoCanvas: null,
      fotosSinMascarilla: [],
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    async init() {
      await this.obtenerAjustes();
      await this.obtenerRegistros();
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
    async obtenerRegistros() {
      try {
        const res = await axios.get("api/registro");
        this.registros = res.data.registros;
        this.calculoDeRegistros();
      } catch (error) {
        alerta.mensaje("Error al obtener los registros.", "error");
      }
    },
    cargarGrafico() {
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
        // labels.push(
        //   moment(new Date(this.registros[i].created_at)).format(
        //     "DD/MM/YYYY hh:mm A"
        //   )
        // );
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
      if (this.graficoCanvas != null) {
        this.graficoCanvas.destroy();
        this.graficoCanvas = null;
      }

      const grafico = this.$refs.myChart.getContext("2d");
      this.graficoCanvas = new Chart(grafico, {
        type: "line",
        data: data,
        options: {
          responsive: true,
          plugins: {
            title: {
              display: true,
              text: [
                `Temperatura visitantes`,
                "ITCA-FEPADE",
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
                text: "Value",
              },
              suggestedMin: 30,
              suggestedMax: 42,
            },
          },
        },
      });
    },
    calculoDeRegistros() {
      this.totalDatos = this.registros.length;

      let conProtocoloCompleto = 0;
      let conMascarilla = 0;
      let sinMascarilla = 0;
      let usoTotalDeGel = 0;
      let conTemperatura = 0;
      let fotosSinMascarilla = [];
      let j = 0;

      this.registros.forEach((el) => {
        if (el.protocolo_completo) {
          conProtocoloCompleto++;
          conMascarilla++;
        }

        if (!el.sinMascarilla) {
          sinMascarilla++;
          if (j <= 8) {
            //Hasta 8 fotos disponibles sin mascarilla
            fotosSinMascarilla.push(el.foto);
            j++;
          }
        }

        if (el.temperatura >= this.temperaturaMaxima) {
          conTemperatura++;
        }

        usoTotalDeGel += parseFloat(el.usoDeGel).toFixed(2);
      });

      this.conProtocoloCompleto = conProtocoloCompleto;
      this.conMascarilla = conMascarilla;
      this.sinMascarilla = sinMascarilla;
      this.usoTotalDeGel = usoTotalDeGel;
      this.fotosSinMascarilla = fotosSinMascarilla;
      this.conTemperatura = conTemperatura;

      this.actualizarComponente++;
    },
    limpiarFiltro() {
      this.filtroHoraFinal = "";
      this.filtroFechaFinal = "";
      this.filtroHoraInicio = "";
      this.filtroFechaInicio = "";
    },
    async filtrarPorFecha() {
      const fechaInicio = new Date(this.filtroFechaInicio);

      const fechaFinal = new Date(this.filtroFechaFinal);

      try {
        const res = await axios.post("api/filtrarRegistro", {
          fechaInicio: fechaInicio,
          fechaFinal: fechaFinal,
        });

        if (res.data.registros.length == 0) {
          alerta.mensaje(
            "No se encontraron registros entre las fechas especificadas.",
            "info"
          );

          return;
        }

        this.registros = res.data.registros;
        this.calculoDeRegistros();
        this.cargarGrafico();
        alerta.mensaje("Registros actualizados.", "success");
      } catch (error) {
        console.log(error);
        alerta.mensaje("Error al obtener los registros.", "error");
      }
    },
  },
};
</script>
