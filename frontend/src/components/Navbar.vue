<template>
	<nav>
		<div class="container">
			<header class="navbar">
				<div class="logo">Seidei</div>
				<ul class="nav-links">
					<li>
						<RouterLink :to="{ name: 'home' }">Home</RouterLink>
					</li>
					<li>
						<RouterLink :to="{ name: 'about' }">About</RouterLink>
					</li>
					<li v-if="user">
						<RouterLink :to="{ name: 'blog' }">Blog</RouterLink>
					</li>
				</ul>
				<div class="login-info">
					<div class="flex gap-05 items-center">
						<p v-if="user">Welcome back, {{ user.name }}</p>
						<button
							v-if="user"
							class="btn btn-badge"
							@click="logout"
						>
							Logout
						</button>
					</div>

					<RouterLink
						v-if="!user"
						:to="{ name: 'login' }"
						class="btn btn-badge"
					>
						Login
					</RouterLink>
				</div>
			</header>
		</div>
	</nav>
</template>
<script>
import { ref, computed } from "vue";
import { useStore } from "vuex";
import { fetching } from "../utils";
import { useRouter } from "vue-router";
import { APP_NAME } from "../config";
export default {
	name: "Seidei - Navbar",
	setup() {
		const store = useStore();
		const router = useRouter();
		const user = computed(() => store.state.user);

		async function logout() {
			const res = await fetching("post", "auth/logout");
			if (res.status === 200) {
				localStorage.removeItem(`${APP_NAME}_TOKEN`);
				store.commit("setUser", null);
				router.push({
					name: "login",
				});
			}
		}

		return { user, logout };
	},
};
</script>
