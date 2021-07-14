<template>
  <div class="container pt-3">
    <div class="row">
      <div class="col-md-12">
        <div class="media">
          <img
            src="/imgs/ajustes.png"
            class="align-self-center mr-3"
            alt="..."
          />
          <div class="media-body ajustes-text">
            <h1>Ajustes</h1>
          </div>
        </div>
        <div class="col-md-4 pt-3">
          <div class="input-group">
            <p class="temperatura-text pr-2">Temperatura (°C)</p>
            <input
              type="number"
              step="0.01"
              class="form-control"
              v-model="temperatura"
            />
          </div>
        </div>
        <a href="#" class="btn btn-primary mt-3" @click="modificar()"
          ><i class="bi bi-archive"></i> Modificar</a
        >
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Alerta from "../libs/alerta";

const alerta = new Alerta();

export default {
  data() {
    return {
      temperatura: 0,
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    async init() {
      try {
        const res = await axios.get("api/ajustes");
        this.ajustes = res.data.ajustes;
        this.temperatura = res.data.ajustes.temperatura;
      } catch (error) {
        alerta.mensaje("Error al obtener el valor de la temperatura.", "error");
      }
    },
    async modificar() {
      try {
        const ajustes = {
          _id: this.ajustes._id,
          temperatura: this.temperatura,
        };
        const res = await axios.post("api/actualizarAjustes", ajustes);

        if (res.data.mensaje == "exito") {
          alerta.mensaje("Ajustes actualizados correctamente.", "success");
        }
      } catch (error) {
        console.log(error);
        alerta.mensaje("Error al obtener el valor de la temperatura.", "error");
      }
    },
  },
};
</script>
