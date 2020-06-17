<template>
    <div class="container">
       <div class="row">
        <div class="col-12">
          <div class="card ">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title flex-grow-1 ">Category Table</h3>
              <router-link :to="'/categories/create/'">
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
                    <th>Created</th>
                    <th>Updated</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                    <tr v-for="category in categories" :key="category.id">
                        <td> {{ category.id }}</td>
                        <td> {{ category.name }}</td>
                        <td> {{ category.created_at | dateFormatDMY}}</td>
                        <td> {{ category.updated_at | dateFormatDMY}}</td>
                        <td> 
                            <router-link :to="'/categories/create/'+ category.id">
                              <i class="fas fa-edit green"></i>
                            </router-link> - 
                            <i class="fas fa-trash red"></i>
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
            axios.get('/api/categories').
            then((res) => {
                this.categories = res.data;
                console.log(res.data)
            }).
            catch((err) => {

            })
        },
        filters: {
            dateFormatDMY: function (date) {
                return moment(date).format('D-M-Y');
            }
        },

    }
</script>
