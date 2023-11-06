<template>
  <div>
    <h1 class="main">ホーム</h1>
    <Message :posts="posts"/>
  </div>
</template>

<script>
import firebase from '~/plugins/firebase';
import axios from 'axios';
export default {
  layout: 'main',
  computed: {
    posts() {
      return this.$store.state.post.posts;
    },
  },
  created() {
    this.$store.dispatch('post/getPost');
  },
};
</script>

<style scoped>
.main{
  color:white;
  border-bottom:1px solid white;
  margin-top:20px;
}

</style>