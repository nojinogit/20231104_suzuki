<template>
  <div class="register">
    <h1>新規登録</h1>
    <validation-observer ref="obs" v-slot="{ invalid, validated }">
    <form @submit.prevent="register">
      <validation-provider v-slot="{ errors }" rules="required|max:20">
      <div class="error">{{ errors[0] }}</div>
      <p class="resister-p"><input type="text" v-model="name" name="名前" placeholder="ユーザーネーム" class="input"></p>
      </validation-provider>
      <validation-provider v-slot="{ errors }" rules="required|email">
      <div class="error">{{ errors[0] }}</div>
      <p class="resister-p"><input type="email" v-model="email"  name="メールアドレス" placeholder="メールアドレス" class="input"></p>
      </validation-provider>
      <validation-provider v-slot="{ errors }" rules="required|min:6">
      <div class="error">{{ errors[0] }}</div>
      <p class="resister-p"><input type="password" v-model="password"  name="パスワード" placeholder="パスワード" class="input"></p>
      </validation-provider>
      <button type="submit" class="register-button" :disabled="invalid || !validated" :class="{ 'button-invalid': invalid && validated }">新規登録</button>
    </form>
    </validation-observer>
  </div>
</template>

<script>
import axios from 'axios';
import firebase from "~/plugins/firebase";
export default {
  data() {
    return {
      email: null,
      password: null,
      name:null,
    };
  },
  methods: {
    register() {
      if (!this.email || !this.password) {
        alert("メールアドレスまたはパスワードが入力されていません。");
        return;
      }
      firebase
        .auth()
        .createUserWithEmailAndPassword(this.email, this.password)
        .then((data) => {
          data.user.sendEmailVerification().then(() => {
            this.$router.replace("/Index");
          });
        axios.post('http://localhost/api/register', {
          name: this.name,
          email: this.email,
          uid: data.user.uid,
        })
        .then((response) => {
          console.log(response);
        })
        .catch((error) => {
          switch (error.code) {
            case "auth/invalid-email":
              alert("メールアドレスの形式が違います。");
              break;
            case "auth/email-already-in-use":
              alert("このメールアドレスはすでに使われています。");
              break;
            case "auth/weak-password":
              alert("パスワードは6文字以上で入力してください。");
              break;
            default:
              alert("エラーが起きました。しばらくしてから再度お試しください。");
              break;
          }
        });
      });
    },
  },
};
</script>

<style scoped>
h1{
  font-size:20px;
  margin-bottom:10px;
}
.register{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 30%;
    background-color: white;
    text-align: center;
    border-radius:10px;
    }
.resister-p input{
    width:80%;
    height:40px;
    border-radius:10px;
    margin-bottom:10px;
    }
.input{
    border:1px solid black;
}
.register-button{
  width:100px;
  height:40px;
  border-radius:20px;
  background-color:blue;
  margin-bottom:20px;
  color:white;
  cursor:pointer;
  border:none;
    }
.button-invalid {
  background-color:gray;
  cursor:default;
}
.error{
  color:red;
}
</style>