<template>
  <section>
    <div class="contain-body">
         <!-- <h1 class="text-center p-4 font-weight-light">My Events Registration</h1> -->
    <div class="form-field">
        <form action="#" @submit.prevent="addUserInfo">
            <div class="form-group inser-img d-flex">
                 <div v-if="imagepreview">
                     <img :src="imagepreview" class="figure-img img-fluid rounded"  width="100" height="100">
                 </div>
                 <div v-else>
                    <img src="../../assets/avatar.png" alt="" width="100" height="100" class="rounded">
                 </div>
                <div class="m-auto">
                    <input type="file" name="" id="image" class="d-none" @change="imageSeleted">
                    <label for="image" class="fa fa-plus-circle btn btn-outline-info img-icon"></label>
                </div>
            </div>
           
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input
                    type="text"
                    class="form-control"
                    placeholder="First name"
                    v-model="signup_form.first_name"
                    required
                    />
                    <small class="text-danger" v-if="error_message.first_name_error"> {{error_message.first_name_error[0]}} </small>
                </div>
               
                
                <div class="form-group col-md-6">
                    <input
                    type="text"
                    class="form-control"
                    placeholder="Last name"
                    v-model="signup_form.last_name"
                    required
                    />
                    <small class="text-danger" v-if="error_message.last_name_error"> {{error_message.last_name_error[0]}} </small>
                </div>
            </div>
            <div class="form-group">
              
                <input
                    type="email"
                    class="form-control"
                    placeholder="Email"
                    v-model="signup_form.email"
                    required
                />
                <div class="text-danger" v-if="error_message.email_error"> {{error_message.email_error[0]}} </div>
                
            </div>
            <div class="form-group">
                
                <input
                    type="password"
                    class="form-control"
                    placeholder="Password"
                    v-model="signup_form.password"
                    required
                />
                <div class="text-danger" v-if="error_message.password_error"> {{error_message.password_error[0]}} </div>
            </div>
            <div class="form-group">

                <input
                    type="password"
                    class="form-control"
                    placeholder="Comfirm Password"
                    v-model="signup_form.comfirm_password"
                    required
                />
                <div class="text-danger" v-if="error_message.confirm_password_error"> {{error_message.confirm_password_error[1]}} </div>
            </div>
            
            <button class="btn btn-primary form-control" >Register now</button>
        </form>
    </div>
    <p class="text-center mt-2">Have you already an account? <router-link to="/signin">Sign in</router-link></p>
    </div>
   
  </section>
</template>

<script>
export default {
    emits: ['adduser'],
    inject: ['error_message'],
    data() {
        return {
            signup_form: {
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                comfirm_password: ''
            },
            image:null,
            imagepreview : null,
            
        }
    },
    methods: {
        imageSeleted(e){
            this.image = e.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(this.image);
            reader.onload = e =>{
                this.imagepreview = e.target.result;
            }
        },
        addUserInfo() {
            this.$emit('adduser', this.signup_form);
        },
        
    },
};
</script>

<style scoped>

.contain-body {
    background: url('../../assets/lastImg.jpg');
    background-size: cover;
    background-position: center center;  
    width: auto;
    height: 100vh;
    padding-top: 100px;
    
}
.form-field {
  width: 35%;
  margin: auto;
  box-shadow: 0px 2px 16px 11px rgba(30, 48, 54, 0.67);
  background: #e7eef0;
  border-radius: 10px;
  padding: 20px;
  opacity: 0.8;
  position: center center;
 
}
.img-icon {
    margin-left: 40px;
    font-size: 20px;
}

button{
    background: #020269;
    color: white;
}
</style>
