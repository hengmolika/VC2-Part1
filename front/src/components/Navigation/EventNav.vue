<template>
  <section>
    <nav v-if="username !== null" class="navbar navbar-expand-lg navbar-light nav ">
        <a class="navbar-brand text-white d-flex justify-content-center align-items-center" href="#">
            <img src="../../assets/avatar.png" width="40" height="40" class="d-inline-block align-top rounded rounded-circle mr-2" alt="">
            {{username.first_name}} {{username.last_name}}
        </a>
      <button
        class="navbar-toggler bg-white"
        type="button"
        data-toggle="collapse"
        data-target="#navbarTogglerDemo02"
        aria-controls="navbarTogglerDemo02"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav ml-auto m-auto mt-lg-0">
          <li class="nav-item">
            <router-link to="/my-event" class="nav-link text-white menu-page">My Events</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/find-event" class="nav-link text-white menu-page">Find Events</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/category" class="nav-link text-white menu-page">Category</router-link>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <a href="#" class="nav-link text-warning my-2 my-sm-0" @click.prevent="ToLogout"> <h5>Logout</h5> </a>
        </form>
      </div>
    </nav>
  </section>
</template>

<script>
export default {
  props: ["username"],
  emits: ['logout'],
  methods: {
    ToLogout() {
      this.$emit('logout');
    }
  },
};
</script>

<style scoped>
body {
  background: white;
}
/* #020269 */
.nav {
  background:  #020269; 
}
.menu-page {
    font-family: sans-serif;
    font-weight: 500;
    color: #022730;
}
.btn-signout {
    font-family: sans-serif;
    font-style: normal;
    font-weight: normal;
}
.nav-item{
  margin-right: 50px;
}

.router-link-active {
    text-decoration: 3px underline white;
    /* background: blue; */
    border-radius: 2px;
}

</style>
