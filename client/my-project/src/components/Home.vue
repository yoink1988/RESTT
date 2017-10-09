<template>
  <div class="home">
    <div class="menu">
    <select id="category" v-model="responseType">
        <option value="">Response Type</option>
        <option v-for="type in typeSelector" :value="type.value">{{ type.title }}</option>
    </select>
     <button @click="showCars" class="cars"> Show Cars </button>
     <router-link :to="'/register/'">Register</router-link>
     <router-link :to="'/login/'">Login</router-link>
        </div>
    <pre> {{ parseData }} </pre>
  </div>
</template>

<script>
export default {
  name: 'Home',
  data () {
    return {
      refreshed: true,
      // cars:'',
      responseType: '',
      typeSelector: [
        {
          title: 'JSON',
          value: '.json'
        },
        {
          title: 'XML',
          value: '.xml'
        },
        {
          title: 'TXT',
          value: '.txt'
        },
        {
          title: 'HTML',
          value: '.html'
        },
      ]
    }
    
  },
  created(){
    // this.getData()
  },
  methods:{
    showCars: function(){
    var self = this
    // console.log(self.responseType)
    axios.get('http://localhost/public_html/RESTT/client/api/shop/cars/'+self.responseType)
      .then(function (response) {
    self.data = (response.data)

    self.refreshed = false
    })
      .catch(function (error) {
         console.log(error);
      });
    }
    // getData: function(){

    // }
  },
  computed:{
    parseData(){
      if(!this.refreshed)
      {
        // console.log(this.data)
      var data = this.data
      this.refreshed = true
      return data
      }
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
