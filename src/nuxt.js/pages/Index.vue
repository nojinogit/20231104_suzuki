<template>
  <div class="login">
    <h1>ログイン</h1>
    <validation-observer ref="obs" v-slot="{ invalid, validated }">
      <form @submit.prevent="login">
        <validation-provider v-slot="{ errors }" rules="required">
          <div class="error">{{ errors[0] }}</div>
          <p class="login-p"><input type="email" v-model="email" name="メールアドレス" placeholder="メールアドレス" class="input"/></p>
        </validation-provider>
        <validation-provider v-slot="{ errors }" rules="required">
          <div class="error">{{ errors[0] }}</div>
          <p class="login-p"><input type="password" v-model="password" name="パスワード" placeholder="パスワード"  class="input"/></P>
        </validation-provider>
        <button type="submit" class="login-button" :disabled="invalid || !validated" :class="{ 'button-invalid': invalid && validated }">ログイン</button>
      </form>
    </validation-observer>
  </div>
</template>

<script>
import firebase from '~/plugins/firebase'
export default {
data() {
return {
email: null,
password: null,
}
},
methods: {
login() {
if (!this.email || !this.password) {
alert('メールアドレスまたはパスワードが入力されていません。')
return
}
firebase
.auth()
.signInWithEmailAndPassword(this.email, this.password)
.then(() => {
this.$router.push('/Home')
})
.catch((error) => {
switch (error.code) {
case 'auth/invalid-email':
alert('メールアドレスの形式が違います。')
break
case 'auth/user-disabled':
alert('ユーザーが無効になっています。')
break
case 'auth/user-not-found':
alert('ユーザーが存在しません。')
break
case 'auth/wrong-password':
alert('パスワードが間違っております。')
break
default:
alert('ログインエラーです。メールアドレス・パスワードを確かめてください。')
break
}
})
},
},
}
</script>
<style scoped>
h1{
  font-size:20px;
  margin-bottom:10px;
}
.login{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 30%;
    background-color: white;
    text-align: center;
    border-radius:10px;
    }
.login-p input{
    width:80%;
    height:40px;
    border-radius:10px;
    margin-bottom:10px;
    }
.input{
      border:1px solid black;
}
.login-button{
  width:100px;
  height:40px;
  margin-bottom:20px;
  border-radius:20px;
  border:none;
  background-color:blue;
  color:white;
  cursor:pointer;
    }
.error{
  color:red;
}
.button-invalid {
  background-color:gray;
  cursor:default;
}
</style>