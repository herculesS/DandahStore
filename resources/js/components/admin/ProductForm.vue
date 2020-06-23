<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 v-if="editMode" class="card-title">Editing Product</h3>
            <h3 v-else class="card-title">Create Product</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" v-on:submit.prevent>
            <div class="card-body text-center">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input
                      v-model="form.name"
                      type="text"
                      class="form-control"
                      placeholder="Enter a name for the product"
                    />
                  </div>
                </div>
                <div class="col-md-6 d-flex">
                  <div class="form-group flex-grow-1">
                    <label for="exampleInputFile">Product Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input
                          v-on:change="handleFileUpload"
                          type="file"
                          class="custom-file-input"
                          id="exampleInputFile"
                        />
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id>Upload</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="inputSuccess">Quantity</label>
                    <input
                      v-model="form.quantity"
                      type="number"
                      class="form-control"
                      id="inputSuccess"
                      placeholder="Enter a quantity"
                    />
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Categories</label>
                    <select
                      placeholder="Categories"
                      v-model="form.category_id"
                      class="form-control"
                    >
                      <option disabled value>Please select category</option>
                      <option
                        v-for="category in categories"
                        v-bind:value="category.id"
                        v-bind:key="category.id"
                      >{{category.name}}</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
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
                  >{{form.available ? 'Available':'Unavailable'}}</label>
                </div>
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer d-flex justify-content-end">
              <button v-if="editMode" @click="submit()" type="submit" class="btn btn-success">Update</button>
              <button v-else @click="submit()" type="submit" class="btn btn-primary">Create</button>
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
      }
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
          data: this.form,
        });
      } else {
        this.submitCall({
          method: "put",
          url: "/api/products/create",
          data: this.form,
        });
      }
    },
    submitCall(params) {
      this.$Progress.start();
      axios(params)
        .then(res => {
          this.$Progress.finish();
          //this.$router.push("/products");
        })
        .catch(err => {
          this.$Progress.fail();
        });
    }
  }
};
</script>
