
<template>
  <div>
    <b-container fluid>
      <b-row align-h="center" class="my-5">
        <b-col cols="4">
          <b-button block @click="openSaveFruit()">Agregar una nueva Bodega</b-button>
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
          <template v-slot:cell(Editar)="data"> <b-button  variant="primary" @click="openEditStore(data.item.id)">Editar</b-button></template>
        </b-table>
      </b-row>
    </b-container>

    <b-modal id="modal-1" ref="modal-2" title="Bodega" size="lg" hide-footer>
      <b-container fluid>
        <b-form>
          <b-row class="my-3">
            <b-col sm="12">
              <b-form-input
                id="fruit-name"
                v-model="name"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Ingrese el nombre de la bodega"
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
                placeholder="Ingrese la dirección de la bodega"
                trim
              ></b-form-input>
            </b-col>
          </b-row>

          <b-button @click="saveFruit()" variant="primary">{{btnStore}}</b-button>
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
      storeId: null,
      btnStore: null,
      fields: [
        "#",
        { key: "name", label: "Nombre" },
        { key: "address", label: "Dirección" },
        "Editar"
      ],
      stores: JSON.parse(this.storesArray),
      name: null,
      address: null
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
    makeErrorToast(message) {
      if (message == "") {
        message = "Ocurrió un problema, intente de nuevo";
      }
      this.$bvToast.toast(message, {
        title: `Error`,
        variant: "danger",
        solid: true
      });
    },
    makeSuccessToast() {
      this.$bvToast.toast("Registro guardado correctamente", {
        title: `Éxito`,
        variant: "success",
        solid: true
      });
    },
    getstores() {
      return (this.stores = JSON.parse(this.storesArray));
    },
    saveFruit() {
      let me = this;
      let url = "/createStore"; 
      if(this.btnStore == "Actualizar"){
        url = "/updateStore";
      }
      axios.post(url, {
          id: this.storeId,
          name: this.name,
          address: this.address
        })
        .then(function(response) {
          me.stores = response.data.stores;
          me.makeSuccessToast();
        })
        .catch(function(error) {
          console.log(error);
        });
        this.$refs['modal-2'].hide();
    },
    openSaveFruit(){
      this.btnStore = "Guardar";
      this.clearFields();
      this.$refs['modal-2'].show();
    },
    openEditStore(id){
      this.storeId = id;
      this.btnStore = "Actualizar";
      let me = this;
      axios
        .get("/editStore", {
          params: {
            id: id
          }
        })
        .then(function(response) {
          console.log(response)
          me.name = response.data.store.name;
          me.address = response.data.store.address;
          me.$refs["modal-2"].show();
        })
        .catch(function(error) {
          console.log(error);
          me.makeErrorToast("");
        });
    },
    clearFields() {
      this.name = "";
      this.address = "";
    }
  }
};
</script>

