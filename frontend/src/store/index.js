import { createStore } from "vuex";
import { fetching } from "@/utils";

const store = createStore({
	state: {
		user: null,
	},
	mutations: {
		setUser(state, payload) {
			state.user = payload;
		},
	},
});

async function checkAuth() {
	const me = await fetching("get", "me");
	console.log(me);
	if (me.status != 401) {
		store.commit("setUser", me.data);
	}
}

checkAuth();

export default store;
