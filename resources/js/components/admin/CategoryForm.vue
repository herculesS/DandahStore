<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 v-if="editMode" class="card-title">Editing Category</h3>
            <h3 v-else class="card-title">Create Category</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" v-on:submit.prevent>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Category Name</label>
                <input
                  v-model="form.name"
                  type="text"
                  class="form-control"
                  id="exampleInputEmail1"
                  placeholder="Enter a name for the category"
                />
                 <div class="text-danger" v-if="errors.name">{{errors.name[0]}}</div>
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
      category_to_edit: {},
      category_to_edit_id: "",
      form: {
        name: ""
      },
      errors: {}
    };
  },

  created() {
    this.category_to_edit_id = this.$route.params.id;
    this.editMode = this.category_to_edit_id ? true : false;
    if (this.editMode) {
      axios
        .get("/api/categories/" + this.category_to_edit_id)
        .then(res => {
          console.log(res.data);
          this.category_to_edit = res.data;
          this.form.name = this.category_to_edit.name;
        })
        .catch(err => {});
    }
  },
  methods: {
    submit() {
      if (this.editMode) {
        this.submitCall({
          method: "patch",
          url: "/api/categories/update/" + this.category_to_edit_id,
          data: {
            name: this.form.name
          }
        });
      } else {
        this.submitCall({
          method: "put",
          url: "/api/categories/create",
          data: {
            name: this.form.name
          }
        });
      }
    },
    submitCall(params) {
      this.$Progress.start();
      axios(params)
        .then(res => {
          this.$Progress.finish();
          this.$router.push("/categories");
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
