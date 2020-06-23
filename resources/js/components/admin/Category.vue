<template>
    <div class="container">
       <div class="row">
        <div class="col-12">
          <div class="card ">
            <!-- card-header -->
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title flex-grow-1 ">Category Table</h3>
              <router-link :to="'/categories/form/'">
                <i class="fas fa-plus-circle " style="font-size: 1.4em"></i>
              </router-link>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th >Created</th>
                    <th >Updated</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                    <tr v-for="category in categories" :key="category.id">
                        <td> {{ category.id }}</td>
                        <td> {{ category.name }}</td>
                        <td > {{ category.created_at | dateFormatDMY}}</td>
                        <td > {{ category.updated_at | dateFormatDMY}}</td>
                        <td> 
                            <router-link :to="'/categories/form/'+ category.id">
                              <i class="fas fa-edit green"></i>
                            </router-link> - 
                            <i @click="deleteCategory(category.id)" role="button" class="fas fa-trash red"></i>
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
                categories: [],

            }

        },
        created() {
            this.refreshCategories();
        },
        methods: {
          refreshCategories() {
            this.$Progress.start()
            axios.get('/api/categories').
            then((res) => {
              this.$Progress.finish()
                this.categories = res.data;
            }).
            catch((err) => {
              this.$Progress.fail()
            })
          },
          deleteCategory(id) {
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
                 axios.delete('/api/categories/delete/' + id).then(res => {
                    this.refreshCategories()
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
