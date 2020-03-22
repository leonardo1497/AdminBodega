<template>
    <div>
        <b-card-group columns class="m-5">
            <b-card
                v-for="store of stores"
                :key="store.id"
                border-variant="primary"
                :header="store.name"
                  header-bg-variant="primary"
                  header-text-variant="white"
                  align="center"
            >
                <b-card-text>{{store.address}} </b-card-text>
                <b-button :href="'/store/'+store.id+'/'" variant="outline-primary">Abrir</b-button>
            </b-card>
        </b-card-group>
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
  }
};
</script>