
<template>
  <div>
    <b-container fluid>
      <b-row align-h="center" class="my-5">
        <b-col cols="4">
          <b-button block v-b-modal.modal-1>Agregar nueva fruta</b-button>
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
          :items="fruits"
          :per-page="perPage"
          :current-page="currentPage"
        >
          <template v-slot:cell(#)="data">{{ data.index + 1 }}</template>
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
                id="fruit-description"
                v-model="description"
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
  props: ["fruits-array"],
  data() {
    return {
      perPage: 10,
      currentPage: 1,
      fields: [
        "#",
        { key: "name", label: "Nombre" },
        { key: "description", label: "Descripción" }
      ],
      fruits: JSON.parse(this.fruitsArray),
      name: "",
      description: ""
    };
  },
  mounted() {
  },
  computed: {
    rows() {
      return this.fruits.length;
    }
  },
  methods: {
    getFruits() {
      return (this.fruits = JSON.parse(this.fruitsArray));
    },
    saveFruit() {
      let me = this;
      let url = "/createFruit"; 
      axios.post(url, {

          name: this.name,
          description: this.description
        })
        .then(function(response) {
          me.clearFields(); 
        })
        .catch(function(error) {
          console.log(error);
        });
        this.$refs['modal-2'].hide();
    },
    clearFields() {
      this.name = "";
      this.description = "";
    }
  }
};
</script>

