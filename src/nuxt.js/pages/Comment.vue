<template>
  <div class="comment">
    <div class="post-index">
      <h1 class="main">コメント</h1>
      <Message :posts="posts"/>
    </div>
    <div class="comment-index">
      <p class="comment-index-p">コメント</p>
      <div v-for="comment in comments" :key="comment.id" class="comment-main">
        <h2>{{ comment.user.name }}</h2>
        <p>{{ comment.comment }}</p>
      </div>
    </div>
    <div>
        <validation-observer ref="obs" v-slot="{ invalid, validated }">
        <validation-provider v-slot="{ errors }" rules="required|max:120">
        <textarea name="message" id="textarea" rows="3" v-model="comment" ></textarea>
        <div class="error">{{ errors[0] }}</div>
        </validation-provider>
        <p><button @click="storeComment" class="comment-button" :disabled="invalid || !validated" :class="{ 'button-invalid': invalid && validated }">コメント</button></p>
        </validation-observer>
    </div>
  </div>
</template>

<script>
import firebase from '~/plugins/firebase';
import axios from 'axios';
export default {
  layout: 'main',
  computed: {
    posts() {
      return this.$store.state.comment.posts;
    },
    comments() {
      return this.$store.state.comment.comments;
    },
  },
  created() {
    const postId = this.$route.query.id;
    if (postId) {
      this.$store.dispatch('comment/commentPost', postId);
      this.$store.dispatch('comment/commentGet', postId);
    } else {
      console.error('No post ID provided in query.');
    };
  },
  data() {
    return {
      comment: "",
    };
  },
  methods: {
    async storeComment() {
    try {
      let user = firebase.auth().currentUser;
      const postId = this.$route.query.id;
      const sendData = {
        uid: user.uid,
        comment: this.comment,
        post_id: postId,
      };
      await this.$axios.post("http://localhost/api/commentStore", sendData);
      this.comment = '';
      await this.$store.dispatch('comment/commentGet', postId);
    } catch (error) {
      console.error(error);
      alert('エラーが起きました。')
    }
    },
  },
}
</script>

<style scoped>
.comment{
  width:80%;
}
.main{
  color:white;
  border-bottom:1px solid white;
  margin-top:20px;
}
.p{
  color:white;
}
.comment-index{
  width:100%;
  text-align:center;
}
.comment-index-p{
  border-bottom:1px solid white;
  padding:20px 0;
}
.comment-main{
  text-align:left;
  border-bottom:1px solid white;
  padding:10px 0;
}
#textarea{
  width:90%;
  margin:20px 20px;
  background-color:transparent;
  border:1px solid white;
  border-radius:10px;
  color:white;
}
.comment-button{
  width:100px;
  height:40px;
  border-radius:20px;
  border:none;
  background-color:blue;
  color:white;
  cursor:pointer;
  margin-left:80%;
}
.button-invalid {
  background-color:gray;
  cursor:default;
}
.error{
  color:white;
}
</style>