<template>
  <div class="Register">
      <div class="form">
      <label for="form">Registration form:</label>
      <p><input placeholder="email" v-model="user.email" type="text"/></p>
      <p><input placeholder="Password" v-model="user.pass" type="text"/></p>
      <p><button @click="register">LogIn</button></p>
      <p><span>{{ errorEmail }}</span></p>
      <p><span> {{ errorPass }} </span></p>
    </div>
  </div>
</template>

<script>

export default {
  name: 'Register',
  data () {
    return {
      user: {},
      errorPass:'',
      errorEmail:'',
    }
  },
  methods:{
    register: function(){
      var self = this
      var config = {
        headers: {'Content-Type': 'application/x-www-form-urlencoded'
        },
      }
      var data = new FormData();
      data.append('name', self.user.name);
      data.append('lname', self.user.lName);
      data.append('login', self.user.email);
      data.append('pass', self.user.pass);
      axios.post('http://localhost/public_html/RESTT/client/api/shop/users/', data, config)
          .then(function (response) {
          console.log(response);
          })
  .catch(function (error) {
    console.log(error);
  });
    }
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 0 10px;
}

a {
  color: #42b983;
}
</style>
