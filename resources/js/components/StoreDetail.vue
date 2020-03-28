<template>
  <div>
    <b-jumbotron>
      <template v-slot:header>{{store.name}}</template>

      <template v-slot:lead>{{store.address}}</template>

      <hr class="my-4" />
      <b-button variant="primary" v-b-modal.modal-3>Vendedores</b-button>
    </b-jumbotron>
    <div>
      <b-tabs content-class="mt-3" class="m-3">
        <b-tab title="Ventas" active>
          <h3 class="text-center">Ventas</h3>
          <b-button class="mb-5 ml-5" variant="primary" @click="saveDaySale()">Iniciar venta del día</b-button>
          <b-row align-h="center" class="mx-5">
            <b-table
              striped
              hover
              :fields="fieldsDaySale"
              :items="daySale"
              :per-page="perPage"
              :current-page="currentPage"
            >
              <template v-slot:cell(#)="data">{{ data.index + 1 }}</template>
              <template v-slot:cell(created_at)="data">{{ data.item.created_at.split(" ")[0] }}</template>
              <template v-slot:cell(Activo)="data">
                <span v-if="data.item.active == 1">Disponible</span>
                <span v-else>Terminado</span>
              </template>
              <template v-slot:cell(Ventas)="data">
                <b-button variant="primary" @click="openSaleDays(data.item.id)">Ventas</b-button>
              </template>
              <template v-slot:cell(Agregar)="data">
                <b-button variant="primary" @click="openModalSale(data.item.id)">Agregar</b-button>
              </template>
            </b-table>
          </b-row>
        </b-tab>
        <b-tab title="Bodega">
          <h3 class="text-center">Bodega</h3>
          <b-button class="mb-5 ml-5" variant="primary" @click="openSaveCellar()">Agregar</b-button>
          <b-row align-h="center" class="mx-5">
            <b-table
              striped
              hover
              :fields="fieldsCellar"
              :items="cellar"
              :per-page="perPage"
              :current-page="currentPage"
            >
              <template v-slot:cell(#)="data">{{ data.index + 1 }}</template>
              <template v-slot:cell(Fruta)="data">{{data.item.fruit.name}}</template>
              <template v-slot:cell(priceton)="data">{{data.item.price_ton}}</template>
              <template v-slot:cell(Primera)="data">${{data.item.first}}</template>
              <template v-slot:cell(Segunda)="data">${{data.item.second}}</template>
              <template v-slot:cell(Activo)="data">
                <span v-if="data.item.active == 1">Disponible</span>
                <span v-else>Terminado</span>
              </template>
              <template v-slot:cell(Editar)="data">
                <b-button variant="primary" @click="openEditCellar(data.item.id)">Editar</b-button>
              </template>
            </b-table>
          </b-row>
        </b-tab>
        <b-tab title="Frutas">
          <h3 class="text-center">Frutas</h3>
          <b-button class="mb-5 ml-5" variant="primary" @click="openSaveFruit()">Agregar</b-button>
          <b-row align-h="center" class="mx-5">
            <b-table
              striped
              hover
              :fields="fields"
              :items="fruitSlt"
              :per-page="perPage"
              :current-page="currentPage"
            >
              <template v-slot:cell(#)="data">{{ data.index + 1 }}</template>
              <template v-slot:cell(Editar)="data">
                <b-button variant="primary" @click="openEditFruit(data.item.id)">Editar</b-button>
              </template>
            </b-table>
            </b-row>
        </b-tab>
        <b-tab title="Clientes">
          <h3 class="text-center">Clientes</h3>
          <b-button class="mb-5 ml-5" variant="primary" @click="openSaveCustomer()">Agregar</b-button>
          <b-row align-h="center" class="mx-5">
            <b-table
              striped
              hover
              :fields="fieldsCustomer"
              :items="customerSlt"
              :per-page="perPage"
              :current-page="currentPage"
            >
              <template v-slot:cell(#)="data">{{ data.index + 1 }}</template>
              <template v-slot:cell(Editar)="data">
                <b-button variant="primary" @click="openEditCustomer(data.item.id)">Editar</b-button>
              </template>
            </b-table>
            </b-row>
        </b-tab>
        <b-tab title="Vendedores">
          <h3 class="text-center">Vendedores</h3>
          <b-button class="mb-5 ml-5" variant="primary" @click="openSaveSeller()">Agregar</b-button>
          <b-row align-h="center" class="mx-5">
            <b-table
              striped
              hover
              :fields="fieldsSeller"
              :items="sellerSlt"
              :per-page="perPage"
              :current-page="currentPage"
            >
              <template v-slot:cell(#)="data">{{ data.index + 1 }}</template>
              <template v-slot:cell(Editar)="data">
                <b-button variant="primary" @click="openEditSeller(data.item.id)">Editar</b-button>
              </template>
            </b-table>
            </b-row>
        </b-tab>
      </b-tabs>
    </div>

    <b-modal
      id="modal-0"
      ref="modal-0"
      title="Entrada de fruta a la bodega"
      size="lg"
      @hidden="clearFruitFields"
      hide-footer
    >
      <b-container fluid>
        <b-form @submit="saveCellar">
          <b-row class="my-3">
            <b-col sm="12">
              <b-form-select
                :disabled="btnCellar == 'Actualizar'"
                v-model="formCellar.selectedFruitCellar"
                :options="optionsFruitsCellar"
                required
              ></b-form-select>
            </b-col>
          </b-row>

          <b-row class="my-3">
            <b-col sm="12">
              <b-form-input
              :disabled="btnCellar == 'Actualizar'"
                type="number"
                v-model="formCellar.quantityTom"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Ingrese la cantidad en toneladas"
                step=".00001"
                trim
                @change="calculateSuggestedPrice"
                required
              ></b-form-input>
            </b-col>
          </b-row>

          <b-row class="my-3">
            <b-col sm="12">
              <b-form-input
                type="number"
                :disabled="btnCellar == 'Actualizar'"
                v-model="formCellar.quantityPrice"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Precio por tonelada"
                step=".00001"
                trim
                @change="calculateSuggestedPrice"
                required
              ></b-form-input>
            </b-col>
          </b-row>

          <b-row class="my-3">
            <b-col sm="12">
              <div class="mt-3">Precio por Kg: ${{suggestedPrice}}</div>
            </b-col>
          </b-row>
          <b-row class="my-3">
            <b-col sm="4">
              <div class="mt-3">Precio sugerido de primera:</div>
            </b-col>
            <b-col sm="4">
              <b-form-input
                type="number"
                id
                v-model="formCellar.first"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Escribe el precio"
                step=".00001"
                trim
                required
              ></b-form-input>
            </b-col>
          </b-row>
          <b-row class="my-3">
            <b-col sm="4">
              <div class="mt-3">Precio sugerido de segunda:</div>
            </b-col>
            <b-col sm="4">
              <b-form-input
                type="number"
                id
                v-model="formCellar.second"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Escribe el precio"
                step=".00001"
                trim
                required
              ></b-form-input>
            </b-col>
          </b-row>
          <b-row  v-if="btnCellar == 'Actualizar'" class="my-3">
            <b-col sm="4">
              <div class="mt-3">Estatus:</div>
            </b-col>
            <b-col sm="8">
              <b-form-select v-model="formCellar.active" class="mb-3" required>
                <b-form-select-option :value="null">Por favor selecciona un opción</b-form-select-option>
                <b-form-select-option value="1">Activo</b-form-select-option>
                <b-form-select-option value="2">Inactivo</b-form-select-option>
              </b-form-select>
            </b-col>
          </b-row>
          <b-row align-h="end">
            <b-col cols="2">
              <b-button type="submit" variant="primary">{{btnCellar}}</b-button>
            </b-col>
          </b-row>
        </b-form>
      </b-container>
    </b-modal>


    <b-modal
      id="modal-1"
      ref="modal-1"
      title="Fruta"
      size="lg"
      hide-footer
    >
      <b-container fluid>
        <b-form @submit="saveFruit">
          <b-row class="my-3">
            <b-col sm="12">
              <b-form-input
                id="fruit-name"
                v-model="formFruit.name"
                type="text"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Ingrese el nombre de la fruta"
                trim
                required
              ></b-form-input>
            </b-col>
          </b-row>

          <b-row class="my-3">
            <b-col sm="12">
              <b-form-input
                id="fruit-description"
                v-model.lazy="formFruit.description"
                type="text"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Ingrese la descripción de la fruta"
                trim
                required
              ></b-form-input>
            </b-col>
          </b-row>

          <b-button type="submit" variant="primary">{{btnFruit}}</b-button>
        </b-form>
        <br />
      </b-container>
    </b-modal>

    <b-modal id="modal-2" ref="modal-2" title="Nuevo cliente" size="lg" hide-footer>
      <b-container fluid>
        <b-form @submit="saveCustomer">
          <b-row class="my-3">
            <b-col sm="12">
              <b-form-input
                id="customer-name"
                v-model="formCustomer.name"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Ingrese el nombre del cliente"
                trim
                required
              ></b-form-input>
            </b-col>
          </b-row>

          <b-row class="my-3">
            <b-col sm="12">
              <b-form-textarea
                id="customer-description"
                v-model="formCustomer.description"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Ingrese la descripción del cliente"
                trim
                required
              ></b-form-textarea>
            </b-col>
          </b-row>

          <b-button type="submit" variant="primary">{{btnCustomer}}</b-button>
        </b-form>
      </b-container>
    </b-modal>

    <b-modal id="modal-3" ref="modal-3" title="Vendedor" size="lg" hide-footer>
      <b-container fluid>
        <b-form @submit="saveSeller">
          <b-row class="my-3">
            <b-col sm="12">
              <b-form-input
                id="fruit-name"
                v-model="formSeller.name"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Ingrese el nombre del vendedor"
                trim
                required
              ></b-form-input>
            </b-col>
          </b-row>

          <b-button type="submit" variant="primary">{{btnSeller}}</b-button>
        </b-form>
      </b-container>
    </b-modal>

    <b-modal id="modal-4" ref="modal-4" title="Ventas" size="xl" hide-footer>
      <b-container fluid>
        <b-form @submit="saveNewSale">
          <b-row class="my-3">
            <b-col sm="12" v-b-tooltip.hover title="Nombre del cliente">
              <b-form-select
                :disabled="updateSale"
                v-model="formSaleDay.selectedCustomer"
                :options="optionsCustomers"
                required
              ></b-form-select>
            </b-col>
          </b-row>
          <div v-if="!updateSale">
            <b-row class="my-3">
              <b-col sm="12">
                <b-form-select
                  v-model="formSaleDay.selectedFruit"
                  :options="optionsFruits"
                  @change="getCellar($event)"
                ></b-form-select>
              </b-col>
            </b-row>
            <b-row class="my-3">
              <b-col sm="12">{{informationCellarSlt}}</b-col>
            </b-row>
            <b-row class="my-3">
              <b-col sm="12">
                <b-form-input
                  type="number"
                  id
                  v-model="formSaleDay.quantity"
                  aria-describedby="input-live-help input-live-feedback"
                  placeholder="Ingrese la cantidad kg"
                  trim
                ></b-form-input>
              </b-col>
            </b-row>
            <b-row class="my-3">
              <b-col sm="12">
                <b-form-input
                  type="number"
                  v-model="formSaleDay.priceKg"
                  aria-describedby="input-live-help input-live-feedback"
                  placeholder="Precio por kg"
                  trim
                ></b-form-input>
              </b-col>
            </b-row>
            <b-row class="my-3">
              <b-col sm="12">
                <b-button @click="addFruitSale()">Agregar una nueva fruta</b-button>
              </b-col>
            </b-row>
          </div>
          <div class="my-4 text-center">
            <h2>Frutas agregadas Total: ${{total}}</h2>
            <b-table striped hover :items="items" :fields="fieldsFruitsSale">
              <template v-slot:cell(Eliminar)="data">
                <b-button
                  v-if="!updateSale"
                  variant="danger"
                  size="sm"
                  class="mb-2"
                  @click="deleteFruitSale(data.index)">
                  <b-icon icon="trash"></b-icon>Eliminar
                </b-button>
              </template>
            </b-table>
          </div>

          <b-row class="my-3">
            <b-col sm="12" v-b-tooltip.hover title="Nombre del vendedor">
              <b-form-select
                :disabled="updateSale"
                v-model="formSaleDay.selectedSeller"
                :options="optionsSellers"
                required
              ></b-form-select>
            </b-col>
          </b-row>
          <b-row class="my-3">
            <b-col sm="12" v-b-tooltip.hover title="Nombre de la persona que entrega">
              <b-form-select
                :disabled="updateSale"
                v-model="formSaleDay.selectedDelivery"
                :options="optionsDelivery"
                required
              ></b-form-select>
            </b-col>
          </b-row>
          <b-row class="my-3">
            <b-col sm="12" v-b-tooltip.hover title="Tipo de pago">
              <b-form-select
                :disabled="updateSale"
                v-model="formSaleDay.selectedPay"
                :options="optionsPay"
                @change="optionPay($event)"
                required
              ></b-form-select>
            </b-col>
          </b-row>
          <b-row v-if="credit" class="my-3">
            <b-col sm="12">
              <b-form-input
                :disabled="updateSale"
                type="number"
                v-model="formSaleDay.credit"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Abono"
                required
              ></b-form-input>
            </b-col>
          </b-row>
          <b-button v-if="!updateSale" type="submit" variant="primary">Agregar nueva venta</b-button>
        </b-form>
        <div v-if="updateSale && typePaySale != null">
          <div class="my-4 text-center">
            <h2>Pagos realizados</h2>
            <b-table striped hover :items="typePaySale" :fields="fieldPaySale">
            </b-table>
          </div>
          <b-row v-if="actualPay < total" class="my-3"> 
          <b-col sm="3">
              <b-form-input
                type="number"
                v-model="payment"
                aria-describedby="input-live-help input-live-feedback"
                placeholder="Abono"
                required
              ></b-form-input>
          </b-col>
          <b-col sm="3">
            <b-button type="button" variant="primary" @click="updatePayment">Agregar abono</b-button>
          </b-col>
          </b-row>
        </div>
      </b-container>
    </b-modal>

    <b-modal id="modal-5" ref="modal-5" title="Ventas del día" size="xl" hide-footer>
      <b-container fluid>
        <b-row align-h="center" class="mx-5">
          <b-table
            striped
            hover
            :fields="fieldsSale"
            :items="sales"
            :per-page="perPage"
            :current-page="currentPage"
          >
            <template v-slot:cell(#)="data">{{ data.index + 1 }}</template>
            <template v-slot:cell(Cliente)="data">{{data.item.customer.name}}</template>
            <template v-slot:cell(Tipo)="data">
              <span v-if="data.item.type_pay == 1">Contado</span>
              <span v-else>Crédito</span>
            </template>
            <template v-slot:cell(Editar)="data">
              <b-button variant="primary" @click="openEditSale(data.item.id)">Editar</b-button>
            </template>
          </b-table>
        </b-row>
      </b-container>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: [
    "store-data",
    "fruit-data",
    "customer-data",
    "seller-data",
    "cellar-data",
    "daysale-data"
  ],
  data() {
    return {
      informationCellarSlt: "",
      idCellar: 0,
      btnCellar: null,
      btnFruit: null,
      perPage: 10,
      currentPage: 1,
      updateSale: false,
      fieldsDaySale: [
        "#",
        { key: "created_at", label: "Fecha" },
        "Activo",
        "Ventas",
        "Agregar"
      ],
      fields: [
        "#",
        { key: "name", label: "Nombre" },
        { key: "description", label: "Descripción" },
        "Editar"
      ],
      fieldPaySale: [
        { key: "pay", label: "Monto de pago" },
        { key: "date", label: "Fecha" },
      ],
      fieldsCellar: [
        "#",
        "Fruta",
        { key: "ton", label: "Toneladas" },
        { key: "priceton", label: "Precio por tonelada" },
        { key: "kg", label: "Kg. disponibles" },
        "Primera",
        "Segunda",
        "Activo",
        "Editar"
      ],
      fieldsSale: [
        "#",
        "Cliente",
        "Tipo",
        { key: "total", label: "Total" },
        { key: "pay", label: "Pagado" },
        "Editar"
      ],
      fieldsFruitsSale: [
        "Nombre",
        "Cantidad/kg",
        "Precio/kg",
        "Total",
        "Eliminar"
      ],
      fieldsCustomer:[
        "#",
        { key: "name", label: "Nombre" },
        { key: "description", label: "Descripción" },
        "Editar"
      ],
      fieldsSeller:[
        "#",
        { key: "name", label: "Nombre" },
        "Editar"
      ],
      store: JSON.parse(this.storeData),
      fruitSlt: JSON.parse(this.fruitData),
      customerSlt: JSON.parse(this.customerData),
      sellerSlt: JSON.parse(this.sellerData),
      cellar: JSON.parse(this.cellarData),
      sales: null,
      daySale: JSON.parse(this.daysaleData),
      daySaleId: null,
      formCellar: {
        selectedFruitCellar: null,
        quantityTom: null,
        quantityPrice: null,
        priceFirst: null,
        priceSecond: null,
        active:null
      },
      fruitId: null,
      formFruit: {
        name: null,
        description: null
      },
      btnCustomer: null,
      customerId: null,
      formCustomer: {
        name: null,
        description: null
      },
      sellerId: null,
      btnSeller : null,
      formSeller: {
        name: null
      },
      formSaleDay: {
        selectedCustomer: null,
        selectedFruit: null,
        quantity: null,
        priceKg: null,
        selectedSeller: null,
        selectedDelivery: null,
        selectedPay: null,
        credit: null
      },
      actualPay: null,
      saleId: null,
      payment: null,
      typePaySale: null,
      credit: false,
      total: 0,
      suggestedPrice: null,
      optionsCustomers: [{ value: null, text: "Seleccione a un cliente" }],
      optionsFruitsCellar: [{ value: null, text: "Seleccione una fruta" }],
      optionsFruits: [{ value: null, text: "Seleccione una fruta" }],
      optionsSellers: [{ value: null, text: "Seleccione una vendedor" }],
      optionsDelivery: [
        { value: null, text: "Seleccione a la persona que entregó" }
      ],
      optionsPay: [
        { value: null, text: "Seleccione el tipo de pago" },
        { value: 1, text: "Contado" },
        { value: 2, text: "Crédito" }
      ],
      items: []
    };
  },
  mounted() {
    for (let index = 0; index < this.fruitSlt.length; index++) {
      this.optionsFruitsCellar.push({
        value: this.fruitSlt[index].id,
        text: this.fruitSlt[index].name
      });
    }
    for (let index = 0; index < this.customerSlt.length; index++) {
      this.optionsCustomers.push({
        value: this.customerSlt[index].id,
        text: this.customerSlt[index].name
      });
    }

    for (let index = 0; index < this.cellar.length; index++) {
      if(this.cellar[index].active == true){
        this.optionsFruits.push({
          value:
            this.cellar[index].id +
            "|" +
            this.cellar[index].fruit.name +
            " " +
            this.cellar[index].created_at.split(" ")[0] +
            " " +
            this.cellar[index].id,
          text:
            this.cellar[index].fruit.name +
            " " +
            this.cellar[index].created_at.split(" ")[0] +
            " " +
            this.cellar[index].id
        });
      }
    }

    for (let index = 0; index < this.sellerSlt.length; index++) {
      this.optionsSellers.push({
        value: this.sellerSlt[index].id,
        text: this.sellerSlt[index].name
      });
      this.optionsDelivery.push({
        value: this.sellerSlt[index].id,
        text: this.sellerSlt[index].name
      });
    }
  },
  computed: {},
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
    makeWarningToast(message) {
      this.$bvToast.toast(message, {
        title: `Advertencia`,
        variant: "warning",
        solid: true
      });
    },
    saveDaySale() {
      let me = this;
      let url = "/createDaySale";
      axios
        .post(url, {
          id: this.store.id
        })
        .then(function(response) {
          if (response.data.data) {
            me.daySale = response.data.daySales;
            me.makeSuccessToast();
          } else {
            me.makeErrorToast(response.data.message);
          }
        })
        .catch(function(error) {
          console.log(error);
          me.makeErrorToast("");
        });
    },
    saveFruit(evt) {
      evt.preventDefault();
      let me = this;
      var url = "/createFruit";
      if(this.btnFruit == "Actualizar"){
        url = "/updateFruit";
      }
      axios.post(url, {
          fruitId: this.idFruit,
          id: this.store.id,
          name: this.formFruit.name,
          description: this.formFruit.description
        })
        .then(function(response) {
          me.makeSuccessToast();
          me.fruitSlt = response.data.fruits;
          me.optionsFruitsCellar= [{ value: null, text: "Seleccione una fruta" }];
          for (let index = 0; index < me.fruitSlt.length; index++) {
            me.optionsFruitsCellar.push({
              value: me.fruitSlt[index].id,
              text: me.fruitSlt[index].name
            });
          }
        })
        .catch(function(error) {
          console.log(error);
          me.makeErrorToast("");
        });
      this.$refs["modal-1"].hide();
    },
    openSaveSeller(){
      this.btnSeller = "Guardar";
      this.clearSellerFields();
      this.$refs["modal-3"].show();
    },
    openEditSeller(idSeller){
      this.btnSeller = "Actualizar";
      this.sellerId = idSeller;
      let me = this;
      axios
        .get("/editSeller", {
          params: {
            id: idSeller
          }
        })
        .then(function(response) {
          me.formSeller.name = response.data.seller.name;
          me.$refs["modal-3"].show();
        })
        .catch(function(error) {
          console.log(error);
          me.makeErrorToast("");
        });
    },
    openSaveCustomer(){
      this.btnCustomer = "Guardar";
      this.clearCustomerFields();
      this.$refs["modal-2"].show();
    },
    openEditCustomer(idCustomer){
      this.btnCustomer = "Actualizar";
      this.clearCustomerFields();
      this.customerId = idCustomer;
      let me = this;
      axios
        .get("/editCustomer", {
          params: {
            id: idCustomer
          }
        })
        .then(function(response) {
          me.formCustomer.description = response.data.customer.description;
          me.formCustomer.name = response.data.customer.name;
          me.$refs["modal-2"].show();
        })
        .catch(function(error) {
          console.log(error);
          me.makeErrorToast("");
        });
  
    },
    saveCustomer(evt) {
      evt.preventDefault();
      let me = this;
      let url = "/createCustomer";
      if(this.btnCustomer == "Actualizar"){
        url = "/updateCustomer";
      }
      axios
        .post(url, {
          customerId: this.customerId,
          id: this.store.id,
          name: this.formCustomer.name,
          description: this.formCustomer.description
        })
        .then(function(response) {
          me.makeSuccessToast();
          me.customerSlt = response.data.customers;
          me.optionsCustomers = [{ value: null, text: "Seleccione a un cliente" }];
          for (let index = 0; index < me.customerSlt.length; index++) {
            me.optionsCustomers.push({
              value: me.customerSlt[index].id,
              text: me.customerSlt[index].name
            });
          }
        })
        .catch(function(error) {
          console.log(error);
          me.makeErrorToast("");
        });
      this.$refs["modal-2"].hide();
    },
    saveSeller(evt) {
      evt.preventDefault();
      let me = this;
      let url = "/createSeller";
      if(this.btnSeller == "Actualizar"){
        url = "/updateSeller";
      }
      axios
        .post(url, {
          sellerId: this.sellerId,
          id: this.store.id,
          name: this.formSeller.name
        })
        .then(function(response) {
          me.makeSuccessToast();
          me.sellerSlt = response.data.sellers;
          me.optionsSellers = [{ value: null, text: "Seleccione una vendedor" }];
          me.optionsDelivery= [{ value: null, text: "Seleccione a la persona que entregó" }];
          for (let index = 0; index < me.sellerSlt.length; index++) {
            me.optionsSellers.push({
              value: me.sellerSlt[index].id,
              text: me.sellerSlt[index].name
            });
            me.optionsDelivery.push({
              value: me.sellerSlt[index].id,
              text: me.sellerSlt[index].name
            });
          }
        })
        .catch(function(error) {
          console.log(error);
          me.makeErrorToast("");
        });
      this.$refs["modal-3"].hide();
    },
    saveCellar(evt) {
      evt.preventDefault();
      let me = this;
      let url;
      if (this.btnCellar == "Guardar") {
        url = "/createCellar";
      } else {
        url = "/updateCellar";
      }
      axios
        .post(url, {
          id: this.idCellar,
          storeId: this.store.id,
          fruitId: this.formCellar.selectedFruitCellar,
          ton: this.formCellar.quantityTom,
          priceTon: this.formCellar.quantityPrice,
          first: this.formCellar.first,
          second: this.formCellar.second,
          active: this.formCellar.active
        })
        .then(function(response) {
          me.cellar = response.data.cellars;
          me.optionsFruits = [{ value: null, text: "Seleccione una fruta" }];
          for (let index = 0; index < me.cellar.length; index++) {
            if(me.cellar[index].active == true){
              me.optionsFruits.push({
                value:
                  me.cellar[index].id +
                  "|" +
                  me.cellar[index].fruit.name +
                  " " +
                  me.cellar[index].created_at.split(" ")[0] +
                  " " +
                  me.cellar[index].id,
                text:
                  me.cellar[index].fruit.name +
                  " " +
                  me.cellar[index].created_at.split(" ")[0] +
                  " " +
                  me.cellar[index].id
              });
            }
          }
          me.makeSuccessToast();
          me.clearSellerFields();
          me.$refs["modal-0"].hide();
        })
        .catch(function(error) {
          console.log(error);
          me.makeErrorToast("");
        });
    },
    openSaveCellar() {
      (this.store.id = null),
        (this.formCellar.selectedFruitCellar = null),
        (this.formCellar.quantityTom = null),
        (this.formCellar.quantityPrice = null),
        (this.formCellar.first = null),
        (this.formCellar.second = null),
        (this.btnCellar = "Guardar");
      this.$refs["modal-0"].show();
    },
    openEditCellar(idCellar) {
      this.idCellar = idCellar;
      this.btnCellar = "Actualizar";
      let url = "/editCellar";
      let me = this;
      axios
        .get(url, {
          params: {
            id: idCellar
          }
        })
        .then(function(response) {
          console.log(response.data.cellar.first);
          (me.formCellar.selectedFruitCellar = response.data.cellar.fruit_id),
            (me.formCellar.quantityTom = response.data.cellar.ton),
            (me.formCellar.quantityPrice = response.data.cellar.price_ton),
            (me.formCellar.first = response.data.cellar.first),
            (me.formCellar.second = response.data.cellar.second),
            (me.formCellar.active = response.data.cellar.active)
            me.$refs["modal-0"].show();
            let kg = me.formCellar.quantityTom * 1000;
            let price = me.formCellar.quantityPrice * me.formCellar.quantityTom;
            me.suggestedPrice = price / kg;
        })
        .catch(function(error) {
          console.log(error);
          me.makeErrorToast("");
        });
    },
    getCellar(event) {
      console.log(event);
      let me = this;
      if (event != null) {
        let idCellar = event;
        let url = "/editCellar";
        axios
          .get(url, {
            params: {
              id: idCellar
            }
          })
          .then(function(response) {
            me.informationCellarSlt = "";
            (me.informationCellarSlt +=
              "Kg. disponibles: " + response.data.cellar.kg),
              (me.informationCellarSlt +=
                "- Precio sugerido primera: $" + response.data.cellar.first),
              (me.informationCellarSlt +=
                "- Precio sugerido segunda: $" + response.data.cellar.second);
          })
          .catch(function(error) {
            console.log(error);
            me.makeErrorToast("");
          });
      } else {
        me.informationCellarSlt = "";
      }
    },
    openSaveFruit() {
      this.clearFruitFields();
      this.btnFruit = "Guardar";
      this.$refs["modal-1"].show();

    },
    openEditFruit(idFruit) {
      let url = "/editFruit";
      let me = this;
      this.btnFruit = "Actualizar";
      this.idFruit = idFruit;
      axios
        .get(url, {
          params: {
            id: idFruit
          }
        })
        .then(function(response) {
          me.formFruit.description = response.data.fruit.description;
          me.formFruit.name = response.data.fruit.name;
          me.$refs["modal-1"].show();
        })
        .catch(function(error) {
          console.log(error);
          me.makeErrorToast("");
        });
    },
    updateFruit(evt) {
      evt.preventDefault();
      let me = this;
      let url = "/updateFruit";
      axios
        .post(url, {
          id: this.store.id,
          name: this.formFruit.name,
          description: this.formFruit.description
        })
        .then(function(response) {
          me.makeSuccessToast();
          me.clearFruitFields();
        })
        .catch(function(error) {
          me.makeErrorToast("");
        });
    },
    openModalSale(id) {
      this.updateSale = false;
      this.total = 0;
      this.daySaleId = id;
      this.items = [];
      this.informationCellarSlt = "";
      this.$refs["modal-4"].show();
    },
    clearFruitFields() {
      this.formFruit.name = null;
      this.formFruit.description = null;
    },
    clearCustomerFields() {
      this.formCustomer.name = null;
      this.formCustomer.description = null;
    },
    clearSellerFields() {
      this.formSeller.name = null;
    },
    calculateSuggestedPrice() {
      if (
        this.formCellar.quantityTom != null &&
        this.formCellar.quantityPrice != null
      ) {
        let kg = this.formCellar.quantityTom * 1000;
        let price = this.formCellar.quantityPrice * this.formCellar.quantityTom;
        this.suggestedPrice = price / kg;
      }
    },
    addFruitSale() {
      if (
        this.formSaleDay.selectedFruit != null &&
        this.formSaleDay.quantity != null &&
        this.formSaleDay.priceKg != null
      ) {
        let array = this.formSaleDay.selectedFruit.split("|");
        let total = this.formSaleDay.quantity * this.formSaleDay.priceKg;
        this.total += total;
        this.items.push({
          id: this.items.length,
          Nombre: array[1],
          "Cantidad/kg": this.formSaleDay.quantity,
          "Precio/kg": this.formSaleDay.priceKg,
          Total: "$" + total,
          idCellar: array[0]
        });
        this.formSaleDay.quantity = null;
        this.formSaleDay.priceKg = null;
        this.formSaleDay.selectedFruit = null;
      } else {
        this.makeWarningToast(
          "Llenar todos los campos necesarios para agregar una fruta"
        );
      }
    },
    deleteFruitSale(index) {
      this.total -= parseFloat(this.items[index].Total.substring(1));
      this.items.splice(index, 1);
    },
    saveNewSale(evt) {
      evt.preventDefault();
      console.log(this.formSaleDay.selectedPay);
      if (this.items.length == 0) {
        this.makeWarningToast("Agregar al menos una fruta");
      } else {
        let creditValue = "";
        if (this.formSaleDay.credit != null) {
          let date = new Date();
          let month = date.getMonth() + 1;
          var datePay;
          if (month < 10) {
            datePay = date.getDate() + "-0" + month + "-" + date.getFullYear();
          } else {
            datePay = date.getDate() + "-" + month + "-" + date.getFullYear();
          }
          creditValue =
            '[{"pay": "' +
            this.formSaleDay.credit +
            '", "date":"' +
            datePay +
            '"}]';
        }
        let me = this;
        let url = "/createSale";
        axios
          .post(url, {
            id: this.daySaleId,
            customer: this.formSaleDay.selectedCustomer,
            seller: this.formSaleDay.selectedSeller,
            delivery: this.formSaleDay.selectedDelivery,
            pay: this.formSaleDay.selectedPay,
            credit: creditValue,
            creditPay: this.formSaleDay.credit,
            items: JSON.stringify(this.items),
            total: this.total
          })
          .then(function(response) {
            if (response.data.data) {
              me.makeSuccessToast();
            } else {
              me.makeErrorToast(response.data.message);
            }
          })
          .catch(function(error) {
            me.makeErrorToast("");
          });
        this.formSaleDay.selectedCustomer = null;
        this.formSaleDay.selectedSeller= null;
        this.formSaleDay.selectedDelivery= null;
        this.formSaleDay.selectedPay= null;
        this.formSaleDay.credit = null;
        this.$refs["modal-4"].hide();
      }
    },
    optionPay(evt) {
      if (evt != null) {
        if (evt == 2) {
          this.credit = true;
        } else {
          this.credit = false;
        }
      }
    },
    openSaleDays(id) {
      let url = "/getSales";
      let me = this;
      axios
        .get(url, {
          params: {
            id: id
          }
        })
        .then(function(response) {
          me.sales = response.data.sales;
          me.$refs["modal-5"].show();
        })
        .catch(function(error) {
          console.log(error);
          me.makeErrorToast("");
        });
    },
    openEditSale(id) {
      this.saleId = id;
      let url = "/editSale";
      let me = this;
      axios
        .get(url, {
          params: {
            id: id
          }
        })
        .then(function(response) {
          me.updateSale = true;
          me.formSaleDay.selectedCustomer = response.data.sale.customer_id;
          me.formSaleDay.selectedSeller = response.data.sale.seller_id;
          me.formSaleDay.selectedDelivery =
            response.data.sale.seller_delivery_id;
          me.formSaleDay.selectedPay = response.data.sale.type_pay;
          me.items = JSON.parse(response.data.sale.fruits);
          me.total = response.data.sale.total;
          me.actualPay = response.data.sale.pay;
          if (response.data.sale.pays != null) {
            me.typePaySale = JSON.parse(response.data.sale.pays);
          } else {
            me.typePaySale = response.data.sale.pays;
          }

          me.$refs["modal-4"].show();
        })
        .catch(function(error) {
          console.log(error);
          me.makeErrorToast("");
        });
    },
    updatePayment(){
      if(this.payment != null){
        let date = new Date();
        let month = date.getMonth() + 1;
        var datePay;
        if (month < 10) {
          datePay = date.getDate() + "-0" + month + "-" + date.getFullYear();
        } else {
          datePay = date.getDate() + "-" + month + "-" + date.getFullYear();
        }
        this.typePaySale.push({
            pay: this.payment,
            date: datePay
          });
      let me = this;
      let url = "/updatePayment";
      axios.put(url, {
          id: this.saleId,
          pays: JSON.stringify(this.typePaySale),
          payment: this.payment
        })
        .then(function(response) {
          me.makeSuccessToast();
          me.sales = response.data.sales;
        })
        .catch(function(error) {
          console.log(error);
          me.makeErrorToast("");
        
        });
      this.$refs["modal-4"].hide();
      this.payment = null;
      }else{
        this.makeWarningToast(
          "Llenar el campo con la cantidad del abono"
        );
      }

    }
  }
};
</script>