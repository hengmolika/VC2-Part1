<template>
  <section>
    <!-- <event-nav> </event-nav> -->
    
    <div class="container p-4">
      <div
        v-if="isClick"
        class="alert alert-dismissible mb-3"
        :class="
         isTodo ? 'alert-success' : 'alert-danger'
        "
      >
        <a href="#" class="close" data-dismiss="alert" aria-label="close"
          >&times;</a
        >
        <strong>{{ message }}</strong>
      </div>
      <div class="d-flex justify-content-between">
        <h2>Category</h2>
          <!-- @updateCategoryData="updateCategoryItem" -->
        <category-form
          @categoryData="addCategory"
          class="mb-4 d-flex justify-content-end"
        >
        </category-form>
      </div>

      <hr id="border" />
      <form class="form">
        <div class="input-group">
          <input
            type="text"
            class="form-control"
            placeholder="Category name"
            aria-label="Username"
            aria-describedby="basic-addon1"
            v-model="name" v-on:keyup.prevent="searchName"
          />
          <div class="input-group-prepend">
            <button
              class="fa fa-search btn rounded-right"
              @click.prevent="searchName"
              id="btn-search"
            ></button>
          </div>
        </div>
      </form>
    </div>


    <category-card
      :categoryData="categories"
      @deleteItem="removeItem"
     @updateCategory="updateCategoryCard"
    >
    </category-card>
  </section>
</template>

<script>
import axios from "axios";
const API_URL = "http://localhost:8000/api";
export default {
  // props: ["isUpdated_fount"],
  data() {
    return {
      categories: [],
      message: "",
      isClick: false,
      isTodo: false,
      name: "",
      
    };
  },

  // provide() {
  //   return {
  //     category_update_info: this.update_info,
  //   };
  // },

  methods: {
    addCategory(name) {
      axios
        .post(API_URL + "/category", { name })
        .then((response) => {
          console.log(response.data);
          this.getCategory();
          this.message = "Create success!";
          this.isTodo = true;
        })
        .catch((error) => {
          this.message = error.response.data.errors.name[0];
          this.isTodo = false;
        });
      this.isClick = true;
    },
    getCategory() {
      axios.get(API_URL + "/category").then((response) => {
        this.categories = response.data;
      });
    },
    searchName() {
      if (this.name !== "") {
        axios.get(API_URL + "/category/search/" + this.name).then((res) => {
          this.categories = res.data;
        });
      } else {
        this.getCategory();
      }
    },

    // DELETE CATEGORY==========================================================================

    removeItem(id) {
      axios.delete(API_URL + "/category/" + id).then((res) => {
        this.message = res.data.message;
        this.getCategory();
        this.isTodo = true;
        this.isClick = true;
        // console.log(id);
      })
    
    },

    // UPDATE CATEGORY ========================================================================

    updateCategoryCard(id, title) {
      axios
        .put(API_URL + "/category/" + id, { name: title })
        .then((response) => {
          this.message = response.data.message;
          console.log(response.data);
          this.getCategory();
          this.isTodo = true;
        })
        .catch((error) => {
          this.message = error.response.data.errors.name[0];
          this.isTodo = false;
        });

        this.isClick = true;
        this.categoryName = '';

      console.log("Title of category", title);
    },
  
  },
  mounted() {
    this.getCategory();
  },
};
</script>

<style>
*/ .has-search input {
  border-radius: 40px;
}
#btn-search { 
  background: #020269;
}
#border {
  border-top: 4px solid rgb(95, 92, 92);
  padding: 5px;
}
h2 {
  color: #020269;
}
</style>
