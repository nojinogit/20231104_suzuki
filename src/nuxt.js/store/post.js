import firebase from '~/plugins/firebase';
export const state = () => ({
  posts: [],
});

export const mutations = {
  setPosts(state, posts) {
    state.posts = posts;
  },
};

export const actions = {
  async getPost({ commit }) {
    let user = firebase.auth().currentUser;
    let uid;

    if (user != null) {
      uid = user.uid;
    }

    const resData = await this.$axios.get("http://localhost/api/index", {
      params: {
        uid: uid
      }
    });
    commit('setPosts', resData.data.data);
  },
};
