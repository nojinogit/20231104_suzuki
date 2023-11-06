<template>
  <div>
    <div v-for="post in posts" :key="post.id" class="post">
      <div class="post-menu">
        <h2>{{ post.user.name }}</h2>
        <div v-show="post.isLikedByUser===false"><a @click="addLike(post.id)"><img src="@/assets/image/heart.png" alt="logo" class="icon"></a></div>
        <div v-show="post.isLikedByUser===true"><a @click="removeLike(post.id)"><img src="@/assets/image/heart-red.png" alt="logo" class="icon"></a></div>
        <div>{{ post.likes_count }}</div>
        <div v-if="post.myMessage===true"><a @click="deletePost(post.id)"><img src="@/assets/image/cross.png" alt="logo" class="icon"></a></div>
        <div><NuxtLink :to="{ path: '/Comment', query: { id: post.id } }"><img src="@/assets/image/detail.png" alt="logo" class="icon"></NuxtLink></div>
      </div>
      <p>{{ post.message }}</p>
    </div>
  </div>
</template>

<script>
import firebase from '~/plugins/firebase';
import axios from 'axios';
export default {
  props: ['posts'],
  methods: {
    async addLike(postId) {
      let user = firebase.auth().currentUser;
      const sendData = {
        uid: user.uid,
        post_id: postId,
      };
      await this.$axios.post("http://localhost/api/add", sendData);
      await this.$store.dispatch('post/getPost');
      await this.$store.dispatch('comment/commentPost', postId);
    },
    async removeLike(postId) {
      let user = firebase.auth().currentUser;
      const sendData = {
        uid: user.uid,
        post_id: postId,
      };
      await this.$axios.post("http://localhost/api/remove", sendData);
      await this.$store.dispatch('post/getPost');
      await this.$store.dispatch('comment/commentPost', postId);
    },
    async deletePost(postId) {
      const sendData = {
        post_id: postId,
      };
      await this.$axios.post("http://localhost/api/delete", sendData);
      await this.$store.dispatch('post/getPost');
      this.$router.push('/Home')
    },
  },
};
</script>


<style scoped>

.post{
  border-bottom:1px solid white;
  padding:20px 0;
}
.post-menu{
  display:flex;
  align-items:center;
}
.post-menu div{
  margin-left:20px;
}
.icon{
  width:40px;
  cursor:pointer;
}
</style>