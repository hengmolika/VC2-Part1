<template>
  <section>
    
    <div class="container">
      <div
        class="card mb-2"
        v-for="(category, index) of categoryData"
        :key="index"
      >
        <div class="card-body">
          <div class="card-title">
            <h4>{{ category.name }}</h4>
          </div>
          <div class="icon">
            <button
              id="delete"
              data-toggle="modal"
              data-target="#exampleModalCenter"
              @click="deleteItemAction(category.id)"
            >
              <i class="fa fa-trash"></i>
            </button>
            <button id="edit" data-toggle="modal"
              data-target="#exampleModalCenter"
            @click ="updateAction(category)" >
              <i class="fa fa-pencil"></i>
            </button>
          </div>
        </div>
        <!-- V-IF CONDITION  -->
        <div v-if="!isUpdated"
          class="modal fade"
          id="exampleModalCenter"
          tabindex="-1"
          role="dialog"
          aria-labelledby="exampleModalCenterTitle"
          aria-hidden="true" >
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <!-- Cancel Remove an updated action -->
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" >
                  Remove Item?
                </h5>
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <!-- Title of Action  -->
              <div class="modal-body" id="description">
                Are you sure you want to remove this item?
              </div>
              <!-- Button updated or deleted condition -->
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-sm text-light"
                  id="cancel"
                  data-dismiss="modal"
                >
                  No, Cancel
                </button>
                <button 
                  type="button"
                  class="btn btn-danger btn-sm" data-dismiss="modal" 
                  @click="deleteItem(delete_id)" >
                  Yes, Remove
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- V-ELSE CONDITION -->
        <div v-else
          class="modal fade"
          id="exampleModalCenter"
          tabindex="-1"
          role="dialog"
          aria-labelledby="exampleModalCenterTitle"
          aria-hidden="true" >
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <!-- Cancel Remove an updated action -->
              <div class="modal-header" >
                <h5 class="modal-title" id="exampleModalLongTitle" >
                  Update Item?
                </h5>
               <button @click="cancelUpdate"
                type="button"
                class="btn btn-danger rounded rounded-circle" 
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <i class="fa fa-times"></i>
                </button>
              </div>
              <!-- Title of Action  -->
              <div class="modal-body" id="description" >
                <input type="text" placeholder="Update item" class="form-control p-2" v-model="titleForm">
              </div>
              <!-- Button updated or deleted condition -->
              <div class="modal-footer justify-content-between">
                <button  
                  type="button"
                  class="btn btn-block" data-dismiss="modal" 
                  @click="updateCategory(update_id,titleForm)" >
                  Update Category
                </button>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  props: ["categoryData"],
  emits: ["deleteItem", "updateCategory"],
  data() {
    return {
      delete_id: 0,
      update_data: [],
      isUpdated: false,
      update_id: 0,
      titleForm: "",
    }
  },
  

  methods: {
    deleteItemAction(id){
      this.delete_id = id;
      console.log("hello",this.delete_id);
    },
    deleteItem(id) {
      this.$emit("deleteItem",id);
      // console.log("deleted", id)
    },

    updateAction(udate_value) {
      this.update_id = udate_value.id;
      this.titleForm = udate_value.name;
      this.isUpdated = true;
      console.log("action updated", this.isUpdated);
    },
    cancelUpdate(){
      this.isUpdated = false;
    },

    updateCategory(id, title){
      this.$emit("updateCategory", id,title);
        this.isUpdated = false;
      }
    },
};
</script>

<style>
.container {
  margin: 1rem auto;
  padding: 1px;
  border-radius: 30px;
  max-width: 50rem;
}
.card-body {
  display: flex;
  justify-content: space-between;
}

#delete {
  color: #e03030;
  margin: 5px;
  padding: 5px;
  border-radius: 5px;
  background: #e030304b;
  outline: none;
  font-size: 20px;
}
#edit {
  color: #020269;
  margin: 5px;
  padding: 5px;
  border-radius: 5px;
  background: #00808041;
  outline: none;
  font-size: 20px;
}
button {
  cursor: pointer;
  border: none;
}
#exampleModalLongTitle {
  color: #020269;
}
</style>