<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 v-if="editMode" class="card-title">Edição do Produto</h3>
            <h3 v-else class="card-title">Criação de Produto</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" v-on:submit.prevent>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nome</label>

                    <input
                      v-model="form.name"
                      type="text"
                      class="form-control"
                      placeholder="Dê um nome ao produto."
                    />
                    <div class="text-danger" v-if="errors.name">{{errors.name[0]}}</div>
                  </div>
                </div>
                <div class="col-md-6 d-flex">
                  <div class="form-group flex-grow-1">
                    <label for="exampleInputFile">Imagem do Produto</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input
                          v-on:change="handleFileUpload"
                          type="file"
                          class="custom-file-input"
                          id="exampleInputFile"
                        />
                        <label class="custom-file-label" for="exampleInputFile">Escolha Imagem</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id>Upload</span>
                      </div>
                    </div>
                    <div class="text-danger" v-if="errors.image">{{errors.image[0]}}</div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="inputSuccess">Quantidade</label>
                    <input
                      v-model="form.quantity"
                      type="number"
                      class="form-control"
                      id="inputSuccess"
                      placeholder="Escreva a quantidade"
                    />
                    <div class="text-danger" v-if="errors.quantity">{{errors.quantity[0]}}</div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Categoria</label>
                    <select
                      placeholder="Categorias"
                      v-model="form.category_id"
                      class="form-control"
                    >
                      <option disabled value>Selecione uma categoria</option>
                      <option
                        v-for="category in categories"
                        v-bind:value="category.id"
                        v-bind:key="category.id"
                      >{{category.name}}</option>
                    </select>
                    <div class="text-danger" v-if="errors.category_id">{{errors.category_id[0]}}</div>
                  </div>
                </div>
              </div>
              <div class="form-group text-center">
                <div
                  class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success"
                >
                  <input
                    v-model="form.available"
                    type="checkbox"
                    class="custom-control-input"
                    id="customSwitch3"
                  />
                  <label
                    class="custom-control-label"
                    for="customSwitch3"
                  >{{form.available ? 'Disponível':'Indisponível'}}</label>
                </div>
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer d-flex justify-content-end">
              <button v-if="editMode" @click="submit()" type="submit" class="btn btn-success">Salvar</button>
              <button v-else @click="submit()" type="submit" class="btn btn-primary">Criar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      editMode: false,
      product_to_edit: {},
      product_to_edit_id: "",
      categories: {},
      form: {
        name: "",
        quantity: "",
        available: "",
        category_id: "",
        image: null
      },
      errors: []
    };
  },

  created() {
    this.getCategories();
    this.product_to_edit_id = this.$route.params.id;
    this.editMode = this.product_to_edit_id ? true : false;
    if (this.editMode) {
      axios
        .get("/api/products/" + this.product_to_edit_id)
        .then(res => {
          this.product_to_edit = res.data[0];
          this.form.name = this.product_to_edit.name;
          this.form.quantity = this.product_to_edit.quantity;
          this.form.available = this.product_to_edit.available;
          this.form.category_id = this.product_to_edit.category_id;
          this.form.image = this.product_to_edit.image;
        })
        .catch(err => {});
    }
  },
  methods: {
    handleFileUpload(event) {
      let reader = new FileReader();
      reader.onloadend = () => {
        this.form.image = reader.result;
      };
      reader.readAsDataURL(event.target.files[0]);
    },
    getCategories() {
      this.$Progress.start();
      axios
        .get("/api/categories")
        .then(res => {
          this.$Progress.finish();
          this.categories = res.data;
        })
        .catch(err => {
          this.$Progress.fail();
        });
    },
    submit() {
      if (this.editMode) {
        this.submitCall({
          method: "patch",
          url: "/api/products/update/" + this.product_to_edit_id,
          data: this.form
        });
      } else {
        this.submitCall({
          method: "put",
          url: "/api/products/create",
          data: this.form
        });
      }
    },
    submitCall(params) {
      this.$Progress.start();
      axios(params)
        .then(res => {
          this.$Progress.finish();
          this.$router.push("/products");
        })
        .catch(err => {
          let error = Object.assign({}, err);
          this.errors = Object.assign({}, error.response.data.errors);
          this.$Progress.fail();
        });
    }
  }
};
</script>
