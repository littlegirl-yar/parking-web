<template>
  <div class="absolute top-4 right-4">
    <div v-if="this.$auth.loggedIn">
      <nuxt-link class="btn-main" to="/account">Account</nuxt-link>
      <button class="btn-main" @click="logout()">Log out</button>
    </div>
    <div class="flex space-x-2" v-else>
      <nuxt-link class="btn-main" to="/login">Login</nuxt-link>
      <nuxt-link class="btn-main" to="/register">Register</nuxt-link>
    </div>
  </div>
</template>

<script>
export default {

  methods: {
    logout() {
      this.$auth.logout();
    },
  }
}
</script>
