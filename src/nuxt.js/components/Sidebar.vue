<template>
  <div class="sidebar">
    <img src="@/assets/image/logo.png" alt="logo" class="logo">
    <div class="menu">
      <NuxtLink to="/Home" class="home">
        <div><img src="@/assets/image/home.png" alt="logo" class="icon"></div>
        <div>ホーム</div>
      </NuxtLink>
    </div>
    <div class="menu">
      <a @click="logout" class="logout">
        <div><img src="@/assets/image/logout.png" alt="logo" class="icon"></div>
        <div>ログアウト</div>
      </a>
    </div>
    <div>
      <p class="p">シェア</p>
      <div>
        <validation-observer ref="obs" v-slot="{ invalid, validated }">
        <validation-provider v-slot="{ errors }" rules="required|max:120">
        <textarea name="message" id="textarea" rows="10" v-model="message" ></textarea>
        <div class="error">{{ errors[0] }}</div>
        </validation-provider>
        <p><button @click="storeMessage" class="share" :disabled="invalid || !validated" :class="{ 'button-invalid': invalid && validated }">シェアする</button></p>
        </validation-observer>
      </div>
    </div>
  </div>
</template>

<script>
import firebase from '~/plugins/firebase';
import axios from 'axios';
export default {
  layout: 'main',
  data() {
    return {
      message: "",
    };
  },
  methods: {
    logout() {
    firebase
    .auth()
    .signOut()
    .then(() => {
    this.$router.replace('/Index')
    })
    },
    async storeMessage() {
    try {
      let user = firebase.auth().currentUser;
      const sendData = {
        uid: user.uid,
        message: this.message,
      };
      await this.$axios.post("http://localhost/api/store", sendData);
      this.message = '';
      await this.$store.dispatch('post/getPost');
      this.$router.replace('/Home')
    } catch (error) {
      console.error(error);
      alert('エラーが起きました。')
    }
    },
  },
};
</script>

<style scoped>
.sidebar {
  margin:50px;
  margin-bottom: 30px;
}
.logo{
  width:200px;
}
.menu{
  margin:20px 0;
}
.home{
  width:30%;
  justify-content: space-between;
  display:flex;
  align-items:center;
  color:white;
  text-decoration:none;
  cursor:pointer;
  white-space:nowrap;
}
.logout{
  width:38%;
  justify-content: space-between;
  display:flex;
  align-items:center;
  color:white;
  text-decoration:none;
  cursor:pointer;
  white-space:nowrap;
}
.icon{
  width:40px;
}
.p{
  color:white;
}
#textarea{
  width:85%;
  background-color:transparent;
  border:1px solid white;
  border-radius:5px;
  color:white;
}
.share{
  width:100px;
  height:40px;
  border-radius:20px;
  border:none;
  background-color:blue;
  color:white;
  cursor:pointer;
  margin-left:45%;
}
.button-invalid {
  background-color:gray;
  cursor:default;
}
.error{
  color:white;
}
</style>