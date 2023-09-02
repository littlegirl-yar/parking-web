export default {
  actions: {
    async LOGIN({commit}, payload) {
      try{
        await this.$auth.loginWith('auth_jwt', {
          data: {
            email: payload.email,
            password: payload.password
          }
        })
        this.$router.push({ path: '/' })
      }
      catch(e){
        this.$toast.error(e.response.data.message);
      }
    },
    async REGISTER({commit}, payload) {
      try{
        await this.$axios.post(`${process.env.API_URL}/auth/register`, payload)
      }
      catch(e){
        this.$toast.error(e.response.data.message + '' + Object.values(e.response.data.errors));
        throw e
      }
    }
  }
}
