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

<!-- ################################ DIALOG FORM ##################################### -->

      <div class="d-flex justify-content-between mb-3">
        <h2 class="text-primary">My Events</h2>
        <base-dailog
          v-if="dialogDisplayed" 
          :title="dialogTitle"
          @close="closeDialog"
        >
          <div v-if="dialogMode !== 'remove'">
              <div class="event-form">
                <div class="form-row">
                  <div class="form-group col-sm-12">
                    <div v-if="imageToEdt === 'create' ">
                      <div v-if="imagepreview">
                        <img
                          :src="imagepreview"
                          class="img-fluid"
                          alt=""
                        />
                      </div>
                    </div>
                    <div v-if="dialogMode !== 'edit' ">
                      <label >Image</label>
                      <input id="image" type="file" hidden class="form-control mr-3" @change="imageSeleted"/>
                      <label for="image" class="fa fa-image btn btn-outline-primary p-3"></label>
                    </div>
                      
                  </div>
                  <div class="form-group col-sm-12">
                    <label for="category">Category</label>
                    
                    <select name="category" id="category" class="form-control" v-model="event_data.categoryId">
                      <option v-for="category of categories" :key="category.id" :value="category.id"> {{category.name}} </option>
                    </select>
                  </div>
                  <div class="form-group col-sm-12">
                    <label for="title">Title</label>
                    <input
                      type="text"
                      id="title"
                      class="form-control"
                      placeholder="Title"
                      v-model="event_data.title"
                    />
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="startDate">Start date and time</label>
                    <input
                      type="datetime-local"
                      id="startDate"
                      class="form-control"
                      v-model="event_data.start_date"
                    />
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="endDate">End date and time</label>
                    <input
                      type="datetime-local"
                      id="endDate"
                      class="form-control"
                      v-model="event_data.end_date"
                    />
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="contry">Country</label>
                    <input
                      list="countryList"
                      class="form-control"
                      placeholder="Select city"
                      v-model="event_data.country"
                    />
                    <datalist id="countryList">
                      <option v-for="name of countryName" :key="name" class="form-control">{{name}}</option>
                    </datalist>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="city">City</label>
                    <input
                      list="cityList"
                      class="form-control"
                      placeholder="Select city"
                      v-model="event_data.city"
                    />
                    <datalist id="cityList">
                      <option v-for="city of countries[event_data.country]" :key="city" class="form-control">{{city}}</option>
                    </datalist>
                  </div>
                  <div class="form-group col-sm-12">
                    <label for="description">Description</label>
                    <textarea
                      id="description"
                      class="form-control"
                      placeholder="Description"
                      v-model="event_data.description"
                    ></textarea>
                  </div>
                </div>
              </div>
          </div>
          <div v-else>
            <h5>Are you sure you want to remove this event?</h5>
          </div>
          <template #action>
            <base-button @click="closeDialog" class="mr-3 btn btn-secondary"> Close </base-button>
            <base-button :class="classButton"
            @click="onConfirm"
            >
            {{dialogButton}}
            </base-button>
          </template>
        </base-dailog>

        <base-button
          class="right-man-button btn btn-primary" 
          type="submit"
          @click="showCreateMyEvent"
        >
          + Add Event
        </base-button>
      </div>

      <hr class="bg-dark pb-1">

<!-- ################################ MY EVENT FORM SEARCH ##################################### -->

      <my-event-search
      @searchName="searchEvent"
      > </my-event-search>

<!-- ################################ MY EVENT CARD ##################################### -->
      <my-event-card 
      v-for="event of my_events" :key="event.id" 
      :event="event" 
      :buttonMode="myEventMode"
      class="mt-3"
      @requestToDelete="showDeleteForm"
      @requestToEdt="showEditForm"
      > 
      </my-event-card>


    </div>
  </section>
</template>

<script>
import axios from '../axios-http.js';
import MyEventCard from "../components/Pages/myevent/MyEventCard.vue";
import MyEventFormSearch from "../components/Pages/myevent/MyEventFormSearch.vue";
import BaseButton from "../components/UI/BaseButton.vue";
import BaseDialog from "../components/UI/BaseDialog.vue";

export default {
  components: {
    "my-event-card": MyEventCard,
    "my-event-search": MyEventFormSearch,
    "base-button": BaseButton,
    "base-dailog": BaseDialog,
  },
  data() {
    return {
      event_data: {
        categoryId: null,
        title: "",
        start_date: "",
        end_date: "",
        country: "",  
        city: "",
        description: "",
      },
      my_events: [],
      message: "",
      isShowMessage: false,
      ShowMessage: "",
      myClass: "",
      myMessage: "",
      myEventAction: {},
      dialogMode: "create",
      dialogDisplayed: false,
      categories: [],
      countries: {},
      countryName: [],
      defaultImage: "../assets/null.png",
      image: "",
      imagepreview: null,
      myEventMode: 'myEvent',

      messageError:{
        image_error: "",
        title_error: "",
        description_error: "",
        country_error: "",
        city_error: "",
        start_date_error: "",
        end_date_error: "",

      },

      imageToEdt: 'create',
      url : 'http://localhost:8000/storage/images/events/',

    };
  },
  computed: {
//############################################# GET DIALOG TITLE ############################################
    dialogTitle() {
      let message = "";
      if (this.dialogMode === "create") {
        message = "CREATE MY EVENT";
      } else if (this.dialogMode === "edit") {
        message = "EDIT MY EVENT";
      } else {
        message = "REMOVE THIS EVENT?";
      }
      return message;
    },
//############################################# GET DIALOG BUTTON NAME ############################################
    dialogButton() {
      let message = "";
      if (this.dialogMode === "create") {
        message = "CREATE";
      } else if (this.dialogMode === "edit") {
        message = "UPDATE";
      } else {
        message = "REMOVE";
      }
      return message;
    },

//############################################# GET DIALOG BUTTON CLASS STYLE ############################################
    classButton() {
      let message = "";
      if (this.dialogMode === "create") {
        message = "btn btn-primary";
      } else if (this.dialogMode === "edit") {
        message = "btn btn-success";
      } else {
        message = "btn btn-danger";
      }
      return message;
    },
  },
  methods: {
//############################################# GET MY EVENTS ############################################
    getMyEvent() {
      axios.get('/myevent')
      .then(response => {
        this.my_events = response.data.filter((event) => event.user_id === parseInt(localStorage.getItem('userId')));
      })
    },
//############################################# SHOW CREATE MY EVENT FORM ############################################
    showCreateMyEvent() {
      this.dialogMode = "create";
      this.dialogDisplayed = true;
      this.imagepreview = null;
    },
//############################################# SHOW DELETE MY EVENT DIALOG ############################################
    showDeleteForm(id) {
      this.dialogMode = "remove";
      this.dialogDisplayed = true;
      this.myEventAction = {
        id: id
      }
    },
// #################################### SHOW CREATE FORM WHEN CLICK ON ADD EVENT ########################
    showEditForm(eventData) {
      this.imageToEdt = 'edit';
      this.dialogMode = 'edit';
      this.dialogDisplayed = true;
      this.myEventAction = {
        id: eventData.id,
        category_id: eventData.categories_id,
        user_id: eventData.user_id,
        image: eventData.image,
        title: eventData.title,
        description: eventData.description,
        country: eventData.country,
        city: eventData.city,
        start_date: eventData.start_date,
        end_date: eventData.end_date
      }

      this.event_data.categoryId = eventData.category.id;

      this.event_data.title = eventData.title;
      this.event_data.description = eventData.description;
      this.event_data.start_date = eventData.start_date;
      this.event_data.end_date = eventData.end_date;
      this.event_data.country = eventData.country;
      this.event_data.city = eventData.city;

      this.imagepreview = eventData.image;
    },

// #################################### UPDATE EVENT FUNCTION ########################
    updateMyEvent(previousData) {
      
      let myNewEventData = {
        user_id: previousData.user_id,
        category_id: this.event_data.categoryId,
        title: this.event_data.title,
        description: this.event_data.description,
        country: this.event_data.country,
        city: this.event_data.city,
        start_date: this.event_data.start_date,
        end_date: this.event_data.end_date,
      }
        
      axios.put("/myevent/" + previousData.id, myNewEventData)
      .then(res => {
        
        this.showMessage = res.data.message;
        this.message = "Update successfully";
        this.myClass = "alert-success";
        this.myMessage = "Updated";
        
        this.getMyEvent();
      })
      .catch((error) => {
        console.log(error.response.data.errors)
        if (error.response.status === 422 || error.response.status === 500) {
          if(error.response.status === 500){
            this.messageError.image_error =
            "Please select an image !";
          }
          if(error.response.data.errors.image !== undefined) {
            this.messageError.image_error = error.response.data.errors.image;
          }
          if(error.response.data.errors.title !== undefined) {
            this.messageError.title_error =
            error.response.data.errors.title;
          }
          if (error.response.data.errors.description !== undefined) {
            this.messageError.description_error = 
            error.response.data.errors.description;
          } 

          if (error.response.data.errors.country !== undefined) {
            this.messageError.country_error =
            error.response.data.errors.country;
          }
          if (error.response.data.errors.start_date) {
            this.messageError.start_date_error =
            error.response.data.errors.start_date;
          }
          if (error.response.data.errors.end_date) {
            this.messageError.end_date_error =
            error.response.data.errors.end_date;
          }
        }

        this.message = this.messageError.image_error + "\n" +
        this.messageError.title_error + "\n" + 
        this.messageError.description_error + "\n" + 
        this.messageError.country_error + "\n" + 
        this.messageError.start_date_error + "\n" + 
        this.messageError.end_date_error;
      });
      
      this.isShowMessage = true;
    },
// ################################### CLOSE FORM FUNCTION ##################################

    closeDialog() {
      this.dialogDisplayed = false;

      this.event_data.categoryId = "";
      this.event_data.title = "";
      this.event_data.start_date = "";
      this.event_data.end_date = "";
      this.event_data.country = "";
      this.event_data.city = "";
      this.event_data.country = "";
      this.event_data.description = "";

      this.image = null;
      this.imagepreview = null;
    },
// ################################# SHOW DELETE DIALOG WHEN CLICK ON BUTTON REMOVE ##########################
    showDeleteDialog(id) {
      this.dialogMode = 'remove';
      this.dialogDisplayed = true
      this.myEventAction = {
        id: id
      }
    },
// ################################# DELETE MY EVENT FUNCTION ########################################
    deleteMyEvent(id) {
      this.isShowMessage = true;
      axios.delete('/myevent/' + id)
      .then((response) => {
        this.my_events = this.my_events.filter(event => event.id !== id);
        this.showMessage = response.data.message;
        this.message = "Delete successfully";
        this.myClass = "alert-success";
        this.myMessage = "Deleted";
      })
      console.log(id);
    },
//  ########################################### ADD NEW EVENT FUNCTION #################################
    addMyEvent() {
      let myEventData = new FormData();

      myEventData.append('user_id', parseInt(localStorage.getItem("userId")));
      myEventData.append('category_id', this.event_data.categoryId);
      myEventData.append('title', this.event_data.title);
      myEventData.append('description', this.event_data.description);
      myEventData.append('country', this.event_data.country);
      myEventData.append('city', this.event_data.city);
      myEventData.append('start_date', this.event_data.start_date);
      myEventData.append('end_date', this.event_data.end_date);
     
      myEventData.append('image', this.image);
      console.log(myEventData);

      axios.post("/myevent", myEventData)
      .then(res => {
        
        this.showMessage = res.data.message;
        this.message = "Create successfully";
        this.myClass = "alert-success";
        this.myMessage = "Created";
        
        this.getMyEvent();
      })
      .catch((error) => {
        console.log(error.response.data.errors.image)
        if (error.response.status === 422 || error.response.status === 500) {
          if(error.response.status === 500){
            this.messageError.image_error =
            "Please select an image !";
          }
          if(error.response.data.errors.image !== undefined){
            this.messageError.image_error =
            error.response.data.errors.image;
          }
          if(error.response.data.errors.title !== undefined) {
            this.messageError.title_error =
            error.response.data.errors.title;
          }
          if (error.response.data.errors.description !== undefined) {
            this.messageError.description_error = 
            error.response.data.errors.description;
          } 

          if (error.response.data.errors.country !== undefined) {
            this.messageError.country_error =
            error.response.data.errors.country;
          }
          if (error.response.data.errors.start_date) {
            this.messageError.start_date_error =
            error.response.data.errors.start_date;
          }
          if (error.response.data.errors.end_date) {
            this.messageError.end_date_error =      
            error.response.data.errors.end_date;       
          }
        }

        this.message = this.messageError.image_error + "\n" +
        this.messageError.title_error + "\n" + 
        this.messageError.description_error + "\n" + 
        this.messageError.country_error + "\n" + 
        this.messageError.start_date_error + "\n" + 
        this.messageError.end_date_error;
      });
      
      this.isShowMessage = true;
    },
// ###################################### GET IMAGE FILE AND DISPLAY IMAGE ON FORM #############################
    imageSeleted(e) {

      this.imageToEdt = 'create';
      this.image = e.target.files[0];

      let reader = new FileReader();
      reader.readAsDataURL(this.image);
      reader.onload = e => {
        this.imagepreview = e.target.result;
      };
    },

// ####################################### REMOVE MYEVENT BY ID FUNCTION ####################################################
    removeMyEvent(id) {
      this.isShowMessage = true;
      axios.delete('/myevent/' + id)
      .then((response) => {
        this.my_events = this.my_events.filter(event => event.id !== id);
        this.showMessage = response.data.message;
        this.message = "Delete successfully";
        this.myClass = "alert-success";
        this.myMessage = "Deleted";
      })
    },

// ####################################### ON CONFIRM FUNCTION ####################################################
    onConfirm() {
      if(this.dialogMode === 'create') {
        this.addMyEvent(this.event_data);
      } else if (this.dialogMode === 'edit') {
        this.updateMyEvent(this.myEventAction);
      } else if(this.dialogMode === 'remove') {
        this.deleteMyEvent(this.myEventAction.id)
      }

      this.closeDialog();
    },

// ####################################### SEARCH EVENT BY TITLE FUNCTION ####################################################    
    searchEvent(name) {
      if(name !== "") {
        axios.get('/myevent/search/' + name)
        .then(res => {
          this.my_events = res.data.filter(event => event.user_id === parseInt(localStorage.getItem("userId")));
        })
      } else {
        this.getMyEvent();
      }
    }
  },

  mounted() {
// ###################################### CALL GET MY EVENT FUNCTION ##############################################
    this.getMyEvent();

// ##################################### GET CATEGORY FORM BACKEND ################################################
    axios.get('/category')
    .then(res => {
      this.categories = res.data
    })

// #################################### GET COUNTRY FROM BACKEND ##################################################
    axios.get('/countries')
    .then(res => {
        this.countries = res.data
        for(let count in res.data) {
          this.countryName.push(count);
        }
    })
// ###################################  GET CATEGORY FROM BACKEND ##################################################
    axios.get('/category')
    .then(res => {
        this.categories = res.data
    })
    
  },
}
</script>

<style scoped>
  label {
    font-weight: bold;
    display: block;
    margin-bottom: 0.5rem;
  }
  .event-form {
    width: 100%;
    height: 45vh;
    padding: 20px;
    overflow-y: scroll;
  }

  h3 {
    margin: 0.5rem 0;
    font-size: 1rem;
  }

  .h2{
    color:  #020269;
  }
</style>