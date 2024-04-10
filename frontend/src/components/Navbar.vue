<template>
	<nav>
		<div class="container">
			<header class="navbar" :class="{open: open}">
				<div class="nav-logo">Seidei</div>
				<div class="nav-content">
					<ul class="nav-links">
						<li>
							<RouterLink :to="{ name: 'home' }" @click="closeSidebar">Home</RouterLink>
						</li>
						<li>
							<RouterLink :to="{ name: 'about' }" @click="closeSidebar">About</RouterLink>
						</li>
						<li v-if="user">
							<RouterLink :to="{ name: 'blog' }" @click="closeSidebar">Blog</RouterLink>
						</li>
					</ul>
					<div class="login-info">
						<div class="flex gap-05 items-center flex-wrap">
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
							@click="closeSidebar"
						>
							Login
						</RouterLink>
					</div>
				</div>

				<div class="hamburger-menu" @click="toggleOpen">
					<span></span>
					<span></span>
					<span></span>
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
		const open = ref(false);
		const store = useStore();
		const router = useRouter();
		const user = computed(() => store.state.user);

		async function logout() {
			closeSidebar();
			const res = await fetching("post", "auth/logout");
			if (res.status === 200) {
				localStorage.removeItem(`${APP_NAME}_TOKEN`);
				store.commit("setUser", null);
				router.push({
					name: "login",
				});
			}
		}

		function toggleOpen(){
			open.value = !open.value;
		}

		function closeSidebar(){
			open.value = false;
		}

		return { user, logout, open, toggleOpen, closeSidebar };
	},
};
</script>
