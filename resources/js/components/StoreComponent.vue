
<template>
  <div>
    <b-container fluid>
      <b-row align-h="center" class="my-5">
        <b-col cols="4">
          <b-button block v-b-modal.modal-1>Agregar una nueva Bodega</b-button>
        </b-col>
      </b-row>

      <b-row align-h="center">
      <b-pagination
        v-model="currentPage"
        :total-rows="rows"
        :per-page="perPage"
        aria-controls="my-table"
       align="fill"></b-pagination>
      </b-row>
      <b-row align-h="center" class="mx-5">
        <b-table
          striped
          hover
          :fields="fields"
          :items="stores"
          :per-page="perPage"
          :current-page="currentPage"
        >
          <template v-slot:cell(#)="data">{{ data.index + 1 }}</template>
          <template v-slot:cell(Editar)="data"> <b-button  variant="primary" @click="updateFruit(data.item.id)">Editar {{data.item.id}}</b-button></template>
        </b-table>
      </b-row>
    </b-container>

    <b-modal id="modal-1" ref="modal-2" title="Nueva fruta" size="lg" hide-footer>
      <b-container fluid>
        <b-form>
          <b-row class="my-3">
            <b-col sm="12">
              <b-form-input
                id="fruit-name"
                v-model="name"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Ingrese el nombre de la fruta"
                trim
              ></b-form-input>
            </b-col>
          </b-row>

          <b-row class="my-3">
            <b-col sm="12">
              <b-form-input
                id="fruit-address"
                v-model="address"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Ingrese la descripción de la fruta"
                trim
              ></b-form-input>
            </b-col>
          </b-row>

          <b-button @click="saveFruit()" variant="primary">Enviar</b-button>
        </b-form>
      </b-container>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: ["stores-array"],
  data() {
    return {
      perPage: 10,
      currentPage: 1,
      fields: [
        "#",
        { key: "name", label: "Nombre" },
        { key: "address", label: "Dirección" },
        "Editar"
      ],
      stores: JSON.parse(this.storesArray),
      name: "",
      address: ""
    };
  },
  mounted() {
  },
  computed: {
    rows() {
      return this.stores.length;
    }
  },
  methods: {
    getstores() {
      return (this.stores = JSON.parse(this.storesArray));
    },
    saveFruit() {
      let me = this;
      let url = "/createStore"; 
      axios.post(url, {

          name: this.name,
          address: this.address
        })
        .then(function(response) {
          me.clearFields(); 
        })
        .catch(function(error) {
          console.log(error);
        });
        this.$refs['modal-2'].hide();
    },
    updateFruit(id){
      console.log("hola: "+id)
    },
    clearFields() {
      this.name = "";
      this.address = "";
    }
  }
};
</script>

