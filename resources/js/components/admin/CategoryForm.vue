<template>
    <div class="container">
 <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
              <h3 v-if="editMode" class="card-title">Editing Category</h3>
              <h3 v-else class="card-title">Create Category</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form">
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Category Name</label>
                <input v-model="form.name" type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter a name for the category">
              </div>
              
            </div>
            <!-- /.card-body -->

            <div class="card-footer d-flex justify-content-end">
              <button v-if="editMode" type="submit" class="btn btn-success">Update</button>
              <button v-else type="submit" class="btn btn-primary">Create</button>
            </div>
          </form>
        </div>
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
                category_to_edit_id: '',
                form: {
                  name:''
                }
            }
        },

        created() {
            this.category_to_edit_id = this.$route.params.id;
            this.editMode = this.category_to_edit_id ? true : false;
            if(this.editMode) {
                
                axios.get('/api/categories/'+ this.category_to_edit_id).
                then((res) => {
                    console.log(res.data)
                    this.category_to_edit = res.data;
                    this.form.name = this.category_to_edit.name;
                    
                }).
                catch(err => {

                });
            }
            
        }
    }
</script>
