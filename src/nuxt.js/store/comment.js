import axios from 'axios';
import firebase from '~/plugins/firebase';

export const state = () => ({
  posts: [],
  comments:[],
});

export const mutations = {
  setPosts(state, posts) {
    state.posts = posts;
  },
  setComments(state, comments) {
    state.comments = comments;
  }
};

export const actions = {
  async commentPost({ commit }, post_id) {
    try {
      const uid = firebase.auth().currentUser ? firebase.auth().currentUser.uid : null;
      if (uid) {
        const response = await axios.get("http://localhost/api/commentIndex", {
          params: { uid, post_id }
        });
        commit('setPosts', response.data);
      } else {
        console.error('User is not authenticated.');
      }
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  },
  async commentGet({ commit }, post_id) {
    try {
      const uid = firebase.auth().currentUser ? firebase.auth().currentUser.uid : null;
      if (uid) {
        const response = await axios.get("http://localhost/api/commentGet", {
          params: { uid, post_id }
        });
        commit('setComments', response.data.data);
      } else {
        console.error('User is not authenticated.');
      }
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  },
};
