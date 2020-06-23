<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- card-header -->
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title flex-grow-1">Products Table</h3>
            <router-link :to="'/products/form/'">
              <i class="fas fa-plus-circle" style="font-size: 1.4em"></i>
            </router-link>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap text-center">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Qty</th>
                  <th>Category</th>
                  <th>Available</th>
                  <th>Created</th>
                  <th>Updated</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="product in products" :key="product.id">
                  <td>{{ product.id }}</td>
                  <td>{{ product.name }}</td>
                  <td>{{ product.quantity }}</td>
                  <td>{{ product.category.name }}</td>
                  <td>{{ product.available | booleanFormat }}</td>
                  <td>{{ product.created_at | dateFormatDMY}}</td>
                  <td>{{ product.updated_at | dateFormatDMY}}</td>
                  <td>
                    <router-link :to="'/products/form/'+ product.id">
                      <i class="fas fa-edit green"></i>
                    </router-link>-
                    <i @click="deleteProduct(product.id)" role="button" class="fas fa-trash red"></i>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      products: []
    };
  },
  created() {
    this.refreshProducts();
  },
  methods: {
    refreshProducts() {
      this.$Progress.start();
      axios
        .get("/api/products")
        .then(res => {
          this.$Progress.finish();
          this.products = res.data;
        })
        .catch(err => {
          this.$Progress.fail();
        });
    },
    deleteProduct(id) {
            swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                 axios.delete('/api/products/delete/' + id).then(res => {
                    this.refreshProducts()
                    swal.fire(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                    )
                  }).catch(err => {
                    swal.fire(
                      'Fail!',
                      'Could Not Delete!.',
                      'fail'
                    )
                  })
              
              }
            })
          }
        }
  }
</script>
