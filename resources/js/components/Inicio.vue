<template>
  <div class="container-fluid p-0 m-0">
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
            <a
              href="#"
              class="btn btn-success ml-1"
              @click="init()"
              v-if="!datosIniciales"
              ><i class="bi bi-house"></i> Inicio</a
            >
          </div>
          <div class="col-md-12 col-sm-12 mb-3 pr-0"></div>
        </div>
      </div>
      <!-- Encabezado -->
      <!-- Datos -->
      <div class="container-fluid" v-if="registros.length > 0">
        <div class="row">
          <div class="col-12 col-md-12 p-0 m-0 col-sm-12 col-xl-12">
            <informacion
              :totalDatos="totalDatos"
              :conProtocoloCompleto="conProtocoloCompleto"
              :conMascarilla="conMascarilla"
              :sinMascarilla="sinMascarilla"
              :usoDeGel="usoTotalDeGel"
              :conTemperatura="conTemperatura"
              :registros="registros"
              :temperaturaMaxima="temperaturaMaxima"
              :key="actualizarComponente"
            />
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

      <div class="container mb-0 mt-0 pt-0">
        <div class="row pt-0 mt-0">
          <div class="img-covid">
            <img src="/imgs/covid.svg" />
          </div>
        </div>
      </div>
      <!-- Datos -->
    </div>
    <!-- SVG -->
    <div class="container-fluid pt-0 bg-white">
      <div class="row">
        <div class="svg mr-0">
          <svg
            height="100%"
            width="100%"
            id="svg"
            viewBox="0 0 1440 260"
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
    <!-- SVG -->
    <!-- Galería -->
    <div class="container-fluid bg-white" id="divContSinMascarilla">
      <div class="container">
        <a
          href="#divContSinMascarilla"
          class="text-dark text-decoration-none"
          @click="mostrarDiv"
          ><h4 class="text-darkblue">
            <i class="bi bi-chevron-down"></i> Fotografías registradas sin
            mascarilla
          </h4></a
        >
        <div class="row" id="divSinMascarilla">
          <div class="col-md-4 pt-4 pb-4">
            <h5 class="text-darkblue">
              Estas fotografías son personas que no llevaban mascarilla o
              aquellas en las que el algoritmo no fue capaz de detectarla.
            </h5>
          </div>
          <div class="col-md-8 mt-4" v-if="registros.length > 0">
            <div class="row">
              <div
                class="col-md-4"
                v-for="registro in fotosSinMascarilla"
                :key="registro._id"
              >
                {{ registro._id }}
                <img
                  style="width: 110px; height: 110px"
                  class="mt-0 ml-1 rounded-circle"
                  :src="registro"
                />
              </div>
            </div>
          </div>
          <div v-else class="mx-auto pt-3">
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
    <!-- Galería -->

    <!-- Modal -->
    <div class="modal fade" id="modalFiltro" ref="modal">
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
import informacion from "./Informacion.vue";
import axios from "axios";
import moment from "moment";
import Alerta from "../libs/alerta";
import Interfaz from "../libs/interfaz";

const alerta = new Alerta();
const ui = new Interfaz();

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
      fotosSinMascarilla: [],
      datosIniciales: true,
      animacionesOcultas: {
        divSinMascarilla: {
          nombre: "divSinMascarilla",
          estado: false,
        },
      },
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    /**
     * Invoca los métodos cuando recién se monta el componente.
     */
    async init() {
      this.datosIniciales = true;
      await this.obtenerAjustes();
      await this.obtenerRegistros();
      //   this.cargarGrafico();
    },
    /**
     * Obtiene el valor máximo de temperatura que luego será utilizado en la gráfica.
     */
    async obtenerAjustes() {
      try {
        const res = await axios.get("api/ajustes");
        this.temperaturaMaxima = res.data.ajustes.temperatura;
      } catch (error) {
        alerta.mensaje("Error al obtener el valor de la temperatura.", "error");
      }
    },
    /**
     * Obtiene los últimos 50 registros.
     */
    async obtenerRegistros() {
      try {
        const res = await axios.get("api/registro");
        this.registros = res.data.registros;
        this.calculoDeRegistros();
      } catch (error) {
        alerta.mensaje("Error al obtener los registros.", "error");
      }
    },

    /**
     * Realizar los cálculos de los registros obtenidos para luego ser dibujados
     * en el componente Información.
     */
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
        if (el.protocoloCompleto) {
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

        usoTotalDeGel += parseFloat(el.usoDeGel);
      });

      this.conProtocoloCompleto = conProtocoloCompleto;
      this.conMascarilla = conMascarilla;
      this.sinMascarilla = sinMascarilla;
      this.usoTotalDeGel = usoTotalDeGel.toFixed(2);
      this.fotosSinMascarilla = fotosSinMascarilla;
      this.conTemperatura = conTemperatura;

      this.actualizarComponente++;
    },
    /**
     * Elimina los valores asignados a las variables de filtrarPorFechas.
     */
    limpiarFiltro() {
      this.filtroHoraFinal = "";
      this.filtroFechaFinal = "";
      this.filtroHoraInicio = "";
      this.filtroFechaInicio = "";
    },
    /**
     * Actualiza los registros filtrando por una fecha de inicio y una fecha final.
     */
    async filtrarPorFecha() {
      this.datosIniciales = false;
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
        // this.cargarGrafico();
        alerta.mensaje("Registros actualizados.", "success");
        $(this.$refs.modal).modal("hide");
      } catch (error) {
        console.log(error);
        alerta.mensaje("Error al obtener los registros.", "error");
      }
    },
    /*
    Muesta y Oculta el div de personas sin mascarilla
    */
    mostrarDiv(e) {
      const icono = e.target.parentNode.parentNode.querySelector(".bi");
      const div = e.target.parentNode.parentNode.querySelector(".row");

      const ref = div.getAttribute("id");

      // if (ref == this.animacionesOcultas.variables.nombre) {
      //   let estado = ui.mostrarObjeto(
      //     div,
      //     this.animacionesOcultas.variables,
      //     icono
      //   );

      //   this.animacionesOcultas.variables.estado = estado;
      // }

      // if (ref == this.animacionesOcultas.generales.nombre) {
      //   const estado = ui.mostrarObjeto(
      //     div,
      //     this.animacionesOcultas.generales,
      //     icono
      //   );

      //   this.animacionesOcultas.generales.estado = estado;
      // }

      // if (ref == this.animacionesOcultas.graficos.nombre) {
      //   const estado = ui.mostrarObjeto(
      //     div,
      //     this.animacionesOcultas.graficos,
      //     icono
      //   );

      //   this.animacionesOcultas.graficos.estado = estado;
      // }

      if (ref == this.animacionesOcultas.divSinMascarilla.nombre) {
        const estado = ui.mostrarObjeto(
          div,
          this.animacionesOcultas.divSinMascarilla,
          icono
        );

        this.animacionesOcultas.divSinMascarilla.estado = estado;
      }
    },
  },
};
</script>
