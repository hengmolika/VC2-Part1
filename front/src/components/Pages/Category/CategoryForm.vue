<template>
  <section>
    <!-- Button to Open the Modal -->
    <button data-toggle="modal" data-target="#myModal" class="btn p-2">
      Add Category +
    </button>
    <div class="modal" id="myModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title" id="title">Create event category</h4>
            <button
              type="button"
              class="btn btn-danger rounded rounded-circle"
              data-dismiss="modal"
            >
              <i class="fa fa-times"></i>
            </button>
          </div>
          <!-- Modal body -->
          <form>
            <div class="modal-body">
              <input
                type="text"
                class="form-control"
                placeholder="Event category"
                v-model="category_name"
              />
            </div>
            <!-- Modal footer -->
            <div class="modal-footer" id="btn-create">
              <button
                type="button"
                class="btn btn-block"
                @click="addCategoryData"
                data-dismiss="modal">
                Create
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
 
  </section>
</template>
<script>

export default {
  emits: ["categoryData"],
  props:['categoryName'],
  
  data() {
    return {
      category_name: '',
    };
  },

  methods: {
    addCategoryData() {
      this.$emit("categoryData", this.category_name);
      this.category_name = "";
    },
    
  },

};
</script>

<style>
button {
  padding: 10px;
  background: #020269;
  color: rgb(240, 236, 236);
}
#title {
  color: #020269;
}
</style>