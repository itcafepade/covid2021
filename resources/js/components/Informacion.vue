<template>
  <div class="container pb-2">
    <div class="col-md-12 col-sm-11 offset-sm-1 col-12">
      <div class="container">
        <div class="row pb-1">
          <div class="col-md-2 col-sm-2 col-2 offset-1 pl-1">
            <img src="/imgs/persona.png" alt="" />
          </div>
          <div class="col-md-7 col-sm-9 col-8 pr-0">
            <h6 class="mb-0">Personas visitantes</h6>
            <h2>{{ totalDatos }}</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 col-sm-11 offset-sm-1 col-12">
      <div class="container">
        <div class="row pb-1">
          <div class="col-md-2 col-sm-2 col-2 offset-1 pl-1">
            <img src="/imgs/gel.png" alt="" />
          </div>
          <div class="col-md-7 col-sm-9 col-8 pr-0">
            <h6 class="mb-0">Protocolo completo</h6>
            <h2>
              {{ conProtocoloCompleto }} ({{
                calcularPorcentaje(conProtocoloCompleto)
              }}%)
            </h2>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 col-sm-11 offset-sm-1 col-12">
      <div class="container">
        <div class="row pb-1">
          <div class="col-md-2 col-sm-2 col-2 offset-1 pl-1">
            <img src="/imgs/mascara.png" alt="" />
          </div>
          <div class="col-md-7 col-sm-9 col-8 pr-0">
            <h6 class="mb-0">Personas con mascarilla</h6>
            <h2>
              {{ conMascarilla }} ({{ calcularPorcentaje(conMascarilla) }}%)
            </h2>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 col-sm-11 offset-sm-1 col-12">
      <div class="container">
        <div class="row pb-1">
          <div class="col-md-2 col-sm-2 col-2 offset-1 pl-1">
            <img src="/imgs/sin-mascara.png" alt="" />
          </div>
          <div class="col-md-7 col-sm-9 col-8 pr-0">
            <h6 class="mb-0">Personas sin mascarilla</h6>
            <h2>
              {{ sinMascarilla }} ({{ calcularPorcentaje(sinMascarilla) }}%)
            </h2>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 col-sm-11 offset-sm-1 col-12 pr-0">
      <div class="container">
        <div class="row pb-1">
          <div class="col-md-2 col-sm-2 col-2 offset-1 pl-1">
            <img src="/imgs/temperatura.png" alt="" />
          </div>
          <div class="col-md-7 col-sm-9 col-8 pr-0">
            <h6 class="mb-0">Personas con temperatura</h6>
            <h2>
              {{ conTemperatura }} ({{ calcularPorcentaje(conTemperatura) }}%)
            </h2>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 col-sm-11 offset-sm-1 col-12">
      <div class="container">
        <div class="row pb-1">
          <div class="col-md-2 col-sm-2 col-2 offset-1 pl-1">
            <img src="/imgs/gel.png" alt="" />
          </div>
          <div class="col-md-7 col-sm-9 col-8 pr-0">
            <h6 class="mb-0">Uso total de gel</h6>
            <h2>{{ usoDeGel }} mL</h2>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    totalDatos: 0,
    conProtocoloCompleto: 0,
    conMascarilla: 0,
    sinMascarilla: 0,
    conTemperatura: 0,
    usoDeGel: 0,
  },
  methods: {
    calcularPorcentaje(numero = 0) {
      return (numero / this.totalDatos) * 100;
    },
  },
};
</script>
