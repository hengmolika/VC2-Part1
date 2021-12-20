<template>
  <section>
    <div class="contain-body">
        <h1 class="text-center p-4 font-weight-light">My Events Sign In</h1>
    <div class="form-field">
        <form action="#" @submit.prevent="addMyLogin">
            <div class="form-group text-style">
                <hr>
                <p class="btn-text">Sign In Here</p>
                <hr>
            </div>
            <div class="alert alert-danger" v-if="messageErrorLogin"> Invalid password or email, Please try again! </div>
            <div class="form-group">
                <input
                    type="email"
                    class="form-control"
                    placeholder="Email"
                    v-model="form_info.email"
                    required
                />
            </div>
            <div class="form-group">
                <input
                    type="password"
                    class="form-control"
                    placeholder="Password"
                    v-model="form_info.password"
                    required
                />
            </div>
            
            <button type="submit" class="btn form-control">Login</button>
        </form>
        
    </div>
    <p class="text-center mt-2">Don't have an account yet? <router-link to="/register">Register</router-link></p>
    </div>
    
  </section>
</template>

<script>
export default {
    emits: ['login'],
    props: ['messageErrorLogin'],
    data() {
        return {
            form_info: {
                email: '',
                password: ''
            }
        }
    },
    methods: {
        addMyLogin() {
            this.$emit('login', this.form_info)
        }
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
hr {
    font-weight: bolder;
    width: 25%;
    background: #020269;
    border: 1px solid #020269;
}
.text-style {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.btn-text { 
    border: none;
    background: rgba(207, 204, 204, 0.81);
    color: #020269;
    border-radius: 10px;
    font-family: Arial, Helvetica, sans-serif;
    padding: 7px;
    display: flex;
    align-items: center;
}
button{
    background: #020269;
    color: white;
}
</style>
