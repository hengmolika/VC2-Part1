<template>
  <section>
    <navbar :username="user" @logout="Logout"> </navbar>
    <router-view
    @adduser="register"
    @login="Login"
    :messageErrorLogin="message_error_login"
    >
    </router-view>
    <!-- <category-view> </category-view>
    <my-event-card></my-event-card> -->
  </section>

</template>
<script>
import axios from "./axios-http.js";
import Navigation from './components/Navigation/EventNav.vue'

export default {
  components: {
    'navbar': Navigation,
  },
  data() {
    return {
      error_message: {
        first_name_error: "",
        last_name_error: "",
        email_error: "",
        password_error: "",
        confirm_password_error: "",
      },
      user: null,
      message_error_login: false,
    };
  },
  provide() {
    return {
      error_message: this.error_message,
    };
  },
  methods: {
    register(listUser) {
      let dataUser = {
        first_name: listUser.first_name,
        last_name: listUser.last_name,
        email: listUser.email,
        password: listUser.password,
        password_confirmation: listUser.comfirm_password,
      };

      axios
        .post("/register", dataUser)
        .then((response) => {
          this.$router.push("/my-event");
          this.user = response.data.user;
          localStorage.setItem("userId", response.data.user.id);
          this.isRegistered = true;
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.error_message.first_name_error =
              error.response.data.errors.first_name;
            this.error_message.last_name_error =
              error.response.data.errors.last_name;
            this.error_message.email_error = error.response.data.errors.email;
            this.error_message.password_error =
              error.response.data.errors.password;
            this.error_message.confirm_password_error =
              error.response.data.errors.password;
          }
        });
    },
    Login(form_data) {
      axios
        .post("/login", form_data)
        .then((response) => {
          if (response.data.message !== "logined") { 
            this.message_error_login = true;
            console.log('cannot login')
          } else {
            this.$router.push("/my-event");
            this.user = response.data.user;
            localStorage.setItem("userId", response.data.user.id);
            this.message_error_login = false;

          }
        });

    },
    Logout() {
      this.user = null;
      localStorage.removeItem("userId");
      this.$router.push("/signin");
    },
  },
  mounted() {
    window.onpopstate  = () => {
      if(localStorage.getItem('userId') !== null && (this.$route.path === '/signin' || this.$route.path === '/' || this.$route.path === '/register')
      ) {
        this.$router.push('/my-event');
      }
    };
  
    if (localStorage.userId) {
      this.$router.push('/my-event');
      axios.get('/users/' + localStorage.userId)
      .then(response => {
        this.user = response.data;
      })
    } else {
      this.$router.push('/signin');
    }

  },

}

</script>


<style>
:root {
  --main-color: #0096bb;
  --main-color-light: #3d1ee9;
}

* {
  box-sizing: border-box;
}

html {
  font-family: "Roboto", sans-serif;
}

body {
  margin: 0;
}

.right-main-button {
  float: right;
  margin-right: 2rem;
}

</style>


