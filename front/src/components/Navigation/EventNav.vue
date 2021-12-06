<template>
  <section>
    <nav class="navbar navbar-expand-lg navbar-light nav">
        <a class="navbar-brand text-white d-flex justify-content-center align-items-center" href="#">
            <img src="../../assets/avatar.png" width="40" height="40" class="d-inline-block align-top rounded rounded-circle mr-2" alt="">
            {{username}}
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
        <ul class="navbar-nav mt-2 mt-lg-0"  id="nav-item">
          <li class="nav-item" v-for="(menu, index) of menuList" :key="index">
            <router-link :to="menu.url" class="nav-link menu-page" id="menu-item"> {{menu.title}} </router-link>
          </li>

        </ul>
        <form class="form-inline my-2 my-lg-0">
          <router-link to="/signin" class="btn btn-info my-2 my-sm-0 ml-5">Sign Out</router-link>
        </form>
      </div>
    </nav>
  </section>
</template>

<script>
export default {
  inject: ['menuList'],
  data() {
    return {
      username: JSON.parse(localStorage.getItem('user_info')). toUpperCase(),
    }
  },
};
</script>

<style>
body {
    background: none;
}
.nav {
  background: #020269;
}
#menu-item{
  color: rgb(219, 217, 213);
  padding-left: 50px;
}
.menu-page {
    font-family: sans-serif;
    font-weight: 500;
    color: #FFFFFF;
}
.menu-page:hover {
    /* background: rgba(5, 60, 72, 0.88);
    border-radius: 5px; */
    text-decoration: 3px underline red;
}
.btn-signout {
    font-family: sans-serif;
    font-style: normal;
    font-weight: normal;
}
#nav-item{
  margin-left: auto;
}
</style>
