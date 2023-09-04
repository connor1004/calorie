import router from "../../routes/router";
import axios from "../../axios";

const state = {
  user: null,
};

const mutations = {
  SET_USER(state, val) {
    state.user = val;
  },
};

const actions = {
  /* login to the app */
  async login({ commit }, { email, password }) {
    try {
      const response = await axios.post("oauth/token", {
        grant_type: "password",
        client_id: process.env.MIX_OAUTH_CLIENT_ID,
        client_secret: process.env.MIX_OAUTH_CLIENT_SECRET,
        username: email,
        password,
        scope: ""
      });
      
      const token = response.headers["authorization"];
      localStorage.setItem("access_token", token);
      
      if (response.status == 200) {
        localStorage.setItem("access_token", response.data.access_token);
        localStorage.setItem("refresh_token", response.data.refresh_token);
      }
      return response;
    } catch (error) {
      console.log("Something went wrong:", error);
      return error;
    }
  },

  /* logout of the app */
  async logout({ commit }) {
    try {
      await axios.post("api/logout");
      localStorage.removeItem("access_token");
      localStorage.removeItem("refresh_token");
      commit("SET_USER", null);
      router.replace({
        name: "login"
      });
      return true;
    } catch (error) {
      console.error("Something went wrong:", error);
      return error;
    }
  },

  /* signup to the app */
  async register({ commit }, data) {
    try {
      data.timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
      const resp = await axios.post("api/register", data);
      return resp;
    } catch (error) {
      console.error("Something went wrong:", error);
      return error;
    }
  },

  async getUserInfo({ commit }) {
    try {
      const resp = await axios.get("api/user");
      if (resp.data.data) {
        commit("SET_USER", resp.data.data);
      }
      return resp;
    } catch (error) {
      console.error("Something went wrong:", error);
      return error;
    }
  },

  setUser({ commit }, data) {
    commit("SET_USER", data);
  }
};

const getters = {
  getUser: state => state.user
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
};
