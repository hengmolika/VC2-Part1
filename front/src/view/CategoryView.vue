<template>
  <section>
    <div class="container p-4">
      <div
        v-if="isShowMessage"
        class="alert alert-dismissible mb-3"
        :class="showMessage === myMessage ? myClass : 'alert-danger'"
      >
        <a href="#" class="close" data-dismiss="alert" aria-label="close"
          >&times;</a
        >
        <strong>{{ message }}</strong>
      </div>

      <div class="d-flex justify-content-between mb-2 dropdown">
        <h2 id="category-title">Category</h2>

        <base-dailog
        v-if="dialogDissplayed"
        :title="dialogTitle"
        @close="closeDailog"
        >
          <div v-if="dialogMode !== 'Remove'">
            <label for="category">Category name</label>
            <input
              name="description"
              id="category"
              ref="descInput"
              type="text"
              class="form-control"
              placeholder="Type here..."
              v-model="name"
            />
          </div>
          <div v-else>
            <h5>Are you sure you want to remove this category?</h5>
          </div>
          <template #action>
            <base-button  @click="closeDailog" class="mr-3 btn btn-secondary"> Close </base-button>
            <base-button :class="classButton"
            @click="onConfirm"
            >
            {{dialogButton}} 
            </base-button>
            
          </template>
        </base-dailog>

        <base-button
          class="right-man-button btn" id="btn-create"
          type="submit"
          @click="showCreateForm"
        >
        + Add Category
        </base-button>
      </div>

      <hr class="pb-1" />

      <category-form-search @addName="searchCategory"> </category-form-search>
      <category-card class="mt-3"
      v-for="(category, index) in categories" :key="index"
      :category="category"
      @requestRemove="showDeleteDialog"
      @requestEdit="showEditForm"
      >
      </category-card>
    </div>
  </section>
</template>

<script>
import axios from "../axios-http.js";
import CategoryFormSearch from "../components/Pages/Category/CategoryFormSearch.vue";
import BaseButton from '../components/UI/BaseButton.vue';
import BaseDialog from '../components/UI/BaseDialog.vue';
import CategoryCard from '../components/Pages/Category/CategoryCard.vue';
export default {
  components: { 
    'category-form-search': CategoryFormSearch,
    'base-button': BaseButton,
    'base-dailog': BaseDialog,
    'category-card': CategoryCard
  },
  data() {
    return {
      name: '', 
      categories: [],
      message: "",
      isShowMessage: false,
      ShowMessage: "",
      myClass: "",
      myMessage: "",
      categoryToEdit: {},
      dialogMode: 'create',
      dialogDissplayed: false,
      
    };
  },
  computed: {
// ######################### GET DIALOG TITLE #########################################
    dialogTitle() {
 
      let message = "";
      if(this.dialogMode === 'create') {
        message = "CREATE CATEGORY";
      } else if(this.dialogMode === 'edit') {
        message = "EDIT CATEGORY";
      } else {
        message = "Remove this category?"
      }
      return message;
    },

// ######################## GET DIALOG BUTTON NAME ###################################
    dialogButton() {
    
      let message = "";
      if(this.dialogMode === 'create') {
        message = "CREATE";
      } else if(this.dialogMode === 'edit') {
        message = "UPDATE";
      } else {
        message = "Remove"
      }
      return message;
    },
// ########################## GET BUTTON CLASS STYLE ################################
    classButton() {
  
      let message = "";
      if(this.dialogMode === 'create') {
        message = "btn btn-primary";
      } else if(this.dialogMode === 'edit') {
        message = "btn btn-success";
      } else {
        message = "btn btn-danger"
      }
      return message;
    }
  },
  methods: {
// ########################## GET CATEGORY DATA FUNCTION ################################
    getCategory() {
      axios.get("/category").then((res) => {
        this.categories = res.data;
      });
    },
// ########################## SEARCH CATEGORY BY NAME FUNCTION ###########################
    searchCategory(name) {
      if (name !== "") {
        axios.get("/category/search/" + name).then((res) => {
          this.categories = res.data;
        });
      } else {
        this.getCategory();
      }
    },
// ########################## SHOW CREATE DIALOG FORM FUNCTION ################################
    showCreateForm() {
      this.dialogMode = 'create';
      this.dialogDissplayed = true
    },

// ########################## CLOSE DIALOG FORM FUNCTION ################################
    closeDailog() {
      this.dialogDissplayed = false
      this.name = '';
    },

// ########################## ADD CATEGORY FUNCTION ################################
    addCategory(name) {
      this.isShowMessage = true;
      axios
        .post("/category", { name })
        .then((response) => {
          console.log(response.data);
          this.showMessage = response.data.message;
          this.message = "Create successfully";
          this.myClass = "alert-success";
          this.myMessage = "Created";
          this.getCategory();
        })
        .catch((error) => {
          this.message = error.response.data.errors.name[0];
        });
    },
    
// ########################## DELETE CATEGORY FUNCTION ################################
    deleteCategory(id) {
      this.isShowMessage = true;
      axios.delete('/category/' + id)
      .then((response) => {
        this.categories = this.categories.filter(category => category.id !== id);
        this.showMessage = response.data.message;
        this.message = "Delete successfully";
        this.myClass = "alert-success";
        this.myMessage = "Deleted";

        console.log("Deleted");
      })

      this.closeDailog();
    },

// ########################## SHOW DELETE DIALOG FORM FUNCTION ################################
    showDeleteDialog(id) {
      this.dialogMode = 'Remove';
      this.dialogDissplayed = true
      this.categoryToEdit = {
        id: id
      }
    },

// ########################## SHOW EDIT DIALOG FROM FUNCTION ################################
    showEditForm(id, name) {
      this.dialogMode = 'edit';
      this.dialogDissplayed = true;
      this.categoryToEdit = {
        id: id,
        name: name
      }
      this.id = this.categoryToEdit.id;
      this.name = this.categoryToEdit.name
      console.log(this.id, this.name)
    },
// ########################## UPDATE CATEGORY FUNCTION ################################
    updateCategory(id) {
      this.isShowMessage = true;
      let newData = {
        name: this.name,
      };
      axios.put("/category/" + id, newData)
      .then(response => {
        console.log(response.data);
        this.showMessage = response.data.message;
        console.log(response.data)
        this.message = "Update successfully";
        this.myClass = "alert-success";
        this.myMessage = "Updated";
        this.getCategory();
      })
      .catch((error) => {
        this.message = error.response.data.errors.name[0];
      })
    },
// ########################## ONCONFIRM FUNCTION ################################
    onConfirm() {
      if(this.dialogMode === 'create') {
        this.addCategory(this.name);
      } else if (this.dialogMode === 'edit') {
        this.updateCategory(this.categoryToEdit.id);
      } else if(this.dialogMode === 'Remove') {
        this.deleteCategory(this.categoryToEdit.id)
      }

      this.closeDailog();
    },


  },
  mounted() {
    this.getCategory();
  },
};
</script>

<style scoped>
.form-control {
  margin: 0.5rem 0;
}

label {
  font-weight: bold;
  display: block;
  margin-bottom: 0.5rem;
}

input,
textarea {
  display: block;
  width: 100%;
  border: 1px solid #ccc;
  font: inherit;
}

input:focus,
textarea:focus {
  background-color: #f0e6fd;
  outline: none;
  border-color: #3d008d;
}

h3 {
  margin: 0.5rem 0;
  font-size: 1rem;
}

#btn-create{
  background: #022669;
}
#category-title{
  color: #022669;
}
hr{
  background:#022669;
}

::-webkit-scrollbar {
width: 10px;
}

</style>
